<?php

namespace App\Livewire\Modules\Disenos;

use App\Models\Diseno; // Asegúrate de que tu modelo exista en app/Models/Diseno
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;

class Create extends Component
{
    use WithFileUploads;

    #[Rule('required|string|max:255')]
    public $nombre = '';

    #[Rule('required|string|max:255|unique:disenos,slug')]
    public $slug = '';

    #[Rule('nullable|string')]
    public $descripcion = '';

    #[Rule('nullable|string|max:100')]
    public $tipo_diseno = '';

    #[Rule('nullable|image|max:2048')]
    public $url_imagen_principal;

    #[Rule('nullable|string|max:255|url')]
    public $url_archivo_diseno = '';

    #[Rule('nullable|numeric|decimal:0,2|min:0')]
    public $largo_cm = '';


    public function updatedNombre($value)
    {
        // Genera el slug automáticamente
        $this->slug = Str::slug($value);
    }

    public function save()
    {
        $validatedData = $this->validate();

        if ($this->url_imagen_principal) {
            $validatedData['url_imagen_principal'] = $this->url_imagen_principal->store('disenos', 'public');
        }

        Diseno::create($validatedData);

        session()->flash('message', 'Diseño guardado exitosamente.');
        $this->reset();
    }
    public function render()
    {
        return view('livewire.modules.disenos.create');
    }
}
