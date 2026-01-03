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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('nama_hotel');
            $table->string('lokasi');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga_per_malam', 15, 2);
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('kamar_total')->default(0);
            $table->integer('kamar_tersedia')->default(0);
            $table->string('tipe_kamar')->nullable();
            $table->boolean('wifi')->default(false);
            $table->boolean('kolam_renang')->default(false);
            $table->boolean('restoran')->default(false);
            $table->boolean('gym')->default(false);
            $table->boolean('parkir')->default(false);
            $table->string('foto')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
