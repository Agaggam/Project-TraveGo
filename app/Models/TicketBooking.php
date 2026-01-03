<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ticket_id',
        'jumlah_tiket',
        'total_harga',
        'status_booking',
        'payment_status',
        'midtrans_order_id',
        'payment_url',
        'kode_booking',
        'nama_penumpang',
        'email_penumpang',
        'telepon_penumpang',
        'nomor_identitas',
        'tipe_identitas'
    ];

    protected $casts = [
        'total_harga' => 'decimal:2',
        'jumlah_tiket' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class, 'booking_id')->where('booking_type', 'TicketBooking');
    }
}
