<?php

namespace App\Http\Livewire\Barang;

use Livewire\Component;
use App\Models\Barang;

class Add extends Component
{
    public $nama_barang;
    public $harga;
    public $showModal = false;

    protected $rules = [
        'nama_barang' => 'required|string|max:255',
        'harga' => 'required|numeric|min:0',
    ];

    public function submit()
    {
        $this->validate();

        Barang::create([
            'nama_barang' => $this->nama_barang,
            'harga' => $this->harga,
        ]);

        $this->reset(['nama_barang', 'harga']);
        $this->showModal = false; // Tutup modal setelah data berhasil disimpan
        $this->emit('refreshLivewireDatatable');
        session()->flash('success', 'Barang berhasil ditambahkan!');
    }

    public function render()
    {
        return view('livewire.barang.add');
    }
}
