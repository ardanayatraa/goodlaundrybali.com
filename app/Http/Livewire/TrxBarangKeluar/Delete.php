<?php

namespace App\Http\Livewire\TrxBarangKeluar;

use Livewire\Component;
use App\Models\TrxBarangKeluar;

class Delete extends Component
{
    public $id_trx_barang_keluar;
    public $showModal = false;

    public function mount($id_trx_barang_keluar)
    {
        $this->id_trx_barang_keluar = $id_trx_barang_keluar;
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function delete()
    {
        TrxBarangKeluar::where('id_trx_barang_keluar', $this->id_trx_barang_keluar)->delete();

        $this->showModal = false;
        session()->flash('success', 'Barang keluar berhasil dihapus!');
    }

    public function render()
    {
        return view('livewire.trx-barang-keluar.delete');
    }
}
