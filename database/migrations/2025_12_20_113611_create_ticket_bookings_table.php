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
        Schema::create('ticket_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
            $table->integer('jumlah_tiket');
            $table->decimal('total_harga', 15, 2);
            $table->enum('status_booking', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            $table->enum('payment_status', ['unpaid', 'paid', 'refunded'])->default('unpaid');
            $table->string('midtrans_order_id')->nullable();
            $table->string('payment_url')->nullable();
            $table->string('kode_booking')->unique();
            $table->string('nama_penumpang');
            $table->string('email_penumpang');
            $table->string('telepon_penumpang');
            $table->string('nomor_identitas');
            $table->string('tipe_identitas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_bookings');
    }
};
