<?php

namespace App\Livewire\Modules\Sticker;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\stickers;

class Create extends Component
{
    use WithFileUploads;

    public $nombre;
    public $img;
    public $largo;
    public $alto;

    // Reglas de validación en tiempo real
    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:100',
            'img'    => 'nullable|image|max:2048', // 2MB Máximo
            'largo'  => 'required|numeric|min:0',
            'alto'   => 'required|numeric|min:0',
        ];
    }

    public function updated($propertyName)
    {
        // Validar el campo en tiempo real cuando el usuario lo modifica
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        // 1. Validar todos los campos antes de guardar
        $validatedData = $this->validate();

        // 2. Guardar la imagen en el servidor
        // El archivo se guardará en `storage/app/public/stickers`
        if ($this->img) {
            $imagePath = $this->img->store('stickers', 'public');
            $validatedData['img'] = $imagePath;
        }
        // 3. Crear el registro en la base de datos
        stickers::create($validatedData);

        // 4. Mostrar un mensaje de éxito
        session()->flash('message', '¡Sticker agregado exitosamente! 🎉');

        // 5. Limpiar los campos del formulario
        $this->reset();
    }

    public function render()
    {
        return view('livewire.modules.sticker.create');
    }
}
