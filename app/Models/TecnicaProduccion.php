<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TecnicaProduccion extends Model
{
    use HasFactory;

    protected $table = 'tecnica_produccions';
    protected $fillable = ['nombre', 'estatus'];

    public function configuraciones(): HasMany
    {
        return $this->HasMany(ConfiguracionProduccion::class);
    }

    public function productoBaseDescrip(): HasMany
    {
        return $this->HasMany(ProductoBaseDescripcion::class);
    }
}
