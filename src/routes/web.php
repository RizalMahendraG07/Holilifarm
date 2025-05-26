<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\LupaKatasandiController;
use App\Http\Controllers\ResetPassword;

// Public routes (tidak perlu login)
Route::get('/', [LandingPageController::class, 'index']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/lupakatasandi', [AuthController::class, 'showLupaKatasandi'])->name('lupakatasandi');
// Pemesanan
Route::post('/pesan', [PemesananController::class, 'store'])->name('pesan.store');


// Form input email (lupa password)
Route::get('forgot-password', [LupaKatasandiController::class, 'showLinkRequestForm'])->name('password.request');

// Kirim link ke email
Route::post('forgot-password', [LupaKatasandiController::class, 'sendResetLinkEmail'])->name('password.email');

// Form untuk set password baru
Route::get('reset-password/{token}', [ResetPassword::class, 'showResetForm'])->name('password.reset');

// Simpan password baru
Route::post('reset-password', [ResetPassword::class, 'reset'])->name('password.update');


// Routes yang butuh login
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/grafik', [DashboardController::class, 'grafik'])->name('grafik.index');

    // Produk
    Route::get('/produk', [DashboardController::class, 'index'])->name('products.index');
    Route::get('/products/create', [DashboardController::class, 'create'])->name('products.create');
    Route::post('/products', [DashboardController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [DashboardController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [DashboardController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [DashboardController::class, 'destroy'])->name('products.destroy');

    // Informasi
    Route::get('/informasi', [InformasiController::class, 'index'])->name('informasi.index');
    Route::get('/informasi/create', [InformasiController::class, 'create'])->name('informasi.create');
    Route::post('/informasi', [InformasiController::class, 'store'])->name('informasi.store');
    Route::get('/informasi/{id}/edit', [InformasiController::class, 'edit'])->name('informasi.edit');
    Route::put('/informasi/{id}', [InformasiController::class, 'update'])->name('informasi.update');
    Route::delete('/informasi/{id}', [InformasiController::class, 'destroy'])->name('informasi.destroy');

    // Riwayat
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/create', [RiwayatController::class, 'create'])->name('riwayat.create');
    Route::post('/riwayat', [RiwayatController::class, 'store'])->name('riwayat.store');
    Route::get('/riwayat/{id}/edit', [RiwayatController::class, 'edit'])->name('riwayat.edit');
    Route::put('/riwayat/{id}', [RiwayatController::class, 'update'])->name('riwayat.update');
    Route::delete('/riwayat/{id}', [RiwayatController::class, 'destroy'])->name('riwayat.destroy');

    
});
