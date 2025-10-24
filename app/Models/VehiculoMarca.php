<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VehiculoMarca extends Model
{
    use HasFactory;
    protected $table = 'vehiculo_marcas';
    protected $fillable = ['nombre','estatus'];

    public function modelos(): HasMany
    {
        return $this->hasMany(VehiculoModelo::class);
    }
}
