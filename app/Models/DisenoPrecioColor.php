<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DisenoPrecioColor extends Model
{
    use HasFactory;
    protected $table = 'disenos_precios_colores';
    protected $fillable = [
        'diseno_id',
        'color_primario_id',
        'color_secundario_id',
        'color_terciario_id',
        'precio_adicional',
        'url_imagen_ejemplo',
    ];

    public function diseno(): BelongsTo
    {
        return $this->BelongsTo(Diseno::class);
    }
    public function colorPrimario(): BelongsTo
    {
        return $this->BelongsTo(Color::class);
    }
    public function colorSecundario(): BelongsTo
    {
        return $this->BelongsTo(Color::class);
    }
    public function colorTerciario(): BelongsTo
    {
        return $this->BelongsTo(related: Color::class);
    }
}
