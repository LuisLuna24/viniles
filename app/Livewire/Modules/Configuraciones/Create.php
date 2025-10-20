<?php

namespace App\Livewire\Modules\Configuraciones;

use App\Models\configuraciones;
use App\Models\configuraciones_descripcion;
use App\Models\marcas;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Locked;

class Create extends Component
{

    public $marcas = [];

    public function mount()
    {
        $this->resetSteps();
        $this->marcas = marcas::where('estatus', 1)->where('tipo', 'Tienda')->orderBy('nombre', 'asc')->get();
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
        $this->validate([
            'listConfig' => 'required|array|min:1',
        ]);

        DB::beginTransaction();

        try {
            $config = configuraciones::create([
                'nombre' => $this->nombre,
                'marca_id' => $this->marca,
                'producto' => $this->producto,
                'otro' => $this->otro,
                'precio' => $this->precio,
            ]);

            $descriptionsToInsert = collect($this->listConfig)->map(function ($item) use ($config) {
                return [
                    'configuracion_id' => $config->id,
                    'descripcion' => $item['descripcion'],
                    'otro' => $item['otro'],
                    'unidad' => $item['unidad'],
                    'valores' => $item['valores'],
                ];
            })->all();

            if (!empty($descriptionsToInsert)) {
                configuraciones_descripcion::insert($descriptionsToInsert);
            }

            DB::commit();
            $this->notifications('success', 'Configuración', 'La configuración se guardó con éxito');
            $this->restForm();
            $this->resetSteps();
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
            'listConfig'
        ]);
        $this->resetErrorBag();
    }

    //*================================================================================================================================= Agregar config

    public $descripcion = '', $otra_descripcion, $unidad, $valores;
    public $listConfig = [];

    public function addConfig()
    {
        $validatedData = $this->validate([
            'descripcion' => 'required',
            'otra_descripcion' => 'nullable|string|max:255',
            'unidad' => 'nullable|string|max:50',
            'valores' => 'required',
        ]);

        $data = [
            'descripcion' => $this->descripcion,
            'otro' => $this->otra_descripcion,
            'unidad' => $this->unidad,
            'valores' => $this->valores,
        ];

        if (!$this->isEdit) {
            $this->listConfig[] = $data;
        } else {
            $this->listConfig[$this->indexId] = $data;
        }

        $this->notifications('success', 'Configuración', 'El elemento se ha añadido a la lista.');
        $this->resetFormConfig();
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
        $data = $this->listConfig[$index];
        $this->indexId = $index;

        $this->descripcion = $data['descripcion'];
        $this->otra_descripcion = $data['otro'];
        $this->unidad = $data['unidad'];
        $this->valores = $data['valores'];
    }

    //*================================================================================================================================= Eliminar Config

    public function deleteConfig($index)
    {
        unset($this->listConfig[$index]);
        $this->notifications('danger', 'Configuración', 'El elemento se ha elimindo a la lista.');
    }

    //*================================================================================================================================= Notification


    public function notifications($type, $title, $message)
    {
        //info-success-danger
        $this->dispatch('notify',  variant: $type, title: $title, message: $message);
    }

    public function render()
    {
        return view('livewire.modules.configuraciones.create');
    }
}
