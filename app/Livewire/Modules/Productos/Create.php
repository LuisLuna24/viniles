<?php

namespace App\Livewire\Modules\Productos;

use App\Models\Categoria;
use App\Models\ProductoBase;
use App\Models\Subcategoria;
use Illuminate\Support\Str;
use App\Models\Unidad;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{

    //*================================================================================================================================= Datos

    public $categorias = [], $subcategorias = [], $unidades = [];

    public function mount()
    {
        $this->categorias = Categoria::where('estatus', 1)->orderBy('nombre', 'asc')->get();

        $this->unidades = Unidad::where('estatus', 1)->orderBy('nombre', 'asc')->get();
    }

    //*================================================================================================================================= Save

    public $nombre, $descripcion, $categoria = '', $subcategoria = '', $unidad = '', $stock = 1, $precio_costo, $precio_venta, $slug;
    public $vendible_sin_personalizar = 0;

    public function updatedNombre($value)
    {
        $this->slug = Str::slug($this->nombre);
    }

    public function updatedCategoria($value)
    {
        $this->subcategorias = Subcategoria::where('categoria_id', $value)->where('estatus', 1)->orderBy('nombre', 'asc')->get();
    }

    public function save()
    {
        $this->validate([
            'nombre' => ['required', 'max:255'],
            'descripcion' => ['required', 'max:255'],
            'categoria' => ['required'],
            'subcategoria' => ['required'],
            'unidad' => ['required'],
            'stock' => ['nullable'],
            'precio_costo' => ['required', 'decimal:0,2'],
            'precio_venta' => ['required', 'decimal:0,2'],
        ]);

        DB::beginTransaction();
        try {

            ProductoBase::create([
                'slug' => $this->slug,
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
                'categoria_id' => $this->categoria,
                'subcategoria_id' => $this->subcategoria,
                'unidad_id' => $this->unidad,
                'stock' => $this->stock,
                'precio_costo' => $this->precio_costo,
                'precio_venta_base' => $this->precio_venta,
                'vendible_sin_personalizar' => $this->vendible_sin_personalizar
            ]);

            DB::commit();
            $this->notifications('success', 'Productos', 'El producto se a guardado correctamente.');
            $this->resetForm();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            $this->notifications('danger', 'Productos', 'Lo sentimos, que ha ocurrido un error. Si el problema persiste, contacte con Two Brothers');
        }
    }

    public function resetForm()
    {
        $this->resetErrorBag();
        $this->reset([
            'nombre',
            'slug',
            'descripcion',
            'categoria',
            'subcategoria',
            'unidad',
            'stock',
            'precio_costo',
            'precio_venta',
            'vendible_sin_personalizar'
        ]);
    }


    //*================================================================================================================================= Notification
    public function notifications($type, $title, $message)
    {
        $this->dispatch('notify',  variant: $type, title: $title, message: $message);
    }

    //*================================================================================================================================= Render
    public function render()
    {
        return view('livewire.modules.productos.create');
    }
}
