<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DestinasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destinasis = [
            [
                'nama_destinasi' => 'Pantai Kuta Bali',
                'deskripsi' => 'Pantai terkenal di Bali dengan pasir putih dan ombak yang cocok untuk berselancar. Tempat yang sempurna untuk menikmati matahari terbenam yang spektakuler.',
                'lokasi' => 'Kuta, Bali',
                'gambar_url' => 'https://images.unsplash.com/photo-1537953773345-d172ccf13cf1?w=800',
                'rating' => 4.5,
                'kategori' => 'pantai',
                'is_featured' => true,
                'harga' => 15000,
                'stok' => 100
            ],
            [
                'nama_destinasi' => 'Gunung Bromo',
                'deskripsi' => 'Gunung berapi aktif yang menawarkan pemandangan sunrise yang luar biasa dari atas bukit. Dikelilingi oleh lautan pasir yang luas.',
                'lokasi' => 'Probolinggo, Jawa Timur',
                'gambar_url' => 'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?w=800',
                'rating' => 4.8,
                'kategori' => 'gunung',
                'is_featured' => true,
                'harga' => 35000,
                'stok' => 50
            ],
            [
                'nama_destinasi' => 'Borobudur Temple',
                'deskripsi' => 'Candi Buddha terbesar di dunia yang merupakan situs warisan dunia UNESCO. Arsitektur yang megah dan penuh sejarah.',
                'lokasi' => 'Magelang, Jawa Tengah',
                'gambar_url' => 'https://images.unsplash.com/photo-1582510003544-4d00b7f74220?w=800',
                'rating' => 4.7,
                'kategori' => 'budaya',
                'is_featured' => true,
                'harga' => 50000,
                'stok' => 200
            ],
            [
                'nama_destinasi' => 'Raja Ampat',
                'deskripsi' => 'Kepulauan dengan keindahan bawah laut yang luar biasa. Tempat diving terbaik di Indonesia dengan terumbu karang yang masih alami.',
                'lokasi' => 'Papua Barat',
                'gambar_url' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800',
                'rating' => 4.9,
                'kategori' => 'alam',
                'is_featured' => true,
                'harga' => 500000,
                'stok' => 20
            ],
            [
                'nama_destinasi' => 'Jakarta Cathedral',
                'deskripsi' => 'Gereja katedral yang megah di pusat kota Jakarta. Arsitektur gothic yang indah dan menjadi landmark penting di ibukota.',
                'lokasi' => 'Jakarta Pusat',
                'gambar_url' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=800',
                'rating' => 4.2,
                'kategori' => 'kota',
                'is_featured' => false,
                'harga' => 0,
                'stok' => 1000
            ],
            [
                'nama_destinasi' => 'Pantai Sanur',
                'deskripsi' => 'Pantai yang lebih tenang dibanding Kuta, cocok untuk keluarga. Menawarkan suasana yang lebih santai dengan pemandangan sunrise yang indah.',
                'lokasi' => 'Sanur, Bali',
                'gambar_url' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800',
                'rating' => 4.3,
                'kategori' => 'pantai',
                'is_featured' => false,
                'harga' => 10000,
                'stok' => 150
            ],
            [
                'nama_destinasi' => 'Gunung Rinjani',
                'deskripsi' => 'Gunung tertinggi kedua di Indonesia dengan danau segara anak yang indah. Tantangan bagi para pendaki yang berpengalaman.',
                'lokasi' => 'Lombok, Nusa Tenggara Barat',
                'gambar_url' => 'https://images.unsplash.com/photo-1464822759844-d150f38d609c?w=800',
                'rating' => 4.6,
                'kategori' => 'gunung',
                'is_featured' => false,
                'harga' => 150000,
                'stok' => 30
            ],
            [
                'nama_destinasi' => 'Kawah Ijen',
                'deskripsi' => 'Kawah vulkanik dengan fenomena blue fire yang unik. Pemandangan api biru yang hanya ada di dua tempat di dunia.',
                'lokasi' => 'Banyuwangi, Jawa Timur',
                'gambar_url' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800',
                'rating' => 4.4,
                'kategori' => 'alam',
                'is_featured' => false,
                'harga' => 25000,
                'stok' => 80
            ],
            [
                'nama_destinasi' => 'Tanah Lot',
                'deskripsi' => 'Pura laut ikonik di Bali dengan panorama sunset yang sangat terkenal.',
                'lokasi' => 'Tabanan, Bali',
                'gambar_url' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?w=800',
                'rating' => 4.8,
                'kategori' => 'budaya',
                'is_featured' => true,
                'harga' => 60000,
                'stok' => 200
            ],
            [
                'nama_destinasi' => 'Uluwatu Temple',
                'deskripsi' => 'Pura di atas tebing dengan pemandangan laut lepas dan pertunjukan Tari Kecak.',
                'lokasi' => 'Uluwatu, Bali',
                'gambar_url' => 'https://images.unsplash.com/photo-1583037189850-1921ae7c6c22?w=800',
                'rating' => 4.7,
                'kategori' => 'budaya',
                'is_featured' => true,
                'harga' => 50000,
                'stok' => 150
            ],
            [
                'nama_destinasi' => 'Tegallalang Rice Terrace',
                'deskripsi' => 'Sawah terasering indah dengan pemandangan alam khas Ubud.',
                'lokasi' => 'Ubud, Bali',
                'gambar_url' => 'https://images.unsplash.com/photo-1559628233-100c798642d4?w=800',
                'rating' => 4.6,
                'kategori' => 'alam',
                'is_featured' => false,
                'harga' => 25000,
                'stok' => 120
            ],
            [
                'nama_destinasi' => 'Piaynemo',
                'deskripsi' => 'Gugusan pulau karst dengan panorama laut biru ikonik Raja Ampat.',
                'lokasi' => 'Raja Ampat, Papua Barat',
                'gambar_url' => 'https://images.unsplash.com/photo-1516690561799-46d8f74f9abf?w=800',
                'rating' => 4.9,
                'kategori' => 'alam',
                'is_featured' => true,
                'harga' => 150000,
                'stok' => 50
            ],
            [
                'nama_destinasi' => 'Manta Point',
                'deskripsi' => 'Spot snorkeling dan diving untuk melihat ikan pari manta.',
                'lokasi' => 'Raja Ampat, Papua Barat',
                'gambar_url' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800',
                'rating' => 5.0,
                'kategori' => 'alam',
                'is_featured' => true,
                'harga' => 300000,
                'stok' => 20
            ],
            [
                'nama_destinasi' => 'Pantai Kuta Lombok',
                'deskripsi' => 'Pantai pasir putih dengan ombak tenang dan pemandangan alami.',
                'lokasi' => 'Lombok Tengah, NTB',
                'gambar_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800',
                'rating' => 4.5,
                'kategori' => 'pantai',
                'is_featured' => false,
                'harga' => 10000,
                'stok' => 200
            ],
            [
                'nama_destinasi' => 'Gili Trawangan',
                'deskripsi' => 'Pulau kecil dengan pantai eksotis dan spot snorkeling terbaik.',
                'lokasi' => 'Lombok Utara, NTB',
                'gambar_url' => 'https://images.unsplash.com/photo-1570789210967-2cac24ba4d35?w=800',
                'rating' => 4.7,
                'kategori' => 'pantai',
                'is_featured' => true,
                'harga' => 75000,
                'stok' => 150
            ],
            [
                'nama_destinasi' => 'Keraton Yogyakarta',
                'deskripsi' => 'Istana resmi Kesultanan Yogyakarta yang sarat nilai budaya.',
                'lokasi' => 'Yogyakarta',
                'gambar_url' => 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?w=800',
                'rating' => 4.4,
                'kategori' => 'budaya',
                'is_featured' => false,
                'harga' => 15000,
                'stok' => 300
            ],
            [
                'nama_destinasi' => 'Malioboro',
                'deskripsi' => 'Jalan ikonik pusat belanja dan wisata kuliner Yogyakarta.',
                'lokasi' => 'Yogyakarta',
                'gambar_url' => 'https://images.unsplash.com/photo-1600793575654-910699b5e4b3?w=800',
                'rating' => 4.5,
                'kategori' => 'kota',
                'is_featured' => true,
                'harga' => 0,
                'stok' => 1000
            ],
            [
                'nama_destinasi' => 'Pulau Padar',
                'deskripsi' => 'Pulau dengan view bukit ikonik dan tiga teluk berwarna berbeda.',
                'lokasi' => 'Labuan Bajo, NTT',
                'gambar_url' => 'https://images.unsplash.com/photo-1518930259200-3e5b29f42096?w=800',
                'rating' => 4.9,
                'kategori' => 'alam',
                'is_featured' => true,
                'harga' => 150000,
                'stok' => 60
            ],
            [
                'nama_destinasi' => 'Pulau Komodo',
                'deskripsi' => 'Habitat asli hewan purba Komodo.',
                'lokasi' => 'Labuan Bajo, NTT',
                'gambar_url' => 'https://images.unsplash.com/photo-1526778548025-fa2f459cd5c1?w=800',
                'rating' => 4.8,
                'kategori' => 'alam',
                'is_featured' => true,
                'harga' => 250000,
                'stok' => 40
            ]
        ];

        foreach ($destinasis as $destinasi) {
            \App\Models\Destinasi::create($destinasi);
        }
    }
}
