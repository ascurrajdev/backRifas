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
        Schema::create('ruffle_numbers', function (Blueprint $table) {
            $table->id();
            $table->foreignId("client_id");
            $table->foreignId("collection_id");
            $table->foreignId("ruffle_id");
            $table->foreign("client_id")->on("clients")->references("id");
            $table->foreign("collection_id")->on("collections")->references("id");
            $table->foreign("ruffle_id")->on("ruffles")->references("id");
            $table->integer('number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruffle_numbers');
    }
};
