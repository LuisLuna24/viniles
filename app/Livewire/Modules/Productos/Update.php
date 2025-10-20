<?php

namespace App\Livewire\Modules\Productos;

use App\Models\categorias;
use App\Models\productos;
use App\Models\productos_descripciones;
use App\Models\productos_imagenes;
use App\Models\subcategorias;
use App\Models\unidades;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

class Update extends Component
{
    use WithPagination;
    use WithFileUploads;

    #[Reactive]
    public $id;

    //*================================================================================================================================= Busquedas

    public $categorias = [], $subcategorias = [], $unidades = [];
    public function mount()
    {
        $this->resetSteps();
        $this->categorias = categorias::where('estatus', 1)->orderBy('nombre', 'asc')->get();
        $this->unidades = unidades::where('estatus', 1)->orderBy('nombre', 'asc')->get();
        $this->searchdata();
    }

    public function searchdata()
    {

        $data = productos::find($this->id);

        $this->categoria = $data->categoria_id;
        $this->subcategorias = subcategorias::where('categoria_id', $data->categoria_id)
            ->orderByRaw('id = ? DESC', [$data->subcategoria_id])
            ->orderBy('nombre')->get();
        $this->subcategoria = $data->subcategoria_id;

        $this->nombre = $data->nombre;
        $this->precio_venta = $data->precio_venta;
        $this->precio_costo = $data->precio_costo;
        $this->stock = $data->stock;
        $this->unidad = $data->unidad_id;
        $this->mostrar_en = $data->mostrar_en;
        $this->url_mercado = $data->url_mercado;
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
        '3' => 'Descripciones',
        '4' => 'Imagenes',
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
            case 2:
                $this->validate([
                    'nombre' => 'required|string|max:255',
                    'precio_venta' => 'required|numeric|min:0',
                    'precio_costo' => 'nullable|numeric|min:0',
                    'stock' => 'required|integer|min:0',
                    'unidad' => 'required',
                    'mostrar_en' => 'required',
                    'url_mercado' => 'nullable|url|max:255',
                ]);
                break;
        }
    }

    public function resetSteps()
    {
        $this->totalSteps = 4;
        $this->currentStep = 1;
        $this->updated_porcentaje();
    }



    //*================================================================================================================================= Form

    public $categoria = '', $subcategoria = '';

    public $nombre, $precio_venta, $precio_costo, $stock, $url_mercado;
    public $unidad = '';
    public $mostrar_en = '';
    public $listConfig = [];

    public function submitForm()
    {
        DB::beginTransaction();
        try {
            productos::updateOrCreate(
                // Criterio de búsqueda (si $id es null, creará un nuevo registro)
                ['id' => $this->id],
                // Datos para actualizar o crear, tomados directamente de las propiedades
                [
                    'nombre' => $this->nombre,
                    'precio_venta' => $this->precio_venta,
                    'precio_costo' => $this->precio_costo,
                    'stock' => $this->stock,
                    'mostrar_en' => $this->mostrar_en,
                    'url_mercado' => $this->url_mercado,
                ]
            );

            DB::commit();

            $this->notifications('success', 'Productos', 'El producto ha sido guardado con éxito');

            // La redirección debe ser retornada para que funcione correctamente
            return redirect()->route('admin.productos.index');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            $this->notifications('danger', 'Productos', 'Lo sentimos, ha ocurrido un error. Intente de nuevo.');
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

    //*================================================================================================================================= Agregar Descrip

    public $modalDescrip = false;
    public $descripcion;

    public $editDecID;

    public function createDescrip()
    {
        $this->modalDescrip = true;
        $this->resetformDescrip();
    }

    public function editDescrip($editDecID)
    {
        $this->modalDescrip = true;
        $this->resetformDescrip();
        $this->editDecID = $editDecID;
        $this->descripcion = productos_descripciones::find($editDecID)->descripcion;
    }


    public function submitDescrip()
    {

        $this->validate([
            'descripcion' => ['required', 'max:255']
        ]);

        DB::beginTransaction();
        try {

            productos_descripciones::updateOrCreate([
                'id' => $this->editDecID
            ], [
                'producto_id' => $this->id,
                'descripcion' => $this->descripcion
            ]);


            DB::commit();
            $this->notifications('success', 'Productos', 'La descripcion ha sido agregado con exito');
            $this->closeModalDesc();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            $this->notifications('danger', 'Productos', 'Lo sentimos, que ha ocurrido un error. Si el problema persiste, contacte al área de sistemas');
        }
    }

    public function closeModalDesc()
    {
        $this->modalDescrip = false;
        $this->resetformDescrip();
    }

    public function resetformDescrip()
    {
        $this->reset([
            'descripcion',
            'editDecID'
        ]);
        $this->resetErrorBag();
    }

    //*================================================================================================================================= Agregar Iamgenes

    public $modalImage = false;
    public $imagen;

    public $editImgID;
    public $existingImageUrl;

    public function createImage()
    {
        $this->modalImage = true;
        $this->resetformImage();
    }

    public function editImge($editImgID)
    {
        $this->modalImage = true;
        $this->resetformImage();
        $this->editImgID = $editImgID;
        $this->existingImageUrl = productos_imagenes::find($editImgID)->url_imagen;
    }


    public function submitImge()
    {
        $this->validate([
            'imagen' => ['required', 'image', 'max:2048']
        ]);

        DB::beginTransaction();
        try {
            // 2. BUSCA Y BORRA LA IMAGEN ANTERIOR (SI EXISTE)
            if ($this->editImgID) {
                $imagenAnterior = productos_imagenes::find($this->editImgID);

                // Si encontramos el registro y tiene una imagen asignada...
                if ($imagenAnterior && $imagenAnterior->url_imagen) {
                    // Borramos el archivo del disco 'public'
                    Storage::disk('public')->delete($imagenAnterior->url_imagen);
                }
            }

            // 3. SUBE LA NUEVA IMAGEN
            $path = $this->imagen->store('productos', 'public');

            // 4. GUARDA O ACTUALIZA EL REGISTRO EN LA BD
            productos_imagenes::updateOrCreate([
                'id' => $this->editImgID
            ], [
                'producto_id' => $this->id,
                'url_imagen' => $path
            ]);

            DB::commit();
            $this->notifications('success', 'Productos', 'La imagen ha sido agregada con éxito');
            $this->closeModalImge();
        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e->getMessage()); // Evita usar dd() en producción
            $this->notifications('danger', 'Productos', 'Lo sentimos, ha ocurrido un error.');
        }
    }

    public function closeModalImge()
    {
        $this->modalImage = false;
        $this->resetformImage();
    }

    public function resetformImage()
    {
        $this->reset([
            'imagen',
            'editImgID',
            'existingImageUrl',
        ]);
        $this->resetErrorBag();
    }

    //*================================================================================================================================= Editar config

    public $isEdit = 0;
    public $indexId;
    public function editConfig($index)
    {
        $this->modalDescrip = true;
        $this->resetformDescrip();
        $this->isEdit = 1;
        $data = $this->listConfig[$index];
        $this->indexId = $index;
    }

    //*================================================================================================================================= Eliminar descrip


    public $deleteModal = false;
    public $delteId;

    public $isDescriporImage;
    public function deleteDescrip($id)
    {
        $this->deleteModal = true;
        $this->delteId = $id;
        $this->isDescriporImage = 1;
    }

    public function deleteImage($id)
    {
        $this->deleteModal = true;
        $this->delteId = $id;
        $this->isDescriporImage = 2;
    }

    public $password, $password_confirmation;
    public function deleteSubmit()
    {
        $this->validate([
            'password' => 'required|string|confirmed',
        ]);

        if (!Hash::check($this->password, hashedValue: Auth::user()->password)) {
            $this->notifications('danger', 'Productos', 'La contraseña no coincide con la actual.');
            return;
        }

        DB::beginTransaction();
        try {
            if ($this->isDescriporImage == 1) {
                productos_descripciones::find($this->delteId)->delete();
                $message = 'La descripcion ha sido eliminado';
            } else if ($this->isDescriporImage == 2) {
                productos_imagenes::find($this->delteId)->delete();
                $message = 'La imagen ha sido eliminado';
            }


            DB::commit();
            $this->deleteModal = false;
            $this->reset(['delteId', 'password', 'password_confirmation']);
            $this->notifications('danger', 'Productos', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            //dd($e->getMessage());
            $this->notifications('danger', 'Productos', 'Lo sentimos, que ha ocurrido un error. Si el problema persiste, contacte al área de sistemas');
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
        $descripciones = productos_descripciones::where('producto_id', $this->id)->paginate(10, pageName: 'descripciones-page');
        $imagenes = productos_imagenes::where('producto_id', $this->id)->paginate(10, pageName: 'descripciones-page');

        return view('livewire.modules.productos.update', [
            'descripciones' => $descripciones,
            'imagenes' => $imagenes,
        ]);
    }
}
