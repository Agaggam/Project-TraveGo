<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
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
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/paket', [AdminPaketWisataController::class, 'index'])->name('paket.index');
    Route::get('/paket/create', [AdminPaketWisataController::class, 'create'])->name('paket.create');
    Route::post('/paket', [AdminPaketWisataController::class, 'store'])->name('paket.store');
    Route::get('/paket/{paketWisata}/edit', [AdminPaketWisataController::class, 'edit'])->name('paket.edit');
    Route::put('/paket/{paketWisata}', [AdminPaketWisataController::class, 'update'])->name('paket.update');
    Route::delete('/paket/{paketWisata}', [AdminPaketWisataController::class, 'destroy'])->name('paket.destroy');
});
