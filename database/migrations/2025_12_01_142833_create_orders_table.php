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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('paket_wisata_id')->constrained()->onDelete('cascade');
            $table->string('nama_pemesan');
            $table->string('email');
            $table->string('phone');
            $table->date('tanggal_berangkat');
            $table->integer('jumlah_peserta')->default(1);
            $table->decimal('total_harga', 15, 2);
            $table->enum('status', ['pending', 'paid', 'cancelled', 'expired', 'refunded'])->default('pending');
            $table->string('snap_token')->nullable();
            $table->string('payment_type')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
