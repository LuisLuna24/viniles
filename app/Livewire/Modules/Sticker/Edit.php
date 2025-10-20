<?php

namespace App\Livewire\Modules\Sticker;

use App\Models\Colores;
use App\Models\stickers;
use App\Models\stickersColor;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Reactive;
use Livewire\WithPagination;

class Edit extends Component
{
    use WithFileUploads;
    use WithPagination;

    #[Reactive]
    public $id;

    public ?stickers $sticker = null;

    // Propiedades del formulario principal del Sticker
    public $nombre;
    public $largo;
    public $alto;
    public $newImage;

    // Propiedades para el modal
    public $colores = [];

    // Reglas de validación para el formulario principal
    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:100',
            'largo'  => 'required|numeric|min:0',
            'alto'   => 'required|numeric|min:0',
            'newImage' => 'nullable|image|max:2048',
        ];
    }

    public function mount()
    {
        $this->sticker = stickers::findOrFail($this->id);

        $this->nombre = $this->sticker->nombre;
        $this->largo = $this->sticker->largo;
        $this->alto = $this->sticker->alto;

        $this->colores = Colores::where('estatus', 1)->orderBy('nombre', 'asc')->get();
    }

    public function update()
    {
        $this->validate();

        if ($this->newImage) {
            $oldImagePath = $this->sticker->img;
            $imagePath = $this->newImage->store('stickers', 'public');
            $this->sticker->img = $imagePath;
            if ($oldImagePath) {
                Storage::disk('public')->delete($oldImagePath);
            }
        }

        $this->sticker->nombre = $this->nombre;
        $this->sticker->largo = $this->largo;
        $this->sticker->alto = $this->alto;
        $this->sticker->save();

        session()->flash('message', '¡Sticker actualizado exitosamente! ✨');
    }

    //^=======================================================================================================================
    //^ Lógica para el MODAL DE COLORES
    //^=======================================================================================================================

    public $modalColor = false;
    public $typeFormColor = 1; // 1 = Crear, 2 = Editar
    public $color_sticker_id;  // ID del registro en la tabla pivote (stickers_colors)

    // Propiedades del formulario del modal (sincronizadas con el blade)
    public $color_id; // ID del color seleccionado
    public $precio_unitario_color;
    public $precio_mayoreo_color;
    public $img_color; // Para la nueva imagen subida
    public $img_color_url; // Para mostrar la imagen existente al editar

    /**
     * Reglas de validación para el formulario de colores.
     */
    protected function colorRules()
    {
        return [
            'color_id' => 'required|integer|exists:colores,id',
            'precio_unitario_color' => 'required|numeric|min:0',
            'precio_mayoreo_color' => 'required|numeric|min:0|lte:precio_unitario_color',
            'img_color' => [
                $this->typeFormColor == 1 ? 'required' : 'nullable', // Requerido al crear, opcional al editar
                'image',
                'max:2048' // 2MB Max
            ],
        ];
    }

    /**
     * Mensajes de validación personalizados para el formulario de colores.
     */
    protected function colorMessages()
    {
        return [
            'precio_mayoreo_color.lte' => 'El precio de mayoreo no puede ser mayor al unitario.',
            'img_color.required' => 'La imagen para el color es obligatoria.',
        ];
    }

    public function newColor()
    {
        $this->resetFormColor();
        $this->typeFormColor = 1; // Modo creación
        $this->modalColor = true;
    }

    public function editColor($id)
    {
        $this->resetFormColor();
        $this->typeFormColor = 2; // Modo edición
        $this->color_sticker_id = $id;

        $data = stickersColor::findOrFail($id);

        $this->color_id = $data->color_id;
        $this->precio_unitario_color = $data->precio_unitario;
        $this->precio_mayoreo_color = $data->precio_mayoreo;

        if ($data->img) {
            $this->img_color_url = Storage::url($data->img);
        }

        $this->modalColor = true;
    }

    public function submitColors()
    {
        $this->validate($this->colorRules(), $this->colorMessages());

        $imagePath = null;
        if ($this->img_color) {
            $imagePath = $this->img_color->store('stickers_colors', 'public');
        }

        if ($this->typeFormColor == 1) { // Crear nuevo
            stickersColor::create([
                'sticker_id' => $this->id,
                'color_id' => $this->color_id,
                'precio_unitario' => $this->precio_unitario_color,
                'precio_mayoreo' => $this->precio_mayoreo_color,
                'img' => $imagePath,
                'estatus' => true,
            ]);
            session()->flash('message', '¡Color agregado exitosamente!');
        } else { // Actualizar existente
            $colorSticker = stickersColor::findOrFail($this->color_sticker_id);

            if ($imagePath && $colorSticker->img) {
                Storage::disk('public')->delete($colorSticker->img);
            }

            $colorSticker->update([
                'color_id' => $this->color_id,
                'precio_unitario' => $this->precio_unitario_color,
                'precio_mayoreo' => $this->precio_mayoreo_color,
                'img' => $imagePath ?? $colorSticker->img,
            ]);
            session()->flash('message', '¡Color actualizado exitosamente!');
        }

        $this->resetFormColor();
    }

    public function deleteColor($id)
    {
        $colorSticker = stickersColor::findOrFail($id);
        if ($colorSticker->img) {
            Storage::disk('public')->delete($colorSticker->img);
        }
        $colorSticker->delete();
        session()->flash('message', '¡Color eliminado exitosamente!');
    }

    public function resetFormColor()
    {
        $this->reset([
            'modalColor',
            'typeFormColor',
            'color_sticker_id',
            'color_id',
            'precio_unitario_color',
            'precio_mayoreo_color',
            'img_color',
            'img_color_url'
        ]);
        $this->resetErrorBag(); // Limpia los errores de validación
    }

    //^=======================================================================================================================
    //^ Render
    //^=======================================================================================================================
    public function render()
    {
        $coloresStiker = stickersColor::where('sticker_id', $this->id)
            ->with('color') // Optimización para cargar la relación
            ->orderBy('created_at', 'asc')
            ->paginate(10, pageName: 'colores-page');

        return view('livewire.modules.sticker.edit', [
            'coloresStiker' => $coloresStiker
        ]);
    }
}
