<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Customer;
use App\Models\NotificationLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{

    public function index()
    {
        $pageTitle = 'All Customers';
        $customers = Customer::searchable(['name', 'mobile', 'email', 'address'], false)->with('sale', 'saleReturns')->orderBy('id', 'desc');
        if (request()->print) {
            $customers = $customers->get();
            return downloadPDF('pdf.customer.list', compact('pageTitle', 'customers'));
        }
        $customers = $customers->paginate(getPaginate());
        $pdfButton = true;
        return view('admin.customer.list', compact('pageTitle', 'customers', 'pdfButton'));
    }

    public function store(Request $request, $id = 0)
    {
        $this->validation($request, $id);
        if ($id) {
            $notification = 'Customer updated successfully';
            $customer =  Customer::findOrFail($id);
        } else {
            $exist = Customer::where('mobile', $request->mobile)->first();
            if ($exist) {
                $notify[] = ['error', 'The mobile number already exists'];
                return back()->withNotify($notify);
            }
            $notification = 'Customer added successfully';
            $customer =  new Customer();
        }

        $customer->name     = $request->name;
        $customer->email    = strtolower(trim($request->email));
        $customer->mobile   = $request->mobile;
        $customer->address  = $request->address;
        $customer->save();

        Action::newEntry($customer, $id ? 'UPDATED' : 'CREATED');

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    protected function validation($request, $id = 0)
    {
        $request->validate([
            'name'     => 'required|string|max:40',
            'email'    => 'nullable|string|email|unique:suppliers,email,' . $id,
            'mobile'   => 'required|regex:/^([0-9]*)$/|unique:suppliers,mobile,' . $id,
            'address'  => 'nullable|string|max:500',
        ]);
    }

    //Notification
    public function showNotificationSingleForm($id)
    {
        $customer = Customer::findOrFail($id);
        $general = gs();
        $pageTitle = 'Send Notification to ' . $customer->name;
        return view('admin.customer.notification_single', compact('pageTitle', 'customer'));
    }

    public function sendNotificationSingle(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string',
            'subject' => 'required|string',
        ]);

        $customer = Customer::findOrFail($id);
        notify($customer, 'DEFAULT', [
            'subject' => $request->subject,
            'message' => $request->message,
        ]);
        $notify[] = ['success', 'Notification sent successfully'];
        return back()->withNotify($notify);
    }

    public function showNotificationAllForm()
    {
        $general = gs();
        $customers = Customer::count();
        $pageTitle = 'Notification to All Customers';
        return view('admin.customer.notification_all', compact('pageTitle', 'customers'));
    }

    public function sendNotificationAll(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'message' => 'required',
            'subject' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $customer = Customer::skip($request->skip)->first();

        notify($customer, 'DEFAULT', [
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return response()->json([
            'success' => 'message sent',
            'total_sent' => $request->skip + 1,
        ]);
    }

    public function notificationLog($id)
    {
        $customer = Customer::findOrFail($id);
        $pageTitle = 'Notifications Sent to ' . $customer->name;
        $logs = NotificationLog::where('customer_id', $id)->with('customer')->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.customer.notification_history', compact('pageTitle', 'logs', 'customer'));
    }

    public function emailDetails($id)
    {
        $pageTitle = 'Email Details';
        $email = NotificationLog::findOrFail($id);
        return view('admin.customer.email_details', compact('pageTitle', 'email'));
    }
}
