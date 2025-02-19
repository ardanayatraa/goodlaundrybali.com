<?php

namespace App\Http\Livewire\Barang;

use Livewire\Component;
use App\Models\Barang;

class Delete extends Component
{
    public $id_barang;
    public $showModal = false;

    public function mount($id_barang)
    {
        $this->id_barang = $id_barang;
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function delete()
    {
        Barang::where('id_barang', $this->id_barang)->delete();
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.barang.delete');
    }
}
