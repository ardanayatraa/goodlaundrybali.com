<?php

namespace App\Http\Livewire\UnitPaket;

use Livewire\Component;
use App\Models\UnitPaket;
use App\Models\Paket;
use App\Models\Unit;

class Add extends Component
{
    public $id_paket, $id_unit, $jumlah;

    protected $rules = [
        'id_paket' => 'required|exists:pakets,id_paket',
        'id_unit' => 'required|exists:units,id_unit',
        'jumlah' => 'required|integer|min:1',
    ];

    public function save()
    {
        $this->validate();

        UnitPaket::create([
            'id_paket' => $this->id_paket,
            'id_unit' => $this->id_unit,
            'jumlah' => $this->jumlah,
        ]);

        $this->reset();
        return redirect('/unit-paket')->with('success', 'Unit Paket berhasil ditambahkan!');
    }

    public function render()
    {
        return view('livewire.unit-paket.add', [
            'pakets' => Paket::all(),
            'units' => Unit::all(),
        ]);
    }
}
