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
        Schema::create('diseno_precio_colors', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_color');
            $table->foreignId('diseno_id')->constrained('disenos')->onDelete('cascade');
            $table->foreignId('color_primario_id')->constrained('colores');
            $table->foreignId('color_secundario_id')->nullable()->constrained('colores');
            $table->foreignId('color_terciario_id')->nullable()->constrained('colores');
            $table->decimal('precio_adicional', 10, 2)->default(0);
            $table->string('url_imagen_ejemplo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diseno_precio_colors');
    }
};
