<?php

namespace App\Http\Livewire\Barang;

use Livewire\Component;
use App\Models\Barang;

class Add extends Component
{
    public $nama_barang, $harga, $stok;

    protected $rules = [
        'nama_barang' => 'required|string|max:50',
        'harga' => 'required|numeric|min:0',
        'stok' => 'required|integer|min:0',
    ];

    public function save()
    {
        $this->validate();

        Barang::create([
            'nama_barang' => $this->nama_barang,
            'harga' => $this->harga,
            'stok' => $this->stok,
        ]);
    }

    public function render()
    {
        return view('livewire.barang.add');
    }
}
