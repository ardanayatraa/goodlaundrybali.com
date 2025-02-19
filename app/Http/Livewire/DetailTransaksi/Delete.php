<?php

namespace App\Http\Livewire\DetailTransaksi;

use Livewire\Component;
use App\Models\DetailTransaksi;

class Delete extends Component
{
    public $id_detail_transaksi;
    public $showModal = false;

    public function mount($id_detail_transaksi)
    {
        $this->id_detail_transaksi = $id_detail_transaksi;
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function delete()
    {
        DetailTransaksi::where('id_detail_transaksi', $this->id_detail_transaksi)->delete();
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.detail-transaksi.delete');
    }
}
