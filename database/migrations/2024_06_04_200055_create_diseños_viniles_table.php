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
        Schema::create('diseños_viniles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('diseño_id');
            $table->unsignedBigInteger('vinil_id');
            $table->foreign('diseño_id')->references('id')->on('diseños');
            $table->foreign('vinil_id')->references('id')->on('viniles');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diseños_viniles');
    }
};
