<?php

namespace App\Http\Livewire\Barang;

use Livewire\Component;
use App\Models\Barang;

class Edit extends Component
{
    public $id_barang, $nama_barang, $harga, $stok, $id_unit;
    public $searchUnit = '';
    public $focusedUnit = false;

    protected $rules = [
        'nama_barang' => 'required|string|max:50',
        'harga' => 'required|numeric|min:0',
        'stok' => 'required|integer|min:0',
        'id_unit' => 'required|integer|exists:units,id_unit',
    ];

    public function mount($id_barang)
    {
        $barang = Barang::findOrFail($id_barang);
        $this->id_barang = $barang->id_barang;
        $this->nama_barang = $barang->nama_barang;
        $this->harga = $barang->harga;
        $this->stok = $barang->stok;
        $this->id_unit = $barang->id_unit;
    }

    public function update()
    {
        $this->validate();

        Barang::where('id_barang', $this->id_barang)->update([
            'nama_barang' => $this->nama_barang,
            'harga' => $this->harga,
            'stok' => $this->stok,
            'id_unit' => $this->id_unit,
        ]);

        return redirect('/barang');
    }

    public function render()
    {
        return view('livewire.barang.edit', [
            'units' => \App\Models\Unit::where('nama_unit', 'like', '%' . $this->searchUnit . '%')
                                       ->limit(5)
                                       ->get(),
        ]);
    }
}
