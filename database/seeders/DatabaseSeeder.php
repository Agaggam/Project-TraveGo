<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PaketWisata;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@travego.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Sample User
        User::create([
            'name' => 'User Test',
            'email' => 'user@travego.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Create Sample Paket Wisata
        $pakets = [
            [
                'nama_paket' => 'Pesona Bali 4D3N',
                'deskripsi' => "Nikmati keindahan Pulau Dewata dengan paket wisata lengkap!\n\nItinerary:\n- Hari 1: Penjemputan bandara, check-in hotel, dinner\n- Hari 2: Tanah Lot, Uluwatu Temple, Kecak Dance\n- Hari 3: Ubud, Tegallalang Rice Terrace, Monkey Forest\n- Hari 4: Breakfast, free time, transfer ke bandara",
                'harga' => 3500000,
                'durasi' => '4 Hari 3 Malam',
                'lokasi' => 'Bali',
                'rating' => 4.8,
                'gambar_url' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=800',
            ],
            [
                'nama_paket' => 'Raja Ampat Explorer 5D4N',
                'deskripsi' => "Jelajahi surga bawah laut Indonesia di Raja Ampat!\n\nItinerary:\n- Hari 1: Tiba di Sorong, transfer ke Waisai\n- Hari 2: Snorkeling di Pianemo, Sunset di Piaynemo Hills\n- Hari 3: Island hopping, snorkeling spot terbaik\n- Hari 4: Manta Point, Cape Kri\n- Hari 5: Breakfast, transfer ke Sorong",
                'harga' => 8500000,
                'durasi' => '5 Hari 4 Malam',
                'lokasi' => 'Raja Ampat',
                'rating' => 4.9,
                'gambar_url' => 'https://images.unsplash.com/photo-1516690561799-46d8f74f9abf?w=800',
            ],
            [
                'nama_paket' => 'Lombok Adventure 3D2N',
                'deskripsi' => "Petualangan seru di Lombok!\n\nItinerary:\n- Hari 1: Tiba di Lombok, Pantai Kuta Lombok\n- Hari 2: Gili Trawangan, snorkeling, sunset\n- Hari 3: Pantai Pink, transfer ke bandara",
                'harga' => 2800000,
                'durasi' => '3 Hari 2 Malam',
                'lokasi' => 'Lombok',
                'rating' => 4.7,
                'gambar_url' => 'https://images.unsplash.com/photo-1570789210967-2cac24ba4d35?w=800',
            ],
            [
                'nama_paket' => 'Yogyakarta Heritage 3D2N',
                'deskripsi' => "Wisata budaya dan sejarah di Jogja!\n\nItinerary:\n- Hari 1: Candi Prambanan, Keraton Yogyakarta\n- Hari 2: Candi Borobudur sunrise, Malioboro\n- Hari 3: Taman Sari, oleh-oleh, transfer bandara",
                'harga' => 2200000,
                'durasi' => '3 Hari 2 Malam',
                'lokasi' => 'Yogyakarta',
                'rating' => 4.6,
                'gambar_url' => 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?w=800',
            ],
            [
                'nama_paket' => 'Komodo Island 4D3N',
                'deskripsi' => "Bertemu langsung dengan Komodo!\n\nItinerary:\n- Hari 1: Tiba di Labuan Bajo, sunset di Puncak Waringin\n- Hari 2: Pulau Rinca, trekking melihat Komodo\n- Hari 3: Pulau Padar, Pink Beach, snorkeling Manta Point\n- Hari 4: Breakfast, transfer ke bandara",
                'harga' => 5500000,
                'durasi' => '4 Hari 3 Malam',
                'lokasi' => 'Labuan Bajo',
                'rating' => 4.8,
                'gambar_url' => 'https://images.unsplash.com/photo-1518930259200-3e5b29f42096?w=800',
            ],
            [
                'nama_paket' => 'Bromo Midnight 2D1N',
                'deskripsi' => "Saksikan sunrise spektakuler di Gunung Bromo!\n\nItinerary:\n- Hari 1: Tiba di Malang, transfer ke hotel area Bromo\n- Hari 2: Midnight trip Penanjakan, sunrise, kawah Bromo, Pasir Berbisik",
                'harga' => 1500000,
                'durasi' => '2 Hari 1 Malam',
                'lokasi' => 'Malang',
                'rating' => 4.5,
                'gambar_url' => 'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?w=800',
            ],
        ];

        foreach ($pakets as $paket) {
            PaketWisata::create($paket);
        }
    }
}
