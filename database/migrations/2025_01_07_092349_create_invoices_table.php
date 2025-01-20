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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique()->index(); // Unique invoice number
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Link to orders table
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Link to users table
            $table->decimal('subtotal', 15, 2); // Subtotal before tax and discount
            $table->decimal('tax', 15, 2)->nullable(); // Tax amount
            $table->decimal('discount_amount', 15, 2)->nullable(); // Discount amount
            $table->decimal('shipping_fee', 15, 2)->nullable(); // Shipping fee
            $table->decimal('total', 15, 2); // Total invoice amount
            $table->string('currency', 10)->default('KD'); // Currency (default to 'KD')
            $table->enum('status', ['pending', 'paid', 'canceled', 'refunded'])->default('pending'); // Invoice status
            $table->timestamp('billed_at')->nullable(); // Date of billing
            $table->timestamp('payment_date')->nullable(); // Date of payment
            $table->string('payment_method')->nullable(); // Payment method used
            $table->string('billing_address')->nullable(); // Billing address
            $table->string('shipping_address')->nullable(); // Shipping address
            $table->text('notes')->nullable(); // Additional notes or remarks
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
