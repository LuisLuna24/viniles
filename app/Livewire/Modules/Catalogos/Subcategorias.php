<?php

namespace App\Livewire\Modules\Catalogos;

use App\Models\Categoria;
use App\Models\subcategoria as ModelsSubcategorias;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Subcategorias extends Component
{
    use WithPagination;
    public $perEstatus, $perPage = '10', $search;

    public $categorias = [];
    public function mount()
    {
        $this->categorias = Categoria::where('estatus', 1)->orderBy('nombre', 'asc')->get();
    }
    //*================================================================================================================================= Form

    public $modal = false;
    public $typeForm, $editId;
    public $nombre, $categoria = '';
    public function create()
    {
        $this->resetForm();
        $this->typeForm = 1;
        $this->modal = true;
    }

    public function edit($id)
    {
        $this->resetForm();
        $this->typeForm = 2;
        $this->modal = true;
        $data = ModelsSubcategorias::find($id);
        $this->nombre = $data->nombre;
        $this->categoria = $data->categoria_id;
        $this->editId = $id;
    }

    private function validateData()
    {
        $this->validate([
            'nombre' => [
                'required',
                'max:100',
                Rule::unique('subcategorias', 'nombre')
                    ->where('categoria_id', $this->categoria)
                    ->ignore($this->editId),
            ],
            'categoria' => ['required', 'exists:categorias,id'], // Mejora: Asegura que la categoría exista
        ]);
    }

    public function submitForm()
    {
        $this->validateData();

        DB::beginTransaction();
        try {

            ModelsSubcategorias::updateOrCreate([
                'id' => $this->editId
            ], [
                'nombre' => $this->nombre,
                'categoria_id' => $this->categoria
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
            $this->notifications('success', 'Catalogos', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->notifications('danger', 'Catalogos', 'Lo sentimos, que ha ocurrido un error. Si el problema persiste, contacte con Two Brothers');
        }
    }

    public function resetForm()
    {
        $this->reset([
            'nombre',
            'categoria',
            'typeForm',
            'editId'
        ]);
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
        $data = ModelsSubcategorias::find($id);
        $this->statusId = $id;
        $this->status = $data->estatus;
    }

    public function estatusSubmit()
    {
        DB::beginTransaction();
        try {
            $data = ModelsSubcategorias::find($this->statusId);

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
            ModelsSubcategorias::find($this->delteId)->delete();

            DB::commit();
            $this->deleteModal = false;
            $this->reset(['delteId','password','password_confirmation']);
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
        $collection = ModelsSubcategorias::query();


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
        return view('livewire.modules.catalogos.subcategorias', [
            'collection' => $collection
        ]);
    }
}
