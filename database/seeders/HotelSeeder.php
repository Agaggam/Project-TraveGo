<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hotel;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hotels = [
            [
                'nama_hotel' => 'The Mulia Bali',
                'lokasi' => 'Nusa Dua, Bali',
                'deskripsi' => 'Hotel mewah tepi pantai dengan pelayanan kelas dunia dan fasilitas premium.',
                'harga_per_malam' => 4500000,
                'harga_standard' => 4500000,
                'harga_deluxe' => 6500000,
                'harga_suite' => 12000000,
                'rating' => 4.9,
                'kamar_total' => 50,
                'kamar_tersedia' => 15,
                'kamar_standard' => 5,
                'kamar_deluxe' => 7,
                'kamar_suite' => 3,
                'tipe_kamar' => 'Ocean View',
                'wifi' => true,
                'kolam_renang' => true,
                'restoran' => true,
                'gym' => true,
                'parkir' => true,
                'foto' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=800',
                'status' => 'active',
            ],
            [
                'nama_hotel' => 'Amanjiwo Resort',
                'lokasi' => 'Magelang, Jawa Tengah',
                'deskripsi' => 'Resort eksklusif dengan pemandangan langsung ke Candi Borobudur.',
                'harga_per_malam' => 12000000,
                'harga_standard' => 12000000,
                'harga_deluxe' => 18000000,
                'harga_suite' => 35000000,
                'rating' => 5.0,
                'kamar_total' => 20,
                'kamar_tersedia' => 5,
                'kamar_standard' => 2,
                'kamar_deluxe' => 2,
                'kamar_suite' => 1,
                'tipe_kamar' => 'Borobudur Suite',
                'wifi' => true,
                'kolam_renang' => true,
                'restoran' => true,
                'gym' => false,
                'parkir' => true,
                'foto' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=800',
                'status' => 'active',
            ],
            [
                'nama_hotel' => 'Hotel Indonesia Kempinski',
                'lokasi' => 'Jakarta Pusat',
                'deskripsi' => 'Hotel ikonik di pusat kota Jakarta dengan akses langsung ke pusat perbelanjaan.',
                'harga_per_malam' => 3200000,
                'harga_standard' => 3200000,
                'harga_deluxe' => 4500000,
                'harga_suite' => 8000000,
                'rating' => 4.8,
                'kamar_total' => 100,
                'kamar_tersedia' => 45,
                'kamar_standard' => 20,
                'kamar_deluxe' => 15,
                'kamar_suite' => 10,
                'tipe_kamar' => 'Grand Deluxe',
                'wifi' => true,
                'kolam_renang' => true,
                'restoran' => true,
                'gym' => true,
                'parkir' => true,
                'foto' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800',
                'status' => 'active',
            ],
            [
                'nama_hotel' => 'Plataran Komodo Resort',
                'lokasi' => 'Labuan Bajo, NTT',
                'deskripsi' => 'Eco-luxury resort dengan panorama laut dan pulau eksotis.',
                'harga_per_malam' => 6800000,
                'harga_standard' => 6800000,
                'harga_deluxe' => 9500000,
                'harga_suite' => 15000000,
                'rating' => 4.7,
                'kamar_total' => 30,
                'kamar_tersedia' => 10,
                'kamar_standard' => 4,
                'kamar_deluxe' => 4,
                'kamar_suite' => 2,
                'tipe_kamar' => 'Beachfront Villa',
                'wifi' => true,
                'kolam_renang' => true,
                'restoran' => true,
                'gym' => false,
                'parkir' => true,
                'foto' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=800',
                'status' => 'active',
            ],
            [
                'nama_hotel' => 'Greenhost Boutique Hotel',
                'lokasi' => 'Yogyakarta',
                'deskripsi' => 'Hotel ramah lingkungan dengan konsep modern dan artistik.',
                'harga_per_malam' => 950000,
                'harga_standard' => 950000,
                'harga_deluxe' => 1300000,
                'harga_suite' => 1800000,
                'rating' => 4.4,
                'kamar_total' => 40,
                'kamar_tersedia' => 18,
                'kamar_standard' => 8,
                'kamar_deluxe' => 6,
                'kamar_suite' => 4,
                'tipe_kamar' => 'Eco Deluxe',
                'wifi' => true,
                'kolam_renang' => false,
                'restoran' => true,
                'gym' => false,
                'parkir' => true,
                'foto' => 'https://images.unsplash.com/photo-1551884170-09fb70a3a2ed?w=800',
                'status' => 'active',
            ],
        ];

        foreach ($hotels as $hotel) {
            Hotel::create($hotel);
        }
    }
}
