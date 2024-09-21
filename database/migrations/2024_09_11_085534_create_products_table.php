<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{public function up()
    {
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name', 50);
        $table->string('slug', 50)->unique();
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->text('description')->nullable();
        $table->string('brand');
        $table->decimal('price', 8, 2);
        $table->decimal('final_price', 8, 2);
        $table->enum('discount_type', ['percentage', 'fixed']);
        $table->integer('discount');
        $table->string('image');

        $table->timestamps();
    });
}

    public function down()
    {
        Schema::dropIfExists('products');
    }}