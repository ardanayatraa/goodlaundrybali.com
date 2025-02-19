<?php

namespace App\Http\Livewire\Transaksi;

use Livewire\Component;
use App\Models\Transaksi;

class Delete extends Component
{
    public $id_transaksi;
    public $showModal = false;

    public function mount($id_transaksi)
    {
        $this->id_transaksi = $id_transaksi;
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function delete()
    {
        Transaksi::where('id_transaksi', $this->id_transaksi)->delete();
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.transaksi.delete');
    }
}
