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
        Schema::create('rams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('capacitie_id');
            $table->foreign('capacitie_id')->references('id')->on('capacities')->onDelete('cascade');
            $table->unsignedBigInteger('marck_id');
            $table->foreign('marck_id')->references('id')->on('marcks')->onDelete('cascade');
            $table->unsignedBigInteger('velositie_id');
            $table->foreign('velositie_id')->references('id')->on('velosities')->onDelete('cascade');
            $table->double('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rams');
    }
};
