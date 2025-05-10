<?php

namespace App\Http\Livewire\Unit;

use Livewire\Component;
use App\Models\Unit;

class Delete extends Component
{
    public $showModal = false;
    public $id_unit;

    protected $listeners = ['deleteModal' => 'openModal'];

    /**
     * Membuka modal konfirmasi penghapusan unit.
     *
     * @param int $id_unit
     * @return void
     */
    public function openModal($id_unit)
    {
        $this->id_unit = $id_unit;
        $this->showModal = true;
    }

    /**
     * Menghapus data unit dari database.
     *
     * @return void
     */
    public function delete()
    {
        Unit::where('id_unit', $this->id_unit)->delete();
        $this->showModal = false;
        session()->flash('success', 'Unit berhasil dihapus!');
        $this->emit('refreshLivewireDatatable');
    }

    /**
     * Merender tampilan untuk menghapus unit.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.unit.delete');
    }
}
