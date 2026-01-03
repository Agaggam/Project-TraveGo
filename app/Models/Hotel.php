<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_hotel',
        'slug',
        'lokasi',
        'deskripsi',
        'harga_per_malam',
        'harga_standard',
        'harga_deluxe',
        'harga_suite',
        'rating',
        'kamar_total',
        'kamar_tersedia',
        'kamar_standard',
        'kamar_deluxe',
        'kamar_suite',
        'tipe_kamar',
        'wifi',
        'kolam_renang',
        'restoran',
        'gym',
        'parkir',
        'foto',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($hotel) {
            if (!$hotel->slug) {
                $baseSlug = Str::slug($hotel->nama_hotel);
                $slug = $baseSlug;
                $counter = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }
                $hotel->slug = $slug;
            }
        });

        static::updating(function ($hotel) {
            if ($hotel->isDirty('nama_hotel')) {
                $baseSlug = Str::slug($hotel->nama_hotel);
                $slug = $baseSlug;
                $counter = 1;
                while (static::where('slug', $slug)->where('id', '!=', $hotel->id)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }
                $hotel->slug = $slug;
            }
        });
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $casts = [
        'harga_per_malam' => 'decimal:2',
        'harga_standard' => 'decimal:2',
        'harga_deluxe' => 'decimal:2',
        'harga_suite' => 'decimal:2',
        'rating' => 'decimal:2',
        'kamar_total' => 'integer',
        'kamar_tersedia' => 'integer',
        'kamar_standard' => 'integer',
        'kamar_deluxe' => 'integer',
        'kamar_suite' => 'integer',
        'wifi' => 'boolean',
        'kolam_renang' => 'boolean',
        'restoran' => 'boolean',
        'gym' => 'boolean',
        'parkir' => 'boolean',
    ];

    /**
     * Get price by room type
     */
    public function getPriceByType(string $type): float
    {
        return match($type) {
            'standard' => (float) ($this->harga_standard ?: $this->harga_per_malam),
            'deluxe' => (float) ($this->harga_deluxe ?: $this->harga_per_malam * 1.5),
            'suite' => (float) ($this->harga_suite ?: $this->harga_per_malam * 2),
            default => (float) $this->harga_per_malam,
        };
    }

    /**
     * Get available rooms by type
     */
    public function getAvailableByType(string $type): int
    {
        return match($type) {
            'standard' => $this->kamar_standard,
            'deluxe' => $this->kamar_deluxe,
            'suite' => $this->kamar_suite,
            default => $this->kamar_tersedia,
        };
    }

    /**
     * Decrement room by type
     */
    public function decrementRoomByType(string $type): void
    {
        match($type) {
            'standard' => $this->decrement('kamar_standard'),
            'deluxe' => $this->decrement('kamar_deluxe'),
            'suite' => $this->decrement('kamar_suite'),
            default => $this->decrement('kamar_tersedia'),
        };
    }

    /**
     * Increment room by type
     */
    public function incrementRoomByType(string $type): void
    {
        match($type) {
            'standard' => $this->increment('kamar_standard'),
            'deluxe' => $this->increment('kamar_deluxe'),
            'suite' => $this->increment('kamar_suite'),
            default => $this->increment('kamar_tersedia'),
        };
    }

    public function hotelBookings(): HasMany
    {
        return $this->hasMany(HotelBooking::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'active')
                    ->where('kamar_tersedia', '>', 0);
    }

    public function scopeByLocation($query, $location)
    {
        return $query->where('lokasi', 'LIKE', '%' . $location . '%');
    }

    public function scopeByRating($query, $minRating)
    {
        return $query->where('rating', '>=', $minRating);
    }

    /**
     * Get reviews for this hotel.
     */
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    /**
     * Get approved reviews.
     */
    public function approvedReviews()
    {
        return $this->reviews()->approved();
    }

    /**
     * Get average rating from approved reviews.
     */
    public function getAverageRatingAttribute()
    {
        $avgRating = $this->approvedReviews()->avg('rating');
        return $avgRating ? round($avgRating, 1) : $this->rating;
    }
}
