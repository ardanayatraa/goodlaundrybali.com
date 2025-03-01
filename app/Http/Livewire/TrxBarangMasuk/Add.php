<?php

namespace App\Http\Livewire\TrxBarangMasuk;

use Livewire\Component;
use App\Models\TrxBarangMasuk;
use App\Models\Barang;

class Add extends Component
{
    public $id_barang, $jumlah, $tanggal_masuk;

    protected $rules = [
        'id_barang' => 'required|exists:barangs,id_barang',
        'jumlah' => 'required|integer|min:1',
        'tanggal_masuk' => 'required|date',
    ];

    public function save()
    {
        $this->validate();

        TrxBarangMasuk::create([
            'id_barang' => $this->id_barang,
            'jumlah' => $this->jumlah,
            'tanggal_masuk' => $this->tanggal_masuk,
        ]);

        $this->reset();
        return redirect('/trx-barang-masuk')->with('success', 'Barang masuk berhasil ditambahkan!');
    }

    public function render()
    {
        return view('livewire.trx-barang-masuk.add', [
            'barangs' => Barang::all()
        ]);
    }
}
