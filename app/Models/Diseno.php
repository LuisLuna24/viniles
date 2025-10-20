<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Diseno extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'tipo_diseno',
        'url_imagen_principal',
        'url_archivo_diseno',
        'largo_cm',
        'alto_cm',
        'estatus',
    ];

    public function preciosPorColor(): HasMany
    {
        return $this->hasMany(DisenoPrecioColor::class);
    }
    public function aplicacionesVehiculos(): HasMany
    {
        return $this->hasMany(DisenoAplicacionVehiculo::class);
    }
}
