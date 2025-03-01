<?php

namespace App\Http\Livewire\Transaksi;

use Livewire\Component;
use App\Models\Transaksi;

class Delete extends Component
{
    public $showModal = false;
    public $id_transaksi;

    protected $listeners = ['deleteModal' => 'openModal'];

    public function openModal($id_transaksi)
    {
        $this->id_transaksi = $id_transaksi;
        $this->showModal = true;
    }

    public function delete()
    {
        Transaksi::where('id_transaksi', $this->id_transaksi)->delete();
        $this->showModal = false;
        session()->flash('success', 'Transaksi berhasil dihapus!');
        $this->emit('refreshLivewireDatatable');
    }

    public function render()
    {
        return view('livewire.transaksi.delete');
    }
}
