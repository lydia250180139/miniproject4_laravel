<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

// Redirect utama ke Login Admin
Route::get('/', fn () => redirect()->route('login.admin'));
Route::get('/login', fn () => redirect()->route('login.admin'))->name('login');

// Portal Login Tamu (Guest)
Route::middleware('guest')->group(function () {
    // Portal Login Administrator
    Route::get('/login/admin', [AuthController::class, 'showAdmin'])->name('login.admin');
    Route::post('/login/admin', [AuthController::class, 'loginAdmin'])->name('login.admin.post');

    // Portal Login Staff
    Route::get('/login/staff', [AuthController::class, 'showStaff'])->name('login.staff');
    Route::post('/login/staff', [AuthController::class, 'loginStaff'])->name('login.staff.post');
});

// Area Terproteksi (Harus Login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Fitur Umum (Admin & Staff)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    // Transaksi & Mutasi Stok (Admin & Staff)
    Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
    Route::get('/stock/create', [StockController::class, 'create'])->name('stock.create');
    Route::post('/stock', [StockController::class, 'store'])->name('stock.store');

    // Fitur Khusus Administrator (Akses Terlarang 403 untuk Staff)
    Route::middleware('role:admin')->group(function () {
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

        Route::resource('categories', CategoryController::class)->except('show');
        Route::resource('suppliers', SupplierController::class)->except('show');
    });

    // Detail Produk (Ditaruh setelah /products/create agar tidak bentrok)
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
});
