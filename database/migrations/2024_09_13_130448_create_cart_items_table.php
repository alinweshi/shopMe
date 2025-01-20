<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_attribute_id')->nullable()->constrained('product_attributes')->onDelete('cascade');

            $table->integer('quantity')->unsigned()->default(1);
            $table->decimal('original_price', 8, 2)->nullable();
            $table->decimal('item_discount', 8, 2)->nullable();
            $table->decimal('final_price', 8, 2);

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['cart_id', 'product_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
};
