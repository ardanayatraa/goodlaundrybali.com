<?php

namespace App\Http\Livewire\Pelanggan;

use Livewire\Component;
use App\Models\Pelanggan;

class Delete extends Component
{
    public $showModal = false;
    public $id_pelanggan;

    protected $listeners = ['deleteModal' => 'openModal'];

    /**
     * Buka modal konfirmasi penghapusan pelanggan.
     *
     * @param int $id_pelanggan
     * @return void
     */
    public function openModal($id_pelanggan)
    {
        $this->id_pelanggan = $id_pelanggan;
        $this->showModal = true;
    }

    /**
     * Hapus data pelanggan dari database.
     *
     * @return void
     */
    public function delete()
    {
        Pelanggan::where('no_telp', $this->id_pelanggan)->delete();
        $this->showModal = false;
        session()->flash('success', 'Pelanggan berhasil dihapus!');
        $this->emit('refreshLivewireDatatable');
    }

    /**
     * Render tampilan komponen Livewire.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.pelanggan.delete');
    }
}
