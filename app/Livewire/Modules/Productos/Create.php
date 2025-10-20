<?php

namespace App\Livewire\Modules\Productos;

use App\Models\categorias;
use App\Models\productos;
use App\Models\subcategorias;
use App\Models\unidades;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Create extends Component
{

    //*================================================================================================================================= Busquedas

    public $categorias = [], $subcategorias = [], $unidades = [];
    public function mount()
    {
        $this->resetSteps();
        $this->categorias = categorias::where('estatus', 1)->orderBy('nombre', 'asc')->get();
        $this->unidades = unidades::where('estatus', 1)->orderBy('nombre', 'asc')->get();
    }


    public function updated($property, $value)
    {
        switch ($property) {
            case 'categoria':
                $this->subcategoria = '';
                $this->subcategorias = subcategorias::where('categoria_id', $value)
                    ->orderByRaw('id = ? DESC', [$this->subcategoria])
                    ->orderBy('nombre')->get();
        }
    }

    //*================================================================================================================================= Steps

    #[Locked]
    public $totalSteps;

    public $currentStep;

    #[Locked]
    public $porcentaje;

    public $titles = [
        '1' => 'Categorias',
        '2' => 'Protoductos',
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
                    'categoria' => 'required',
                    'subcategoria' => 'required',
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



    //*================================================================================================================================= Form

    public $categoria = '', $subcategoria = '';


    public $listConfig = [];

    public function submitForm()
    {
        $this->validate([
            'listProducts' => 'required|array',
        ], [
            'listProducts.*' => 'Deves agregar almenos un producto'
        ]);

        DB::beginTransaction();
        try {

            foreach ($this->listProducts as $item) {
                productos::create([
                    'categoria_id' => $this->categoria,
                    'subcategoria_id' => $this->subcategoria,
                    'nombre' => $item['nombre'],
                    'slug' => Str::slug($item['nombre']),
                    'precio_venta' => $item['precio_venta'],
                    'precio_costo' => $item['precio_costo'],
                    'stock' => $item['stock'],
                    'unidad_id' => $item['unidad'],
                    'mostrar_en' => $item['mostrar_en'],
                    'url_mercado' => $item['url_mercado'],
                ]);
            }

            DB::commit();
            $this->notifications('success', 'Productos', 'El producto ha sido agregado con exito');
            $this->resetForm();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            $this->notifications('danger', 'Productos', 'Lo sentimos, que ha ocurrido un error. Si el problema persiste, contacte al área de sistemas');
        }
    }

    public function resetForm()
    {
        $this->resetSteps();
        $this->reset([
            'categoria',
            'subcategoria',
            'listProducts'
        ]);
        $this->resetErrorBag();
    }

    //*================================================================================================================================= Agregar producto

    public $modalProduct = false;

    public function openModal()
    {
        $this->modalProduct = true;
        $this->resetformProduct();
    }
    public $nombre, $precio_venta, $precio_costo, $stock, $url_mercado;
    public $unidad = '';
    public $mostrar_en = '';

    public $listProducts = [];

    protected $rules = [
        'nombre' => 'required|string|max:255',
        'precio_venta' => 'required|numeric|min:0',
        'precio_costo' => 'nullable|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'unidad' => 'required',
        'mostrar_en' => 'required|in:tienda,linea,ambas',
        'url_mercado' => 'nullable|url|max:255',
    ];

    public function addProduct()
    {
        $validatedData = $this->validate();

        if (!$this->isEdit) {
            $this->listProducts[] = $validatedData;
            $this->notifications('success', 'Producto Añadido', 'El producto se ha añadido a la lista.');
        } else {
            $this->listProducts[$this->indexId] = $validatedData;
            $this->notifications('success', 'Producto Actualizado', 'El producto se ha actualizado en la lista.');
        }

        $this->resetFormProduct();
        $this->cancelModalProduct();
    }

    public function cancelModalProduct()
    {
        $this->modalProduct = false;
        $this->resetformProduct();
    }

    public function resetformProduct()
    {
        $this->reset([
            'nombre',
            'precio_venta',
            'precio_costo',
            'stock',
            'unidad',
            'mostrar_en',
            'url_mercado',
            'indexId',
            'isEdit',
        ]);
        $this->resetErrorBag();
    }

    //*================================================================================================================================= Editar config

    public $isEdit = 0;
    public $indexId;
    public function editConfig($index)
    {
        $this->modalProduct = true;
        $this->resetformProduct();
        $this->isEdit = 1;
        $data = $this->listProducts[$index];
        $this->indexId = $index;
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
        return view('livewire.modules.productos.create');
    }
}
