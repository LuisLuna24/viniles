<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductoBaseDescripcion extends Model
{
    use HasFactory;
    protected $table = 'productos_base_descripcion';
    protected $fillable = ['producto_base_id', 'descripcion', 'orden'];

    public function productoBase(): BelongsTo
    {
        return $this->BelongsTo(ProductoBase::class);
    }
}
