<?php

namespace App\Http\Livewire\Paket;

use Livewire\Component;
use App\Models\Paket;

class Add extends Component
{
    public $jenis_paket, $harga, $unit, $waktu_pengerjaan;

    protected $rules = [
        'jenis_paket' => 'required|string|max:50',
        'harga' => 'required|numeric|min:0',
        'unit' => 'required|string|max:10',
        'waktu_pengerjaan' => 'required|string|max:50',
    ];

    public function save()
    {
        $this->validate();

        Paket::create([
            'jenis_paket' => $this->jenis_paket,
            'harga' => $this->harga,
            'unit' => $this->unit,
            'waktu_pengerjaan' => $this->waktu_pengerjaan,
        ]);

        // Reset form after save
        $this->reset();
        return redirect('/paket');
    }

    public function render()
    {
        return view('livewire.paket.add');
    }
}
