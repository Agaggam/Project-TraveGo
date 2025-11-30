<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PaketWisataController;

Route::get('/paket-wisata', [PaketWisataController::class, 'index']);
Route::get('/paket-wisata/{id}', [PaketWisataController::class, 'show']);
Route::post('/paket-wisata', [PaketWisataController::class, 'store']);
Route::put('/paket-wisata/{id}', [PaketWisataController::class, 'update']);
Route::delete('/paket-wisata/{id}', [PaketWisataController::class, 'destroy']);
