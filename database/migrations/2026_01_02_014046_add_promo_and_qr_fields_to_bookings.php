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
        // Add promo and QR fields to orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('promo_id')->nullable()->after('catatan')->constrained()->nullOnDelete();
            $table->decimal('discount_amount', 12, 2)->default(0)->after('promo_id');
            $table->string('qr_code')->nullable()->after('discount_amount');
            $table->string('eticket_token')->nullable()->unique()->after('qr_code');
        });
        
        // Add promo and QR fields to ticket_bookings table
        Schema::table('ticket_bookings', function (Blueprint $table) {
            $table->foreignId('promo_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->string('qr_code')->nullable();
            $table->string('eticket_token')->nullable()->unique();
        });
        
        // Add promo and QR fields to hotel_bookings table
        Schema::table('hotel_bookings', function (Blueprint $table) {
            $table->foreignId('promo_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->string('qr_code')->nullable();
            $table->string('eticket_token')->nullable()->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('promo_id');
            $table->dropColumn(['discount_amount', 'qr_code', 'eticket_token']);
        });
        
        Schema::table('ticket_bookings', function (Blueprint $table) {
            $table->dropConstrainedForeignId('promo_id');
            $table->dropColumn(['discount_amount', 'qr_code', 'eticket_token']);
        });
        
        Schema::table('hotel_bookings', function (Blueprint $table) {
            $table->dropConstrainedForeignId('promo_id');
            $table->dropColumn(['discount_amount', 'qr_code', 'eticket_token']);
        });
    }
};
