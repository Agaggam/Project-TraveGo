<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromoController extends Controller
{
    /**
     * Validate a promo code.
     */
    public function validateCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|string|in:destinasi,hotel,tiket,paket',
        ]);

        $promo = Promo::where('code', strtoupper($request->code))->first();

        if (!$promo) {
            return response()->json([
                'success' => false,
                'message' => 'Kode promo tidak ditemukan.',
            ], 404);
        }

        if (!$promo->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'Kode promo sudah tidak berlaku.',
            ], 400);
        }

        if (!$promo->canBeUsed(Auth::id())) {
            return response()->json([
                'success' => false,
                'message' => 'Kode promo sudah mencapai batas penggunaan.',
            ], 400);
        }

        if (!$promo->isApplicableTo($request->type)) {
            return response()->json([
                'success' => false,
                'message' => 'Kode promo tidak berlaku untuk produk ini.',
            ], 400);
        }

        $discount = $promo->calculateDiscount($request->amount);

        if ($discount <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Minimum pembelian Rp ' . number_format($promo->min_order, 0, ',', '.') . ' untuk menggunakan promo ini.',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'promo' => [
                'id' => $promo->id,
                'code' => $promo->code,
                'name' => $promo->name,
                'type' => $promo->type,
                'value' => $promo->value,
                'formatted_value' => $promo->formatted_value,
            ],
            'discount' => $discount,
            'final_amount' => $request->amount - $discount,
            'message' => 'Promo berhasil diterapkan! Anda hemat Rp ' . number_format($discount, 0, ',', '.'),
        ]);
    }
}
