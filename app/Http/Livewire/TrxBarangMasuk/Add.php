<?php

namespace App\Http\Livewire\TrxBarangMasuk;

use Livewire\Component;
use App\Models\TrxBarangMasuk;

class Add extends Component
{
    public $id_barang, $jumlah, $tanggal_masuk;
    public $showModal = false;

    protected $rules = [
        'id_barang' => 'required|exists:barangs,id_barang',
        'jumlah' => 'required|integer|min:1',
        'tanggal_masuk' => 'required|date',
    ];

    public function openModal()
    {
        $this->reset();
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        TrxBarangMasuk::create([
            'id_barang' => $this->id_barang,
            'jumlah' => $this->jumlah,
            'tanggal_masuk' => $this->tanggal_masuk,
        ]);

        $this->showModal = false;
        session()->flash('success', 'Barang masuk berhasil ditambahkan!');
    }

    public function render()
    {
        return view('livewire.trx-barang-masuk.add', [
            'barangs' => \App\Models\Barang::all() 
        ]);
    }
}
