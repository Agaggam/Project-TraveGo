<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PaketWisata extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_paket',
        'deskripsi',
        'harga',
        'durasi',
        'lokasi',
        'rating',
        'gambar_url',
        'slug',
        'stok'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($paket) {
            if (!$paket->slug) {
                $paket->slug = Str::slug($paket->nama_paket);
            }
        });
    }

    public function destinasis()
    {
        return $this->belongsToMany(Destinasi::class, 'paket_wisata_destinasi');
    }
}
