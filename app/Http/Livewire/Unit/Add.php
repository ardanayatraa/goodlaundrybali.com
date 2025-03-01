<?php

namespace App\Http\Livewire\Unit;

use Livewire\Component;
use App\Models\Unit;

class Add extends Component
{
    public $nama_unit, $keterangan;

    protected $rules = [
        'nama_unit' => 'required|string|max:50',
        'keterangan' => 'nullable|string|max:300',
    ];

    public function save()
    {
        $this->validate();

        Unit::create([
            'nama_unit' => $this->nama_unit,
            'keterangan' => $this->keterangan,
        ]);

        $this->reset();
        return redirect('/unit')->with('success', 'Unit berhasil ditambahkan!');
    }

    public function render()
    {
        return view('livewire.unit.add');
    }
}
