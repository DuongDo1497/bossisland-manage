<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $pageTitle    = "All Products";
        $products     = Product::searchable(['name', 'sku', 'alert_quantity'])
            ->with('category:id,name', 'brand:id,name', 'unit:id,name', 'productStock:id,product_id,quantity', 'saleDetails')
            ->orderBy('id', 'desc');

        if (request()->print) {
            $products = $products->get();
            return downloadPDF('pdf.product.list', compact('pageTitle', 'products'));
        }

        $products = $products->paginate(getPaginate());
        $pdfButton = true;
        return view('admin.product.index', compact('pageTitle', 'products', 'pdfButton'));
    }

    public function create()
    {
        $pageTitle   = 'Add Product';
        $categories  = Category::orderBy('name')->get();
        $brands      = Brand::orderBy('name')->get();
        $units       = Unit::orderBy('name')->get();
        return view('admin.product.form', compact('pageTitle', 'categories', 'brands', 'units'));
    }

    public function store(Request $request, $id = 0)
    {
        $this->validation($request, $id);
        if ($id) {
            $product  = Product::findOrFail($id);
            $notification  = 'Product updated successfully';
        } else {
            $product = new Product();
            $notification  = 'Product added successfully';
        }
        $this->productSave($request, $product, $id);
        $notify[] = ['success',  $notification];
        return back()->withNotify($notify);
    }

    public function edit($id)
    {
        $product     = Product::findOrFail($id);
        $pageTitle   = 'Edit Product';
        $categories  = Category::orderBy('name')->get();
        $brands      = Brand::orderBy('name')->get();
        $units       = Unit::orderBy('name')->get();
        return view('admin.product.form', compact('product', 'pageTitle', 'categories', 'brands', 'units'));
    }

    protected function productSave($request, $product, $id)
    {
        if ($request->hasFile('image')) {
            try {
                $old = $product->image;
                $product->image = fileUploader($request->image, getFilePath('product'), getFileSize('product'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }
        $product->name               = $request->name;
        $product->sku                = $request->sku;
        $product->category_id        = $request->category;
        $product->brand_id           = $request->brand;
        $product->unit_id            = $request->unit;
        $product->alert_quantity     = $request->alert_quantity;
        $product->note               = $request->note;
        $product->save();
        Action::newEntry($product, $id ? 'UPDATED' : 'CREATED');
    }

    protected function validation($request, $id = 0)
    {
        $request->validate(
            [
                'name'            => 'required|string|unique:products,name,' . $id,
                'category'        => 'required|exists:categories,id',
                'sku'             => 'required|string|max:40|unique:products,sku,' . $id,
                'brand'           => 'required|exists:brands,id',
                'unit'            => 'required|exists:units,id',
                'alert_quantity'  => 'nullable|numeric',
                'note'            => 'nullable|string|max:500',
                'image'           => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])]
            ]
        );
    }


    public function alert()
    {
        $pageTitle  = 'All Alerting Products';
        $products   = Product::searchable(['products.name']);
        $products->select('products.id', 'products.sku', 'products.name', 'units.name as unit_name', 'products.alert_quantity', 'product_stocks.quantity', 'warehouses.name as warehouse_name')
            ->join('product_stocks', 'products.id', '=', 'product_stocks.product_id')
            ->join('units', 'units.id', '=', 'products.unit_id')
            ->join('warehouses', 'warehouses.id', '=', 'product_stocks.warehouse_id')
            ->whereRaw('products.alert_quantity >= product_stocks.quantity');

        $products = $products->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.product.alert', compact('pageTitle', 'products'));
    }


    public function allProducts()
    {
        $products = Product::select('id', 'name', 'sku')->where('name', 'LIKE', "%" . request()->search . "%")->orWhere('sku', 'LIKE', "%" . request()->search . "%")->paginate(request()->rows ?? 5);

        return response()->json([
            'success'   => true,
            'products' => $products,
            'more'      => $products->hasMorePages()
        ]);
    }
}
