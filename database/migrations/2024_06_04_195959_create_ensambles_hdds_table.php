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
        Schema::create('ensambles_hdds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hdd_id');
            $table->unsignedBigInteger('ensamble_id');
            $table->foreign('hdd_id')->references('id')->on('hdds');
            $table->foreign('ensamble_id')->references('id')->on('ensambles');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ensambles_hdds');
    }
};
