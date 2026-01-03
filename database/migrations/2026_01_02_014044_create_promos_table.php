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
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            
            // Discount type and value
            $table->enum('type', ['percentage', 'fixed_amount'])->default('percentage');
            $table->decimal('value', 12, 2); // Percentage (0-100) or fixed amount
            
            // Constraints
            $table->decimal('min_order', 12, 2)->default(0); // Minimum order amount
            $table->decimal('max_discount', 12, 2)->nullable(); // Maximum discount for percentage
            
            // Usage limits
            $table->integer('usage_limit')->nullable(); // null = unlimited
            $table->integer('usage_limit_per_user')->default(1);
            $table->integer('used_count')->default(0);
            
            // Validity period
            $table->date('start_date');
            $table->date('end_date');
            
            // Status and applicability
            $table->boolean('is_active')->default(true);
            $table->json('applicable_to')->nullable(); // ['destinasi', 'hotel', 'tiket', 'paket'] or null for all
            
            $table->timestamps();
            
            // Indexes
            $table->index('code');
            $table->index('is_active');
            $table->index(['start_date', 'end_date']);
        });
        
        // User promo usage tracking
        Schema::create('promo_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promo_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('booking_type'); // Order, TicketBooking, HotelBooking
            $table->unsignedBigInteger('booking_id');
            $table->decimal('discount_amount', 12, 2);
            $table->timestamps();
            
            $table->index(['promo_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_usages');
        Schema::dropIfExists('promos');
    }
};
