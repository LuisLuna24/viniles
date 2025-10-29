<?php

namespace App\Livewire\Modules\Disenos;

use App\Models\Color;    // Asumiendo que tienes un modelo Color
use App\Models\Diseno;
use App\Models\DisenoPrecioColor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;

class Edit extends Component
{
    use WithFileUploads;

    // ----- PROPIEDADES DEL DISEÑO PRINCIPAL -----
    public Diseno $diseno;
    public $nombre;
    public $slug;
    public $descripcion;
    public $tipo_diseno;
    public $url_archivo_diseno;
    public $largo_cm;
    public $estatus;
    public $nueva_imagen_principal; // Para subir una imagen nueva

    // ----- PROPIEDADES PARA EL NUEVO COLOR (MODAL) -----

    public $nombre_color;
    public $color_primario_id;
    public $color_secundario_id;
    public $color_terciario_id;
    public $precio_adicional = 0;
    public $nueva_imagen_ejemplo; // Para subir la imagen del color

    /**
     * Carga el diseño y llena las propiedades del formulario.
     */
    public function mount($diseno_id)
    {
        // Busca el diseño manualmente
        $diseno = Diseno::findOrFail($diseno_id);

        $this->diseno = $diseno;
        $this->nombre = $diseno->nombre;
        $this->slug = $diseno->slug;
        $this->descripcion = $diseno->descripcion;
        $this->tipo_diseno = $diseno->tipo_diseno;
        $this->url_archivo_diseno = $diseno->url_archivo_diseno;
        $this->largo_cm = $diseno->largo_cm; // Asegúrate que el nombre de columna sea correcto
        $this->estatus = $diseno->estatus;
    }

    /**
     * Actualiza el slug cuando el nombre cambia.
     */
    public function updatedNombre($value)
    {
        $this->slug = Str::slug($value);
    }

    /**
     * Reglas de validación para el Diseño principal.
     */
    protected function rulesDiseno()
    {
        return [
            'nombre' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('disenos')->ignore($this->diseno->id),
            ],
            'descripcion' => 'nullable|string',
            'tipo_diseno' => 'nullable|string|max:100',
            'url_archivo_diseno' => 'nullable|string|max:255|url',
            'largo_cm' => 'nullable|numeric|decimal:0,2|min:0',
            'estatus' => 'required|boolean',
            'nueva_imagen_principal' => 'nullable|image|max:2048',
        ];
    }

    /**
     * Reglas de validación para el formulario de Color/Precio.
     */
    protected function rulesColor()
    {
        return [
            'nombre_color' => 'required',
            'color_primario_id' => 'required|exists:colores,id',
            'color_secundario_id' => 'nullable|exists:colores,id',
            'color_terciario_id' => 'nullable|exists:colores,id',
            'precio_adicional' => 'required|min:0',
            'nueva_imagen_ejemplo' => 'nullable|max:2048',
        ];
    }

    /**
     * Guarda los cambios del DISEÑO (Pestaña "Información").
     */
    public function updateDiseno()
    {
        $validatedData = $this->validate($this->rulesDiseno());

        // Manejar la subida de la nueva imagen principal
        if ($this->nueva_imagen_principal) {
            Storage::disk('public')->delete($this->diseno->url_imagen_principal);

            $validatedData['url_imagen_principal'] = $this->nueva_imagen_principal->store('disenos', 'public');
        }

        // Quitar la propiedad que no es de la BD
        unset($validatedData['nueva_imagen_principal']);

        // Actualizar el modelo
        $this->diseno->update($validatedData);

        // Refrescar el estado (por si acaso)
        $this->diseno = $this->diseno->fresh();

        session()->flash('messageDiseno', 'Información del diseño actualizada.');
    }

    public function saveColor()
    {
        $validatedData = $this->validate($this->rulesColor());

        // Si estamos en modo edición
        if ($this->editId) {
            $color = DisenoPrecioColor::find($this->editId);

            // Manejar la subida de la nueva imagen si se proporciona
            if ($this->nueva_imagen_ejemplo instanceof \Illuminate\Http\UploadedFile) {
                // Eliminar imagen anterior si existe
                if ($color->url_imagen_ejemplo && Storage::disk('public')->exists($color->url_imagen_ejemplo)) {
                    Storage::disk('public')->delete($color->url_imagen_ejemplo);
                }
                $validatedData['url_imagen_ejemplo'] = $this->nueva_imagen_ejemplo->store('disenos', 'public');
            } else {
                // Mantener la imagen actual si no se subió una nueva
                $validatedData['url_imagen_ejemplo'] = $color->url_imagen_ejemplo;
            }

            // Quitar la propiedad que no es de la BD
            unset($validatedData['nueva_imagen_ejemplo']);

            // Actualizar el registro
            $color->update($validatedData);

            session()->flash('messageColor', 'Variación de color actualizada.');
        } else {
            // Modo creación - crear nuevo registro
            if ($this->nueva_imagen_ejemplo instanceof \Illuminate\Http\UploadedFile) {
                $validatedData['url_imagen_ejemplo'] = $this->nueva_imagen_ejemplo->store('disenos', 'public');
            }

            // Quitar la propiedad que no es de la BD
            unset($validatedData['nueva_imagen_ejemplo']);

            // Crear el registro asociado al diseño
            $this->diseno->colores()->create($validatedData);

            session()->flash('messageColor', 'Variación de color guardada.');
        }

        $this->resetFormColor();
        $this->diseno->load('colores');
        $this->dispatch('showColorModal,false');
    }



    //*================================================================================================================================= Editar

    public $editId;
    public function edit($id)
    {
        $this->resetFormColor();
        $this->editId = $id;
        $data = DisenoPrecioColor::find($id);

        $this->nombre_color = $data->nombre_color;
        $this->color_primario_id = $data->color_primario_id;
        $this->color_secundario_id = $data->color_secundario_id;
        $this->color_terciario_id = $data->color_terciario_id;
        $this->precio_adicional = $data->precio_adicional;
        $this->nueva_imagen_ejemplo = $data->url_imagen_ejemplo; // Asignar la imagen actual

        // Emitir evento para Alpine.js si es necesario
        $this->dispatch('editModeEnabled', image: $data->url_imagen_ejemplo ? asset('storage/' . $data->url_imagen_ejemplo) : null);
    }

    public function resetFormColor()
    {
        $this->reset('nombre_color', 'color_primario_id', 'color_secundario_id', 'color_terciario_id', 'precio_adicional', 'nueva_imagen_ejemplo', 'editId');
    }


    //*================================================================================================================================= Eliminar

    public $deleteModal = false;
    public $delteId;
    public function delete($id)
    {
        $this->deleteModal = true;
        $this->delteId = $id;
    }

    public $password, $password_confirmation;

    public function deleteSubmit()
    {
        $this->validate([
            'password' => 'required|string|confirmed',
        ]);

        if (!Hash::check($this->password, hashedValue: Auth::user()->password)) {
            $this->notifications('danger', 'Diseño', 'La contraseña no coincide con la actual.');
            return;
        }

        DB::beginTransaction();
        try {

            $data = DisenoPrecioColor::find($this->delteId);
            if ($data->url_imagen_ejemplo) {
                Storage::disk('public')->delete($data->url_imagen_ejemplo);
            }
            $data->delete();

            DB::commit();
            $this->deleteModal = false;
            $this->reset(['delteId', 'password', 'password_confirmation']);
            $this->notifications('danger', 'Diseño', 'El diseño ha sido eliminado');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            $this->notifications('danger', 'Diseño', 'Lo sentimos, que ha ocurrido un error. Si el problema persiste, contacte al área de sistemas');
        }
    }

    //*================================================================================================================================= Notification

    public function notifications($type, $title, $message)
    {
        //info-success-danger
        $this->dispatch('notify',  variant: $type, title: $title, message: $message);
    }

    public function render()
    {
        return view('livewire.modules.disenos.edit', [
            'colores' => Color::all(), // Para los <select> del modal
            'variaciones' => $this->diseno->colores()->latest()->get() // Lista para la tabla
        ]);
    }
}
