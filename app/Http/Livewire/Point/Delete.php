<?php

namespace App\Http\Livewire\Point;

use Livewire\Component;
use App\Models\Point;

class Delete extends Component
{
    public $id_point;
    public $showModal = false;

    public function mount($id_point)
    {
        $this->id_point = $id_point;
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function delete()
    {
        Point::where('id_point', $this->id_point)->delete();
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.point.delete');
    }
}
