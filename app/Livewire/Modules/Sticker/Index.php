<?php

namespace App\Livewire\Modules\Sticker;

use App\Models\stickers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $perEstatus, $perPage = '10', $search;
    //*================================================================================================================================= Form

    public $modal = false;
    public $typeForm, $editId;
    public $nombre;
    public function create()
    {
        return redirect()->route('admin.stickers.create');
    }

    public function edit($id)
    {
        return redirect()->route('admin.stickers.edit', ['id' => $id]);
    }

    //*================================================================================================================================= Estatus

    public $estatusModal = false;
    public $statusId, $status;

    public function statusRegister($id)
    {
        $this->estatusModal = true;
        $data = stickers::find($id);
        $this->statusId = $id;
        $this->status = $data->estatus;
    }

    public function estatusSubmit()
    {
        DB::beginTransaction();
        try {
            $data = stickers::find($this->statusId);

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
            stickers::find($this->delteId)->delete();

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
        $collection = stickers::query();


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
        return view('livewire.modules.sticker.index',[
            'collection' => $collection
        ]);
    }
}
