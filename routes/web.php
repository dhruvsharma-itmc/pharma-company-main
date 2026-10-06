<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ServiceController;
use App\Http\Controllers\Frontend\SampleSubmissionController as FrontendSampleSubmissionController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\Frontend\VerifyController;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceCategoryController;
use App\Http\Controllers\Admin\ServiceItemController;
use App\Http\Controllers\Admin\AdditionalServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CoaReportController;
use App\Http\Controllers\Admin\SampleSubmissionController as AdminSampleSubmissionController;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about-us', [HomeController::class, 'about'])->name('about');
Route::get('/products', [HomeController::class, 'products'])->name('products');
Route::get('/contact-us', [HomeController::class, 'contact'])->name('contact');

/*
|--------------------------------------------------------------------------
| Batch Verification
|--------------------------------------------------------------------------
*/

Route::get('/verify', [VerifyController::class, 'index'])->name('verify.index');
Route::post('/verify', [VerifyController::class, 'check'])->name('verify.check');
Route::get('/verify/report/{report}/download', [VerifyController::class, 'downloadReport'])->name('verify.report.download');

/*
|--------------------------------------------------------------------------
| Services / What We Verify
|--------------------------------------------------------------------------
*/

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{categorySlug}/{itemSlug}', [ServiceController::class, 'item'])->name('services.item');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

/*
|--------------------------------------------------------------------------
| Cart Routes
|--------------------------------------------------------------------------
*/

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{serviceItem}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{cartKey}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

/*
|--------------------------------------------------------------------------
| Frontend Submit Sample
|--------------------------------------------------------------------------
*/

Route::get('/submit-sample', [FrontendSampleSubmissionController::class, 'create'])->name('sample.submit');
Route::post('/submit-sample', [FrontendSampleSubmissionController::class, 'store'])->name('sample.submit.store');

/*
|--------------------------------------------------------------------------
| Customer Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard/login', [UserDashboardController::class, 'showLogin'])->name('user.login');
Route::post('/dashboard/login', [UserDashboardController::class, 'login'])->name('user.login.submit');
Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
Route::get('/dashboard/submissions/{sampleSubmission}', [UserDashboardController::class, 'show'])->name('user.submissions.show');
Route::post('/dashboard/submissions/{sampleSubmission}/payment-proof', [UserDashboardController::class, 'updatePaymentProof'])->name('user.submissions.payment-proof');
Route::post('/dashboard/logout', [UserDashboardController::class, 'logout'])->name('user.logout');

/*
|--------------------------------------------------------------------------
| Login Redirect
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('service-categories', ServiceCategoryController::class)->except(['show']);
        Route::resource('service-items', ServiceItemController::class)->except(['show']);
        Route::resource('additional-services', AdditionalServiceController::class)->except(['show']);

        Route::resource('coa-reports', CoaReportController::class)->except(['show']);

        /*
        |--------------------------------------------------------------------------
        | Admin Sample Submissions
        |--------------------------------------------------------------------------
        | Important:
        | Yahan AdminSampleSubmissionController use hoga,
        | FrontendSampleSubmissionController nahi.
        */
        Route::resource('sample-submissions', AdminSampleSubmissionController::class)->except(['create', 'store']);

        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});
