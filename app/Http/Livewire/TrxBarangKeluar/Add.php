<?php

namespace App\Http\Livewire\TrxBarangKeluar;

use Livewire\Component;
use App\Models\Barang;
use App\Models\TrxBarangKeluar;

class Add extends Component
{
    public $id_barang;
    public $tanggal_keluar;
    public $nama_admin;
    public $showModal = false;

    protected $rules = [
        'id_barang' => 'required|exists:barangs,id_barang',
        'tanggal_keluar' => 'required|date',
        'nama_admin' => 'required|string|max:255',
    ];

    public function submit()
    {
        $this->validate();

        TrxBarangKeluar::create([
            'id_barang' => $this->id_barang,
            'tanggal_keluar' => $this->tanggal_keluar,
            'nama_admin' => $this->nama_admin,
        ]);

        $this->reset(['id_barang', 'tanggal_keluar', 'nama_admin']);
        $this->showModal = false; // Tutup modal
        session()->flash('success', 'Transaksi barang keluar berhasil ditambahkan!');

        $this->emit('refreshLivewireDatatable');
    }

    public function render()
    {
        return view('livewire.trx-barang-keluar.add', [
            'barangs' => Barang::all(),
        ]);
    }
}
