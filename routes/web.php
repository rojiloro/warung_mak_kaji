<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\DashboardController;

// Route Halaman Utama (Bisa diakses tanpa login)
Route::get('/', function () {
    return view('welcome');
});

// ====================================================================
// SEMUA ROUTE DI BAWAH INI HANYA BISA DIAKSES JIKA SUDAH LOGIN (AUTH)
// ====================================================================
Route::middleware(['auth'])->group(function () {
    
    // Route Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route Fitur Kasir & Transaksi Belanja
    Route::get('/cashier', [CashierController::class, 'index']);
    Route::post('/products/add-to-cart/{id}', [CashierController::class, 'addToCart']);
    Route::post('/cart/remove/{id}', [CashierController::class, 'removeCart']);
    Route::post('/cart/increase/{id}', [CashierController::class, 'increaseQty']);
    Route::post('/cart/decrease/{id}', [CashierController::class, 'decreaseQty']);
    Route::post('/checkout', [CashierController::class, 'checkout']);
    Route::get('/receipt/{id}', [CashierController::class, 'receipt']);
    Route::post('/cart/clear', [CashierController::class, 'clearCart']);
    Route::post('/cart/barcode', [CashierController::class, 'scanBarcode']);
    Route::get('/cashier/search',[CashierController::class,'search']);
    Route::post('/cart/update-qty/{id}', [CashierController::class, 'updateQty']);

    // Route CRUD Produk (Daftar Barang)
    Route::resource('products', ProductController::class);

    // Route Manajemen Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';