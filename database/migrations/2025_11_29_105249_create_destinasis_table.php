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
        Schema::create('destinasis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_destinasi');
            $table->text('deskripsi');
            $table->string('lokasi');
            $table->string('gambar_url')->nullable();
            $table->decimal('rating', 2, 1)->nullable()->default(0);
            $table->enum('kategori', ['pantai', 'gunung', 'kota', 'alam', 'budaya', 'kuliner', 'petualangan']);
            $table->string('slug')->unique();
            $table->decimal('harga', 15, 2)->default(0);
            $table->integer('stok')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinasis');
    }
};
