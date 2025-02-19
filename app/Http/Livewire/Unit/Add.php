<?php

namespace App\Http\Livewire\Unit;

use Livewire\Component;
use App\Models\Unit;

class Add extends Component
{
    public $nama_unit, $keterangan;
    public $showModal = false;

    protected $rules = [
        'nama_unit' => 'required|string|max:50',
        'keterangan' => 'nullable|string|max:300',
    ];

    public function openModal()
    {
        $this->reset();
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        Unit::create([
            'nama_unit' => $this->nama_unit,
            'keterangan' => $this->keterangan,
        ]);

        $this->showModal = false;
        session()->flash('success', 'Unit berhasil ditambahkan!');
    }

    public function render()
    {
        return view('livewire.unit.add');
    }
}
