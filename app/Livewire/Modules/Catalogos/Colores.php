<?php

namespace App\Livewire\Modules\Catalogos;

use App\Models\Color;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Colores extends Component
{
    use WithPagination;
    public $perEstatus, $perPage = '10', $search;
    //*================================================================================================================================= Form

    public $modal = false;
    public $typeForm, $editId;
    public $nombre, $hex_code;

    // --- MODIFICACIONES ---
    // 1. Convertimos $esGradiante a booleano. Es mucho más fácil para Livewire
    //    manejar true/false con un checkbox que 1/0.
    public $esGradiante = false; // MODIFICADO (antes 0)

    // 2. Añadimos un array temporal para manejar los colores del gradiente en la UI
    public $hex_codes_array = []; // NUEVO
    // --- FIN MODIFICACIONES ---

    public function create()
    {
        $this->resetForm();
        $this->typeForm = 1;
        $this->modal = true;

        // NUEVO: Establecer un color por defecto para el picker
        $this->hex_code = '#000000';
    }

    public function edit($id)
    {
        $this->resetForm();
        $this->typeForm = 2;
        $this->modal = true;
        $data = Color::find($id);

        $this->nombre = $data->nombre;
        $this->editId = $id;

        // --- MODIFICADO: Lógica para cargar gradiente o color único ---
        $this->esGradiante = (bool)$data->gradiante; // Convertir 1/0 a true/false

        if ($this->esGradiante) {
            // Si es gradiente, explotamos el string en nuestro array
            $this->hex_codes_array = explode(',', $data->hex_code);
            $this->hex_code = null; // Limpiamos el color único
        } else {
            // Si es color único, solo asignamos el string
            $this->hex_code = $data->hex_code;
            $this->hex_codes_array = []; // Limpiamos el array
        }
        // --- FIN MODIFICACIÓN ---
    }

    // NUEVO: Hook que se dispara cuando se (des)marca el checkbox
    // Esto nos permite limpiar el estado opuesto.
    public function updatedEsGradiante($value)
    {
        if ($value) {
            // El usuario marcó "Es Gradiente"
            // Si $hex_code tenía un color, lo usamos como el primero del gradiente
            $this->hex_codes_array = !empty($this->hex_code) ? [$this->hex_code, '#FFFFFF'] : ['#FF0000', '#0000FF'];
            $this->hex_code = null;
        } else {
            // El usuario desmarcó "Es Gradiente"
            // Usamos el primer color del gradiente (si existe) como el nuevo color único
            $this->hex_code = !empty($this->hex_codes_array) ? $this->hex_codes_array[0] : '#000000';
            $this->hex_codes_array = [];
        }
        $this->resetErrorBag(); // Limpiamos errores de validación
    }

    // NUEVO: Método para añadir un color al array del gradiente
    public function addColor()
    {
        $this->hex_codes_array[] = '#FFFFFF'; // Añade blanco por defecto
    }

    // NUEVO: Método para eliminar un color del array
    public function removeColor($index)
    {
        unset($this->hex_codes_array[$index]);
        $this->hex_codes_array = array_values($this->hex_codes_array); // Re-indexa el array
    }

    private function validateData()
    {
        $this->validate([
            'nombre' => ['required', 'max:100', Rule::unique('colores')->ignore($this->editId)],

            // Esta regla es importante para asegurar que el valor booleano exista
            'esGradiante' => ['required', 'boolean'],

            // --- REGLAS CORREGIDAS ---

            // Valida 'hex_code' SOLAMENTE SI 'esGradiante' es false
            'hex_code' => [
                'exclude_if:esGradiante,true', // EXCLUYE si es gradiente
                'required',                    // Si no se excluye, es requerido
                'string',
                'max:7'
            ],

            // Valida 'hex_codes_array' SOLAMENTE SI 'esGradiante' es true
            'hex_codes_array' => [
                'exclude_if:esGradiante,false', // EXCLUYE si NO es gradiente
                'required',                     // Si no se excluye, es requerido
                'array',
                'min:2'                         // Mínimo 2 colores para un gradiente
            ],

            // Valida CADA ITEM del array SOLAMENTE SI 'esGradiante' es true
            'hex_codes_array.*' => [
                'exclude_if:esGradiante,false', // EXCLUYE si NO es gradiente
                'required',
                'string',
                'max:7'
            ]
        ]);
    }

    public function submitForm()
    {

        $this->validateData();

        $finalHexCode = $this->esGradiante
            ? implode(',', $this->hex_codes_array)
            : $this->hex_code;


        DB::beginTransaction();
        try {

            Color::updateOrCreate([
                'id' => $this->editId
            ], [
                'nombre' => $this->nombre,
                'hex_code' => $finalHexCode, // MODIFICADO: Usamos el string final
                'gradiante' => $this->esGradiante, // MODIFICADO: Enviará true (1) o false (0)
            ]);

            switch ($this->typeForm) {
                case 1:
                    $message = "El registro se guardo con exito!";
                    break;
                case 2:
                    $message = "El registro se edito con exito!";
                    break;
            }


            DB::commit();
            $this->closeModal();
            $this->notifications('success', 'Catalogos', $message); // Asumo que tienes este método
        } catch (\Exception $e) {
            DB::rollBack();
            // $this->notifications('danger', 'Catalogos', 'Lo sentimos, que ha ocurrido un error. Si el problema persiste, contacte con Two Brothers');
            session()->flash('error', 'Ocurrió un error: ' . $e->getMessage()); // Ejemplo
        }
    }

    public function resetForm()
    {
        // MODIFICADO: Añadimos las nuevas propiedades al reset
        $this->reset([
            'nombre',
            'hex_code',
            'typeForm',
            'editId',
            'esGradiante', // Añadido
            'hex_codes_array' // Añadido
        ]);

        $this->esGradiante = false; // Valor por defecto
        $this->hex_codes_array = []; // Valor por defecto
        $this->resetErrorBag();
    }

    public function closeModal()
    {
        $this->modal = false;
        $this->resetForm();
    }

    //*================================================================================================================================= Estatus

    public $estatusModal = false;
    public $statusId, $status;

    public function statusRegister($id)
    {
        $this->estatusModal = true;
        $data = Color::find($id);
        $this->statusId = $id;
        $this->status = $data->estatus;
    }

    public function estatusSubmit()
    {
        DB::beginTransaction();
        try {
            $data = Color::find($this->statusId);

            $data->update([
                'estatus' => $this->status == 1 ? 0 : 1
            ]);

            DB::commit();
            $this->estatusModal = false;
            $this->reset(['statusId']);
            $this->notifications('success', 'Catalogos', 'El estatus cambio con exitio');
        } catch (\Exception $e) {
            DB::rollBack();
            //dd($e->getMessage());
            $this->notifications('danger', 'Catalogos', 'Lo sentimos, que ha ocurrido un error. Si el problema persiste, contacte al área de sistemas');
        }
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
            $this->notifications('danger', 'Catalogos', 'La contraseña no coincide con la actual.');
            return;
        }

        DB::beginTransaction();
        try {
            Color::find($this->delteId)->delete();

            DB::commit();
            $this->deleteModal = false;
            $this->reset(['delteId', 'password', 'password_confirmation']);
            $this->notifications('danger', 'Catalogos', 'El dia ha sido eliminado junto a sus registros');
        } catch (\Exception $e) {
            DB::rollBack();
            //dd($e->getMessage());
            $this->notifications('danger', 'Catalogos', 'Lo sentimos, que ha ocurrido un error. Si el problema persiste, contacte al área de sistemas');
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
        $collection = Color::query();

        if ($this->perEstatus) {
            switch ($this->perEstatus) {
                case '1':
                    $collection = $collection->where('estatus', '1');
                    break;
                case '2':
                    $collection = $collection->where('estatus', '0');
                    break;
            }
        }

        $collection = $collection->where(function ($query) {
            $query->where('nombre', 'like', '%' . $this->search . '%');
        });

        $collection = $collection->orderBy('nombre', 'asc')->paginate($this->perPage, pageName: "collection-page");
        return view('livewire.modules.catalogos.colores', [
            'collection' => $collection,
        ]);
    }
}
