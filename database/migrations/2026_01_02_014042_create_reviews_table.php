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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Polymorphic relation (Destinasi, Hotel, PaketWisata, Ticket)
            $table->string('reviewable_type');
            $table->unsignedBigInteger('reviewable_id');
            
            // Reference to which booking this review is for
            $table->string('booking_type')->nullable(); // Order, TicketBooking, HotelBooking
            $table->unsignedBigInteger('booking_id')->nullable();
            
            // Review content
            $table->unsignedTinyInteger('rating'); // 1-5
            $table->text('comment');
            $table->json('photos')->nullable(); // Array of photo URLs
            
            // Moderation
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->foreignId('moderated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('moderated_at')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['reviewable_type', 'reviewable_id']);
            $table->index(['booking_type', 'booking_id']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
