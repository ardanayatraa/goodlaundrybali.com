<?php

namespace App\Http\Livewire\Paket;

use Livewire\Component;
use App\Models\Paket;

class Delete extends Component
{
    public $showModal = false;
    public $id_paket;

    protected $listeners = ['deleteModal' => 'openModal'];

    public function openModal($id_paket)
    {
        $this->id_paket = $id_paket;
        $this->showModal = true;
    }

    public function delete()
    {
        Paket::where('id_paket', $this->id_paket)->delete();
        $this->showModal = false;
        $this->emit('refreshLivewireDatatable'); 
    }

    public function render()
    {
        return view('livewire.paket.delete');
    }
}
