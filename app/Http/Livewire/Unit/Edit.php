<?php

namespace App\Http\Livewire\Unit;

use Livewire\Component;
use App\Models\Unit;

class Edit extends Component
{
    public $id_unit, $nama_unit, $keterangan;
    public $showModal = false;

    protected $rules = [
        'nama_unit' => 'required|string|max:50',
        'keterangan' => 'nullable|string|max:300',
    ];

    public function mount($id_unit)
    {
        $unit = Unit::findOrFail($id_unit);
        $this->id_unit = $unit->id_unit;
        $this->nama_unit = $unit->nama_unit;
        $this->keterangan = $unit->keterangan;
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate();

        Unit::where('id_unit', $this->id_unit)->update([
            'nama_unit' => $this->nama_unit,
            'keterangan' => $this->keterangan,
        ]);

        $this->showModal = false;
        session()->flash('success', 'Unit berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.unit.edit');
    }
}
