<?php

namespace App\Http\Livewire\TrxBarangMasuk;

use Livewire\Component;
use App\Models\TrxBarangMasuk;

class Delete extends Component
{
    public $id_trx_barang_masuk;
    public $showModal = false;

    public function mount($id_trx_barang_masuk)
    {
        $this->id_trx_barang_masuk = $id_trx_barang_masuk;
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function delete()
    {
        TrxBarangMasuk::where('id_trx_barang_masuk', $this->id_trx_barang_masuk)->delete();

        $this->showModal = false;
        session()->flash('success', 'Barang masuk berhasil dihapus!');
    }

    public function render()
    {
        return view('livewire.trx-barang-masuk.delete');
    }
}
