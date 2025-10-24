<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function configuracionProduccion(): BelongsTo
    {
        return $this->belongsTo(ConfiguracionProduccion::class);
    }
}
