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
        Schema::create('admin_raffles', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id");
            $table->foreignId("raffle_id");
            $table->foreign("user_id")->on("users")->references("id");
            $table->foreign("raffle_id")->on("raffles")->references("id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_raffles');
    }
};
