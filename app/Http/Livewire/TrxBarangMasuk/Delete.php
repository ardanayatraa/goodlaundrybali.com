<?php

namespace App\Http\Livewire\TrxBarangMasuk;

use Livewire\Component;
use App\Models\TrxBarangMasuk;

class Delete extends Component
{
    public $showModal = false;
    public $id_trx_barang_masuk;

    protected $listeners = ['deleteModal' => 'openModal'];

    public function openModal($id_trx_barang_masuk)
    {
        $this->id_trx_barang_masuk = $id_trx_barang_masuk;
        $this->showModal = true;
    }

    public function delete()
    {
        TrxBarangMasuk::where('id_trx_brgmasuk', $this->id_trx_barang_masuk)->delete();
        $this->showModal = false;
        session()->flash('success', 'Barang masuk berhasil dihapus!');
        $this->emit('refreshLivewireDatatable');
    }

    public function render()
    {
        return view('livewire.trx-barang-masuk.delete');
    }
}
