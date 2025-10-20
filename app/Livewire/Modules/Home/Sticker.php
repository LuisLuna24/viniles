<?php

namespace App\Livewire\Modules\Home;

use App\Models\stickers;
use Livewire\Component;
use Livewire\WithPagination;

class Sticker extends Component
{

    use WithPagination;
    public $search = ''; // 3. Propiedad para el input del buscador

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $stickers = stickers::with('colores')->where('nombre', 'like', '%' . $this->search . '%')->where('estatus', 1)->paginate(12, pageName: 'stickers-page');
        return view('livewire.modules.home.sticker', [
            'stickers' => $stickers
        ]);
    }
}
