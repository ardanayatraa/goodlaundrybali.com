<?php

namespace App\Http\Livewire\UnitPaket;

use Livewire\Component;
use App\Models\UnitPaket;

class Delete extends Component
{
    public $id_unit_paket;
    public $showModal = false;

    public function mount($id_unit_paket)
    {
        $this->id_unit_paket = $id_unit_paket;
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function delete()
    {
        UnitPaket::where('id_unit_paket', $this->id_unit_paket)->delete();

        $this->showModal = false;
        session()->flash('success', 'Unit Paket berhasil dihapus!');
    }

    public function render()
    {
        return view('livewire.unit-paket.delete');
    }
}
