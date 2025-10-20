<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfiguracionProduccion extends Model
{
    use HasFactory;
    protected $table = 'configuraciones_produccion';
    protected $fillable = [
        'nombre_configuracion',
        'maquina_id',
        'tecnica_id',
        'tipo_material',
    ];

    public function maquina(): BelongsTo { /* ... */ }
    public function tecnica(): BelongsTo { /* ... */ }
    public function detalles(): HasMany { /* ... */ }
}
