<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string(column: 'name', length: 100);
            $table->string('slug', length: 50)->unique();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->string('brand');
            $table->decimal('price', total: 8, places: 2);

            $table->decimal('final_price', 8, 2);
            $table->enum('discount_type', ['percentage', 'fixed']);
            $table->integer('discount')->nullable();
            $table->string('image')->nullable();
            $table->integer('stock')->default(0); // Track stock

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
