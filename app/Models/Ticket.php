<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_transportasi',
        'slug',
        'jenis_transportasi',
        'kode_transportasi',
        'asal',
        'tujuan',
        'waktu_berangkat',
        'waktu_tiba',
        'durasi_menit',
        'harga',
        'kapasitas',
        'tersedia',
        'kelas',
        'fasilitas',
        'aktif'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            if (!$ticket->slug) {
                $baseSlug = Str::slug($ticket->nama_transportasi . '-' . $ticket->asal . '-' . $ticket->tujuan);
                $slug = $baseSlug;
                $counter = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }
                $ticket->slug = $slug;
            }
        });

        static::updating(function ($ticket) {
            if ($ticket->isDirty('nama_transportasi') || $ticket->isDirty('asal') || $ticket->isDirty('tujuan')) {
                $baseSlug = Str::slug($ticket->nama_transportasi . '-' . $ticket->asal . '-' . $ticket->tujuan);
                $slug = $baseSlug;
                $counter = 1;
                while (static::where('slug', $slug)->where('id', '!=', $ticket->id)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }
                $ticket->slug = $slug;
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
        'waktu_berangkat' => 'datetime',
        'waktu_tiba' => 'datetime',
        'harga' => 'decimal:2',
        'kapasitas' => 'integer',
        'tersedia' => 'integer',
        'durasi_menit' => 'integer',
        'aktif' => 'boolean'
    ];

    public function ticketBookings(): HasMany
    {
        return $this->hasMany(TicketBooking::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('aktif', true)
                    ->where('tersedia', '>', 0);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('jenis_transportasi', $type);
    }

    public function scopeByRoute($query, $asal, $tujuan)
    {
        return $query->where('asal', $asal)
                    ->where('tujuan', $tujuan);
    }

    // Helper untuk durasi
    public function getDurasiFormattedAttribute()
    {
        $hours = floor($this->durasi_menit / 60);
        $mins = $this->durasi_menit % 60;
        return $hours > 0 ? "{$hours}j {$mins}m" : "{$mins}m";
    }
}
