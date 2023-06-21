<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Staffs';
        $staffs    = Admin::where('role', Status::STAFF)->searchable(['name', 'username', 'email', 'mobile'])->latest();

        if (request()->print) {
            $staffs = $staffs->get();
            return downloadPDF('pdf.staff.list', compact('pageTitle', 'staffs'));
        }

        $staffs    = $staffs->paginate(getPaginate());
        $pdfButton = true;

        return view('admin.staff.index', compact('pageTitle', 'staffs', 'pdfButton'));
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'name'     => 'required|string|max:40',
            'username' => 'required|string|max:40',
            'password' => 'nullable|string|min:5',
            'email'    => 'required|email|unique:suppliers,email,' . $id,
            'mobile'   => 'required|regex:/^([0-9]*)$/|unique:suppliers,mobile,' . $id,
        ]);

        if ($id) {
            $notification = 'Staff updated successfully';
            $this->update($request, $id);
        } else {
            $exist = Admin::where('mobile', $request->mobile)->first();
            if ($exist) {
                $notify[] = ['error', 'The mobile number already exists'];
                return back()->withNotify($notify);
            }

            $notification = 'Staff added successfully';
            $this->createNew($request);
        }

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    protected function createNew($request)
    {

        $staff = new Admin();

        $this->saveStaff($staff, $request);
        $general = gs();

        notify($staff, 'ADD_STAFF', [
            'institute' => $general->site_name,
            'name'      => $staff->name,
            'username'  => $staff->username,
            'password'  => $request->password,
            'guard'     => route('admin.login'),
        ]);
    }

    public function update(Request $request, $id)
    {
        $staff = Admin::findOrFail($id);
        $staff->status = $request->status ? Status::ENABLE : Status::DISABLE;
        $this->saveStaff($staff, $request, $id);
    }

    protected function saveStaff($staff, $request)
    {
        $staff->name     = $request->name;
        $staff->username = $request->username;
        $staff->password = $request->password ? Hash::make($request->password) : $staff->password;
        $staff->email    = strtolower(trim($request->email));
        $staff->mobile   = $request->mobile;
        $staff->save();
    }

    public function login($id)
    {
        Auth::guard('admin')->loginUsingId($id);
        return to_route('admin.dashboard');
    }
}
