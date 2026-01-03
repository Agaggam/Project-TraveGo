<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Destinasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_destinasi',
        'deskripsi',
        'lokasi',
        'gambar_url',
        'rating',
        'kategori',
        'slug',
        'harga',
        'stok',
        'is_featured'
    ];

    protected $casts = [
        'rating' => 'decimal:1',
        'harga' => 'decimal:2',
        'stok' => 'integer',
        'is_featured' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($destinasi) {
            if (!$destinasi->slug) {
                $destinasi->slug = Str::slug($destinasi->nama_destinasi);
            }
        });
    }

    public function paketWisatas()
    {
        return $this->belongsToMany(PaketWisata::class, 'paket_wisata_destinasi');
    }

    /**
     * Get reviews for this destinasi.
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
