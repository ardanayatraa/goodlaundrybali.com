<?php

namespace App\Http\Livewire\DetailTransaksi;

use Livewire\Component;
use App\Models\DetailTransaksi;

class Delete extends Component
{
    public $id_detail_transaksi;
    public $showModal = false;

    protected $listeners = ['deleteModal' => 'openModal'];

    public function openModal($id_detail_transaksi)
    {
        $this->id_detail_transaksi = $id_detail_transaksi;
        $this->showModal = true;
    }

    public function delete()
    {
        DetailTransaksi::where('id_detail_transaksi', $this->id_detail_transaksi)->delete();
        $this->showModal = false;
        session()->flash('success', 'Detail transaksi berhasil dihapus!');
        $this->emit('refreshLivewireDatatable');
    }

    public function render()
    {
        return view('livewire.detail-transaksi.delete');
    }
}
