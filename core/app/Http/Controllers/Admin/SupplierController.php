<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Supplier;
use Illuminate\Http\Request;


class SupplierController extends Controller
{
    public function index()
    {
        $pageTitle  = 'All Suppliers';
        $suppliers  = Supplier::searchable(['name', 'mobile', 'email', 'address'], false)->with('purchases', 'purchaseReturns')->orderBy('id', 'desc');
        if (request()->print) {
            $suppliers = $suppliers->get();
            return downloadPDF('pdf.supplier.list', compact('pageTitle', 'suppliers'));
        }
        $suppliers = $suppliers->paginate(getPaginate());
        $pdfButton = true;
        return view('admin.supplier.index', compact('pageTitle', 'suppliers', 'pdfButton'));
    }

    public function store(Request $request, $id = 0)
    {
        $this->validation($request, $id);
        if ($id) {
            $notification     = 'Supplier updated successfully';
            $supplier         = Supplier::findOrFail($id);
        } else {
            $exist = Supplier::where('mobile', $request->mobile)->first();
            if ($exist) {
                $notify[] = ['error', 'The mobile number already exists'];
                return back()->withNotify($notify);
            }
            $notification = 'Supplier added successfully';
            $supplier =  new Supplier();
        }

        $this->saveSupplier($request, $supplier, $id);
        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    protected function saveSupplier($request, $supplier, $id)
    {
        $supplier->name          = $request->name;
        $supplier->email         = strtolower(trim($request->email));
        $supplier->mobile        = $request->mobile;
        $supplier->company_name  = $request->company_name;
        $supplier->address       = $request->address;
        $supplier->save();
        Action::newEntry($supplier, $id ? 'UPDATED' : 'CREATED');
    }

    protected function validation($request, $id = 0)
    {
        $request->validate([
            'name'         => 'required|string|max:40',
            'email'        => 'required|string|email|unique:suppliers,email,' . $id,
            'mobile'       => 'required|regex:/^([0-9]*)$/|unique:suppliers,mobile,' . $id,
            'company_name' => 'nullable|string|max:40',
            'address'      => 'nullable|string|max:500',

        ]);
    }
}
