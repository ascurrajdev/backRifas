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
        Schema::create('user_raffles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id');
            $table->foreignId('raffle_id');
            $table->integer("min_number")->nullable();
            $table->integer("max_number")->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('raffle_id')->references('id')->on('raffles');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_raffles');
    }
};
