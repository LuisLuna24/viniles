<?php

namespace App\Livewire\Modules\Home\Productos;

use App\Models\Categoria;
use App\Models\ProductoBase;
use App\Models\Subcategoria;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy]
class Index extends Component
{
    use WithPagination;
    public $search = '';


    public function updatingSearch()
    {
        $this->resetPage('disenos-page');
    }

    public function readDesign($slug)
    {
        //dd($slug);
        return redirect()->route('stickers.read', ['slug' => $slug]);
    }

    public function placeholder()
    {
        return view('livewire.placeholders.skeleton');
    }
    public $selectedCategory = null;
    public $selectedSubcategory = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategory' => ['except' => null],
        'selectedSubcategory' => ['except' => null],
    ];

    public function updatedSelectedCategory()
    {
        $this->selectedSubcategory = null; // Reset subcategory when category changes
        $this->resetPage();
    }

    public function updatedSelectedSubcategory()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->selectedCategory = null;
        $this->selectedSubcategory = null;
        $this->resetPage();
    }

    public function render()
    {
        $query = ProductoBase::with(['categoria', 'unidad', 'imagenes'])
            ->when($this->search, function ($query) {
                $query->where('nombre', 'like', '%' . $this->search . '%')
                    ->orWhere('descripcion', 'like', '%' . $this->search . '%');
            })
            ->when($this->selectedCategory, function ($query) {
                $query->where('categoria_id', $this->selectedCategory);
            })
            ->when($this->selectedSubcategory, function ($query) {
                $query->where('subcategoria_id', $this->selectedSubcategory);
            });

        $products = $query->paginate(12, pageName: 'products-page');
        return view('livewire.modules.home.productos.index',  [
            'products' => $products,
            'categories' => Categoria::where('estatus',1)->orderBy('nombre','asc')->get(),
            'subcategories' => $this->selectedCategory
                ? Subcategoria::where('categoria_id', $this->selectedCategory)->where('estatus',1 )->orderBy('nombre','asc')->get()
                : collect(),
        ]);
    }
}
