<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'total', 'metodo_pago', 'estatus'];

    public function user(): BelongsTo { /* ... */ }
    public function items(): HasMany { /* ... */ }
}
