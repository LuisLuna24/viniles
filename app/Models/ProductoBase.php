<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\SlugOptions;

class ProductoBase extends Model
{
    use HasFactory;
    protected $table = 'productos_base';
    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'precio_costo',
        'precio_venta_base',
        'stock',
        'unidad_id',
        'categoria_id',
        'subcategoria_id',
        'vendible_sin_personalizar',
        'estatus',
    ];

    public function categoria(): BelongsTo
    {
        return $this->BelongsTo(Categoria::class);
    }
    public function subcategoria(): BelongsTo
    {
        return $this->BelongsTo(Subcategoria::class);
    }
    public function unidad(): BelongsTo
    {
        return $this->BelongsTo(Unidad::class);
    }
    public function imagenes(): HasMany
    {
        return $this->HasMany(ProductoBaseImagen::class);
    }

    public function descripciones(): HasMany
    {
        return $this->HasMany(ProductoBaseDescripcion::class);
    }
}
