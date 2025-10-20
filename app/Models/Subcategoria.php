<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subcategoria extends Model
{
    use HasFactory;
    protected $fillable = ['categoria_id', 'nombre', 'estatus'];

    public function categoria(): BelongsTo
    {
        return $this->BelongsTo(Categoria::class);
    }
    public function productosBase(): HasMany
    {
        return $this->hasMany(ProductoBase::class);
    }
}
