<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'estatus'];

    public function subcategorias(): HasMany
    {
        return $this->hasMany(Subcategoria::class);
    }
    public function productosBase(): HasMany
    {
        return $this->hasMany(ProductoBase::class);
    }
}
