<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PaketController;
use App\Http\Controllers\Api\DestinasiController;
use App\Http\Controllers\Api\TicketBookingController;
use App\Http\Controllers\Api\HotelBookingController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:jwt')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Ticket Booking Routes
    Route::get('/ticket-bookings', [TicketBookingController::class, 'index']);
    Route::post('/ticket-bookings', [TicketBookingController::class, 'store']);
    Route::get('/ticket-bookings/{id}', [TicketBookingController::class, 'show']);
    Route::delete('/ticket-bookings/{id}/cancel', [TicketBookingController::class, 'cancel']);

    // Hotel Booking Routes
    Route::get('/hotel-bookings', [HotelBookingController::class, 'index']);
    Route::post('/hotel-bookings', [HotelBookingController::class, 'store']);
    Route::get('/hotel-bookings/{id}', [HotelBookingController::class, 'show']);
    Route::delete('/hotel-bookings/{id}/cancel', [HotelBookingController::class, 'cancel']);

    // Promo Validation
    Route::post('/promo/validate', [\App\Http\Controllers\Api\PromoController::class, 'validateCode']);
});

Route::get('/paket', [PaketController::class, 'index']);
Route::get('/paket/{id}', [PaketController::class, 'show']);

Route::get('/destinasi', [DestinasiController::class, 'index']);
Route::get('/destinasi/{id}', [DestinasiController::class, 'show']);

Route::middleware(['auth:jwt', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::post('/paket', [PaketController::class, 'store']);
    Route::post('/paket/{id}', [PaketController::class, 'update']);
    Route::delete('/paket/{id}', [PaketController::class, 'destroy']);

    Route::post('/destinasi', [DestinasiController::class, 'store']);
    Route::post('/destinasi/{id}', [DestinasiController::class, 'update']);
    Route::delete('/destinasi/{id}', [DestinasiController::class, 'destroy']);
});

// Real-time Validation Routes (Public)
Route::prefix('validate')->name('validate.')->group(function () {
    Route::post('/email', [\App\Http\Controllers\Api\ValidationController::class, 'checkEmail'])->name('email');
    Route::post('/password', [\App\Http\Controllers\Api\ValidationController::class, 'checkPassword'])->name('password');
    Route::post('/ticket-availability', [\App\Http\Controllers\Api\ValidationController::class, 'checkTicketAvailability'])->name('ticket');
    Route::post('/hotel-availability', [\App\Http\Controllers\Api\ValidationController::class, 'checkHotelAvailability'])->name('hotel');
    Route::post('/date', [\App\Http\Controllers\Api\ValidationController::class, 'validateDate'])->name('date');
});
