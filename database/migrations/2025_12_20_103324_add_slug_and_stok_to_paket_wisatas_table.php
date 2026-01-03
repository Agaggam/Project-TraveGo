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
        Schema::table('paket_wisatas', function (Blueprint $table) {
            if (!Schema::hasColumn('paket_wisatas', 'slug')) {
                $table->string('slug')->nullable()->unique()->after('nama_paket');
            }
            if (!Schema::hasColumn('paket_wisatas', 'stok')) {
                $table->integer('stok')->default(0)->after('gambar_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paket_wisatas', function (Blueprint $table) {
            $table->dropColumn(['slug', 'stok']);
        });
    }
};
