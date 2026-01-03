<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add simple fields to tickets
        Schema::table('tickets', function (Blueprint $table) {
            if (!Schema::hasColumn('tickets', 'tipe')) {
                $table->string('tipe')->nullable()->after('id'); // flight, train, bus
            }
            if (!Schema::hasColumn('tickets', 'operator')) {
                $table->string('operator')->nullable()->after('tujuan');
            }
            if (!Schema::hasColumn('tickets', 'durasi')) {
                $table->string('durasi')->nullable()->after('waktu_berangkat');
            }
            if (!Schema::hasColumn('tickets', 'kuota')) {
                $table->integer('kuota')->default(50)->after('harga');
            }
        });

        // Add simple fields to hotels
        Schema::table('hotels', function (Blueprint $table) {
            if (!Schema::hasColumn('hotels', 'nama')) {
                $table->string('nama')->nullable()->after('id');
            }
            if (!Schema::hasColumn('hotels', 'harga')) {
                $table->decimal('harga', 12, 2)->nullable()->after('deskripsi');
            }
            if (!Schema::hasColumn('hotels', 'bintang')) {
                $table->integer('bintang')->default(5)->after('harga');
            }
            if (!Schema::hasColumn('hotels', 'gambar_url')) {
                $table->string('gambar_url')->nullable()->after('rating');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn(['tipe', 'operator', 'durasi', 'kuota']);
        });

        Schema::table('hotels', function (Blueprint $table) {
            $table->dropColumn(['nama', 'harga', 'bintang', 'gambar_url']);
        });
    }
};
