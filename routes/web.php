<?php

use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ManagementController;
// Import Controller Admin
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PersonalTrainerController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RetailController;
use App\Http\Controllers\Owner\OwnerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// --- AREA OWNER ---
Route::middleware(['auth', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [OwnerController::class, 'dashboard'])->name('dashboard');

    // Kelola Admin
    Route::get('/admins', [OwnerController::class, 'indexAdmin'])->name('admins');
    Route::post('/admins', [OwnerController::class, 'storeAdmin'])->name('admins.store');

    // Settings Harga
    Route::get('/settings', [OwnerController::class, 'settings'])->name('settings');
    Route::post('/settings', [OwnerController::class, 'updateSettings'])->name('settings.update');

    // Paket PT
    Route::get('/pt-packages', [OwnerController::class, 'indexPtPackage'])->name('pt-packages');
    Route::post('/pt-packages', [OwnerController::class, 'storePtPackage'])->name('pt-packages.store');

    // Laporan
    Route::get('/reports', [OwnerController::class, 'report'])->name('reports');
});

// --- AREA ADMIN ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // 1. Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Kehadiran (Tamu & Member)
    Route::prefix('attendance')->name('attendance.')->group(function () {
        Route::get('/', [AttendanceController::class, 'index'])->name('index');
        Route::post('/process', [AttendanceController::class, 'process'])->name('process');
    });

    // 3. Kasir Retail
    Route::get('/retail', [RetailController::class, 'index'])->name('retail.index');
    Route::post('/retail/store', [RetailController::class, 'store'])->name('retail.store');

    // 4. Beli Paket & Aktivasi
    Route::prefix('package')->name('package.')->group(function () {
        Route::get('/', [PackageController::class, 'index'])->name('index');
        Route::post('/activate', [PackageController::class, 'activateMember'])->name('activate');
        Route::post('/buy', [PackageController::class, 'buyPackage'])->name('buy');
        Route::post('/buy-pt', [PackageController::class, 'buyPT'])->name('buy_pt');
    });

    // 5. Sesi PT
    Route::get('/pt-sessions', [PersonalTrainerController::class, 'index'])->name('pt.index');
    Route::post('/pt-sessions/cut/{id}', [PersonalTrainerController::class, 'cutSession'])->name('pt.cut');

    // 6. Manajemen Data
    Route::get('/data/members', [ManagementController::class, 'members'])->name('data.members');
    Route::post('/data/members/update/{id}', [ManagementController::class, 'updateMember'])
        ->name('data.members.update');

    Route::patch('/data/members/toggle/{id}', [ManagementController::class, 'toggleStatus'])
        ->name('data.members.toggle');

    // Manajemen Data Produk
    Route::get('/data/products', [ManagementController::class, 'products'])->name('data.products');

    // Route yang hilang tadi:
    Route::post('/data/products/store', [ManagementController::class, 'storeProduct'])->name('data.products.store');

    Route::put('/data/products/update/{id}', [ManagementController::class, 'updateProduct'])->name('data.products.update');
    Route::delete('/data/products/delete/{id}', [ManagementController::class, 'destroyProduct'])->name('data.products.delete');

    // 7. Laporan
    Route::get('/report/transactions', [ReportController::class, 'transactions'])->name('report.transactions');
    Route::get('/report/attendance', [ReportController::class, 'attendance'])->name('report.attendance');
});

// --- AREA PROFILE (Breeze) ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
