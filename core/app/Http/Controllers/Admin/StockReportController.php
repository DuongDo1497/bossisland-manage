<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class StockReportController extends Controller
{
    public function index(Request $request)
    {
        $pageTitle         = 'Product Stock Report';
        $warehouses        = Warehouse::orderBy('name')->get();
        $stocksByProduct   = collect([]);
        $stocksByWarehouse = collect([]);
        $productName       = null;
        $pdfButton         = false;

        if ($request->type) {
            $data = $this->getReport($request);
            extract($data);
            $pdfButton = true;
        }

        if (request()->print && request()->type == 'warehouse') {
            $pageTitle = 'Products in ' . $warehouses->where('id', $request->warehouse)->first()->name;
            return downloadPDF('pdf.warehouse.report', compact('pageTitle', 'stocksByWarehouse'));
        }

        if (request()->print && request()->type == 'product') {
            $pageTitle = 'Stock report of ' . $productName;
            return downloadPDF('pdf.product.stock_details', compact('pageTitle', 'stocksByProduct'));
        }
        return view('admin.reports.stock.index', compact('pageTitle', 'warehouses', 'stocksByProduct', 'stocksByWarehouse', 'productName', 'pdfButton'));
    }

    private function getReport($request)
    {
        $request->validate([
            'type' => 'in:warehouse,product',
            'product' => 'nullable|required_if:type,product',
            'warehouse' => 'nullable|required_if:type,warehouse',
        ]);

        if ($request->warehouse) {
            $data['stocksByWarehouse'] = ProductStock::where('warehouse_id', $request->warehouse)->where('quantity', '>', 0)->with('product.brand', 'product.category', 'product.unit')->get();
        }

        if ($request->product) {
            $data['productName'] = Product::find($request->product)->name;
            $data['stocksByProduct'] = ProductStock::where('product_id', $request->product)->with('warehouse', 'product.unit')->get();
        }

        return $data;
    }
}
