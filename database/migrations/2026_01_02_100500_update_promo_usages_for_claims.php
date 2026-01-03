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
        Schema::table('promo_usages', function (Blueprint $table) {
            $table->string('booking_type')->nullable()->change();
            $table->unsignedBigInteger('booking_id')->nullable()->change();
            $table->decimal('discount_amount', 12, 2)->nullable()->change();
            
            // Add status to track if it's just claimed or used
            $table->enum('status', ['claimed', 'used'])->default('claimed')->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promo_usages', function (Blueprint $table) {
            $table->string('booking_type')->nullable(false)->change();
            $table->unsignedBigInteger('booking_id')->nullable(false)->change();
            $table->decimal('discount_amount', 12, 2)->nullable(false)->change();
            $table->dropColumn('status');
        });
    }
};
