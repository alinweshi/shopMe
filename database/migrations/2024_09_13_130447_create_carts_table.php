<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // User ID
            $table->string('session_id')->nullable(); // Session ID for guests
            $table->foreignId('coupon_id')->nullable()->constrained('coupons')->onDelete('set null'); // Link to coupons table
            $table->decimal('total_price', 10, 2)->default(0.0); // Total price for the cart
            $table->timestamp('cart_expiry')->nullable(); // Expiry date for the cart
            $table->enum('status', ['active', 'abandoned', 'completed'])->default('active'); // Cart status
            $table->string('user_agent')->nullable(); // User agent for tracking browser details
            $table->string('ip_address')->nullable(); // IP address for tracking user
            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
