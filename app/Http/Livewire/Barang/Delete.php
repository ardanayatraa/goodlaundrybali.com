<?php

namespace App\Http\Livewire\Barang;

use Livewire\Component;
use App\Models\Barang;

class Delete extends Component
{
    public $id_barang;
    public $showModal = false;

    protected $listeners = ['deleteModal' => 'openModal'];

    /**
     * Membuka modal untuk menghapus barang.
     *
     * @param int $id_barang ID barang yang akan dihapus.
     * @return void
     */
    public function openModal($id_barang)
    {
        $this->id_barang = $id_barang;
        $this->showModal = true;
    }

    /**
     * Menghapus barang berdasarkan ID barang.
     *
     * @return void
     */
    public function delete()
    {
        Barang::where('id_barang', $this->id_barang)->delete();
        $this->showModal = false;
        session()->flash('success', 'Barang berhasil dihapus!');
        $this->emit('refreshLivewireDatatable');
    }

    /**
     * Merender tampilan komponen Livewire.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.barang.delete');
    }
}
