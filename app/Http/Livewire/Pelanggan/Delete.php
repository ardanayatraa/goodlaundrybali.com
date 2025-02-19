<?php

namespace App\Http\Livewire\Pelanggan;

use Livewire\Component;
use App\Models\Pelanggan;

class Delete extends Component
{
    public $showModal = false;
    public $id_pelanggan;

    public function mount($id_pelanggan)
    {
        $this->id_pelanggan = $id_pelanggan;
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function delete()
    {
        Pelanggan::where('id_pelanggan', $this->id_pelanggan)->delete();
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.pelanggan.delete');
    }
}
