<?php

namespace App\Http\Livewire\Point;

use Livewire\Component;
use App\Models\Point;

class Delete extends Component
{
    public $showModal = false;
    public $id_point;

    protected $listeners = ['deleteModal' => 'openModal'];

    public function openModal($id_point)
    {
        $this->id_point = $id_point;
        $this->showModal = true;
    }

    public function delete()
    {
        Point::where('id_point', $this->id_point)->delete();
        $this->showModal = false;
        session()->flash('success', 'Point berhasil dihapus!');
        $this->emit('refreshLivewireDatatable');
    }

    public function render()
    {
        return view('livewire.point.delete');
    }
}
