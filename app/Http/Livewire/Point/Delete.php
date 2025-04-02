<?php

namespace App\Http\Livewire\Point;

use Livewire\Component;
use App\Models\Point;

class Delete extends Component
{
    public $showModal = false;
    public $id_point;

    protected $listeners = ['deleteModal' => 'openModal'];

    /**
     * Membuka modal konfirmasi penghapusan.
     *
     * @param int $id_point
     * @return void
     */
    public function openModal($id_point)
    {
        $this->id_point = $id_point;
        $this->showModal = true;
    }

    /**
     * Menghapus data point dari database.
     *
     * @return void
     */
    public function delete()
    {
        Point::where('id_point', $this->id_point)->delete();
        $this->showModal = false;
        session()->flash('success', 'Point berhasil dihapus!');
        $this->emit('refreshLivewireDatatable');
    }

    /**
     * Merender tampilan komponen Livewire.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.point.delete');
    }
}
