<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('invoice_number')->default('');
            $table->unsignedBigInteger('shipping_method_id'); // Foreign key to the shipping_methods table
            $table->foreign('shipping_method_id')->references('id')->on('shipping_methods')->onDelete('cascade');
            $table->decimal('total_price', 10, 2);
            $table->decimal('tax_amount', 8, 2)->nullable();
            $table->decimal('total_with_tax', 10, 2)->nullable();
            $table->decimal('discount', 10, 2)->default(0); // Store discount applied
            $table->string('coupon_code')->nullable(); // Store coupon code used
            $table->enum('coupon_type', ['percentage', 'fixed'])->nullable(); // Store coupon type
            $table->decimal('coupon_value', 10, 2)->nullable(); // Store coupon value
            $table->enum('status', ['pending', 'processing', 'completed', 'canceled', 'refunded', 'failed'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->timestamp('shipped_date')->nullable();
            $table->timestamp('delivered_date')->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('billing_address')->nullable();
            $table->timestamp('order_date')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_');
    }
};
