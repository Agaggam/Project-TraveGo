<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Order;
use App\Models\TicketBooking;
use App\Models\HotelBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Show review form for a specific item.
     */
    public function create(Request $request)
    {
        $type = $request->type;
        $id = $request->id;
        $bookingType = $request->booking_type;
        $bookingId = $request->booking_id;

        // Debug Log
        \Log::info('Review Create Request', [
            'type' => $type,
            'id' => $id,
            'booking_type' => $bookingType,
            'booking_id' => $bookingId,
            'user_id' => Auth::id()
        ]);

        // Validate that user has a completed booking for this item
        $hasBooking = $this->validateUserBooking($type, $id, $bookingType, $bookingId);
        \Log::info('Has Booking Result: ' . ($hasBooking ? 'true' : 'false'));
        
        if (!$hasBooking) {
            \Log::info('Redirecting back: No booking found');
            return redirect()->back()->with('error', 'Anda harus memiliki booking yang sudah selesai untuk memberikan review.');
        }

        // Check if already reviewed
        $alreadyReviewed = Review::hasUserReviewed(
            Auth::id(),
            'App\\Models\\' . ucfirst($type),
            $id,
            $bookingType,
            $bookingId
        );

        if ($alreadyReviewed) {
            return redirect()->back()->with('error', 'Anda sudah memberikan review untuk item ini.');
        }

        return view('reviews.create', [
            'type' => $type,
            'id' => $id,
            'bookingType' => $bookingType,
            'bookingId' => $bookingId,
            'item' => $this->getItem($type, $id),
        ]);
    }

    /**
     * Store a new review.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:destinasi,hotel,paketWisata,ticket',
            'id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
            'booking_type' => 'nullable|string',
            'booking_id' => 'nullable|integer',
        ]);

        // Validate booking
        $hasBooking = $this->validateUserBooking(
            $request->type,
            $request->id,
            $request->booking_type,
            $request->booking_id
        );

        if (!$hasBooking) {
            return redirect()->back()->with('error', 'Booking tidak valid.');
        }

        // Check if already reviewed
        $alreadyReviewed = Review::hasUserReviewed(
            Auth::id(),
            'App\\Models\\' . ucfirst($request->type),
            $request->id,
            $request->booking_type,
            $request->booking_id
        );

        if ($alreadyReviewed) {
            return redirect()->back()->with('error', 'Anda sudah memberikan review.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'reviewable_type' => 'App\\Models\\' . ucfirst($request->type),
            'reviewable_id' => $request->id,
            'booking_type' => $request->booking_type,
            'booking_id' => $request->booking_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'pending', // Will be approved by admin
        ]);

        return redirect()->route('review.my-reviews')->with('success', 'Terima kasih! Review Anda akan ditampilkan setelah diverifikasi oleh admin.');
    }

    /**
     * Validate that user has a completed booking for the item.
     */
    /**
     * Display user's reviews.
     */
    public function myReviews()
    {
        $reviews = Review::with('reviewable')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('reviews.my-reviews', compact('reviews'));
    }

    private function validateUserBooking($type, $id, $bookingType, $bookingId)
    {
        $userId = Auth::id();

        switch ($bookingType) {
            case 'Order':
                return Order::where('id', $bookingId)
                    ->where('user_id', $userId)
                    ->where('status', 'paid')
                    ->exists();
            case 'TicketBooking':
                return TicketBooking::where('id', $bookingId)
                    ->where('user_id', $userId)
                    ->where('payment_status', 'paid')
                    ->exists();
            case 'HotelBooking':
                return HotelBooking::where('id', $bookingId)
                    ->where('user_id', $userId)
                    ->where('payment_status', 'paid')
                    ->exists();
            default:
                return false;
        }
    }

    /**
     * Get the reviewable item.
     */
    private function getItem($type, $id)
    {
        $modelClass = 'App\\Models\\' . ucfirst($type);
        return $modelClass::find($id);
    }

}
