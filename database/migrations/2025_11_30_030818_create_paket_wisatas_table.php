<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paket_wisatas', function (Blueprint $table) {
            $table->id(); // Primary Key (Big Integer, Auto Increment)

            $table->string('nama_paket'); // Varchar
            $table->text('deskripsi'); // Text (untuk deskripsi panjang)
            $table->decimal('harga', 15, 2); // Decimal (15 digit total, 2 desimal)
            $table->string('durasi'); // Varchar (cth: "3 Hari 2 Malam")
            $table->string('lokasi'); // Varchar
            $table->float('rating')->default(0); // Float (default 0)
            $table->string('gambar_url')->nullable(); // Varchar (boleh kosong)

            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paket_wisatas');
    }
};
