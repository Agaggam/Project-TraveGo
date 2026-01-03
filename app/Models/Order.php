<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'paket_wisata_id',
        'destinasi_id',
        'nama_pemesan',
        'email',
        'phone',
        'tanggal_berangkat',
        'jumlah_peserta',
        'total_harga',
        'status',
        'snap_token',
        'payment_type',
        'paid_at',
        'catatan',
    ];

    protected $casts = [
        'tanggal_berangkat' => 'date',
        'paid_at' => 'datetime',
        'total_harga' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paketWisata()
    {
        return $this->belongsTo(PaketWisata::class);
    }

    public function destinasi()
    {
        return $this->belongsTo(Destinasi::class);
    }

    public static function generateOrderId()
    {
        return 'TRV-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }

    public function review()
    {
        return $this->hasOne(Review::class, 'booking_id')->where('booking_type', 'Order');
    }
}
