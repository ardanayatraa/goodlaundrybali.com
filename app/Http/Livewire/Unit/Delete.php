<?php

namespace App\Http\Livewire\Unit;

use Livewire\Component;
use App\Models\Unit;

class Delete extends Component
{
    public $showModal = false;
    public $id_unit;

    protected $listeners = ['deleteModal' => 'openModal'];

    public function openModal($id_unit)
    {
        $this->id_unit = $id_unit;
        $this->showModal = true;
    }

    public function delete()
    {
        Unit::where('id_unit', $this->id_unit)->delete();
        $this->showModal = false;
        session()->flash('success', 'Unit berhasil dihapus!');
        $this->emit('refreshLivewireDatatable');
    }

    public function render()
    {
        return view('livewire.unit.delete');
    }
}
