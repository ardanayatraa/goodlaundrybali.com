<?php

namespace App\Http\Livewire\TrxBarangMasuk;

use Livewire\Component;
use App\Models\TrxBarangMasuk;
use App\Models\Barang;
use App\Models\Admin;

class Add extends Component
{
    public $id_barang, $jumlah, $tanggal_masuk, $id_admin, $harga = 0, $total_harga = 0;
    public $searchBarang = '', $searchAdmin = '';
    public $focusedBarang = false, $focusedAdmin = false;

    protected $rules = [
        'id_barang' => 'required|exists:barangs,id_barang',
        'jumlah' => 'required|integer|min:1',
        'tanggal_masuk' => 'required|date',
        'id_admin' => 'required|exists:admins,id_admin',
    ];

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['id_barang', 'jumlah'])) {
            if ($propertyName === 'id_barang' && $this->id_barang) {
                $this->harga = Barang::find($this->id_barang)?->harga ?? 0;
            }
            $this->total_harga = $this->jumlah * $this->harga;
        }
    }

    public function save()
    {
        $this->validate();

        TrxBarangMasuk::create([
            'id_barang' => $this->id_barang,
            'jumlah_brgmasuk' => $this->jumlah,
            'tanggal_masuk' => $this->tanggal_masuk,
            'harga' => $this->harga,
            'total_harga' => $this->total_harga,
            'id_admin' => $this->id_admin,
        ]);

        Barang::find($this->id_barang)?->increment('stok', $this->jumlah);

        $this->reset();
        return redirect('/trx-barang-masuk')->with('success', 'Barang masuk berhasil ditambahkan dan stok diperbarui!');
    }


    public function render()
    {
        return view('livewire.trx-barang-masuk.add', [
            'barangs' => Barang::where('nama_barang', 'like', '%' . $this->searchBarang . '%')
                                ->limit(5) // Limit to 5 results
                                ->get(),
            'admins' => Admin::where('nama_admin', 'like', '%' . $this->searchAdmin . '%')
                              ->limit(5) // Limit to 5 results
                              ->get(),
        ]);
    }
}
