<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class processors extends Model
{
    protected $table = 'processors';
    protected $fillable = [
        'id',
        'processors_name',
        'processors_description',
    ];

    public function family(){
        return $this->belongsTo(familys::class);
    }

    public function chipset(){
        return $this->belongsTo(chipsets::class);
    }
    
    use HasFactory;
}
