<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\PaketWisataController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. GUEST ROUTES (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Root route - redirect based on auth status
Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->isAdmin() ? redirect()->route('admin.dashboard') : redirect()->route('user.home');
    }
    return redirect()->route('login');
})->name('home');

// 2. AUTHENTICATED ROUTES (Sudah Login)
Route::middleware('auth')->group(function () {

    // Logout (Bisa diakses semua role)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --------------------------
    // ROLE: USER
    // --------------------------
    Route::middleware(['role:user'])->group(function () {
    Route::get('/user', function () {
        return view('user.home');
    })->name('user.home');
    });

    // --------------------------
    // ROLE: ADMIN
    // --------------------------
    Route::middleware(['role:admin'])->group(function () {

        // Halaman Utama Dashboard Admin (Sesuai view 'app' Anda)
        Route::get('/admin', function () {
            return view('app');
        })->name('admin.dashboard');

        /* * PENTING: Route API untuk Frontend (AJAX/Fetch)
         * Kita taruh di web.php agar otomatis pakai Session Admin (tidak perlu token ribet).
         * URL-nya akan menjadi: domain.com/api/paket-wisata
         */
        Route::get('/api/paket-wisata', [PaketWisataController::class, 'index']);
        Route::post('/api/paket-wisata', [PaketWisataController::class, 'store']);
        Route::get('/api/paket-wisata/{id}', [PaketWisataController::class, 'show']);
        Route::put('/api/paket-wisata/{id}', [PaketWisataController::class, 'update']);
        Route::delete('/api/paket-wisata/{id}', [PaketWisataController::class, 'destroy']);
    });

});

Route::get('/force-logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return 'Berhasil Logout! <a href="/login">Klik di sini untuk Login ulang</a>';
});
