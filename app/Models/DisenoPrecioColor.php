<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DisenoPrecioColor extends Model
{
    use HasFactory;
    protected $table = 'diseno_precio_colors';
    protected $fillable = [
        'diseno_id',
        'nombre_color',
        'color_primario_id',
        'color_secundario_id',
        'color_terciario_id',
        'precio_adicional',
        'url_imagen_ejemplo',
    ];

    protected $casts = [
        'nueva_imagen_ejemplo' => 'string', // O el tipo correcto según tu BD
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
        return $this->BelongsTo(Color::class);
    }
}
