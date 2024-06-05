<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chipsets extends Model
{
    protected $table = 'chipsets';

    public function prosesadores(){
        return $this->hasMany(processors::class);
    }
    use HasFactory;
}
