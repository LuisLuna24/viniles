<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function maquina(): BelongsTo
    {
        return $this->belongsTo(Maquina::class);
    }
    public function tecnica(): BelongsTo
    {
        return $this->belongsTo(TecnicaProduccion::class);
    }
    public function detalles(): HasMany
    {
        return $this->hasMany(ConfiguracionDetalle::class);
    }
}
