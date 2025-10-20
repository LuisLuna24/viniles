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
        Schema::create('producto_base_descripcions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_base_id')->constrained('productos_base')->onDelete('cascade');
            $table->string('descripcion');
            $table->integer('orden')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_base_descripcions');
    }
};
