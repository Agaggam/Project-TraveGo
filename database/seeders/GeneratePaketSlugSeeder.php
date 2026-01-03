<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GeneratePaketSlugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\PaketWisata::whereNull('slug')->orWhere('slug', '')->each(function ($paket) {
            $paket->update(['slug' => Str::slug($paket->nama_paket)]);
        });
    }
}
