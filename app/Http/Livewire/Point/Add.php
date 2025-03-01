<?php

namespace App\Http\Livewire\Point;

use Livewire\Component;
use App\Models\Point;

class Add extends Component
{
    public $id_pelanggan, $tanggal, $jumlah_point;

    protected $rules = [
        'id_pelanggan' => 'required|exists:pelanggans,id_pelanggan',
        'tanggal' => 'required|date',
        'jumlah_point' => 'required|integer|min:0',
    ];

    public function save()
    {
        $this->validate();

        Point::create([
            'id_pelanggan' => $this->id_pelanggan,
            'tanggal' => $this->tanggal,
            'jumlah_point' => $this->jumlah_point,
        ]);

        $this->reset();
        return redirect('/point');
    }

    public function render()
    {
        return view('livewire.point.add');
    }
}
