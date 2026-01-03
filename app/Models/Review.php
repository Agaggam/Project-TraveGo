<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reviewable_type',
        'reviewable_id',
        'booking_type',
        'booking_id',
        'rating',
        'comment',
        'photos',
        'status',
        'admin_notes',
        'moderated_by',
        'moderated_at',
    ];

    protected $casts = [
        'photos' => 'array',
        'moderated_at' => 'datetime',
    ];

    /**
     * Get the user who wrote the review.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the reviewable model (Destinasi, Hotel, PaketWisata, Ticket).
     */
    public function reviewable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the moderator.
     */
    public function moderator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'moderated_by');
    }

    /**
     * Scope for approved reviews.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope for pending reviews.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for rejected reviews.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Check if user has already reviewed this item for this booking.
     */
    public static function hasUserReviewed($userId, $reviewableType, $reviewableId, $bookingType = null, $bookingId = null)
    {
        $query = static::where('user_id', $userId)
            ->where('reviewable_type', $reviewableType)
            ->where('reviewable_id', $reviewableId);

        if ($bookingType && $bookingId) {
            $query->where('booking_type', $bookingType)
                  ->where('booking_id', $bookingId);
        }

        return $query->exists();
    }

    /**
     * Get rating stars as array.
     */
    public function getStarsAttribute()
    {
        return array_fill(0, $this->rating, true);
    }
}
