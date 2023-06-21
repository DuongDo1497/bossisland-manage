<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerPayment;
use App\Models\SupplierPayment;

class PaymentReportController extends Controller
{
    public function supplierPaymentLogs()
    {
        $pageTitle   = 'Supplier Payments';
        $paymentLogs = SupplierPayment::dateFilter()->with('supplier:id,name', 'purchase:id,invoice_no', 'purchaseReturn.purchase:id,invoice_no');

        $keyword     = request()->search;

        if ($keyword) {
            $paymentLogs->where('trx', $keyword)
                ->orWhereHas('supplier', function ($q) use ($keyword) {
                    $q->where('name', 'LIKE', '%' . $keyword . '%');
                })->orWhereHas('purchase', function ($q) use ($keyword) {
                    $q->where('invoice_no', $keyword);
                })->orWhereHas('purchaseReturn.purchase', function ($q) use ($keyword) {
                    $q->where('invoice_no', $keyword);
                });
        }
        $paymentLogs->filter(['remark']);

        if (request()->print) {
            $paymentLogs = $paymentLogs->latest()->get();
            return downloadPDF('pdf.payment_supplier.list', compact('pageTitle', 'paymentLogs'));
        }
        $paymentLogs = $paymentLogs->latest()->paginate(getPaginate());

        $remarks = SupplierPayment::groupBy('remark')->get('remark')->pluck('remark');
        $pdfButton = true;
        return view('admin.payment.supplier.log', compact('pageTitle', 'paymentLogs', 'pdfButton', 'remarks'));
    }


    public function customerPaymentLogs()
    {
        $pageTitle   = 'Customer Payments';
        $paymentLogs = CustomerPayment::dateFilter()->with('customer:id,name', 'sale:id,invoice_no', 'saleReturn.sale:id,invoice_no');

        $keyword     = request()->search;

        if ($keyword) {
            $paymentLogs->where('trx', $keyword)
                ->orWhereHas('customer', function ($q) use ($keyword) {
                    $q->where('name', 'LIKE', '%' . $keyword . '%');
                })->orWhereHas('sale', function ($q) use ($keyword) {
                    $q->where('invoice_no', $keyword);
                })->orWhereHas('saleReturn.sale', function ($q) use ($keyword) {
                    $q->where('invoice_no', $keyword);
                });
        }

        $paymentLogs->filter(['remark']);

        if (request()->print) {
            $paymentLogs = $paymentLogs->latest()->get();
            return downloadPDF('pdf.payment_customer.list', compact('pageTitle', 'paymentLogs'));
        }

        $paymentLogs = $paymentLogs->paginate(getPaginate());
        $pdfButton = true;
        $remarks = CustomerPayment::groupBy('remark')->get('remark')->pluck('remark');
        return view('admin.payment.customer.log', compact('pageTitle', 'paymentLogs', 'pdfButton', 'remarks'));
    }
}
