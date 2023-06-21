<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Auth')->group(function () {
    Route::controller('LoginController')->group(function () {
        Route::get('/', 'showLoginForm')->name('login');
        Route::post('/', 'login')->name('login');
        Route::get('logout', 'logout')->name('logout');
    });

    // Admin Password Reset

    Route::controller('ForgotPasswordController')->prefix('password')->name('password.')->group(function () {
        Route::get('reset', 'showLinkRequestForm')->name('reset');
        Route::post('reset', 'sendResetCodeEmail');
        Route::get('code-verify', 'codeVerify')->name('code.verify');
        Route::post('verify-code', 'verifyCode')->name('verify.code');
    });

    Route::controller('ResetPasswordController')->group(function () {
        Route::get('password/reset/{token}', 'showResetForm')->name('password.reset.form');
        Route::post('password/reset/change', 'reset')->name('password.change');
    });
});

Route::get('banned', 'AdminController@banned')->name('banned');

Route::middleware(['admin', 'check.status'])->group(function () {
    Route::controller('AdminController')->group(function () {
        Route::get('dashboard', 'dashboard')->name('dashboard');
        Route::get('profile', 'profile')->name('profile');
        Route::post('profile', 'profileUpdate')->name('profile.update');
        Route::get('password', 'password')->name('password');
        Route::post('password', 'passwordUpdate')->name('password.update');

        //Report Bugs
        Route::get('request-report', 'requestReport')->name('request.report');
        Route::post('request-report', 'reportSubmit');
        Route::get('download-attachments/{file_hash}', 'downloadAttachment')->name('download.attachment');
    });

    //Category Manage
    Route::middleware('check.staff')->controller('CategoryController')->name('product.category.')->prefix('category')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('delete/{id}', 'remove')->name('delete');
        Route::post('store/{id?}', 'store')->name('store');
    });

    // Brand Manage
    Route::middleware('check.staff')->controller('BrandController')->name('product.brand.')->prefix('brand')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('delete/{id}', 'remove')->name('delete');
        Route::post('store/{id?}', 'store')->name('store');
    });

    // Unit Manage
    Route::middleware('check.staff')->controller('UnitController')->name('product.unit.')->prefix('unit')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('delete/{id}', 'remove')->name('delete');
        Route::post('store/{id?}', 'store')->name('store');
    });

    // Product Manage
    Route::controller('ProductController')->name('product.')->prefix('product')->group(function () {
        Route::get('all/{scope?}', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('store/{id?}', 'store')->name('store');
        Route::get('/alert', 'alert')->name('alert');
    });

    // Warehouse Manage
    Route::middleware('check.staff')->controller('WarehouseController')->name('warehouse.')->prefix('warehouse')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('store/{id?}', 'store')->name('store');
    });

    // Manage Purchase
    Route::controller('PurchaseController')->name('purchase.')->prefix('purchase')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('add-new', 'addNew')->name('new');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('store', 'store')->name('store');
        Route::get('pdf/{id}', 'downloadDetails')->name('pdf');
        Route::post('update/{id}', 'update')->name('update');
        Route::get('product-search', 'productSearch')->name('product.search');
        Route::get('invoice-check', 'invoiceCheck')->name('invoice.check');
    });

    //Manage Purchase Return
    Route::controller('PurchaseReturnController')->name('purchase.return.')->prefix('purchase-return')->group(function () {
        Route::get('new/{id}', 'newReturn')->name('items');

        Route::get('/', 'index')->name('index');
        Route::post('store/{id}', 'store')->name('store');

        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');

        Route::get('pdf/{id}', 'downloadDetails')->name('pdf');
        Route::get('search-product', 'searchProduct')->name('search.product');
        Route::get('check-invoice', 'checkInvoice')->name('check.invoice');
    });

    //Manage Sales
    Route::controller('SaleController')->name('sale.')->prefix('sale')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');

        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');
        Route::get('pdf/{id}', 'downloadInvoice')->name('pdf');
        Route::get('search-product', 'searchProduct')->name('search.product');
        Route::get('search-customer', 'searchCustomer')->name('search.customer');

        Route::get('last-invoice', 'lastInvoice')->name('last.invoice');
    });

    //Manage Sale Return
    Route::controller('SaleReturnController')->name('sale.return.')->prefix('sale-return')->group(function () {

        Route::get('/', 'index')->name('index');
        Route::get('new/{id}', 'newReturn')->name('items');
        Route::post('store/{id}', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');
        Route::get('pdf/{id}', 'downloadInvoice')->name('pdf');
        Route::get('search-product', 'searchProduct')->name('search.product');
        Route::get('search-customer', 'searchCustomer')->name('search.customer');
    });


    //Adjustment
    Route::controller('AdjustmentController')->name('adjustment.')->prefix('adjustment')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('details/{id}', 'detailsPDF')->name('details.pdf');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');
        Route::get('search-product', 'searchProduct')->name('search.product');
    });


    // Staff
    Route::middleware('check.staff')->controller('StaffController')->name('staff.')->prefix('staff')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('store/{id?}', 'store')->name('store');
        Route::get('login/{id}', 'login')->name('login');
    });

    // Supplier
    Route::controller('SupplierController')->name('supplier.')->prefix('supplier')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('store/{id?}', 'store')->name('store');
    });


    // Customer
    Route::controller('CustomerController')->name('customer.')->prefix('customers')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('store/{id?}', 'store')->name('store');

        Route::middleware('check.staff')->group(function () {
            Route::get('notification-log/{id}', 'notificationLog')->name('notification.log');
            Route::get('send-notification/{id}', 'showNotificationSingleForm')->name('notification.single');
            Route::post('send-notification/{id}', 'sendNotificationSingle')->name('notification.single');
            Route::get('send-notification', 'showNotificationAllForm')->name('notification.all');
            Route::post('send-notification', 'sendNotificationAll')->name('notification.all.send');
            Route::get('email/detail/{id}', 'emailDetails')->name('email.details');
        });
    });

    //Payment - Supplier
    Route::controller('SupplierPaymentController')->name('supplier.payment.')->prefix('supplier/payment')->group(function () {
        Route::get('index/{id}', 'index')->name('index');
        Route::post('all-payment/{id}', 'clearPayment')->name('clear');
        Route::post('store/{id?}', 'purchasePayment')->name('store');
        Route::post('receive-payment/{id}', 'purchaseReturnPayment')->name('receive.store');
    });


    //Payment - Customer
    Route::controller('CustomerPaymentController')->name('customer.payment.')->prefix('customer/payment')->group(function () {
        Route::post('all-payment/{id}', 'clearPayment')->name('clear');
        //sale
        Route::get('index/{id}', 'index')->name('index');
        Route::post('store/{id?}', 'salePayment')->name('store');
        //sale return
        Route::post('payable/{id}', 'storeCustomerPayablePayment')->name('payable.store');
    });

    //Manage warehouse Transfer
    Route::controller('TransferController')->name('transfer.')->prefix('transfer')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('store', 'store')->name('store');
        Route::get('pdf/{id}', 'detailsPDF')->name('pdf');
        Route::post('update/{id}', 'update')->name('update');
        Route::get('search-product', 'searchProduct')->name('search.product');
    });


    //Expense
    Route::middleware('check.staff')->controller('ExpenseTypeController')->name('expense.type.')->prefix('expense-type')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('delete/{id}', 'remove')->name('delete');
        Route::post('store/{id?}', 'store')->name('store');
    });

    Route::controller('ExpenseController')->name('expense.')->prefix('expense')->group(function () {
        Route::get('/{id?}', 'index')->name('index');
        Route::post('store/{id?}', 'store')->name('store');
    });

    Route::middleware('check.staff')->controller('GeneralSettingController')->group(function () {
        // General Setting
        Route::get('general-setting', 'index')->name('setting.index');
        Route::post('general-setting', 'update')->name('setting.update');

        //configuration
        Route::get('setting/system-configuration', 'systemConfiguration')->name('setting.system.configuration');
        Route::post('setting/system-configuration', 'systemConfigurationSubmit');

        // Logo-Icon
        Route::get('setting/logo-icon', 'logoIcon')->name('setting.logo.icon');
        Route::post('setting/logo-icon', 'logoIconUpdate')->name('setting.logo.icon');
    });


    //Payment Report
    Route::controller('PaymentReportController')->name('report.payment.')->prefix('reports/payment')->group(function () {
        Route::get('supplier', 'supplierPaymentLogs')->name('supplier');
        Route::get('customer', 'customerPaymentLogs')->name('customer');
    });

    Route::get('reports/stock', 'StockReportController@index')->name('report.stock');
    Route::get('all-products', 'ProductController@allProducts')->name('product.list');

    Route::middleware('check.staff')->group(function () {
        Route::controller('DataEntryReportController')->prefix('reports/data-entry')->name('report.data.entry.')->group(function () {
            Route::get('product', 'product')->name('product');
            Route::get('customer', 'customer')->name('customer');
            Route::get('supplier', 'supplier')->name('supplier');
            Route::get('purchase', 'purchase')->name('purchase');
            Route::get('purchase-return', 'purchaseReturn')->name('purchase.return');
            Route::get('sale', 'sale')->name('sale');
            Route::get('sale-return', 'saleReturn')->name('sale.return');
            Route::get('adjustment', 'adjustment')->name('adjustment');
            Route::get('transfer', 'transfer')->name('transfer');
            Route::get('expense', 'expense')->name('expense');
            Route::get('supplier-payment', 'supplierPayment')->name('supplier.payment');
            Route::get('customer-payment', 'customerPayment')->name('customer.payment');
        });

        //Notification Setting
        Route::name('setting.notification.')->controller('NotificationController')->prefix('notification')->group(function () {
            //Template Setting
            Route::get('global', 'global')->name('global');
            Route::post('global/update', 'globalUpdate')->name('global.update');
            Route::get('templates', 'templates')->name('templates');
            Route::get('template/edit/{id}', 'templateEdit')->name('template.edit');
            Route::post('template/update/{id}', 'templateUpdate')->name('template.update');

            //Email Setting
            Route::get('email/setting', 'emailSetting')->name('email');
            Route::post('email/setting', 'emailSettingUpdate');
            Route::post('email/test', 'emailTest')->name('email.test');

            //SMS Setting
            Route::get('sms/setting', 'smsSetting')->name('sms');
            Route::post('sms/setting', 'smsSettingUpdate');
            Route::post('sms/test', 'smsTest')->name('sms.test');
        });

        //System Information
        Route::controller('SystemController')->name('system.')->prefix('system')->group(function () {
            Route::get('info', 'systemInfo')->name('info');
            Route::get('server-info', 'systemServerInfo')->name('server.info');
            Route::get('optimize', 'optimize')->name('optimize');
            Route::get('optimize-clear', 'optimizeClear')->name('optimize.clear');
        });
    });
});
