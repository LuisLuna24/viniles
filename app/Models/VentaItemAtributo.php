<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VentaItemAtributo extends Model
{
    use HasFactory;
    protected $table = 'venta_item_atributos';
    protected $fillable = ['venta_item_id', 'atributo', 'valor'];

    public function ventaItem(): BelongsTo
    {
        return $this->BelongsTo(VentaItem::class);
    }
}
