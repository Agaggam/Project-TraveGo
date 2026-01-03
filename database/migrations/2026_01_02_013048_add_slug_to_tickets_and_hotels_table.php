<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable()->after('nama_transportasi');
        });

        Schema::table('hotels', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable()->after('nama_hotel');
        });

        // Generate slugs for existing records
        $tickets = \App\Models\Ticket::all();
        foreach ($tickets as $ticket) {
            $baseSlug = Str::slug($ticket->nama_transportasi . '-' . $ticket->asal . '-' . $ticket->tujuan);
            $slug = $baseSlug;
            $counter = 1;
            while (\App\Models\Ticket::where('slug', $slug)->where('id', '!=', $ticket->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            $ticket->update(['slug' => $slug]);
        }

        $hotels = \App\Models\Hotel::all();
        foreach ($hotels as $hotel) {
            $baseSlug = Str::slug($hotel->nama_hotel);
            $slug = $baseSlug;
            $counter = 1;
            while (\App\Models\Hotel::where('slug', $slug)->where('id', '!=', $hotel->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            $hotel->update(['slug' => $slug]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('slug');
        });

        Schema::table('hotels', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
