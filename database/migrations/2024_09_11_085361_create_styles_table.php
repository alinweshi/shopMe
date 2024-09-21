<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStylesTable extends Migration
{
    public function up()
    {
        Schema::create('styles', function (Blueprint $table) {
            $table->id();
            $table->string(column: 'style');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('styles');
    }
}
