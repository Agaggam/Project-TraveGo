<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PaketWisataController;

Route::get('/paket-wisata', [PaketWisataController::class, 'apiIndex']);
Route::get('/paket-wisata/{id}', [PaketWisataController::class, 'apiShow']);
Route::post('/paket-wisata', [PaketWisataController::class, 'apiStore']);
Route::put('/paket-wisata/{id}', [PaketWisataController::class, 'apiUpdate']);
Route::delete('/paket-wisata/{id}', [PaketWisataController::class, 'apiDestroy']);
