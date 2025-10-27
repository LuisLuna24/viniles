<?php

namespace App\Livewire\Modules\Home\Stickers;

use App\Models\Diseno;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class Read extends Component
{
    #[Reactive]
    public $slug;
    public $product;

    public function mount()
    {
        $data = Diseno::where("slug", $this->slug)->first();

        $this->product = (object) [
            'id' => 1,
            'name' => $data->nombre,
            'image_url' => $data->url_imagen_principal,
            'description' => $data->descripcion,
            'largo' => $data->largo_cm,

            'color_groups' => $data->colores->map(fn($item) => (object) [
                'id' => $item->id,
                'name' => $item->nombre_color, // Valor fijo
                'unit_price' => $item->precio_adicional, // Valor fijo
                'wholesale_price' => $item->precio_adicional * 0.5, // Valor fijo
                'image_url' => $item->url_imagen_ejemplo ? 'storage/' . $item->url_imagen_ejemplo : 'storage/' . $data->url_imagen_principal, // Valor fijo
                'colors' => array_merge(
                    [
                        (object) [
                            'name' => $item->colorPrimario->nombre,
                            'style_attribute' => $item->colorPrimario->gradiante == 1
                                ? 'background-image: linear-gradient(to right,' . trim($item->colorPrimario->hex_code, '"') . ');'  // <-- 'background-image' para gradiente
                                : 'background-color:' . $item->colorPrimario->hex_code . ';',
                        ]
                    ],
                    $item->colorSecundario ? [
                        (object) [
                            'name' => $item->colorSecundario->nombre,
                            'style_attribute' => $item->colorSecundario->gradiante == 1
                                ? 'background-image: linear-gradient(to right,' . trim($item->colorSecundario->hex_code, '"') . ');' // <-- 'background-image' para gradiente
                                : 'background-color:' . $item->colorSecundario->hex_code . ';',
                        ]
                    ] : [],
                    $item->colorTerciario ? [
                        (object) [
                            'name' => $item->colorTerciario->nombre,
                            'style_attribute' => $item->colorTerciario->gradiante == 1
                                ? 'background-image: linear-gradient(to right,' . trim($item->colorTerciario->hex_code, '"') . ');'  // <-- 'background-image' para gradiente
                                : 'background-color:' . $item->colorTerciario->hex_code . ';',
                        ]
                    ] : []
                )
            ])->all(),
        ];
    }
    public function render()
    {
        return view('livewire.modules.home.stickers.read');
    }
}
