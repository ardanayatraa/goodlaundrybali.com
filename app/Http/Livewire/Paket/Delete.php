<?php

namespace App\Http\Livewire\Paket;

use Livewire\Component;
use App\Models\Paket;

class Delete extends Component
{
    public $showModal = false;
    public $id_paket;

    protected $listeners = ['deleteModal' => 'openModal'];

    /**
     * Membuka modal konfirmasi penghapusan.
     *
     * @param int $id_paket ID dari paket yang akan dihapus.
     */
    public function openModal($id_paket)
    {
        $this->id_paket = $id_paket;
        $this->showModal = true;
    }

    /**
     * Menghapus data paket dari database berdasarkan id_paket.
     * Menutup modal setelah penghapusan berhasil.
     * Memancarkan event untuk menyegarkan tabel Livewire.
     */
    public function delete()
    {
        Paket::where('id_paket', $this->id_paket)->delete();
        $this->showModal = false;
        $this->emit('refreshLivewireDatatable');
    }

    /**
     * Merender tampilan komponen Livewire.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.paket.delete');
    }
}
