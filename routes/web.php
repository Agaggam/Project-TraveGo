<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\Web\PaketController;
use App\Http\Controllers\Web\OrderController;
use App\Http\Controllers\Web\DestinasiController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PaketController as AdminPaketController;
use App\Http\Controllers\Admin\DestinasiController as AdminDestinasiController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Admin\HotelController as AdminHotelController;
use App\Http\Controllers\Web\TicketController;
use App\Http\Controllers\Web\HotelController;
use App\Http\Controllers\Web\ChatbotController;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/tentang-kami', [PageController::class, 'about'])->name('about');
Route::get('/destinasi', [DestinasiController::class, 'index'])->name('destinasi.index');
Route::get('/destinasi/{destinasi:slug}', [DestinasiController::class, 'show'])->name('destinasi.show');
Route::get('/kontak', [PageController::class, 'kontak'])->name('kontak');

Route::get('/paket', [PaketController::class, 'index'])->name('paket.index');
Route::get('/paket/{paketWisata:slug}', [PaketController::class, 'show'])->name('paket.show');

// Ticket Routes
Route::get('/tiket', [TicketController::class, 'index'])->name('tiket.index');
Route::get('/tiket/search', [TicketController::class, 'search'])->name('tiket.search');
Route::get('/tiket/{ticket:slug}', [TicketController::class, 'show'])->name('tiket.show');

// Hotel Routes
Route::get('/hotel', [HotelController::class, 'index'])->name('hotel.index');
Route::get('/hotel/search', [HotelController::class, 'search'])->name('hotel.search');
Route::get('/hotel/{hotel:slug}', [HotelController::class, 'show'])->name('hotel.show');

// Promo Routes (Public)
Route::get('/promo', [\App\Http\Controllers\Web\PromoController::class, 'index'])->name('promo.index');
Route::get('/promo/{promo}', [\App\Http\Controllers\Web\PromoController::class, 'show'])->name('promo.show');
Route::get('/promo/{promo}/claim', [\App\Http\Controllers\Web\PromoController::class, 'claim'])->name('promo.claim')->middleware('auth');
Route::post('/api/promo/validate', [\App\Http\Controllers\Web\PromoController::class, 'validatePromo'])->name('promo.validate')->middleware('auth');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware(['auth', 'jwt.web'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Order Routes
    Route::get('/checkout/{paketWisata}', [OrderController::class, 'checkout'])->name('order.checkout');
    Route::post('/checkout/{paketWisata}', [OrderController::class, 'store'])->name('order.store');

    // Destination Checkout Routes
    Route::get('/destinasi/checkout/{destinasi:slug}', [OrderController::class, 'checkoutDestinasi'])->name('order.destinasi.checkout');
    Route::post('/destinasi/checkout/{destinasi:slug}', [OrderController::class, 'storeDestinasi'])->name('order.destinasi.store');
    Route::get('/order/success', [OrderController::class, 'success'])->name('order.success');
    Route::get('/orders', [OrderController::class, 'history'])->name('order.history');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('order.show');


    // Ticket Booking Routes
    Route::get('/tiket/{ticket:slug}/booking', [TicketController::class, 'booking'])->name('tiket.booking');
    Route::post('/tiket/{ticket:slug}/booking', [TicketController::class, 'storeBooking'])->name('tiket.booking.store');
    Route::get('/booking/tiket', [TicketController::class, 'myBookings'])->name('booking.tiket');
    Route::get('/booking/tiket/{booking}', [TicketController::class, 'showBooking'])->name('booking.tiket.show');
    Route::delete('/booking/tiket/{booking}', [TicketController::class, 'cancelBooking'])->name('booking.tiket.cancel');

    // Hotel Booking Routes
    Route::get('/hotel/{hotel:slug}/booking', [HotelController::class, 'booking'])->name('hotel.booking');
    Route::post('/hotel/{hotel:slug}/booking', [HotelController::class, 'storeBooking'])->name('hotel.booking.store');
    Route::get('/booking/hotel', [HotelController::class, 'myBookings'])->name('booking.hotel');
    Route::get('/booking/hotel/{booking}', [HotelController::class, 'showBooking'])->name('booking.hotel.show');
    Route::delete('/booking/hotel/{booking}', [HotelController::class, 'cancelBooking'])->name('booking.hotel.cancel');

    // Chatbot Routes
    Route::post('/chatbot/send', [ChatbotController::class, 'chat'])->name('chatbot.send');
    Route::get('/chatbot/history', [ChatbotController::class, 'history'])->name('chatbot.history');
    Route::delete('/chatbot/history', [ChatbotController::class, 'clearHistory'])->name('chatbot.clear');

    // Review Routes

    Route::get('/review/create', [\App\Http\Controllers\Web\ReviewController::class, 'create'])->name('review.create');
    Route::post('/review', [\App\Http\Controllers\Web\ReviewController::class, 'store'])->name('review.store');
    Route::get('/my-reviews', [\App\Http\Controllers\Web\ReviewController::class, 'myReviews'])->name('review.my-reviews');

    // E-Ticket Routes
    Route::get('/eticket/order/{order}', [\App\Http\Controllers\Web\ETicketController::class, 'showOrder'])->name('eticket.order');
    Route::get('/eticket/ticket/{booking}', [\App\Http\Controllers\Web\ETicketController::class, 'showTicket'])->name('eticket.ticket');
    Route::get('/eticket/hotel/{booking}', [\App\Http\Controllers\Web\ETicketController::class, 'showHotel'])->name('eticket.hotel');

    // Support Chat Routes
    Route::prefix('support')->name('support.')->group(function () {
        Route::get('/active', [\App\Http\Controllers\Web\SupportChatController::class, 'getActiveConversation'])->name('active');
        Route::post('/start', [\App\Http\Controllers\Web\SupportChatController::class, 'store'])->name('start');
        Route::get('/{conversation}', [\App\Http\Controllers\Web\SupportChatController::class, 'show'])->name('show');
        Route::post('/{conversation}/send', [\App\Http\Controllers\Web\SupportChatController::class, 'sendMessage'])->name('send');
        Route::get('/{conversation}/messages', [\App\Http\Controllers\Web\SupportChatController::class, 'getMessages'])->name('messages');
    });
});

// E-Ticket Verification (public)
Route::get('/eticket/verify', [\App\Http\Controllers\Web\ETicketController::class, 'verify'])->name('eticket.verify');

Route::post('/payment/callback', [OrderController::class, 'callback'])->name('payment.callback');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('paket', AdminPaketController::class)->parameters(['paket' => 'paketWisata']);
    Route::resource('destinasi', AdminDestinasiController::class);
    Route::resource('tickets', AdminTicketController::class);
    Route::resource('hotels', AdminHotelController::class);

    // Reviews Management
    Route::get('/reviews', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{review}/approve', [\App\Http\Controllers\Admin\ReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('/reviews/{review}/reject', [\App\Http\Controllers\Admin\ReviewController::class, 'reject'])->name('reviews.reject');
    Route::delete('/reviews/{review}', [\App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Promos Management
    Route::resource('promos', \App\Http\Controllers\Admin\PromoController::class);
    Route::post('/promos/{promo}/toggle-status', [\App\Http\Controllers\Admin\PromoController::class, 'toggleStatus'])->name('promos.toggle-status');

    // Support Chat Management
    Route::prefix('support-chat')->name('support-chat.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\SupportChatController::class, 'index'])->name('index');
        Route::get('/unread-count', [\App\Http\Controllers\Admin\SupportChatController::class, 'getUnreadCount'])->name('unread');
        Route::get('/{conversation}', [\App\Http\Controllers\Admin\SupportChatController::class, 'show'])->name('show');
        Route::post('/{conversation}/reply', [\App\Http\Controllers\Admin\SupportChatController::class, 'sendMessage'])->name('reply');
        Route::get('/{conversation}/messages', [\App\Http\Controllers\Admin\SupportChatController::class, 'getMessages'])->name('messages');
        Route::post('/{conversation}/close', [\App\Http\Controllers\Admin\SupportChatController::class, 'closeConversation'])->name('close');
        Route::post('/{conversation}/reopen', [\App\Http\Controllers\Admin\SupportChatController::class, 'reopenConversation'])->name('reopen');
        Route::delete('/{conversation}', [\App\Http\Controllers\Admin\SupportChatController::class, 'destroy'])->name('destroy');
    });
});
