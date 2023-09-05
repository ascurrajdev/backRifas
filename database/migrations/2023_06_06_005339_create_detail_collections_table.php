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
        Schema::create('detail_collections', function (Blueprint $table) {
            $table->id();
            $table->foreignId("raffle_id");
            $table->integer("quantity");
            $table->double("amount");
            $table->foreignId("collection_id");
            $table->foreign("collection_id")->references("id")->on("collections");
            $table->foreign("raffle_id")->references("id")->on("raffles");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_collections');
    }
};
