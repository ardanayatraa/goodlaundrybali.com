<?php

namespace App\Http\Livewire\Paket;

use Livewire\Component;
use App\Models\Paket;

class Delete extends Component
{
    public $showModal = false;
    public $id_paket;

    public function mount($id_paket)
    {
        $this->id_paket = $id_paket;
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function delete()
    {
        Paket::where('id_paket', $this->id_paket)->delete();
        $this->showModal = false;
        return redirect()->to('/paket');
    }

    public function render()
    {
        return view('livewire.paket.delete');
    }
}
