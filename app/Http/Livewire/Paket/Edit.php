<?php

namespace App\Http\Livewire\Paket;

use Livewire\Component;
use App\Models\Paket;

class Edit extends Component
{
    public $id_paket, $jenis_paket, $harga, $unit, $waktu_pengerjaan;

    protected $rules = [
        'jenis_paket' => 'required|string|max:50',
        'harga' => 'required|numeric|min:0',
        'unit' => 'required|string|max:10',
        'waktu_pengerjaan' => 'required|string|max:50',
    ];

    public function mount($id_paket)
    {
        $paket = Paket::findOrFail($id_paket);
        $this->id_paket = $paket->id_paket;
        $this->jenis_paket = $paket->jenis_paket;
        $this->harga = $paket->harga;
        $this->unit = $paket->unit;
        $this->waktu_pengerjaan = $paket->waktu_pengerjaan;
    }

    public function update()
    {
        $this->validate();

        Paket::where('id_paket', $this->id_paket)->update([
            'jenis_paket' => $this->jenis_paket,
            'harga' => $this->harga,
            'unit' => $this->unit,
            'waktu_pengerjaan' => $this->waktu_pengerjaan,
        ]);

        return redirect('/paket');
    }

    public function render()
    {
        return view('livewire.paket.edit');
    }
}
