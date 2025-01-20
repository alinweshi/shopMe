<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('total_price', 10, 2);
            $table->bigInteger(column: 'transaction_id')->unique();
            $table->string('transaction_status');
            $table->string('payment_gate')->nullable();
            $table->string('failing_reason')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger(('order_id'));
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
