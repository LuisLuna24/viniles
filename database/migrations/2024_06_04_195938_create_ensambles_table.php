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
        Schema::create('ensambles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name',50);
            $table->unsignedBigInteger('processor_id');
            $table->foreign('processor_id')->references('id')->on('processors')->onDelete('cascade');
            $table->unsignedBigInteger('motherboard_id');
            $table->foreign('motherboard_id')->references('id')->on('motherboards')->onDelete('cascade');
            $table->unsignedBigInteger('cabinet_id');
            $table->foreign('cabinet_id')->references('id')->on('cabinets')->onDelete('cascade');
            $table->unsignedBigInteger('grafic_id');
            $table->foreign('grafic_id')->references('id')->on('graphics')->onDelete('cascade');
            $table->unsignedBigInteger('ram_id');
            $table->foreign('ram_id')->references('id')->on('rams')->onDelete('cascade');
            $table->integer('can_ram');
            $table->unsignedBigInteger('source_id');
            $table->foreign('source_id')->references('id')->on('sources')->onDelete('cascade');
            $table->double('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ensambles');
    }
};
