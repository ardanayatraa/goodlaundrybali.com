<?php

namespace App\Http\Livewire\UnitPaket;

use Livewire\Component;
use App\Models\UnitPaket;
use App\Models\Paket;
use App\Models\Unit;

class Add extends Component
{
    public $nama_unit, $keterangan;

    protected $rules = [
        'nama_unit' => 'required|string|max:255',
        'keterangan' => 'nullable|string',
    ];

    public function save()
    {
        $this->validate();

        UnitPaket::create([
            'nama_unit' => $this->nama_unit,
            'keterangan' => $this->keterangan,
        ]);

        $this->reset();
        return redirect('/unit-paket')->with('success', 'Unit Paket berhasil ditambahkan!');
    }

    public function render()
    {
        return view('livewire.unit-paket.add');
    }
}
