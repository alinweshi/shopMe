<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->morphs('transactionable'); // Creates transactionable_id and transactionable_type with index
            $table->string('invoice_number')->nullable()->index();
            $table->string('status', 20); // Use VARCHAR for flexibility
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax', 10, 2)->nullable();
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->decimal('shipping_fee', 10, 2)->nullable();
            $table->decimal('net_total', 10, 2);
            $table->string('currency', 3);
            $table->string('payment_method')->nullable();
            $table->string('reference_id')->nullable()->index();
            $table->timestamp('billed_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
