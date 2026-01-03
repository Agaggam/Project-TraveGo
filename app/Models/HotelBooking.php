<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotelBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'hotel_id',
        'tanggal_checkin',
        'tanggal_checkout',
        'jumlah_kamar',
        'jumlah_malam',
        'total_harga',
        'status_booking', // pending, confirmed, cancelled, completed
        'payment_status', // unpaid, paid, refunded
        'midtrans_order_id',
        'midtrans_transaction_id',
        'payment_url',
        'nama_tamu',
        'email_tamu',
        'telepon_tamu',
        'nomor_identitas',
        'tipe_identitas',
        'permintaan_khusus',
        'breakfast_included',
        'tipe_kamar'
    ];

    protected $casts = [
        'tanggal_checkin' => 'date',
        'tanggal_checkout' => 'date',
        'total_harga' => 'decimal:2',
        'jumlah_kamar' => 'integer',
        'jumlah_malam' => 'integer',
        'breakfast_included' => 'boolean'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function scopePending($query)
    {
        return $query->where('status_booking', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status_booking', 'confirmed');
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function getTotalHargaAttribute($value)
    {
        return $this->hotel ? $this->hotel->harga_per_malam * $this->jumlah_malam * $this->jumlah_kamar : $value;
    }

    public function getJumlahMalamAttribute()
    {
        if ($this->tanggal_checkin && $this->tanggal_checkout) {
            return $this->tanggal_checkin->diffInDays($this->tanggal_checkout);
        }
        return $this->attributes['jumlah_malam'] ?? 0;
    }

    public function review()
    {
        return $this->hasOne(Review::class, 'booking_id')->where('booking_type', 'HotelBooking');
    }
}
