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
        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Shipping method name
            $table->decimal('cost', 8, 2); // Shipping cost
            $table->integer('delivery_time')->nullable(); // Delivery time in days
            $table->string(column: 'description')->nullable(); // Shipping method description
            $table->string('image')->nullable(); // Shipping method image
            $table->string('slug')->unique(); // Slug for SEO
            $table->boolean(column: 'is_default')->default(false); // Default shipping method
            $table->boolean('is_free')->default(false); // Free shipping
            $table->boolean(column: 'is_pickup')->default(false); // Pickup from store
            $table->boolean('is_active')->default(true); // Active status
            $table->timestamps(); // Created at & updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_methods');
    }
};
