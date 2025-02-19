<?php

namespace App\Http\Livewire\Unit;

use Livewire\Component;
use App\Models\Unit;

class Delete extends Component
{
    public $id_unit;
    public $showModal = false;

    public function openModal()
    {
        $this->showModal = true;
    }

    public function delete()
    {
        Unit::where('id_unit', $this->id_unit)->delete();
        $this->showModal = false;
        session()->flash('success', 'Unit berhasil dihapus!');
    }

    public function render()
    {
        return view('livewire.unit.delete');
    }
}
