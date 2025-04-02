<?php

namespace App\Http\Livewire\DetailTransaksi;

use Livewire\Component;
use App\Models\DetailTransaksi;

class Delete extends Component
{
    public $id_detail_transaksi;
    public $showModal = false;

    protected $listeners = ['deleteModal' => 'openModal'];

    /**
     * Membuka modal untuk menghapus detail transaksi.
     *
     * @param int $id_detail_transaksi ID detail transaksi yang akan dihapus.
     * @return void
     */
    public function openModal($id_detail_transaksi)
    {
        $this->id_detail_transaksi = $id_detail_transaksi;
        $this->showModal = true;
    }

    /**
     * Menghapus detail transaksi berdasarkan ID.
     *
     * @return void
     */
    public function delete()
    {
        DetailTransaksi::where('id_detail_transaksi', $this->id_detail_transaksi)->delete();
        $this->showModal = false;
        session()->flash('success', 'Detail transaksi berhasil dihapus!');
        $this->emit('refreshLivewireDatatable');
    }

    /**
     * Merender tampilan komponen Livewire.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.detail-transaksi.delete');
    }
}
