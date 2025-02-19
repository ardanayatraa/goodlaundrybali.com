<?php

namespace App\Http\Livewire\TrxBarangKeluar;

use Livewire\Component;
use App\Models\TrxBarangKeluar;

class Add extends Component
{
    public $id_barang, $jumlah, $tanggal_keluar;
    public $showModal = false;

    protected $rules = [
        'id_barang' => 'required|exists:barangs,id_barang',
        'jumlah' => 'required|integer|min:1',
        'tanggal_keluar' => 'required|date',
    ];

    public function openModal()
    {
        $this->reset();
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        TrxBarangKeluar::create([
            'id_barang' => $this->id_barang,
            'jumlah' => $this->jumlah,
            'tanggal_keluar' => $this->tanggal_keluar,
        ]);

        $this->showModal = false;
        session()->flash('success', 'Barang keluar berhasil ditambahkan!');
    }

    public function render()
    {
        return view('livewire.trx-barang-keluar.add');
    }
}
