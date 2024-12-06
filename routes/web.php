<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Admin-only routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin SPecial Dashboard
    Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
    // User Manager Path
    Route::get('/profile', [App\Http\Controllers\UserController::class, 'profilemanager'])->name('user.profile');
    Route::get('/manager/profile', [App\Http\Controllers\AdminController::class, 'profileManager'])->name('admin.profile_manager');
    Route::delete('/manager/profile/{user}', [App\Http\Controllers\AdminController::class, 'deleteProfile'])->name('admin.delete_profile');
    Route::put('/admin/user/{user}/status', [App\Http\Controllers\AdminController::class, 'changeStatus'])->name('admin.change_status');
    //  Bank Manager Path
    Route::resource('bank_accounts', App\Http\Controllers\BankAccountController::class);
    // Services Manager Path
    Route::get('/admin/services', [App\Http\Controllers\AdminController::class, 'manageServices'])->name('admin.services.index');
    Route::get('/admin/services/{service}/edit', [App\Http\Controllers\AdminController::class, 'editServiceStatus'])->name('admin.services.edit');
    Route::put('/admin/services/{service}', [App\Http\Controllers\AdminController::class, 'updateServiceStatus'])->name('admin.services.update');
    // Additional Fee path
    Route::get('/admin/services/{service}/edit-fees', [App\Http\Controllers\AdminController::class, 'editFees'])->name('admin.services.edit_fees');
    Route::put('/admin/services/{service}/update-fees', [App\Http\Controllers\AdminController::class, 'updateFees'])->name('admin.services.update_fees');
    // Discount Manager path
    Route::get('/admin/discounts', [App\Http\Controllers\AdminController::class, 'indexDiscounts'])->name('admin.discounts.index');
    Route::get('/admin/discounts/create', [App\Http\Controllers\AdminController::class, 'createDiscount'])->name('admin.discounts.create');
    Route::post('/admin/discounts', [App\Http\Controllers\AdminController::class, 'storeDiscount'])->name('admin.discounts.store');
    Route::delete('/admin/discounts/{id}', [App\Http\Controllers\AdminController::class, 'destroyDiscount'])->name('admin.discounts.destroy');
    // Manage Invoices
    Route::get('/admin/purchases', [App\Http\Controllers\PurchaseController::class, 'index'])->name('admin.purchases.index');
    Route::get('/admin/purchases/{id}', [App\Http\Controllers\PurchaseController::class, 'show'])->name('admin.purchases.show');
    Route::put('/admin/purchases/{id}/status', [App\Http\Controllers\PurchaseController::class, 'updateStatus'])->name('admin.purchases.updateStatus');
    Route::delete('/admin/purchases/{id}', [App\Http\Controllers\PurchaseController::class, 'destroy'])->name('admin.purchases.destroy');
    // Manage Affiliate Request
    Route::get('/admin/affiliate/requests', [App\Http\Controllers\AffiliateRequestController::class, 'index'])->name('admin.affiliate.requests.index');
    Route::get('/admin/affiliate/requests/{id}', [App\Http\Controllers\AffiliateRequestController::class, 'show'])->name('admin.affiliate.requests.show');
    Route::post('/admin/affiliate/requests/{id}/update', [App\Http\Controllers\AffiliateRequestController::class, 'update'])->name('admin.affiliate.requests.update');
    // Manage Affiliator Withdrawal Request
    Route::get('/admin/withdraws', [App\Http\Controllers\WithdrawController::class, 'adminIndex'])->name('admin.withdraws.index');
    Route::post('/admin/withdraws/{id}/approve', [App\Http\Controllers\WithdrawController::class, 'approve'])->name('admin.withdraws.approve');
    Route::post('/admin/withdraws/{id}/reject', [App\Http\Controllers\WithdrawController::class, 'reject'])->name('admin.withdraws.reject');
    // Manage Project Request
    Route::get('/admin/project-requests/', [App\Http\Controllers\AdminProjectRequestController::class, 'index'])->name('admin.project_requests.index');
    Route::post('/admin/project-requests/{id}/approve', [App\Http\Controllers\AdminProjectRequestController::class, 'approve'])->name('admin.project_requests.approve');
    Route::post('/admin/project-requests/{id}/reject', [App\Http\Controllers\AdminProjectRequestController::class, 'reject'])->name('admin.project_requests.reject');
    Route::get('/admin/projects', [App\Http\Controllers\AdminProjectController::class, 'index'])->name('admin.projects.index');
    Route::get('/admin/projects/{invoice}', [App\Http\Controllers\AdminProjectController::class, 'show'])->name('admin.projects.show');
    Route::post('/admin/projects/{invoice}/finish', [App\Http\Controllers\AdminProjectController::class, 'finish'])->name('admin.projects.finish');
});
// Stop Any Banned User
Route::middleware(['auth', 'check.status'])->group(function () {
// Withdrawal    
    Route::get('/withdraw', [App\Http\Controllers\WithdrawController::class, 'index'])->name('withdraw.index');
    Route::post('/withdraw/request', [App\Http\Controllers\WithdrawController::class, 'store'])->name('withdraw.request');
// User-specific routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [App\Http\Controllers\UserController::class, 'editprofile'])->name('profile.edit');
    Route::put('/profile/update', [App\Http\Controllers\UserController::class, 'updateprofile'])->name('profile.update');
// User Payement Path
    Route::get('/invoice/{id}', [App\Http\Controllers\InvoiceController::class, 'show'])->name('invoice.show');
    Route::get('/invoice/{id}/aff={affiliateCode}', [App\Http\Controllers\InvoiceController::class, 'showWithAffiliate'])->name('invoice.showWithAffiliate');
    Route::post('/invoice/{id}/process', [App\Http\Controllers\InvoiceController::class, 'process'])->name('invoice.process');
    Route::get('/purchase/{id}', [App\Http\Controllers\InvoiceController::class, 'showPurchase'])->name('purchase.show');
    Route::post('/purchase/{id}/upload-proof', [App\Http\Controllers\InvoiceController::class, 'uploadProof'])->name('purchase.uploadProof');
    Route::get('/payment/{id}/report', [App\Http\Controllers\PurchaseController::class, 'showReport'])->name('invoice.report');
    Route::post('/payment/{id}/upload-proof', [App\Http\Controllers\PurchaseController::class, 'uploadProof'])->name('invoice.uploadProof');
    Route::get('/invoice', [App\Http\Controllers\InvoiceController::class, 'index'])->name('user.invoices.index');
// User Affiliate Request
    Route::get('/affiliate/request', [App\Http\Controllers\AffiliateRequestController::class, 'create'])->name('affiliate.request.create');
    Route::post('/affiliate/request', [App\Http\Controllers\AffiliateRequestController::class, 'store'])->name('affiliate.request.store');
});
// Affiliator Only
Route::middleware(['auth', 'role:affiliator'])->group(function () {
    Route::get('/affiliate/purchases', [App\Http\Controllers\AffiliateController::class, 'index'])->name('affiliate.purchases.index');
    Route::get('/affiliate/balance', [App\Http\Controllers\AffiliateController::class, 'showBalance'])->name('affiliate.balance');
    Route::post('/affiliate/balance/update', [App\Http\Controllers\AffiliateController::class, 'updateBalance'])->name('affiliate.balance.update');
// Withdrawal    
    Route::get('/withdraw', [App\Http\Controllers\WithdrawController::class, 'index'])->name('withdraw.index');
    Route::post('/withdraw/request', [App\Http\Controllers\WithdrawController::class, 'store'])->name('withdraw.request');
// Affiliator Service Promote
    Route::get('/affiliate/services', [App\Http\Controllers\AffiliateServiceController::class, 'index'])->name('affiliate.services.index');
    Route::get('/affiliate/service/{id}', [App\Http\Controllers\AffiliateServiceController::class, 'show'])->name('affiliate.service.show');
});
// Installer Only
Route::middleware(['auth', 'role:installer'])->group(function () {
    Route::get('/project-requests', [App\Http\Controllers\ProjectRequestController::class, 'index'])->name('project.requests.index');
    Route::post('/project-requests', [App\Http\Controllers\ProjectRequestController::class, 'store'])->name('project.requests.store');
    Route::get('/project-requests/create', [App\Http\Controllers\ProjectRequestController::class, 'create'])->name('project.requests.create');
    Route::get('/project-progress', [App\Http\Controllers\ProjectRequestController::class, 'progress'])->name('project.progress.index');
    Route::post('/project-progress/{invoice}', [App\Http\Controllers\ProjectRequestController::class, 'updateProgress'])->name('project.progress.update');
    Route::post('/project-progress/{invoice}/complete', [App\Http\Controllers\ProjectRequestController::class, 'completeProject'])->name('project.progress.complete');
    Route::get('/project-progress', [App\Http\Controllers\ProjectRequestController::class, 'progress'])->name('project.progress.index');
    Route::get('/project-progress/{invoice}', [App\Http\Controllers\ProjectRequestController::class, 'showProgress'])->name('project.progress.show');
    Route::post('/project-progress/{invoice}', [App\Http\Controllers\ProjectRequestController::class, 'updateProgress'])->name('project.progress.update');
    Route::post('/project-progress/{invoice}/complete', [App\Http\Controllers\ProjectRequestController::class, 'completeProject'])->name('project.progress.complete');
    Route::get('/installer/balance', [App\Http\Controllers\InstallerController::class, 'showBalance'])->name('installer.balance');
    Route::post('/installer/balance/update', [App\Http\Controllers\InstallerController::class, 'updateBalance'])->name('installer.balance.update');
});
    // Withdrawal    
    Route::get('/withdraw', [App\Http\Controllers\WithdrawController::class, 'index'])->name('withdraw.index');
    Route::post('/withdraw/request', [App\Http\Controllers\WithdrawController::class, 'store'])->name('withdraw.request');
});

// Non User Payment Path
    Route::get('/invoice/{id}', [App\Http\Controllers\InvoiceController::class, 'show'])->name('invoice.show');
    Route::post('/invoice/{id}/apply-discount', [App\Http\Controllers\InvoiceController::class, 'applyDiscount'])->name('invoice.applyDiscount');

// Vendor Only Routes
Route::middleware(['auth', 'role:vendor'])->group(function () {
    Route::get('/vendor/services', [App\Http\Controllers\ServiceController::class, 'index'])->name('vendor.services.index');
    Route::get('/vendor/services/create', [App\Http\Controllers\ServiceController::class, 'create'])->name('vendor.services.create');
    Route::post('/vendor/services', [App\Http\Controllers\ServiceController::class, 'store'])->name('vendor.services.store');
    Route::get('/vendor/services/{service}/edit', [App\Http\Controllers\ServiceController::class, 'edit'])->name('vendor.services.edit');
    Route::put('/vendor/services/{service}', [App\Http\Controllers\ServiceController::class, 'update'])->name('vendor.services.update');
    Route::delete('/vendor/services/{service}', [App\Http\Controllers\ServiceController::class, 'destroy'])->name('vendor.services.destroy');
    Route::get('/groups', [App\Http\Controllers\VendorGroupController::class, 'index'])->name('vendor.groups.index');
    Route::get('/groups/create', [App\Http\Controllers\VendorGroupController::class, 'create'])->name('vendor.groups.create');
    Route::post('/groups', [App\Http\Controllers\VendorGroupController::class, 'store'])->name('vendor.groups.store');
    Route::get('/groups/{group}/edit', [App\Http\Controllers\VendorGroupController::class, 'edit'])->name('vendor.groups.edit');
    Route::put('/groups/{group}', [App\Http\Controllers\VendorGroupController::class, 'update'])->name('vendor.groups.update');
    Route::delete('/groups/{group}', [App\Http\Controllers\VendorGroupController::class, 'destroy'])->name('vendor.groups.destroy');
    Route::get('/vendor/balance', [App\Http\Controllers\VendorController::class, 'showBalance'])->name('vendor.balance');
    Route::post('/vendor/balance/update', [App\Http\Controllers\VendorController::class, 'updateBalance'])->name('vendor.balance.update');
});

// Sign Up Route
Route::get('/signup', [App\Http\Controllers\UserController::class, 'signupForm'])->name('signup');
Route::post('/signup', [App\Http\Controllers\UserController::class, 'signup'])->name('signup.post');



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
