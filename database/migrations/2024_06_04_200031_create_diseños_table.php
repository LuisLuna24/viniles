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
        Schema::create('diseños', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('name',50);
            $table->string('imagen',255);
            $table->unsignedBigInteger('vinilcategory_id');
            $table->foreign('vinilcategory_id')->references('id')->on('vinilcategorys');
            $table->double('price_bruto');
            $table->double('price_client');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diseños');
    }
};
