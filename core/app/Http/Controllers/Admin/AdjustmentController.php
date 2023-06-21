<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Adjustment;
use App\Models\AdjustmentDetails;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdjustmentController extends Controller
{

    public function index()
    {
        $pageTitle   = "All Adjustments";
        $keyword     = request()->search;
        $adjustments = Adjustment::dateFilter('adjust_date');

        if ($keyword) {
            $adjustments = $adjustments->where('tracking_no', 'LIKE', '%' . $keyword . '%')->orWhereHas('warehouse', function ($q) use ($keyword) {
                $q->where('name', 'LIKE', '%' . $keyword . '%');
            });
        }

        $adjustments = $adjustments->with('warehouse:id,name', 'adjustmentDetails', 'createdBy')->whereHas('adjustmentDetails')->orderBy('id', 'desc');

        if (request()->print) {
            $adjustments = $adjustments->get();
            return downloadPDF('pdf.adjustment.list', compact('pageTitle', 'adjustments'));
        }

        $adjustments = $adjustments->paginate(getPaginate());
        $pdfButton = true;

        return view('admin.adjustment.index', compact('pageTitle', 'adjustments', 'pdfButton'));
    }

    public function detailsPDF($id)
    {
        $pageTitle  = "Adjustment Details";
        $adjustment = Adjustment::where('id', $id)->with('adjustmentDetails', 'adjustmentDetails.product', 'adjustmentDetails.product.unit')->whereHas('adjustmentDetails')->firstOrFail();
        return downloadPDF('pdf.adjustment.details', compact('pageTitle', 'adjustment'));
    }

    public function create()
    {
        $pageTitle  = 'New Adjustment';
        $warehouses = Warehouse::active()->orderBy('name')->get();
        return view('admin.adjustment.form', compact('pageTitle', 'warehouses'));
    }

    public function edit($id)
    {
        $adjustment = Adjustment::where('id', $id)->with('adjustmentDetails', 'adjustmentDetails.product.productStock', 'adjustmentDetails.product.unit')->whereHas('adjustmentDetails')->firstOrFail();
        $pageTitle  = 'Edit Adjustment';
        $warehouses = Warehouse::active()->get();
        return view('admin.adjustment.form', compact('pageTitle', 'adjustment', 'warehouses'));
    }

    public function store(Request $request)
    {
        $this->validation($request);

        $this->products     = collect($request->products);
        $productIds         = $this->products->pluck('product_id')->toArray();
        $this->productStock = ProductStock::where('warehouse_id', $request->warehouse_id)->whereIn('product_id', $productIds)->get();

        foreach ($this->products as $product) {

            $product = (object) $product;

            $stock   = $this->productStock->where('product_id', $product->product_id)->first();

            if (empty($stock) && $product->adjust_type == 1) {
                $notify[] = ['error', 'Stock of new product, increase only allowed'];
                return back()->withNotify($notify);
            }

            if ($product->adjust_type == 1 && $stock->quantity < $product->quantity) {
                $notify[] = ['error', 'Provided quantity is not available in stock'];
                return back()->withNotify($notify);
            }
        }

        $adjustment               = new Adjustment();
        $adjustment->warehouse_id = $request->warehouse_id;
        $adjustment->tracking_no  = getTrx(8);
        $adjustment->adjust_date  = Carbon::parse($request->adjust_date);
        $adjustment->note         = $request->note;
        $adjustment->save();

        $this->updateStock($adjustment->id);
        $this->storeAdjustmentDetails($adjustment->id);

        Action::newEntry($adjustment, 'CREATED');

        $notify[] = ['success', 'Adjustment data added successfully'];
        return to_route('admin.adjustment.edit', $adjustment->id)->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $this->validation($request, true);
        $this->products = collect($request->products);

        $productIds         = $this->products->pluck('product_id')->toArray();
        $this->productStock = ProductStock::where('warehouse_id', $request->warehouse_id)->whereIn('product_id', $productIds)->get();
        $adjustment         = Adjustment::with('adjustmentDetails')->findOrFail($id);

        if ($adjustment->warehouse_id != $request->warehouse_id) {
            $notify[] = ['error', 'The warehouse doesn\'t allow to be changed'];
            return back()->withNotify($notify)->withInput();
        }

        foreach ($this->products as $product) { // Check the stock while subtracting
            $product = (object) $product;
            $detail  = $adjustment->adjustmentDetails->where('product_id', $product->product_id)->first();

            if ($product->adjust_type == 1 && $detail) {
                $stock        = $this->productStock->where('product_id', $product->product_id)->first();
                $adjustQty    = $this->getAdjustQuantity($detail, $product->adjust_type, $product->quantity);
                $currentStock = $stock->quantity + $adjustQty;

                if ($currentStock < 0) {
                    $notify[] = ['error', 'The quantity you want to subtract is not available in stock'];
                    return back()->withNotify($notify)->withInput();
                }
            }
        }

        $adjustment->warehouse_id  = $request->warehouse_id;
        $adjustment->adjust_date   = Carbon::parse($request->adjust_date);
        $adjustment->note          = $request->note;
        $adjustment->save();

        $this->updateStock($adjustment->id);
        $this->storeAdjustmentDetails($adjustment->id);

        Action::newEntry($adjustment, 'UPDATED');

        $notify[] = ['success', 'Adjustment data updated successfully'];

        if ($adjustment->adjustmentDetails()->count() == 0) {
            $adjustment->delete();
            return to_route('admin.adjustment.index')->withNotify($notify);
        }

        return back()->withNotify($notify);
    }

    protected function updateStock($adjustmentId)
    {
        $adjustmentDetails = AdjustmentDetails::where('adjustment_id', $adjustmentId)->get();

        foreach ($this->products as $product) {

            $product          = (object) $product;
            $type             = $product->adjust_type;
            $adjustmentDetail = $adjustmentDetails->where('product_id', $product->product_id)->first();
            $productStock     = $this->productStock->where('product_id', $product->product_id)->first();

            if (empty($productStock)) {
                $newWarehouseProduct =  new ProductStock();
                $newWarehouseProduct->warehouse_id = request()->warehouse_id;
                $newWarehouseProduct->product_id   = $product->product_id;
                $newWarehouseProduct->quantity     = $product->quantity;
                $newWarehouseProduct->save();
            } else {
                $adjustQty        = $product->quantity;

                if (!$adjustmentDetail) { // New Adjustment
                    $adjustQty  = $type == 1 ? $adjustQty * -1 : $adjustQty;
                } else { // Update Adjustment
                    $adjustQty = $this->getAdjustQuantity($adjustmentDetail, $type, $adjustQty);
                }


                $productStock->quantity += $adjustQty;
                $productStock->save();
            }
        }
    }


    protected function getAdjustQuantity($detail, $type, $adjustQty)
    {
        $oldType = $detail->adjust_type;
        $oldQty  = $detail->quantity;

        if ($oldType == $type && $adjustQty == $oldQty) { // If same as old value
            return 0;
        }

        if ($oldType == 2 && $type == 1) { // If from ADD to SUBTRACT
            $adjustQty = ($adjustQty * -1) + ($oldQty * -1);
        } elseif ($oldType == 1 && $type == 2) { // If from SUBTRACT to ADD
            $adjustQty += $oldQty;
        } elseif ($type == 1) {
            $adjustQty = $oldQty - $adjustQty;
        } else {
            $adjustQty = $adjustQty - $oldQty;
        }
        return $adjustQty;
    }


    protected function storeAdjustmentDetails($adjustmentId)
    {
        foreach ($this->products as $product) {
            $product = (object) $product;

            $adjustmentDetails = AdjustmentDetails::where('adjustment_id', $adjustmentId)->where('product_id', $product->product_id)->first() ?? new AdjustmentDetails();

            if ($product->quantity == 0) {
                $adjustmentDetails->delete();
            } else {
                $adjustmentDetails->adjustment_id = $adjustmentId;
                $adjustmentDetails->product_id    = $product->product_id;
                $adjustmentDetails->quantity      = $product->quantity;
                $adjustmentDetails->adjust_type   = $product->adjust_type;
                $adjustmentDetails->save();
            }
        }
    }

    protected function validation($request, $isUpdate = false)
    {
        $qtyRule = $isUpdate ? 'gte:0' : 'gt:0';

        $request->validate([
            'warehouse_id'           => 'required|exists:warehouses,id',
            'adjust_date'            => 'required|date_format:m/d/Y',
            'products'               => 'required|array|min:1',
            'products.*.product_id'  => 'required|integer|gt:0',
            'products.*.quantity'    => 'required|integer|' . $qtyRule,
            'products.*.adjust_type' => 'required|integer|in:1,2',
            'note'                   => 'required|string',
        ]);
    }

    public function searchProduct(Request $request)
    {
        $products = Product::query();
        if ($request->keyword) {
            $products = $products->with('productStock')->where(function ($query) use ($request) {
                $query->orWhere('name', 'LIKE', "$request->keyword%")->orWhere('sku', 'LIKE', "$request->keyword%");
            });
        }
        $products = $products->with('unit')->get();
        if ($products) {
            return response()->json([
                'success'    => true,
                'data'       => $products,
            ]);
        }
    }
}
