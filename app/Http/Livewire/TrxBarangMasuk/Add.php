<?php

namespace App\Http\Livewire\TrxBarangMasuk;

use Livewire\Component;
use App\Models\Barang;
use App\Models\TrxBarangMasuk;

class Add extends Component
{
    public $id_barang;
    public $tanggal_masuk;
    public $nama_admin;
    public $total_harga;
    public $showModal = false;

    protected $rules = [
        'id_barang' => 'required|exists:barangs,id_barang',
        'tanggal_masuk' => 'required|date',
        'nama_admin' => 'required|string|max:255',
        'total_harga' => 'required|numeric|min:0',
    ];

    public function submit()
    {
        $this->validate();

        TrxBarangMasuk::create([
            'id_barang' => $this->id_barang,
            'tanggal_masuk' => $this->tanggal_masuk,
            'nama_admin' => $this->nama_admin,
            'total_harga' => $this->total_harga,
        ]);

        $this->reset(['id_barang', 'tanggal_masuk', 'nama_admin', 'total_harga']);
        $this->showModal = false;
        session()->flash('success', 'Transaksi barang masuk berhasil ditambahkan!');
        $this->emit('refreshLivewireDatatable');
    }

    public function render()
    {
        return view('livewire.trx-barang-masuk.add', [
            'barangs' => Barang::all(),
        ]);
    }
}
