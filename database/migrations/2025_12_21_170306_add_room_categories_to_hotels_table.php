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
        Schema::table('hotels', function (Blueprint $table) {
            // Room category prices (only add if not exists)
            if (!Schema::hasColumn('hotels', 'harga_standard')) {
                $table->decimal('harga_standard', 12, 2)->default(0)->after('harga_per_malam');
            }
            if (!Schema::hasColumn('hotels', 'harga_deluxe')) {
                $table->decimal('harga_deluxe', 12, 2)->default(0)->after('harga_standard');
            }
            if (!Schema::hasColumn('hotels', 'harga_suite')) {
                $table->decimal('harga_suite', 12, 2)->default(0)->after('harga_deluxe');
            }
            
            // Room availability per category
            if (!Schema::hasColumn('hotels', 'kamar_standard')) {
                $table->integer('kamar_standard')->default(0)->after('kamar_tersedia');
            }
            if (!Schema::hasColumn('hotels', 'kamar_deluxe')) {
                $table->integer('kamar_deluxe')->default(0)->after('kamar_standard');
            }
            if (!Schema::hasColumn('hotels', 'kamar_suite')) {
                $table->integer('kamar_suite')->default(0)->after('kamar_deluxe');
            }
        });

        // Add snap_token and tipe_kamar_booked to hotel_bookings for Midtrans
        Schema::table('hotel_bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('hotel_bookings', 'snap_token')) {
                $table->string('snap_token')->nullable()->after('tipe_kamar');
            }
            if (!Schema::hasColumn('hotel_bookings', 'kode_booking')) {
                $table->string('kode_booking')->nullable()->after('snap_token');
            }
        });

        // Add snap_token to ticket_bookings for Midtrans
        Schema::table('ticket_bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('ticket_bookings', 'snap_token')) {
                $table->string('snap_token')->nullable()->after('kode_booking');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $columns = ['harga_standard', 'harga_deluxe', 'harga_suite', 'kamar_standard', 'kamar_deluxe', 'kamar_suite'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('hotels', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('hotel_bookings', function (Blueprint $table) {
            if (Schema::hasColumn('hotel_bookings', 'snap_token')) {
                $table->dropColumn('snap_token');
            }
        });

        Schema::table('ticket_bookings', function (Blueprint $table) {
            if (Schema::hasColumn('ticket_bookings', 'snap_token')) {
                $table->dropColumn('snap_token');
            }
        });
    }
};
