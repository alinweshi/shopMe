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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable;
            $table->string('code');
            $table->text('description')->nullable();
            $table->enum('type', ['percentage', 'fixed']); // Percentage or fixed amount discount
            $table->decimal('value', 8, 2); // Discount value (e.g. 10% or $10)
            $table->dateTime('start_date'); // Use datetime instead of timestamp
            $table->dateTime('end_date'); // Use datetime instead of timestamp
            $table->boolean('is_active')->default(true); // Whether the discount is active
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount');
    }
};
