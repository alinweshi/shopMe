<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('product_attributes', function (Blueprint $table) {
            // 1. Drop the existing foreign key constraint
            $table->dropForeign(['product_id']);

            // 2. Re-add the foreign key with explicit table reference
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('product_attributes', function (Blueprint $table) {
            // Reverse the changes if needed
            $table->dropForeign(['product_id']);

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
        });
    }
};
