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
        Schema::create('configuracion_produccions', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_configuracion');
            $table->foreignId('maquina_id')->constrained('maquinas');
            $table->foreignId('tecnica_id')->constrained('tecnica_produccions');
            $table->string('tipo_material', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracion_produccions');
    }
};
