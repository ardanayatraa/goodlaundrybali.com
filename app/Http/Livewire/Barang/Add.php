<?php

namespace App\Http\Livewire\Barang;

use Livewire\Component;
use App\Models\Barang;

class Add extends Component
{
    public $nama_barang, $harga, $stok, $stok_minimum, $id_unit;
    public $searchUnit = '';
    public $focusedUnit = false;

    protected $rules = [
        'nama_barang' => 'required|string|max:50',
        'harga' => 'required',
        'stok' => 'required',
        'stok_minimum' => 'required|integer|min:0',
        'id_unit' => 'required|exists:units,id_unit',
    ];

    /**
     * Menyimpan data barang ke dalam database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save()
    {
        $this->validate();

        Barang::create([
            'nama_barang' => $this->nama_barang,
            'harga' => $this->harga,
            'stok' => $this->stok,
            'stok_minimum' => $this->stok_minimum,
            'id_unit' => $this->id_unit,
        ]);

        return redirect('/barang');
    }

    /**
     * Merender tampilan Livewire untuk menambahkan barang.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.barang.add', [
            'units' => \App\Models\Unit::where('nama_unit', 'like', '%' . $this->searchUnit . '%')
                                       ->limit(5)
                                       ->get(),
        ]);
    }
}
