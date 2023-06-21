<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        $pageTitle    = 'All Warehouses';
        $warehouses   = Warehouse::orderBy('id', 'desc')->get();
        return view('admin.warehouse.index', compact('pageTitle', 'warehouses'));
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'name'    => 'required|string|max:40|unique:warehouses,name,' . $id,
            'address' => 'required|string|max:500',
        ]);

        if ($id) {
            $warehouse          = Warehouse::findOrFail($id);
            $warehouse->status = $request->status ? Status::ENABLE : Status::DISABLE;
            $notification = 'Warehouse updated successfully';
        } else {
            $warehouse          = new Warehouse();
            $notification = 'Warehouse added successfully';
        }

        $warehouse->name    = $request->name;
        $warehouse->address = $request->address;
        $warehouse->save();
        $notify[] = ['success', $notification];
        return to_route('admin.warehouse.index')->withNotify($notify);
    }
}
