<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehiculoModelo extends Model
{
    use HasFactory;
    protected $table = 'vehiculo_modelos';
    protected $fillable = ['marca_id', 'nombre', 'estatus'];

    public function marca(): BelongsTo
    {
        return $this->BelongsTo(VehiculoMarca::class);
    }
}
