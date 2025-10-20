<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfiguracionDetalle extends Model
{
    use HasFactory;
    protected $table = 'configuracion_detalles';
    protected $fillable = [
        'configuracion_id',
        'parametro',
        'valor',
        'unidad',
    ];

    public function configuracionProduccion(): BelongsTo { /* ... */ }
}
