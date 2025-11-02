<?php

namespace App\Livewire\Modules\Home\Productos;

use App\Models\ProductoBase;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class Read extends Component
{

    #[Reactive]
    public $slug;

    public $data;
    public $product;

    public $vendible_sin_personalizar;

    public $tecnica_id;

    public function mount()
    {

        $this->data = ProductoBase::where("slug", $this->slug)->first();

        $this->product = (object) [
            'id' => 1,
            'nombre' => $this->data->nombre,
            'descripcion' => $this->data->descripcion,
            'precio_venta_base' => $this->data->precio_venta_base,
            'unidad' => $this->data->unidad->nombre,
            'categoria' => $this->data->categoria->nombre,
            'vendible_sin_personalizar' => $this->data->vendible_sin_personalizar,
            'imagenes' => $this->data->imagenes,
            'descripciones' => $this->data->descripciones->mapWithKeys(fn($item) => [
                $item->id => (object) [
                    'id' => $item->id,
                    'tecnica' => $item->tecnicaProduc->nombre,
                    'descripcion' => $item->descripcion,
                    'precio_unitario' => $item->precio_unitario,
                    'precio_mayoreo' => $item->precio_mayoreo,
                    'catidad_mayoreo' => $item->cantidad_mayoreo,
                ]
            ])->all(),
        ];

        if ($this->data->descripciones->isNotEmpty()) {
            $this->tecnica_id = $this->data->descripciones->first()->id;
        }


        $this->vendible_sin_personalizar = $this->product->vendible_sin_personalizar;
    }



    public function render()
    {
        $relatedProducts = ProductoBase::where('categoria_id', $this->data->categoria_id)
            ->where('id', '!=', $this->product->id)
            ->with(['categoria', 'unidad', 'imagenes'])
            ->take(4)
            ->get();
        return view('livewire.modules.home.productos.read', compact('relatedProducts'));
    }
}
