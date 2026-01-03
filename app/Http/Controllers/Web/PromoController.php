<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use App\Models\PromoUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromoController extends Controller
{
    /**
     * Display available promos for users to claim.
     */
    public function index(Request $request)
    {
        // Get all valid promos with stock remaining
        $query = Promo::valid()
            ->where(function($q) {
                $q->whereNull('usage_limit')
                  ->orWhereRaw('used_count < usage_limit');
            });

        // Filter by category
        if ($request->filled('category')) {
            $query->where(function($q) use ($request) {
                $q->whereNull('applicable_to')
                  ->orWhereJsonContains('applicable_to', $request->category);
            });
        }

        $promos = $query->orderBy('end_date', 'asc')->paginate(12);

        // Get categories for filter
        $categories = [
            'destinasi' => 'Destinasi',
            'hotel' => 'Hotel',
            'tiket' => 'Tiket Transportasi',
            'paket' => 'Paket Wisata',
        ];

        // Get user's claimed promos
        $claimedPromoIds = [];
        if (Auth::check()) {
            $claimedPromoIds = PromoUsage::where('user_id', Auth::id())
                ->pluck('promo_id')
                ->toArray();
        }

        return view('promos.index', compact('promos', 'categories', 'claimedPromoIds'));
    }

    /**
     * Show promo detail.
     */
    public function show(Promo $promo)
    {
        if (!$promo->isValid()) {
            return redirect()->route('promo.index')->with('error', 'Promo sudah tidak berlaku.');
        }

        $canClaim = $promo->canBeUsed(Auth::id());
        $userUsageCount = 0;
        
        if (Auth::check()) {
            $userUsageCount = PromoUsage::where('user_id', Auth::id())
                ->where('promo_id', $promo->id)
                ->count();
        }

        return view('promos.show', compact('promo', 'canClaim', 'userUsageCount'));
    }

    /**
     * Claim a promo (save to user's promo list).
     */
    public function claim(Promo $promo)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk mengklaim promo.');
        }

        if (!$promo->isValid()) {
            return redirect()->back()->with('error', 'Promo sudah tidak berlaku.');
        }

        // Check if already claimed/utilized
        if (!$promo->canBeUsed(Auth::id())) {
            return redirect()->back()->with('error', 'Anda sudah mengklaim promo ini atau kuota habis.');
        }

        // Create claim record
        PromoUsage::create([
            'promo_id' => $promo->id,
            'user_id' => Auth::id(),
            'status' => 'claimed',
        ]);

        // Increment global usage count (stock decreases)
        $promo->incrementUsage();

        return redirect()->route('promo.index')->with('success', 'Promo "' . $promo->code . '" berhasil diklaim! Stok berkurang.');
    }

    /**
     * Validate promo code via AJAX.
     */
    public function validatePromo(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'amount' => 'required|numeric',
            'type' => 'nullable|string',
        ]);

        $promo = Promo::where('code', $request->code)->first();

        if (!$promo) {
            return response()->json(['success' => false, 'message' => 'Kode promo tidak ditemukan.']);
        }

        if (!$promo->isValid()) {
            return response()->json(['success' => false, 'message' => 'Promo sudah tidak berlaku.']);
        }

        // Check if applicable
        if ($request->type && !$promo->isApplicableTo($request->type)) {
            return response()->json(['success' => false, 'message' => 'Promo tidak berlaku untuk layanan ini.']);
        }

        // Check ownership (claim)
        // Check if user has a claimed (unused) usage record
        $usage = PromoUsage::where('user_id', Auth::id())
            ->where('promo_id', $promo->id)
            ->where(function($q) {
                $q->where('status', 'claimed')
                  ->orWhereNull('booking_id');
            })
            ->first();

        if (!$usage) {
             return response()->json(['success' => false, 'message' => 'Anda belum mengklaim promo ini.']);
        }

        // Calculate discount
        $discount = $promo->calculateDiscount($request->amount);

        if ($discount <= 0) {
            return response()->json(['success' => false, 'message' => 'Minimum pembelian tidak terpenuhi.']);
        }

        return response()->json([
            'success' => true,
            'discount' => $discount,
            'promo' => [
                'code' => $promo->code,
                'name' => $promo->name,
                'formatted_value' => $promo->formatted_value,
            ]
        ]);
    }
}
