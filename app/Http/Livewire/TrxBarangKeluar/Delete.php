<?php

namespace App\Http\Livewire\TrxBarangKeluar;

use Livewire\Component;
use App\Models\TrxBarangKeluar;

class Delete extends Component
{
    public $showModal = false;
    public $id_trx_barang_keluar;

    protected $listeners = ['deleteModal' => 'openModal'];

    public function openModal($id_trx_barang_keluar)
    {
        $this->id_trx_barang_keluar = $id_trx_barang_keluar;
        $this->showModal = true;
    }

    public function delete()
    {
        TrxBarangKeluar::where('id_trx_brgkeluar', $this->id_trx_barang_keluar)->delete();
        $this->showModal = false;
        session()->flash('success', 'Barang keluar berhasil dihapus!');
        $this->emit('refreshLivewireDatatable');
    }

    public function render()
    {
        return view('livewire.trx-barang-keluar.delete');
    }
}
