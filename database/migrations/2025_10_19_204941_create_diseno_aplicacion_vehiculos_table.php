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
        Schema::create('diseno_aplicacion_vehiculos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diseno_id')->constrained('disenos')->onDelete('cascade');
            $table->foreignId('modelo_id')->constrained('vehiculo_modelos')->onDelete('cascade');
            $table->year('ano_inicio');
            $table->year('ano_fin');
            $table->string('parte_vehiculo', 100);
            $table->tinyInteger('estatus')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diseno_aplicacion_vehiculos');
    }
};
