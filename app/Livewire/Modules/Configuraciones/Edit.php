<?php

namespace App\Livewire\Modules\Configuraciones;

use App\Models\configuraciones;
use App\Models\configuraciones_descripcion;
use App\Models\marcas;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Reactive;

class Edit extends Component
{
    #[Reactive]
    public $id;

    public $marcas = [];

    public function mount()
    {
        $this->resetSteps();
        $this->marcas = marcas::where('estatus', 1)->where('tipo', 'Tienda')->orderBy('nombre', 'asc')->get();

        $this->searchData();
    }

    public function searchData()
    {
        $data = configuraciones::find($this->id);

        if ($data) {
            $this->nombre = $data->nombre;
            $this->marca = $data->marca_id;
            $this->producto = $data->producto;
            $this->otro = $data->otro;
            $this->precio = $data->precio;
        } else {
            $this->reset(['nombre', 'marca', 'producto', 'otro', 'precio', 'listConfig']);
            $this->notifications('warning', 'Configuracion', 'No se encontró ninguna configuración con ese ID.');
        }
    }

    #[Locked]
    public $totalSteps;

    public $currentStep;

    #[Locked]
    public $porcentaje;

    public $titles = [
        '1' => 'Datos del producto',
        '2' => 'Configuracion',
    ];

    public function updated_porcentaje()
    {
        // Asegurar que el porcentaje llegue a 100% en el último paso
        $this->porcentaje = min(100, ($this->currentStep / $this->totalSteps) * 100);
    }

    public function increaseStep()
    {
        $this->validateData();
        $this->currentStep = min($this->currentStep + 1, $this->totalSteps);
        $this->updated_porcentaje();
    }

    public function decreaseStep()
    {
        $this->currentStep = max($this->currentStep - 1, 1);
        $this->updated_porcentaje();
    }

    public function validateData()
    {
        switch ($this->currentStep) {

            case 1:
                $this->validate([
                    'nombre' => 'required|string|max:255',
                    'marca' => 'required|exists:marcas,id',
                    'producto' => 'required',
                    'otro' => 'nullable|string',
                    'precio' => 'required|numeric',
                ]);
                break;
        }
    }

    public function resetSteps()
    {
        $this->totalSteps = 2;
        $this->currentStep = 1;
        $this->updated_porcentaje();
    }

    //*================================================================================================================================= Submit
    public $nombre, $marca = '', $producto = '', $otro, $precio;
    public function submitForm()
    {
        DB::beginTransaction();
        try {
            $config = configuraciones::find($this->id)->update([
                'nombre' => $this->nombre,
                'marca_id' => $this->marca,
                'producto' => $this->producto,
                'otro' => $this->otro,
                'precio' => $this->precio,
            ]);

            DB::commit();
            $this->notifications('success', 'Configuración', 'La configuración se editado con éxito');
            $this->restForm();
            $this->resetSteps();
            return redirect()->route('admin.configuraciones.index');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->notifications('danger', 'Error', 'Lo sentimos, ha ocurrido un error. Por favor, intente de nuevo.');
        }
    }

    public function restForm()
    {
        $this->reset([
            'nombre',
            'marca',
            'producto',
            'otro',
            'precio',
        ]);
        $this->resetErrorBag();
    }

    //*================================================================================================================================= Agregar config

    public $descripcion = '', $otra_descripcion, $unidad, $valores;

    public function addConfig()
    {
        $this->validate([
            'descripcion' => 'required',
            'otra_descripcion' => 'nullable|string|max:255',
            'unidad' => 'nullable|string|max:50',
            'valores' => 'required',
        ]);

        DB::beginTransaction();
        try {

            $data = configuraciones_descripcion::find($this->indexId);

            $data = configuraciones_descripcion::updateOrCreate(['id' => $this->indexId], [
                'configuracion_id' => $this->id,
                'descripcion' => $this->descripcion,
                'otro' => $this->otra_descripcion,
                'unidad' => $this->unidad,
                'valores' => $this->valores,
            ]);

            DB::commit();
            $this->notifications('success', 'Configuración', 'El elemento se ha añadido a la lista.');
            $this->resetFormConfig();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->notifications('danger', 'Configuración', 'Lo sentimos, ha ocurrido un error. Por favor, intente de nuevo.');
        }
    }

    public function resetFormConfig()
    {
        $this->reset([
            'descripcion',
            'otra_descripcion',
            'unidad',
            'valores',
            'isEdit',
        ]);
        $this->resetErrorBag();
    }

    //*================================================================================================================================= Editar config

    public $isEdit = 0;
    public $indexId;
    public function editConfig($index)
    {
        $this->isEdit = 1;
        $data = configuraciones_descripcion::find($index);
        $this->indexId = $index;

        $this->descripcion = $data['descripcion'];
        $this->otra_descripcion = $data['otro'];
        $this->unidad = $data['unidad'];
        $this->valores = $data['valores'];
    }

    //*================================================================================================================================= Eliminar

    public $deleteModal = false;
    public $delteId;
    public function deleteConfig($id)
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
            $this->notifications('danger', 'Configuracion', 'La contraseña no coincide con la actual.');
            return;
        }

        DB::beginTransaction();
        try {
            configuraciones_descripcion::find($this->delteId)->delete();

            DB::commit();
            $this->deleteModal = false;
            $this->reset(['delteId','password','password_confirmation']);
            $this->notifications('danger', 'Configuracion', 'La configuración ha sido eliminada');
        } catch (\Exception $e) {
            DB::rollBack();
            //dd($e->getMessage());
            $this->notifications('danger', 'Error', 'Lo sentimos, ha ocurrido un error. Por favor, intente de nuevo.');
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
        $data = configuraciones::find($this->id);

        $listConfig = $data->descripciones;
        return view('livewire.modules.configuraciones.edit', [
            'listConfig' => $listConfig
        ]);
    }
}
