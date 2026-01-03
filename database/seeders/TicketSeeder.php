<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use Carbon\Carbon;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tickets = [

            // ✈️ PESAWAT
            [
                'nama_transportasi' => 'Garuda Indonesia GA-402',
                'jenis_transportasi' => 'pesawat',
                'kode_transportasi' => 'GA402',
                'asal' => 'Jakarta (CGK)',
                'tujuan' => 'Bali (DPS)',
                'waktu_berangkat' => Carbon::now()->addDays(2)->setTime(10, 0),
                'waktu_tiba' => Carbon::now()->addDays(2)->setTime(12, 0),
                'durasi_menit' => 120,
                'harga' => 1800000,
                'kapasitas' => 180,
                'tersedia' => 45,
                'kelas' => 'ekonomi',
                'fasilitas' => 'Bagasi 20kg, Meals, In-flight Entertainment',
                'aktif' => true,
            ],
            [
                'nama_transportasi' => 'Citilink QG-732',
                'jenis_transportasi' => 'pesawat',
                'kode_transportasi' => 'QG732',
                'asal' => 'Jakarta (CGK)',
                'tujuan' => 'Yogyakarta (YIA)',
                'waktu_berangkat' => Carbon::now()->addDays(3)->setTime(7, 30),
                'waktu_tiba' => Carbon::now()->addDays(3)->setTime(8, 45),
                'durasi_menit' => 75,
                'harga' => 950000,
                'kapasitas' => 150,
                'tersedia' => 60,
                'kelas' => 'ekonomi',
                'fasilitas' => 'Bagasi 15kg, Snack',
                'aktif' => true,
            ],

            // 🚆 KERETA
            [
                'nama_transportasi' => 'Argo Lawu Executive',
                'jenis_transportasi' => 'kereta',
                'kode_transportasi' => 'AL-01',
                'asal' => 'Jakarta (GMR)',
                'tujuan' => 'Solo (SLO)',
                'waktu_berangkat' => Carbon::now()->addDay()->setTime(20, 0),
                'waktu_tiba' => Carbon::now()->addDays(2)->setTime(4, 30),
                'durasi_menit' => 510,
                'harga' => 850000,
                'kapasitas' => 50,
                'tersedia' => 18,
                'kelas' => 'eksekutif',
                'fasilitas' => 'Reclining Seat, AC, Stop Kontak',
                'aktif' => true,
            ],
            [
                'nama_transportasi' => 'Taksaka Pagi',
                'jenis_transportasi' => 'kereta',
                'kode_transportasi' => 'TKP-02',
                'asal' => 'Yogyakarta (TGU)',
                'tujuan' => 'Jakarta (GMR)',
                'waktu_berangkat' => Carbon::now()->addDays(2)->setTime(8, 0),
                'waktu_tiba' => Carbon::now()->addDays(2)->setTime(15, 30),
                'durasi_menit' => 450,
                'harga' => 700000,
                'kapasitas' => 60,
                'tersedia' => 25,
                'kelas' => 'eksekutif',
                'fasilitas' => 'Snack, AC, Reclining Seat',
                'aktif' => true,
            ],

            // 🚌 BUS
            [
                'nama_transportasi' => 'Sinar Jaya Executive Suite',
                'jenis_transportasi' => 'bus',
                'kode_transportasi' => 'SJ-88',
                'asal' => 'Jakarta',
                'tujuan' => 'Yogyakarta',
                'waktu_berangkat' => Carbon::now()->addHours(12)->setTime(Carbon::now()->addHours(12)->hour, 0),
                'waktu_tiba' => Carbon::now()->addHours(22)->setTime(Carbon::now()->addHours(22)->hour, 0),
                'durasi_menit' => 600,
                'harga' => 250000,
                'kapasitas' => 22,
                'tersedia' => 5,
                'kelas' => 'eksekutif',
                'fasilitas' => 'Foot Rest, Pillow, Blanket, Coffee',
                'aktif' => true,
            ],
            [
                'nama_transportasi' => 'PO Rosalia Indah',
                'jenis_transportasi' => 'bus',
                'kode_transportasi' => 'RI-12',
                'asal' => 'Surabaya',
                'tujuan' => 'Malang',
                'waktu_berangkat' => Carbon::now()->addHours(5),
                'waktu_tiba' => Carbon::now()->addHours(7),
                'durasi_menit' => 120,
                'harga' => 120000,
                'kapasitas' => 30,
                'tersedia' => 10,
                'kelas' => 'ekonomi',
                'fasilitas' => 'AC, Reclining Seat',
                'aktif' => true,
            ],
        ];

        foreach ($tickets as $ticket) {
            Ticket::create($ticket);
        }
    }
}
