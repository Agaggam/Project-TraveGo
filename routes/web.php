<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaketWisataController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PaketWisataController as AdminPaketWisataController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/paket', [PaketWisataController::class, 'index'])->name('paket.index');
Route::get('/paket/{paketWisata}', [PaketWisataController::class, 'show'])->name('paket.show');

// Guest Routes (hanya untuk yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Auth Routes (hanya untuk yang sudah login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Order Routes
    Route::get('/checkout/{paketWisata}', [OrderController::class, 'checkout'])->name('order.checkout');
    Route::post('/checkout/{paketWisata}', [OrderController::class, 'store'])->name('order.store');
    Route::get('/order/success', [OrderController::class, 'success'])->name('order.success');
    Route::get('/orders', [OrderController::class, 'history'])->name('order.history');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('order.show');
    
    // Payment Routes
    Route::post('/payment/create', [PaymentController::class, 'createTransaction'])->name('payment.create');
    Route::get('/payment/status/{orderId}', [PaymentController::class, 'getTransactionStatus'])->name('payment.status');
});

// Payment Callback (no auth required for Midtrans callback)
Route::post('/payment/callback', [OrderController::class, 'callback'])->name('payment.callback');

// Test Midtrans
require __DIR__.'/test-midtrans.php';

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/paket', [AdminPaketWisataController::class, 'index'])->name('paket.index');
    Route::get('/paket/create', [AdminPaketWisataController::class, 'create'])->name('paket.create');
    Route::post('/paket', [AdminPaketWisataController::class, 'store'])->name('paket.store');
    Route::get('/paket/{paketWisata}/edit', [AdminPaketWisataController::class, 'edit'])->name('paket.edit');
    Route::put('/paket/{paketWisata}', [AdminPaketWisataController::class, 'update'])->name('paket.update');
    Route::delete('/paket/{paketWisata}', [AdminPaketWisataController::class, 'destroy'])->name('paket.destroy');

    // Admin API JSON Routes
    Route::get('/api/paket', [AdminPaketWisataController::class, 'apiIndex'])->name('api.paket.index');
    Route::get('/api/paket/{id}', [AdminPaketWisataController::class, 'apiShow'])->name('api.paket.show');
    Route::post('/api/paket', [AdminPaketWisataController::class, 'apiStore'])->name('api.paket.store');
    Route::put('/api/paket/{id}', [AdminPaketWisataController::class, 'apiUpdate'])->name('api.paket.update');
    Route::delete('/api/paket/{id}', [AdminPaketWisataController::class, 'apiDestroy'])->name('api.paket.destroy');
});
