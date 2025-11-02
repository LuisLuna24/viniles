<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductoBaseDescripcion extends Model
{
    use HasFactory;
    protected $table = 'producto_base_descripcions';
    protected $fillable = [
        'tecnica_id',
        'producto_base_id',
        'descripcion',
        'precio_unitario',
        'precio_mayoreo',
        'cantidad_mayoreo',
        'orden',
    ];

    public function productoBase(): BelongsTo
    {
        return $this->BelongsTo(ProductoBase::class);
    }

    public function tecnicaProduc(): BelongsTo
    {
        return $this->BelongsTo(TecnicaProduccion::class, 'tecnica_id');
    }
}
