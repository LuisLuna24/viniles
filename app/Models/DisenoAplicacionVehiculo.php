<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DisenoAplicacionVehiculo extends Model
{
    use HasFactory;
    protected $table = 'disenos_aplicaciones_vehiculos';
    protected $fillable = [
        'diseno_id',
        'modelo_id',
        'ano_inicio',
        'ano_fin',
        'parte_vehiculo',
    ];

    public function diseno(): BelongsTo
    {
        return $this->belongsTo(Diseno::class);
    }
    public function modelo(): BelongsTo
    {
        return $this->belongsTo(VehiculoModelo::class);
    }
}
