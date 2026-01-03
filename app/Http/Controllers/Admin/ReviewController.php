<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of reviews with filters.
     */
    public function index(Request $request)
    {
        $query = Review::with(['user', 'reviewable', 'moderator']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('reviewable_type', 'App\\Models\\' . ucfirst($request->type));
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('comment', 'LIKE', '%' . $request->search . '%')
                  ->orWhereHas('user', function ($userQuery) use ($request) {
                      $userQuery->where('name', 'LIKE', '%' . $request->search . '%');
                  });
            });
        }

        $reviews = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get counts for stats
        $stats = [
            'pending' => Review::pending()->count(),
            'approved' => Review::approved()->count(),
            'rejected' => Review::rejected()->count(),
        ];

        return view('admin.reviews.index', compact('reviews', 'stats'));
    }

    /**
     * Approve a review.
     */
    public function approve(Review $review)
    {
        $review->update([
            'status' => 'approved',
            'moderated_by' => Auth::id(),
            'moderated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Review berhasil disetujui.');
    }

    /**
     * Reject a review.
     */
    public function reject(Request $request, Review $review)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $review->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
            'moderated_by' => Auth::id(),
            'moderated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Review berhasil ditolak.');
    }

    /**
     * Delete a review.
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->back()->with('success', 'Review berhasil dihapus.');
    }
}
