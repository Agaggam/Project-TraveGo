<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('nama_transportasi'); // Nama pesawat/kereta/bus
            $table->enum('jenis_transportasi', ['pesawat', 'kereta', 'bus']); // Tipe transportasi
            $table->string('kode_transportasi'); // Kode penerbangan/kereta/bus
            $table->string('asal'); // Kota asal
            $table->string('tujuan'); // Kota tujuan
            $table->datetime('waktu_berangkat'); // Waktu keberangkatan
            $table->datetime('waktu_tiba'); // Waktu kedatangan
            $table->integer('durasi_menit'); // Durasi perjalanan dalam menit
            $table->decimal('harga', 15, 2); // Harga tiket
            $table->integer('kapasitas')->default(1); // Kapasitas kursi
            $table->integer('tersedia')->default(0); // Kursi tersedia
            $table->enum('kelas', ['ekonomi', 'bisnis', 'eksekutif'])->default('ekonomi'); // Kelas tiket
            $table->text('fasilitas')->nullable(); // Fasilitas yang tersedia
            $table->boolean('aktif')->default(true); // Status aktif/tidak
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
