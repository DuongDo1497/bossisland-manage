<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Lib\CurlRequest;
use App\Models\Product;
use App\Models\PurchaseReturnDetails;
use App\Models\PurchaseDetails;
use App\Models\SaleDetails;
use App\Models\SaleReturnDetails;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\Sale;
use App\Models\SaleReturn;
use App\Models\Supplier;
use App\Rules\FileTypeValidate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function dashboard()
    {
        $pageTitle = 'Dashboard';

        $widget['total_customers']       = Customer::count();
        $widget['total_product']         = Product::count();
        $widget['total_category']        = Category::count();
        $widget['total_supplier']        = Supplier::count();

        $widget['total_purchase']        = Purchase::sum('payable_amount');
        $widget['total_purchase_return'] = PurchaseReturn::sum('receivable_amount');

        $widget['total_sale']            = Sale::sum('receivable_amount');
        $widget['total_sale_return']     = SaleReturn::sum('payable_amount');

        $widget['alertProductsQty']      = Product::select('products.id', 'products.name', 'units.name as unit_name', 'products.alert_quantity', 'product_stocks.quantity as quantity', 'warehouses.name as warehouse_name')
            ->join('product_stocks', 'products.id', '=', 'product_stocks.product_id')
            ->join('units', 'units.id', '=', 'products.unit_id')
            ->join('warehouses', 'warehouses.id', '=', 'product_stocks.warehouse_id')
            ->whereRaw('products.alert_quantity >= product_stocks.quantity')
            ->orderBy('products.alert_quantity')->get()->take(8);

        //top 5 best sales products
        $topSellingProducts =  Product::where('total_sale', '!=', 0)->orderBy('total_sale', 'desc')->with('unit:id,name')->limit(8)->get();
        $saleReturns        = SaleReturn::with('sale.warehouse', 'customer')->orderBy('id', 'desc')->take(8)->get();



        // Monthly Purchase & Sale Report Graph
        $report['months']                 = collect([]);
        $report['purchase_amount']        = collect([]);
        $report['purchase_return_amount'] = collect([]);
        $report['sale_return_amount']     = collect([]);
        $report['sale_amount']            = collect([]);

        $purchaseMonth = Purchase::where('purchase_date', '>=', now()->subYear())
            ->selectRaw("SUM(payable_amount) as purchaseAmount")
            ->selectRaw("DATE_FORMAT(purchase_date,'%M-%Y') as months")
            ->orderBy('purchase_date')
            ->groupBy('months')
            ->get();

        $saleMonth = Sale::where('sale_date', '>=', now()->subYear())
            ->selectRaw("SUM(receivable_amount) as saleAmount")
            ->selectRaw("DATE_FORMAT(sale_date,'%M-%Y') as months")
            ->orderBy('sale_date')
            ->groupBy('months')
            ->get();

        $purchaseReturnMonth = PurchaseReturn::where('return_date', '>=', now()->subYear())
            ->selectRaw("SUM(receivable_amount) as purchaseReturnAmount")
            ->selectRaw("DATE_FORMAT(return_date,'%M-%Y') as months")
            ->orderBy('return_date')
            ->groupBy('months')
            ->get();

        $saleReturnMonth = SaleReturn::where('return_date', '>=', now()->subYear())
            ->selectRaw("SUM(payable_amount) as saleReturnAmount")
            ->selectRaw("DATE_FORMAT(return_date,'%M-%Y') as months")
            ->orderBy('return_date')
            ->groupBy('months')
            ->get();

        $saleMonth->map(function ($saleData) use ($report) {
            if (!in_array($saleData->months, $report['months']->toArray())) {
                $report['months']->push($saleData->months);
            }
            $report['sale_amount']->push(getAmount($saleData->saleAmount));
        });

        $saleReturnMonth->map(function ($saleReturnData) use ($report) {
            if (!in_array($saleReturnData->months, $report['months']->toArray())) {
                $report['months']->push($saleReturnData->months);
            }
            $report['sale_return_amount']->push(getAmount($saleReturnData->saleReturnAmount));
        });

        $purchaseMonth->map(function ($purchaseData) use ($report) {
            if (!in_array($purchaseData->months, $report['months']->toArray())) {
                $report['months']->push($purchaseData->months);
            }
            $report['purchase_amount']->push(getAmount($purchaseData->purchaseAmount));
        });

        $purchaseReturnMonth->map(function ($purchaseReturnData) use ($report) {
            if (!in_array($purchaseReturnData->months, $report['months']->toArray())) {
                $report['months']->push($purchaseReturnData->months);
            }
            $report['purchase_return_amount']->push(getAmount($purchaseReturnData->purchaseReturnAmount));
        });

        $months = $report['months'];

        for ($i = 0; $i < $months->count(); ++$i) {
            $monthVal      = Carbon::parse($months[$i]);
            if (isset($months[$i + 1])) {
                $monthValNext = Carbon::parse($months[$i + 1]);
                if ($monthValNext < $monthVal) {
                    $temp = $months[$i];
                    $months[$i]   = Carbon::parse($months[$i + 1])->format('F-Y');
                    $months[$i + 1] = Carbon::parse($temp)->format('F-Y');
                } else {
                    $months[$i]   = Carbon::parse($months[$i])->format('F-Y');
                }
            }
        }

        $purchaseData       = [];
        $purchaseReturnData = [];
        $saleData           = [];
        $saleReturnData     = [];

        foreach ($months as $month) {
            $purchaseData[] = getAmount(@$purchaseMonth->where('months', $month)->first()->purchaseAmount);
            $purchaseReturnData[] = getAmount(@$purchaseReturnMonth->where('months', $month)->first()->purchaseReturnAmount);
            $saleData[] = getAmount(@$saleMonth->where('months', $month)->first()->saleAmount);
            $saleReturnData[] = getAmount(@$saleReturnMonth->where('months', $month)->first()->saleReturnAmount);
        }




        return view('admin.dashboard', compact('pageTitle', 'widget', 'report',  'months', 'purchaseData', 'purchaseReturnData', 'saleData', 'saleReturnData', 'topSellingProducts', 'saleReturns'));
    }

    public function profile()
    {
        $pageTitle = 'Profile';
        $admin = auth('admin')->user();
        return view('admin.profile', compact('pageTitle', 'admin'));
    }

    public function profileUpdate(Request $request)
    {
        $this->validate($request, [
            'name'  => 'required',
            'email' => 'required|email',
            'image' => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])]
        ]);
        $user = auth('admin')->user();

        if ($request->hasFile('image')) {
            try {
                $old = $user->image;
                $user->image = fileUploader($request->image, getFilePath('adminProfile'), getFileSize('adminProfile'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->save();
        $notify[] = ['success', 'Profile updated successfully'];
        return to_route('admin.profile')->withNotify($notify);
    }


    public function password()
    {
        $pageTitle = 'Password Setting';
        $admin = auth('admin')->user();
        return view('admin.password', compact('pageTitle', 'admin'));
    }

    public function passwordUpdate(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password'     => 'required|min:5|confirmed',
        ]);

        $user = auth('admin')->user();
        if (!Hash::check($request->old_password, $user->password)) {
            $notify[] = ['error', 'Password doesn\'t match!!'];
            return back()->withNotify($notify);
        }
        $user->password = bcrypt($request->password);
        $user->save();
        $notify[] = ['success', 'Password changed successfully.'];
        return to_route('admin.password')->withNotify($notify);
    }

    public function banned()
    {
        $pageTitle = 'Account Banned';
        if (auth()->guard('admin')->user()->status == 1) {
            return to_route('admin.dashboard');
        }
        return view('admin.banned', compact('pageTitle'));
    }

    public function requestReport()
    {
        $pageTitle            = 'Your Listed Report & Request';
        $arr['app_name']      = systemDetails()['name'];
        $arr['app_url']       = env('APP_URL');
        $arr['purchase_code'] = env('PURCHASE_CODE');
        $url = "https://license.viserlab.com/issue/get?" . http_build_query($arr);
        $response = CurlRequest::curlContent($url);
        $response = json_decode($response);
        if ($response->status == 'error') {
            return to_route('admin.dashboard')->withErrors($response->message);
        }
        $reports = $response->message[0];
        return view('admin.reports', compact('reports', 'pageTitle'));
    }

    public function reportSubmit(Request $request)
    {
        $request->validate([
            'type' => 'required|in:bug,feature',
            'message' => 'required',
        ]);
        $url = 'https://license.viserlab.com/issue/add';

        $arr['app_name']      = systemDetails()['name'];
        $arr['app_url']       = env('APP_URL');
        $arr['purchase_code'] = env('PURCHASE_CODE');
        $arr['req_type']      = $request->type;
        $arr['message']       = $request->message;
        $response = CurlRequest::curlPostContent($url, $arr);
        $response = json_decode($response);
        if ($response->status == 'error') {
            return back()->withErrors($response->message);
        }
        $notify[] = ['success', $response->message];
        return back()->withNotify($notify);
    }

    public function downloadAttachment($fileHash)
    {
        $filePath  = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $general   = gs();
        $title     = slug($general->site_name) . '- attachments.' . $extension;
        $mimetype  = mime_content_type($filePath);
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }
}
