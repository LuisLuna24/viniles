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
        Schema::table('producto_base_descripcions', function (Blueprint $table) {
            $table->foreignId('tecnica_id')->nullable()->constrained('tecnica_produccions')->after('id');
            $table->decimal('precio_unitario', 10, 2)->nullable()->after('descripcion');
            $table->decimal('precio_mayoreo', 10, 2)->nullable()->after('precio_unitario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('producto_base_descripcions', function (Blueprint $table) {
            $table->dropForeign(['tecnica_id']);
            $table->dropColumn('tecnica_id');
            $table->dropColumn('precio_unitario');
            $table->dropColumn('precio_mayoreo');
        });
    }
};
