<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| LANDING PAGE
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\LandingPageController;

Route::get('/', [LandingPageController::class, 'index'])->name('landing');
Route::get('/test-wa', function () {

    return \App\Services\FonnteService::send(
        '6289674901212',
        'Test WhatsApp dari sistem gym 🔥'
    );

});
/*
|--------------------------------------------------------------------------
| OWNER CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Http\Controllers\Owner\AdminController as OwnerAdminController;
use App\Http\Controllers\Owner\SettingController as OwnerSettingController;
use App\Http\Controllers\Owner\PtPackageController as OwnerPtPackageController;
use App\Http\Controllers\Owner\ReportController as OwnerReportController;
use App\Http\Controllers\Owner\MemberController as OwnerMemberController;
use App\Http\Controllers\Owner\ProductController as OwnerProductController;



/*
|--------------------------------------------------------------------------
| ADMIN CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ManagementController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PersonalTrainerController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\RetailController;
use App\Http\Controllers\Admin\VerificationController;


/*
|--------------------------------------------------------------------------
| MEMBER CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
use App\Http\Controllers\Member\PackageController as MemberPackageController;

/*
|--------------------------------------------------------------------------
| PROFILE CONTROLLER
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\PasswordResetController;

/*
|--------------------------------------------------------------------------
| OWNER AREA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:owner'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {

        /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

        Route::get('/dashboard', [OwnerDashboardController::class, 'index'])
            ->name('dashboard');

        /*
    |--------------------------------------------------------------------------
    | ADMIN MANAGEMENT
    |--------------------------------------------------------------------------
    */

      Route::prefix('admins')->name('admins.')->group(function () {

    Route::get('/', [OwnerAdminController::class, 'index'])
        ->name('index');

    Route::post('/store', [OwnerAdminController::class, 'store'])
        ->name('store');

    // UPDATE DATA ADMIN
    Route::put('/update/{id}', [OwnerAdminController::class, 'update'])
        ->name('update');

    // UPDATE PASSWORD
    Route::put('/password/{id}', [OwnerAdminController::class, 'updatePassword'])
        ->name('password');

    // TOGGLE AKTIF / NONAKTIF
    Route::delete('/destroy/{id}', [OwnerAdminController::class, 'destroy'])
        ->name('destroy');
});

        /*
    |--------------------------------------------------------------------------
    | SETTINGS
    |--------------------------------------------------------------------------
    */

        Route::prefix('settings')->name('settings.')->group(function () {

            Route::get('/', [OwnerSettingController::class, 'index'])
                ->name('index');

            Route::post('/update', [OwnerSettingController::class, 'update'])
                ->name('update');
        });

        /*
    |--------------------------------------------------------------------------
    | PT PACKAGES
    |--------------------------------------------------------------------------
    */

        Route::prefix('pt-packages')->name('pt-packages.')->group(function () {

            Route::get('/', [OwnerPtPackageController::class, 'index'])
                ->name('index');

            Route::post('/store', [OwnerPtPackageController::class, 'store'])
                ->name('store');

            Route::put('/update/{id}', [OwnerPtPackageController::class, 'update'])
                ->name('update');

            Route::patch('/toggle/{id}', [OwnerPtPackageController::class, 'toggleStatus'])
                ->name('toggle');

            Route::delete('/delete/{id}', [OwnerPtPackageController::class, 'destroy'])
                ->name('delete');
        });

        Route::prefix('members')->name('members.')->group(function () {

            Route::get('/', [OwnerMemberController::class, 'index'])
                ->name('index');

            Route::get('/{id}', [OwnerMemberController::class, 'show'])
                ->name('show');
        });

      /*
        |--------------------------------------------------------------------------
        | PRODUCTS (OWNER AREA)
        |--------------------------------------------------------------------------
        */
        Route::prefix('products')->name('products.')->group(function () {

            Route::get('/', [OwnerProductController::class, 'index'])
                ->name('index');

            Route::get('/{id}', [OwnerProductController::class, 'show'])
                ->name('show');
                
            // 🌟 TAMBAHKAN ROUTE BARU INI UNTUK TOGGLE STATUS DI SISI OWNER
            Route::patch('/toggle/{id}', [OwnerProductController::class, 'toggleProductStatus'])
                ->name('toggle');
        });
        /*
    |--------------------------------------------------------------------------
    | REPORTS
    |--------------------------------------------------------------------------
    */

        Route::prefix('reports')->name('reports.')->group(function () {

            Route::get('/transactions', [OwnerReportController::class, 'transactions'])
                ->name('transactions');
            Route::get('/transactions/export/excel', [OwnerReportController::class, 'exportTransactionsExcel'])
                ->name('transactions.export.excel');

            Route::get('/transactions/export/pdf', [OwnerReportController::class, 'exportTransactionsPdf'])
                ->name('transactions.export.pdf');

            Route::get('/attendance', [OwnerReportController::class, 'attendance'])
                ->name('attendance');
        });

         Route::get('/ajax/wa-status', function() {
    // Memanggil fungsi cache yang sudah kamu buat
    return response()->json(['status' => \App\Services\FonnteService::checkGatewayStatus()]);
})->name('ajax.wa.status');
    });

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        /*
    |--------------------------------------------------------------------------
    | ATTENDANCE
    |--------------------------------------------------------------------------
    */

        Route::prefix('attendance')->name('attendance.')->group(function () {

            Route::get('/', [AttendanceController::class, 'index'])
                ->name('index');

            Route::post('/process', [AttendanceController::class, 'process'])
                ->name('process');
        });

        /*
    |--------------------------------------------------------------------------
    | RETAIL
    |--------------------------------------------------------------------------
    */

        Route::get('/retail', [RetailController::class, 'index'])
            ->name('retail.index');

        Route::post('/retail/store', [RetailController::class, 'store'])
            ->name('retail.store');

        /*
    |--------------------------------------------------------------------------
    | PACKAGE
    |--------------------------------------------------------------------------
    */

        Route::prefix('package')->name('package.')->group(function () {

            Route::get('/', [PackageController::class, 'index'])
                ->name('index');

            Route::post('/activate', [PackageController::class, 'activateMember'])
                ->name('activate');

            Route::post('/buy', [PackageController::class, 'buyPackage'])
                ->name('buy');

            Route::post('/buy-pt', [PackageController::class, 'buyPT'])
                ->name('buy_pt');

            Route::patch('/transaction/cancel/{id}', [PackageController::class, 'cancelTransaction'])
                ->name('transaction.cancel');
        });

        /*
    |--------------------------------------------------------------------------
    | VERIFICATIONS
    |--------------------------------------------------------------------------
    */

        Route::prefix('verifications')->name('verifications.')->group(function () {

            Route::get('/', [VerificationController::class, 'index'])
                ->name('index');

            Route::patch('/approve/{id}', [VerificationController::class, 'approve'])
                ->name('approve');

            Route::patch('/reject/{id}', [VerificationController::class, 'reject'])
                ->name('reject');
        });

        /*
    |--------------------------------------------------------------------------
    | PT SESSION
    |--------------------------------------------------------------------------
    */

        Route::get('/pt-sessions', [PersonalTrainerController::class, 'index'])
            ->name('pt.index');

        Route::post('/pt-sessions/cut/{id}', [PersonalTrainerController::class, 'cutSession'])
            ->name('pt.cut');

        /*
    |--------------------------------------------------------------------------
    | MEMBER MANAGEMENT
    |--------------------------------------------------------------------------
    */

        Route::get('/data/members', [ManagementController::class, 'members'])
            ->name('data.members');

        Route::post('/data/members/update/{id}', [ManagementController::class, 'updateMember'])
            ->name('data.members.update');

        Route::patch('/data/members/toggle/{id}', [ManagementController::class, 'toggleStatus'])
            ->name('data.members.toggle');

        Route::get(
            '/admin/data/members/export',
            [ManagementController::class, 'exportMembers']
        )->name('data.members.export');

        /*
    |--------------------------------------------------------------------------
    | PRODUCT MANAGEMENT
    |--------------------------------------------------------------------------
    */

        Route::get('/data/products', [ManagementController::class, 'products'])
            ->name('data.products');

        Route::post('/data/products/store', [ManagementController::class, 'storeProduct'])
            ->name('data.products.store');

        Route::put('/data/products/update/{id}', [ManagementController::class, 'updateProduct'])
            ->name('data.products.update');

        Route::delete('/data/products/delete/{id}', [ManagementController::class, 'destroyProduct'])
            ->name('data.products.delete');

            Route::patch('/data/products/toggle/{id}', [ManagementController::class, 'toggleProductStatus'])
            ->name('data.products.toggle');

        /*
    |--------------------------------------------------------------------------
    | REPORTS
    |--------------------------------------------------------------------------
    */

        Route::get('/report/transactions', [AdminReportController::class, 'transactions'])
            ->name('report.transactions');

        Route::get('/report/transactions/export-excel', [AdminReportController::class, 'exportExcel'])
            ->name('report.transactions.excel');

        Route::get('/report/transactions/export-pdf', [AdminReportController::class, 'exportPdf'])
            ->name('report.transactions.pdf');

        Route::get('/report/attendance', [AdminReportController::class, 'attendance'])
            ->name('report.attendance');

        Route::get('/report/attendance/export', [AdminReportController::class, 'exportAttendanceExcel'])
            ->name('report.attendance.export');

        Route::get('/report/pt-activity/export', [AdminReportController::class, 'exportPtActivityExcel'])
            ->name('report.pt_activity.export');

      Route::get('/whatsapp-logs', [\App\Http\Controllers\Admin\WhatsappLogController::class, 'index'])
            ->name('whatsapp.logs');

            Route::get('/ajax/wa-status', function() {
    // Memanggil fungsi cache yang sudah kamu buat
    return response()->json(['status' => \App\Services\FonnteService::checkGatewayStatus()]);
})->name('ajax.wa.status');
    });

    /*
    |--------------------------------------------------------------------------
    | WHATSAPP LOGS MANAGEMENT
    |--------------------------------------------------------------------------
    */

/*
|--------------------------------------------------------------------------
| MEMBER AREA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:member'])
    ->prefix('member')
    ->name('member.')
    ->group(function () {

        Route::get('/dashboard', [MemberDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/activities', [MemberDashboardController::class, 'activities'])
            ->name('activities');

        Route::get('/transactions', [MemberDashboardController::class, 'transactions'])
            ->name('transactions');

        Route::get('/transaction/{id}', [MemberDashboardController::class, 'getTransactionDetail']);

        Route::put('/transaction/{id}/reupload', [MemberPackageController::class, 'reupload'])
            ->name('package.reupload');

        Route::post('/package/store', [MemberPackageController::class, 'store'])
            ->name('package.store');
    });

/*
|--------------------------------------------------------------------------
| PROFILE AREA
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


Route::middleware('guest')->group(function () {
    // 1. Halaman Form Minta OTP (Masukkan No WA)
    Route::get('forgot-password', [PasswordResetController::class, 'create'])
                ->name('password.request');

    // 2. Proses pembuatan OTP & Kirim via Fonnte
    Route::post('forgot-password', [PasswordResetController::class, 'store'])
                ->name('password.whatsapp');

    // 3. Halaman Form Verifikasi OTP & Input Password Baru
    Route::get('reset-password/{whatsapp}', [PasswordResetController::class, 'edit'])
                ->name('password.reset');

    // 4. Proses Update Password Baru ke Database
    Route::post('reset-password', [PasswordResetController::class, 'update'])
                ->name('password.update');
});

require __DIR__ . '/auth.php';
