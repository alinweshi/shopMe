<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('customer_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('orderNumber');
            $table->date('orderDate');
            $table->date('requiredDate');
            $table->date('shippedDate')->nullable();
            $table->string('status', 15);
            $table->text('comments')->nullable();
            $table->integer('customerNumber');
            $table->timestamps(); // Optional: Adds created_at and updated_at columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_orders');
    }
}
