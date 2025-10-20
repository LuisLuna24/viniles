<?php

namespace App\Livewire\Modules\Home;

use App\Models\categorias;
use App\Models\marcas;
use App\Models\productos;
use App\Models\subcategorias;
use Livewire\Component;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;
    public $search = '';
    public $category = '';
    public $subcategory = '';
    public $brand = '';
    public $model = '';

    public $categories = [];
    public $subcategories = [];
    public $brands = [];
    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->categories = categorias::where('estatus', 1)->orderBy('nombre', 'asc')->get();

        $this->brands = marcas::where('estatus', 1)->orderBy('nombre', 'asc')->get();
    }
    public function updated($propertyName, $value)
    {
        $this->resetPage();

        if ($propertyName == 'category') {
            $this->subcategory = '';
            $this->subcategories = subcategorias::where('estatus', 1)->where('categoria_id', $value)->orderBy('nombre', 'asc')->get();
        }
    }
    public function resetFilters()
    {
        // Restablece todas las propiedades de filtro
        $this->reset(['search', 'category', 'subcategory', 'brand', 'model']);
        $this->resetPage();
    }
    public function render()
    {
        $productos = productos::query();

        if ($this->search) {
            $productos->where('nombre', 'like', '%' . $this->search . '%');
        }

        // 3. Aplicar filtro por Categoría
        if ($this->category) {
            $productos->where('categoria_id', $this->category);

            if ($this->subcategory) {
                $productos->where('subcategoria_id', $this->subcategory);
            }
        }

        if ($this->brand) {
            $productos->where('brand_id', $this->brand);
        }

        if ($this->model) {
            $productos->where('model', $this->model);
        }

        $productos = $productos->paginate(9);
        return view('livewire.modules.home.products', [
            'productos' => $productos,
            'categories' => $this->categories,
            'brands' => $this->brands,
        ]);
    }
}
