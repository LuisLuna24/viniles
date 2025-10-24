<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VentaItem extends Model
{
    use HasFactory;
    protected $table = 'venta_items';
    protected $fillable = [
        'venta_id',
        'producto_base_id',
        'diseno_id',
        'descripcion_personalizada',
        'cantidad',
        'precio_unitario',
        'subtotal',
    ];

    public function venta(): BelongsTo
    {
        return $this->BelongsTo(Venta::class);
    }
    public function productoBase(): BelongsTo
    {
        return $this->BelongsTo(ProductoBase::class);
    }
    public function diseno(): BelongsTo
    {
        return $this->BelongsTo(Diseno::class);
    }
    public function atributos(): HasMany
    {
        return $this->hasMany(VentaItemAtributo::class);
    }
}
