<?php

namespace App\Http\Livewire\Pelanggan;

use Livewire\Component;
use App\Models\Pelanggan;

class Delete extends Component
{
    public $showModal = false;
    public $id_pelanggan;

    protected $listeners = ['deleteModal' => 'openModal'];

    public function openModal($id_pelanggan)
    {
        $this->id_pelanggan = $id_pelanggan;
        $this->showModal = true;
    }

    public function delete()
    {
        Pelanggan::where('id_pelanggan', $this->id_pelanggan)->delete();
        $this->showModal = false;
        session()->flash('success', 'Pelanggan berhasil dihapus!');
        $this->emit('refreshLivewireDatatable');
    }

    public function render()
    {
        return view('livewire.pelanggan.delete');
    }
}
