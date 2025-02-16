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
        Schema::table('permissions', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['role_id']);

            // Drop the role_id column
            $table->dropColumn('role_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            // Add the role_id column back
            $table->unsignedBigInteger('role_id');

            // Add the foreign key constraint back
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }
};