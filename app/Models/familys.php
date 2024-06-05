<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class familys extends Model
{
    protected $table = 'families';

    public function procesadores()
    {
        return $this->hasMany(processors::class);
    }

    use HasFactory;
}
