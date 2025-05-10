<?php

namespace App\Http\Livewire\UnitPaket;

use Livewire\Component;
use App\Models\UnitPaket;

class Delete extends Component
{
    public $showModal = false;
    public $id_unit_paket;

    protected $listeners = ['deleteModal' => 'openModal'];

    public function openModal($id_unit_paket)
    {
        $this->id_unit_paket = $id_unit_paket;
        $this->showModal = true;
    }

    public function delete()
    {
        UnitPaket::where('id_unit_paket', $this->id_unit_paket)->delete();
        $this->showModal = false;
        session()->flash('success', 'Unit Paket berhasil dihapus!');
        $this->emit('refreshLivewireDatatable');
    }

    public function render()
    {
        return view('livewire.unit-paket.delete');
    }
}
