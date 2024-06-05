<?php

namespace App\Livewire\Procesador;

use App\Models\processors;
use Livewire\Component;

class Table extends Component
{
    public $datos=10;
    public $search = '';

    public function render()
    {
        $procesadores=processors::where(function ($query) {$query->where('processors.name', 'LIKE', '%' . $this->search . '%')->orWhereHas('family', function ($query){
            $query->where('name', 'LIKE', '%' . $this->search . '%');
        });})->paginate($this->datos);
        return view('livewire.procesador.table',compact('procesadores'));
    }
}

