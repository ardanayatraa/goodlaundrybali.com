<?php

namespace App\Http\Livewire\Point;

use Livewire\Component;
use App\Models\Point;

class Edit extends Component
{
    public $id_point, $id_pelanggan, $tanggal, $jumlah_point;
    public $showModal = false;

    public function mount($id_point)
    {
        $point = Point::findOrFail($id_point);
        $this->id_point = $point->id_point;
        $this->id_pelanggan = $point->id_pelanggan;
        $this->tanggal = $point->tanggal;
        $this->jumlah_point = $point->jumlah_point;
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate([
            'id_pelanggan' => 'required|exists:pelanggans,id_pelanggan',
            'tanggal' => 'required|date',
            'jumlah_point' => 'required|integer|min:0',
        ]);

        Point::where('id_point', $this->id_point)->update([
            'id_pelanggan' => $this->id_pelanggan,
            'tanggal' => $this->tanggal,
            'jumlah_point' => $this->jumlah_point,
        ]);

        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.point.edit');
    }
}
