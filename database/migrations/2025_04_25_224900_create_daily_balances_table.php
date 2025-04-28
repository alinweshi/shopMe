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
        Schema::create('daily_balance', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('account_number');
            $table->string('iban');
            $table->dateTime('date');
            $table->index('date', 'account_number');
            $table->string('name');
            $table->string('currency');
            $table->decimal('balance', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
