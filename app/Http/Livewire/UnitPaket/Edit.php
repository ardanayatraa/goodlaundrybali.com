<?php

namespace App\Http\Livewire\UnitPaket;

use Livewire\Component;
use App\Models\UnitPaket;

class Edit extends Component
{
    public $id_unit_paket, $nama_unit, $keterangan;

    protected $rules = [
        'nama_unit' => 'required|string|max:255',
        'keterangan' => 'nullable|string',
    ];

    public function mount($id_unit_paket)
    {
        $unitPaket = UnitPaket::findOrFail($id_unit_paket);
        $this->id_unit_paket = $unitPaket->id_unit_paket;
        $this->nama_unit = $unitPaket->nama_unit;
        $this->keterangan = $unitPaket->keterangan;
    }

    public function update()
    {
        $this->validate();

        UnitPaket::where('id_unit_paket', $this->id_unit_paket)->update([
            'nama_unit' => $this->nama_unit,
            'keterangan' => $this->keterangan,
        ]);

        return redirect('/unit-paket')->with('success', 'Unit Paket berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.unit-paket.edit');
    }
}
