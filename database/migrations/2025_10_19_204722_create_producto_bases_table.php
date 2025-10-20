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
        Schema::create('productos_base', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('slug')->unique();
            $table->text('descripcion')->nullable();
            $table->string('sku', 100)->unique()->nullable();
            $table->string('tipo_material', 100);
            $table->decimal('precio_costo', 10, 2)->default(0);
            $table->decimal('precio_venta_base', 10, 2)->default(0);
            $table->integer('stock')->default(0);
            $table->foreignId('unidad_id')->constrained('unidades');
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->foreignId('subcategoria_id')->nullable()->constrained('subcategorias');
            $table->boolean('vendible_sin_personalizar')->default(false);
            $table->tinyInteger('estatus')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos_base');
    }
};
