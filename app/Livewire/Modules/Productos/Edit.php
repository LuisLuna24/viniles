<?php

namespace App\Livewire\Modules\Productos;

use App\Models\Categoria;
use App\Models\ProductoBase;
use App\Models\ProductoBaseDescripcion;
use App\Models\ProductoBaseImagen;
use App\Models\Subcategoria;
use App\Models\TecnicaProduccion;
use Illuminate\Support\Str;
use App\Models\Unidad;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

class Edit extends Component
{

    use WithPagination;
    use WithFileUploads;

    #[Reactive]
    public $id;
    public $data;

    //*================================================================================================================================= Datos

    public $categorias = [], $subcategorias = [], $unidades = [], $tipos_produccion = [];

    public function mount()
    {
        $this->categorias = Categoria::where('estatus', 1)->orderBy('nombre', 'asc')->get();

        $this->unidades = Unidad::where('estatus', 1)->orderBy('nombre', 'asc')->get();

        $this->tipos_produccion =  TecnicaProduccion::where('estatus', 1)->orderBy('nombre', 'asc')->get();

        $this->searchData();
    }

    public function searchData()
    {
        $this->data = ProductoBase::findOrFail($this->id);

        $this->subcategorias = Subcategoria::where('categoria_id', $this->data->categoria_id)->where('estatus', 1)
            ->orderByRaw('id = ? DESC', [$this->data->subcategoria_id])
            ->orderBy('nombre', 'asc')->get();

        $this->nombre = $this->data->nombre;
        $this->slug = $this->data->slug;
        $this->descripcion = $this->data->descripcion;
        $this->categoria = $this->data->categoria_id;
        $this->subcategoria = $this->data->subcategoria_id;
        $this->unidad = $this->data->unidad_id;
        $this->stock = $this->data->stock;
        $this->precio_costo = $this->data->precio_costo;
        $this->precio_venta = $this->data->precio_venta_base;
        $this->vendible_sin_personalizar = $this->data->vendible_sin_personalizar;
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

            $this->data->update([
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
            $this->notifications('success', 'Productos', 'El producto se a editado correctamente.');
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
    }


    //*================================================================================================================================= Imagenes


    public $modalImage = false;
    public $image;

    public function newImage()
    {
        $this->resetFormImage();
        $this->modalImage = true;
    }

    public $editingImageId;
    public $existingImagePath;

    public function editImage($imageId)
    {
        $this->resetFormImage();
        $this->editingImageId = $imageId;

        $imageModel = $this->data->imagenes()->find($imageId);

        if ($imageModel) {
            $this->existingImagePath = $imageModel->url_imagen; // <-- NUEVO
        }

        $this->modalImage = true;
    }

    public function saveImage()
    {

        $this->validate([
            'image' => ['required', 'image', 'max:2048']
        ]);

        // 2. Decide qué hacer
        if ($this->editingImageId) {
            $this->updateImage();
        } else {
            $this->createImage();
        }
    }
    private function createImage()
    {
        DB::beginTransaction();
        try {
            $path = $this->image->store('product-images', 'public');

            $this->data->imagenes()->create([
                'url_imagen' => $path
            ]);

            DB::commit();
            $this->notifications('success', 'Imagen Guardada', 'Se ha agregado la imagen correctamente.');
            $this->closeModalImage();
            $this->data->refresh();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            $this->notifications('danger', 'Error', 'Lo sentimos, ha ocurrido un error al crear.');
        }
    }

    private function updateImage()
    {
        DB::beginTransaction();
        try {
            // 1. Encontrar el registro de la imagen
            $imageToUpdate = $this->data->imagenes()->find($this->editingImageId);

            if (!$imageToUpdate) {
                $this->notifications('danger', 'Error', 'Imagen no encontrada.');
                DB::rollBack();
                return;
            }

            // 2. Borrar el archivo FÍSICO anterior
            if ($imageToUpdate->url_imagen && Storage::disk('public')->exists($imageToUpdate->url_imagen)) {
                Storage::disk('public')->delete($imageToUpdate->url_imagen);
            }

            // 3. Guardar el archivo FÍSICO nuevo
            $newPath = $this->image->store('product-images', 'public');

            // 4. Actualizar el registro en la DB
            $imageToUpdate->update([
                'url_imagen' => $newPath
            ]);

            DB::commit();
            $this->notifications('success', 'Imagen Actualizada', 'La imagen se ha reemplazado correctamente.');
            $this->closeModalImage();
            $this->data->refresh();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            $this->notifications('danger', 'Error', 'Lo sentimos, ha ocurrido un error al actualizar.');
        }
    }

    public function closeModalImage()
    {
        $this->modalImage = false;
        $this->resetFormImage();
    }

    public function resetFormImage()
    {
        $this->resetErrorBag();
        $this->reset([
            'image',
            'editingImageId',
            'existingImagePath'
        ]);
    }
    public function deleteImage($imageId)
    {
        DB::beginTransaction();
        try {
            // 1. Buscar la imagen usando la relación (más seguro)
            $image = $this->data->imagenes()->find($imageId);

            if (!$image) {
                $this->notifications('danger', 'Error', 'No se encontró la imagen.');
                DB::rollBack();
                return;
            }

            if ($image->path && Storage::disk('public')->exists($image->path)) {
                Storage::disk('public')->delete($image->path);
            }

            $image->delete();

            DB::commit();
            $this->notifications('success', 'Imagen Eliminada', 'La imagen se ha eliminado correctamente.');
            $this->data->refresh();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            $this->notifications('danger', 'Error', 'Ha ocurrido un error al eliminar la imagen.');
        }
    }

    //*================================================================================================================================= Descripciones


    public $modalDescrip = false;
    public $tecnica_produccion = '', $descripcion_producto, $precio_unitario, $precio_mayoreo, $cantidad_mayoreo = 10, $orden;

    public function newDescrip()
    {
        $this->resetFormDescrip();
        $this->modalDescrip = true;
    }

    public $editDescriptId;

    public function editDescrip($id)
    {
        $this->resetFormDescrip();
        $this->modalDescrip = true;
        $this->editDescriptId = $id;

        $data = $this->data->descripciones()->find($id);
        $this->tecnica_produccion = $data->tecnica_id ?? '';
        $this->descripcion_producto = $data->descripcion ?? '';
        $this->precio_unitario = $data->precio_unitario ?? '';
        $this->precio_mayoreo = $data->precio_mayoreo ?? '';
        $this->cantidad_mayoreo = $data->cantidad_mayoreo ?? '';
        $this->orden = $data->orden ?? '';
    }

    public function saveDescrip()
    {

        $this->validate([
            'tecnica_produccion' => ['required'],
            'descripcion' => ['required', 'max:255'],
            'precio_unitario' => 'required|numeric|decimal:0,2|min:0',
            'precio_mayoreo' => 'required|numeric|decimal:0,2|min:0',
            'cantidad_mayoreo' => ['required', 'min:1'],
        ]);

        DB::beginTransaction();
        try {

            $this->data->descripciones()->updateOrCreate([
                'id' => $this->editDescriptId,
            ], [
                'tecnica_id' => $this->tecnica_produccion,
                'descripcion' => $this->descripcion_producto,
                'precio_unitario' => $this->precio_unitario,
                'precio_mayoreo' => $this->precio_mayoreo,
                'cantidad_mayoreo' => $this->cantidad_mayoreo,
                'orden' => $this->orden
            ]);

            DB::commit();
            $this->notifications('success', 'Productos', 'Se ha agregado correctamente una descripcion al producto.');
            $this->closeModalDescrip();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            $this->notifications('danger', 'Error', 'Ha ocurrido un error al eliminar la imagen.');
        }
    }

    public function deleteDescrip($id)
    {
        DB::beginTransaction();
        try {
            // 1. Buscar la imagen usando la relación (más seguro)
            $descrip = $this->data->descripciones()->find($id);

            if (!$descrip) {
                $this->notifications('danger', 'Error', 'No se encontró la descripcion.');
                DB::rollBack();
                return;
            }

            $descrip->delete();

            DB::commit();
            $this->notifications('success', 'Producto', 'La descripcion se ha eliminado correctamente.');
            $this->closeModalDescrip();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            $this->notifications('danger', 'Error', 'Ha ocurrido un error al eliminar la imagen.');
        }
    }

    public function closeModalDescrip()
    {
        $this->modalDescrip = false;
        $this->resetFormDescrip();
    }

    public function resetFormDescrip()
    {
        $this->resetErrorBag();
        $this->reset([
            'tecnica_produccion',
            'descripcion_producto',
            'precio_unitario',
            'precio_mayoreo',
            'cantidad_mayoreo',
            'orden',
            'editDescriptId',
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
        $imagenes = ProductoBaseImagen::where('producto_base_id', $this->id)->orderBy('orden', 'asc')->paginate(10, pageName: 'imagenes-page');
        $descripciones = ProductoBaseDescripcion::where('producto_base_id', $this->id)->orderBy('orden', 'asc')->paginate(10, pageName: 'descripciones-page');
        return view('livewire.modules.productos.edit', [
            'imagenes' => $imagenes,
            'descripciones' => $descripciones
        ]);
    }
}
