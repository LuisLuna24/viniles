<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Maquina extends Model
{
    use HasFactory;
    protected $table = 'Maquinas';
    protected $fillable = [
        'nombre',
        'marca',
        'modelo',
        'estatus',
    ];

    public function configuraciones(): HasMany
    {
        return $this->HasMany(ConfiguracionProduccion::class);
    }
}
