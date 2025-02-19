<?php

namespace App\Http\Livewire\UnitPaket;

use Livewire\Component;
use App\Models\UnitPaket;

class Add extends Component
{
    public $id_paket, $id_unit, $jumlah;
    public $showModal = false;

    protected $rules = [
        'id_paket' => 'required|exists:pakets,id_paket',
        'id_unit' => 'required|exists:units,id_unit',
        'jumlah' => 'required|integer|min:1',
    ];

    public function openModal()
    {
        $this->reset();
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        UnitPaket::create([
            'id_paket' => $this->id_paket,
            'id_unit' => $this->id_unit,
            'jumlah' => $this->jumlah,
        ]);

        $this->showModal = false;
        session()->flash('success', 'Unit Paket berhasil ditambahkan!');
    }

    public function render()
    {
        return view('livewire.unit-paket.add');
    }
}
