<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | REGISTER & LOGIN (BIARKAN TETAP AKTIF)
    |--------------------------------------------------------------------------
    */
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    // Proses simpan register
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    // Proses masuk akun
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    /*
    |--------------------------------------------------------------------------
    | ✂️ RUTE FORGOT PASSWORD EMAIL BAWAAN LARAVEL SUDAH DIHAPUS DARI SINI
    |--------------------------------------------------------------------------
    | (Karena sudah digantikan oleh rute Custom OTP WhatsApp di web.php)
    |
    */
});

Route::middleware('auth')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | LOGOUT (BIARKAN TETAP AKTIF)
    |--------------------------------------------------------------------------
    */
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    /*
    |--------------------------------------------------------------------------
    | ✂️ RUTE VERIFIKASI EMAIL & CONFIRM PASSWORD JALUR EMAIL DIHAPUS
    |--------------------------------------------------------------------------
    | (Karena sistem UB GYM murni berbasis nomor WhatsApp tanpa kolom email)
    |
    */
});