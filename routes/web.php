<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\Web\PaketController;
use App\Http\Controllers\Web\OrderController;
use App\Http\Controllers\Web\PaymentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PaketController as AdminPaketController;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/tentang-kami', [PageController::class, 'about'])->name('about');
Route::get('/destinasi', [PageController::class, 'destinasi'])->name('destinasi');
Route::get('/kontak', [PageController::class, 'kontak'])->name('kontak');

Route::get('/paket', [PaketController::class, 'index'])->name('paket.index');
Route::get('/paket/{paketWisata}', [PaketController::class, 'show'])->name('paket.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

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

Route::post('/payment/callback', [OrderController::class, 'callback'])->name('payment.callback');
require __DIR__.'/test-midtrans.php';

Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/paket', [AdminPaketController::class, 'index'])->name('paket.index');
    Route::get('/paket/create', [AdminPaketController::class, 'create'])->name('paket.create');
    Route::post('/paket', [AdminPaketController::class, 'store'])->name('paket.store');
    Route::get('/paket/{paketWisata}/edit', [AdminPaketController::class, 'edit'])->name('paket.edit');
    Route::put('/paket/{paketWisata}', [AdminPaketController::class, 'update'])->name('paket.update');
    Route::delete('/paket/{paketWisata}', [AdminPaketController::class, 'destroy'])->name('paket.destroy');
});
