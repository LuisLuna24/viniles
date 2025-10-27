<?php

namespace App\Livewire\Modules\Home\Stickers;

use App\Models\Diseno;
use App\Models\stickers;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Index extends Component
{
    use WithPagination;
    public $search = '';


    public function updatingSearch()
    {
        $this->resetPage('disenos-page');
    }

    public function readDesign($slug)
    {
        dd($slug);
        //return redirect()->route('stickers.read', ['slug' => $slug]);
    }

    public function render()
    {
        $query = Diseno::query()
            // ¡ACTUALIZADO! Carga todas las relaciones necesarias
            ->with([
                'colores.colorPrimario' // Carga las variaciones y el color primario de cada una
            ])
            ->where('estatus', 1);

        if ($this->search) {
            $query->where(function ($q) {
                // Búsqueda existente
                $q->where('nombre', 'like', '%' . $this->search . '%')
                    ->orWhere('tipo_diseno', 'like', '%Sticker%')
                    ->orWhereHas('colores.colorPrimario', function ($colorQuery) {
                        $colorQuery->where('nombre', 'like', '%' . $this->search . '%');
                    });
            });
        }

        $disenos = $query->paginate(12, pageName: 'disenos-page');
        return view('livewire.modules.home.stickers.index', [
            'disenos' => $disenos,
        ]);
    }
}
