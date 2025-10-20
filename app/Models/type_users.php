<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class type_users extends Model
{
    use HasFactory;

    protected $table = 'type_users';

     protected $fillable = [
        'nombre',
        'estatus'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
