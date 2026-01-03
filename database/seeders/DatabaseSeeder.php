<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Hotel;
use App\Models\Ticket;
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
                'stok' => 20,
            ],
            [
                'nama_paket' => 'Raja Ampat Explorer 5D4N',
                'deskripsi' => "Jelajahi surga bawah laut Indonesia di Raja Ampat!\n\nItinerary:\n- Hari 1: Tiba di Sorong, transfer ke Waisai\n- Hari 2: Snorkeling di Pianemo, Sunset di Piaynemo Hills\n- Hari 3: Island hopping, snorkeling spot terbaik\n- Hari 4: Manta Point, Cape Kri\n- Hari 5: Breakfast, transfer ke Sorong",
                'harga' => 8500000,
                'durasi' => '5 Hari 4 Malam',
                'lokasi' => 'Raja Ampat',
                'rating' => 4.9,
                'gambar_url' => 'https://images.unsplash.com/photo-1516690561799-46d8f74f9abf?w=800',
                'stok' => 10,
            ],
            [
                'nama_paket' => 'Lombok Adventure 3D2N',
                'deskripsi' => "Petualangan seru di Lombok!\n\nItinerary:\n- Hari 1: Tiba di Lombok, Pantai Kuta Lombok\n- Hari 2: Gili Trawangan, snorkeling, sunset\n- Hari 3: Pantai Pink, transfer ke bandara",
                'harga' => 2800000,
                'durasi' => '3 Hari 2 Malam',
                'lokasi' => 'Lombok',
                'rating' => 4.7,
                'gambar_url' => 'https://images.unsplash.com/photo-1570789210967-2cac24ba4d35?w=800',
                'stok' => 15,
            ],
            [
                'nama_paket' => 'Yogyakarta Heritage 3D2N',
                'deskripsi' => "Wisata budaya dan sejarah di Jogja!\n\nItinerary:\n- Hari 1: Candi Prambanan, Keraton Yogyakarta\n- Hari 2: Candi Borobudur sunrise, Malioboro\n- Hari 3: Taman Sari, oleh-oleh, transfer bandara",
                'harga' => 2200000,
                'durasi' => '3 Hari 2 Malam',
                'lokasi' => 'Yogyakarta',
                'rating' => 4.6,
                'gambar_url' => 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?w=800',
                'stok' => 25,
            ],
            [
                'nama_paket' => 'Komodo Island 4D3N',
                'deskripsi' => "Bertemu langsung dengan Komodo!\n\nItinerary:\n- Hari 1: Tiba di Labuan Bajo, sunset di Puncak Waringin\n- Hari 2: Pulau Rinca, trekking melihat Komodo\n- Hari 3: Pulau Padar, Pink Beach, snorkeling Manta Point\n- Hari 4: Breakfast, transfer ke bandara",
                'harga' => 5500000,
                'durasi' => '4 Hari 3 Malam',
                'lokasi' => 'Labuan Bajo',
                'rating' => 4.8,
                'gambar_url' => 'https://images.unsplash.com/photo-1518930259200-3e5b29f42096?w=800',
                'stok' => 10,
            ],
            [
                'nama_paket' => 'Promo Bromo Midnight 2D1N',
                'deskripsi' => "Saksikan sunrise spektakuler di Gunung Bromo!\n\nItinerary:\n- Hari 1: Tiba di Malang, transfer ke hotel area Bromo\n- Hari 2: Midnight trip Penanjakan, sunrise, kawah Bromo, Pasir Berbisik",
                'harga' => 1500000,
                'durasi' => '2 Hari 1 Malam',
                'lokasi' => 'Malang',
                'rating' => 4.5,
                'gambar_url' => 'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?w=800',
                'stok' => 30,
            ],
            [
                'nama_paket' => 'Bandung City Escape 3D2N',
                'deskripsi' => "Liburan santai di Kota Kembang!\n\nItinerary:\n- Hari 1: Tiba di Bandung, Lembang, Floating Market\n- Hari 2: Kawah Putih, Glamping Lakeside, Jalan Braga\n- Hari 3: Factory Outlet, oleh-oleh, transfer pulang",
                'harga' => 2100000,
                'durasi' => '3 Hari 2 Malam',
                'lokasi' => 'Bandung',
                'rating' => 4.5,
                'gambar_url' => 'https://images.unsplash.com/photo-1549880338-65ddcdfd017b?w=800',
                'stok' => 20,
            ],
            [
                'nama_paket' => 'Labuan Bajo Sailing Trip 3D2N',
                'deskripsi' => "Sailing trip eksotis menjelajahi pulau-pulau indah Labuan Bajo!\n\nItinerary:\n- Hari 1: Kelor Island, Manjarite\n- Hari 2: Pulau Padar, Pink Beach, Komodo Island\n- Hari 3: Snorkeling, kembali ke Labuan Bajo",
                'harga' => 4800000,
                'durasi' => '3 Hari 2 Malam',
                'lokasi' => 'Labuan Bajo',
                'rating' => 4.9,
                'gambar_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800',
                'stok' => 5,
            ],
            [
                'nama_paket' => 'Medan Danau Toba 4D3N',
                'deskripsi' => "Eksplorasi keindahan Danau Toba dan budaya Batak.\n\nItinerary:\n- Hari 1: City tour Medan\n- Hari 2: Danau Toba, Pulau Samosir\n- Hari 3: Desa Tomok, Bukit Holbung\n- Hari 4: Oleh-oleh, transfer bandara",
                'harga' => 3200000,
                'durasi' => '4 Hari 3 Malam',
                'lokasi' => 'Medan',
                'rating' => 4.6,
                'gambar_url' => 'https://images.unsplash.com/photo-1609921212029-bb5a28e60960?w=800',
                'stok' => 15,
            ],
            [
                'nama_paket' => 'Makassar & Toraja Culture Trip 5D4N',
                'deskripsi' => "Wisata budaya dan alam Sulawesi Selatan.\n\nItinerary:\n- Hari 1: City tour Makassar\n- Hari 2: Pantai Bira\n- Hari 3: Perjalanan ke Toraja\n- Hari 4: Kete Kesu, Londa\n- Hari 5: Kembali ke Makassar",
                'harga' => 5200000,
                'durasi' => '5 Hari 4 Malam',
                'lokasi' => 'Sulawesi Selatan',
                'rating' => 4.7,
                'gambar_url' => 'https://images.unsplash.com/photo-1600959907703-125ba1374a12?w=800',
                'stok' => 10,
            ],
            [
                'nama_paket' => 'Belitung Island Hopping 3D2N',
                'deskripsi' => "Nikmati pantai dan pulau cantik di Belitung.\n\nItinerary:\n- Hari 1: Pantai Tanjung Tinggi\n- Hari 2: Island hopping, Pulau Lengkuas\n- Hari 3: Oleh-oleh, transfer bandara",
                'harga' => 2600000,
                'durasi' => '3 Hari 2 Malam',
                'lokasi' => 'Belitung',
                'rating' => 4.6,
                'gambar_url' => 'https://images.unsplash.com/photo-1526778548025-fa2f459cd5c1?w=800',
                'stok' => 25,
            ],
        ];

        foreach ($pakets as $paket) {
            PaketWisata::create($paket);
        }

        // Create Sample Hotels
        $hotels = [
            [
                'nama_hotel' => 'The Mulia Bali',
                'lokasi' => 'Nusa Dua, Bali',
                'deskripsi' => 'Resor mewah tepi pantai dengan fasilitas kelas dunia dan pemandangan laut yang menakjubkan.',
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
                'tipe_kamar' => 'Royal Ocean Court',
                'wifi' => true,
                'kolam_renang' => true,
                'restoran' => true,
                'gym' => true,
                'parkir' => true,
                'foto' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=800',
                'status' => 'active',
            ],
            [
                'nama_hotel' => 'Amanjiwo',
                'lokasi' => 'Magelang, Jawa Tengah',
                'deskripsi' => 'Pengalaman menginap spiritual dengan pemandangan langsung ke Candi Borobudur.',
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
                'lokasi' => 'Thamrin, Jakarta',
                'deskripsi' => 'Ikon kemewahan di jantung ibu kota Jakarta dengan akses langsung ke Grand Indonesia.',
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
                'tipe_kamar' => 'Grand Deluxe Room',
                'wifi' => true,
                'kolam_renang' => true,
                'restoran' => true,
                'gym' => true,
                'parkir' => true,
                'foto' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800',
                'status' => 'active',
            ]
        ];

        foreach ($hotels as $hotel) {
            Hotel::create($hotel);
        }

        // Create Sample Tickets
        $tickets = [
            [
                'nama_transportasi' => 'Garuda Indonesia GA-402',
                'jenis_transportasi' => 'pesawat',
                'kode_transportasi' => 'GA402',
                'asal' => 'Jakarta (CGK)',
                'tujuan' => 'Bali (DPS)',
                'waktu_berangkat' => now()->addDays(2)->setHour(10)->setMinute(0),
                'waktu_tiba' => now()->addDays(2)->setHour(12)->setMinute(0),
                'durasi_menit' => 120,
                'harga' => 1800000,
                'kapasitas' => 180,
                'tersedia' => 45,
                'kelas' => 'ekonomi',
                'fasilitas' => 'Bagasi 20kg, Meals, In-flight Entertainment',
                'aktif' => true,
            ],
            [
                'nama_transportasi' => 'Argo Bromo Anggrek Executive',
                'jenis_transportasi' => 'kereta',
                'kode_transportasi' => 'ABA-01',
                'asal' => 'Jakarta (GMR)',
                'tujuan' => 'Surabaya (SBI)',
                'waktu_berangkat' => now()->addDays(1)->setHour(8)->setMinute(30),
                'waktu_tiba' => now()->addDays(1)->setHour(16)->setMinute(30),
                'durasi_menit' => 480,
                'harga' => 750000,
                'kapasitas' => 50,
                'tersedia' => 12,
                'kelas' => 'eksekutif',
                'fasilitas' => 'Reclining Seat, AC, Stop Kontak',
                'aktif' => true,
            ],
            [
                'nama_transportasi' => 'Sinar Jaya Executive Suite',
                'jenis_transportasi' => 'bus',
                'kode_transportasi' => 'SJ-88',
                'asal' => 'Jakarta',
                'tujuan' => 'Yogyakarta',
                'waktu_berangkat' => now()->addHours(12)->setMinute(0),
                'waktu_tiba' => now()->addHours(22)->setMinute(0),
                'durasi_menit' => 600,
                'harga' => 250000,
                'kapasitas' => 22,
                'tersedia' => 5,
                'kelas' => 'eksekutif',
                'fasilitas' => 'Foot Rest, Pillow, Blanket, Coffee',
                'aktif' => true,
            ]
        ];

        foreach ($tickets as $ticket) {
            Ticket::create($ticket);
        }

        // Run Destinasi Seeder
        $this->call(DestinasiSeeder::class);
        $this->call(TicketSeeder::class);
        $this->call(HotelSeeder::class);


        // Associate Destinasi with Paket
        $baliPaket = PaketWisata::where('lokasi', 'Bali')->first();
        if ($baliPaket) {
            $baliDestinasis = \App\Models\Destinasi::where('lokasi', 'like', '%Bali%')->pluck('id');
            $baliPaket->destinasis()->sync($baliDestinasis);
        }

        $jogjaPaket = PaketWisata::where('lokasi', 'Yogyakarta')->first();
        if ($jogjaPaket) {
            $borobudur = \App\Models\Destinasi::where('nama_destinasi', 'like', '%Borobudur%')->pluck('id');
            $jogjaPaket->destinasis()->sync($borobudur);
        }

        $bromoPaket = PaketWisata::where('lokasi', 'Malang')->first();
        if ($bromoPaket) {
            $bromo = \App\Models\Destinasi::where('nama_destinasi', 'like', '%Bromo%')->pluck('id');
            $bromoPaket->destinasis()->sync($bromo);
        }
    }
}
