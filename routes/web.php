<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use KhmerPdf\LaravelKhPdf\Facades\PdfKh;
use App\Models\Invoice;
use App\Http\Controllers\{
    AccountingController,
    AddNewOrderController,
    AdminAgentsController,
    AdministrationController,
    AllOrdersController,
    CustAccountController,
    CustFinanceController,
    CustomerContactController,
    CustomersController,
    InvoiceController,
    PermissionController,
    DashboardController,
    LocationController,
    RoleController,
    ProfileController,
    RegisterController,
    ReportController,
    TariffController,
    TestController,
    UnpaidInvoicecontroller,
    UserController,
    RequestChangeController,
    UserGroupsController,
    BandwidthController,
    CaseController,
    RequestTestingController,
    IpPoolController,
};


use App\Http\Controllers\Api\APIController;
/*
|--------------------------------------------------------------------------
| Public Route
|--------------------------------------------------------------------------
*/
        
Route::get('/', fn() => redirect("login"));
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Public API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('api')->group(function () {
    Route::get('/customers/data', [APIController::class, 'getCustomerData']);
    Route::get('/request-changes/data', [APIController::class, 'getAllRequestChangeData']);
    Route::get('/customers/ts_data', [APIController::class, 'getTSCustomerData']);
    Route::get('/request-testing/data', [APIController::class, 'getAllRequestTestingData']);

});


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Home Dashboard
    Route::get('/home', [DashboardController::class, 'index'])->middleware('verified')->name('home');
    Route::get('/dashboard/updating', [DashboardController::class, 'updating'])->name('updating');
    Route::get('/dashboard/customers_by_location', [DashboardController::class, 'customersByLocation'])->name('dashboard.customers_by_location');

    // Web test route (admin only)
    Route::get('/web-test', fn() => view('web-test.index'))->middleware('role:admin');

    /*
    |--------------------------------------------------------------------------
    | Admin-only Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('administration/permissions', PermissionController::class);
        Route::get('administration/permissions/{permissionId}/delete', [PermissionController::class, 'destroy']);

        Route::resource('administration/roles', RoleController::class);
        Route::get('administration/roles/{roleId}/delete', [RoleController::class, 'destroy']);
        Route::get('administration/roles/{roleID}/give-perm', [RoleController::class, 'showPermToRole']);
        Route::put('administration/roles/{roleID}/give-perm', [RoleController::class, 'givePermToRole']);

        Route::resource('administration/users', UserController::class);
        Route::get('administration/users/{userId}/delete', [UserController::class, 'destroy']);
        
        Route::resource('administration/user-groups', UserGroupsController::class);

        Route::resource('administration/tariffs', TariffController::class);
        Route::get('administration/tariffs/create', [TariffController::class, 'create'])->name('tariffs.create');
        Route::post('administration/tariffs', [TariffController::class, 'store'])->name('tariffs.store');
        Route::patch('/administration/tariffs/{tariff}/toggle-status', [TariffController::class, 'toggleStatus'])->name('tariffs.toggleStatus');
        
        Route::resource('administration/bandwidths', BandwidthController::class);
        Route::patch('administration/bandwidths/{bandwidth}/toggle', [BandwidthController::class, 'toggleStatus'])->name('bandwidths.toggle');

        Route::resource('administration/locations', LocationController::class);
        Route::get('administration/locations/create', [LocationController::class, 'create'])->name('locations.create');
        Route::post('administration/locations', [LocationController::class, 'store'])->name('locations.store');
        Route::delete('/administration/locations/{location}', [LocationController::class, 'destroy'])->name('locations.destroy');
        Route::patch('administration/locations/{location}/toggle-status', [LocationController::class, 'toggleStatus'])->name('locations.toggleStatus');

    });

    /*
    |--------------------------------------------------------------------------
    | Admin and User Shared Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth'])->group(function () {
        // Register
        Route::get('register', [RegisterController::class, 'index'])->name('register');
        Route::post('register', [RegisterController::class, 'storeRegister'])->name('storeRegister');

        // Customers
        Route::get('/customers', [CustomersController::class, 'index'])->name('customers');
        Route::get('/customers-noc', [CustomersController::class, 'indexNoc'])->name('customers.noc');

        Route::get('/customers/data', [CustomersController::class, 'getCustomers'])->name('customers.data');

        Route::get('/customers/download', [CustomersController::class, 'downloadCustomerData'])->name('customers.download');
        Route::get('/customers/downloadExcel', [CustomersController::class, 'downloadExcel'])->name('customers.downloadExcel');
        
        Route::get('/ts-customers', [CustomersController::class, 'TSCustomers'])->name('ts-customers');
        Route::get('/ts-customers/data', [CustomersController::class, 'getTSCustomerData'])->name('ts-customers.data');
        
        Route::get('/customers/{customer_id}/view-details', [CustomersController::class, 'viewDetails'])->name('customers.view-details');
        Route::get('/customers/{customer_id}/edit-details', [CustomersController::class, 'editDetails'])->name('customers.edit-details');
        Route::put('/customers/{customer_id}/edit-details', [CustomersController::class, 'updateDetails'])->name('customers.update-details');
        Route::delete('/customers/{customer_id}/delete', [CustomersController::class, 'destroy'])->name('customers.delete');
        Route::get('/customers/{customer_id}/user-agreement', [CustomersController::class, 'userAgreement'])->name('customers.user-agreement');

        // Invoices
        Route::get('invoices', [InvoiceController::class, 'index'])->name('invoices');
        Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
        Route::post('/invoices/create', [InvoiceController::class, 'store'])->name('invoices.store');
        Route::get('/customer/{id}', [InvoiceController::class, 'getCustomerInf'])->name('customer.get');
        Route::get('/unpaid-invoices', [UnpaidInvoicecontroller::class, 'index'])->name('unpaid-invoices');
        Route::post('/invoices/update-payment/{invoiceId}', [UnpaidInvoicecontroller::class, 'updatePaymentStatus'])->name('invoices.update-payment');
        Route::get('/invoices/view/{invoiceId}', [InvoiceController::class, 'viewInvoice'])->name('invoice.view');
        Route::get('/invoices/{id}/print', [InvoiceController::class, 'print'])->name('invoices.print');
    
        Route::get('/invoices/download-all-zip', [AccountingController::class, 'downloadAllInvoicesAsZip'])->name('invoices.download-all-zip');
        Route::get('/invoices/download-zip/{filename}', [AccountingController::class, 'downloadZip'])->name('invoices.downloadZip');
        Route::get('/invoices/generate-and-download-zip', [AccountingController::class, 'downloadAllInvoicesAsZip'])->name('invoices.generateZip');

        // Request Change
        Route::get('/request-change', [RequestChangeController::class, 'index'])->name('request-change');
        Route::get('/request-change/create', [RequestChangeController::class, 'create'])->name('request-change.create');
        Route::post('/request-change/tariff',     [RequestChangeController::class, 'storeTariff'])->name('request-change.store.tariff');
        Route::post('/request-change/status',     [RequestChangeController::class, 'storeStatus'])->name('request-change.store.status');
        Route::post('/request-change/relocation', [RequestChangeController::class, 'storeRelocation'])->name('request-change.store.relocation');
        Route::post('/request-change/remark',     [RequestChangeController::class, 'storeRemark'])->name('request-change.store.remark');
        Route::post('/request-change/add-ip',     [RequestChangeController::class, 'storeAddIp'])->name('request-change.store.add-ip');
        Route::post('/request-change/remove-ip',  [RequestChangeController::class, 'storeRemoveIp'])->name('request-change.store.remove-ip');
        Route::post('/request-change/change-ip',  [RequestChangeController::class, 'storeChangeIp'])->name('request-change.store.change-ip');
        Route::delete('/request-change/{id}', [RequestChangeController::class, 'destroy'])->name('request-change.destroy');
        Route::get('/request-change/{id}', [RequestChangeController::class, 'show'])->name('request-change.show');
        Route::get('/customers/{id}', [RegisterController::class, 'show']);
        
        // Request Testing
        Route::get('/noc/request-testing', [RequestTestingController::class, 'index'])->name('request-testing');
        Route::get('/noc/request-testing/create', [RequestTestingController::class, 'create'])->name('request-testing.create');
        Route::post('/noc/request-testing/create', [RequestTestingController::class, 'store'])->name('request-testing.store');
        Route::post('/noc/request-testing/{id}/complete', [RequestTestingController::class, 'complete'])->name('request-testing.complete');
        Route::delete('/noc/request-testing/{id}', [RequestTestingController::class, 'destroy'])->name('request-testing.destroy');

        // Accounting
        Route::get('/accounting/upcoming-statement', [AccountingController::class, 'upcomingStatement'])->name('accounting.upcoming-statement');
        Route::post('/accounting/upcoming-invoice-generate', [AccountingController::class, 'upcomingInvoiceGenerate'])->name('accounting.upcoming-invoice-generate');
        Route::get('/accounting/view-and-download-invoices', [AccountingController::class, 'viewAndDownloadInvoices'])->name('accounting.view-and-download-invoices');
        
        // Schedule Cases
        Route::get('/noc/schedule/request', [CaseController::class, 'index'])->name('schedule.request');
        Route::get('/noc/schedule/new-register', [CaseController::class, 'SchNewRegister'])->name('schedule.new-register');
        Route::get('/noc/schedule/new-register/data', [CaseController::class, 'schNewRegisterData'])->name('schedule.new-register.data');
        Route::post('/noc/schedule/new-register/{customer_id}/complete', [CaseController::class, 'completeNewRegister'])->name('schedule.new-register.complete');
        Route::delete('/noc/schedule/new-register/{id}/delete', [CaseController::class, 'deleteSchNewRegister'])->name('schedule.request.destroy');


        // Ip Pool
        Route::get('administration/ip-pools', [IpPoolController::class, 'index'])->name('ip.pools.index');
        Route::get('administration/ip-pools/create', [IpPoolController::class, 'viewCreate'])->name('ip.pools.viewCreate');
        Route::post('administration/ip-pools/create', [IpPoolController::class, 'create'])->name('ip.pools.create');
        Route::get('administration/ip-pools/{ipPool}/edit', [IpPoolController::class, 'edit'])->name('ip.pools.edit');
        Route::put('administration/ip-pools/{ipPool}', [IpPoolController::class, 'update'])->name('ip.pools.update');
        Route::get('administration/ip-pools/{pool_id}/ip-inventory', [IpPoolController::class, 'showIpInventory'])->name('ip.pools.showIpInventory');

    });
});
