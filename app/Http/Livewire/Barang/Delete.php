<?php

namespace App\Http\Livewire\Barang;

use Livewire\Component;
use App\Models\Barang;

class Delete extends Component
{
    public $id_barang;
    public $showModal = false;

    protected $listeners = ['deleteModal' => 'openModal'];

    public function openModal($id_barang)
    {
        $this->id_barang = $id_barang;
        $this->showModal = true;
    }

    public function delete()
    {
        Barang::where('id_barang', $this->id_barang)->delete();
        $this->showModal = false;
        session()->flash('success', 'Barang berhasil dihapus!');
        $this->emit('refreshLivewireDatatable');
    }

    public function render()
    {
        return view('livewire.barang.delete');
    }
}
