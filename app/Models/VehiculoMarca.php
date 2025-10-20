<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehiculoMarca extends Model
{
    use HasFactory;
    protected $table = 'vehiculos_marcas';
    protected $fillable = ['nombre'];

    public function modelos(): HasMany { /* ... */ }
}
