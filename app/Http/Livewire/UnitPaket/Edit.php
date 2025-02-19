<?php

namespace App\Http\Livewire\UnitPaket;

use Livewire\Component;
use App\Models\UnitPaket;

class Edit extends Component
{
    public $id_unit_paket, $id_paket, $id_unit, $jumlah;
    public $showModal = false;

    protected $rules = [
        'id_paket' => 'required|exists:pakets,id_paket',
        'id_unit' => 'required|exists:units,id_unit',
        'jumlah' => 'required|integer|min:1',
    ];

    public function mount($id_unit_paket)
    {
        $unitPaket = UnitPaket::findOrFail($id_unit_paket);
        $this->id_unit_paket = $unitPaket->id_unit_paket;
        $this->id_paket = $unitPaket->id_paket;
        $this->id_unit = $unitPaket->id_unit;
        $this->jumlah = $unitPaket->jumlah;
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate();

        UnitPaket::where('id_unit_paket', $this->id_unit_paket)->update([
            'id_paket' => $this->id_paket,
            'id_unit' => $this->id_unit,
            'jumlah' => $this->jumlah,
        ]);

        $this->showModal = false;
        session()->flash('success', 'Unit Paket berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.unit-paket.edit');
    }
}
