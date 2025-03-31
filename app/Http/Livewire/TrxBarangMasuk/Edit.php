<?php

namespace App\Http\Livewire\TrxBarangMasuk;

use Livewire\Component;
use App\Models\TrxBarangMasuk;
use App\Models\Barang;
use App\Models\Admin;

class Edit extends Component
{
    public $id_trx_barang_masuk, $id_barang, $jumlah, $tanggal_masuk, $id_admin, $harga = 0, $total_harga = 0;
    public $searchBarang = '', $searchAdmin = '';
    public $focusedBarang = false, $focusedAdmin = false;

    protected $rules = [
        'id_barang' => 'required|exists:barangs,id_barang',
        'jumlah' => 'required|integer|min:1',
        'tanggal_masuk' => 'required|date',
        'id_admin' => 'required|exists:admins,id_admin',
    ];

    public function mount($id_trx_barang_masuk)
    {
        $trx = TrxBarangMasuk::where('id_trx_brgmasuk', $id_trx_barang_masuk)->firstOrFail();
        $this->id_trx_barang_masuk = $trx->id_trx_brgmasuk;
        $this->id_barang = $trx->id_barang;
        $this->jumlah = $trx->jumlah_brgmasuk;
        $this->tanggal_masuk = $trx->tanggal_masuk;
        $this->id_admin = $trx->id_admin;
        $this->harga = $trx->harga;
        $this->total_harga = $trx->total_harga;
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['id_barang', 'jumlah'])) {
            if ($this->id_barang) {
                $this->harga = Barang::where('id_barang', $this->id_barang)->value('harga') ?? 0;
            } else {
                $this->harga = 0;
            }
            $this->total_harga = $this->jumlah * $this->harga;
        }
    }

    public function update()
    {
        $this->validate();

        TrxBarangMasuk::where('id_trx_brgmasuk', $this->id_trx_barang_masuk)->update([
            'id_barang' => $this->id_barang,
            'jumlah_brgmasuk' => $this->jumlah,
            'tanggal_masuk' => $this->tanggal_masuk,
            'harga' => $this->harga,
            'total_harga' => $this->total_harga,
            'id_admin' => $this->id_admin,
        ]);

        return redirect('/trx-barang-masuk')->with('success', 'Barang masuk berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.trx-barang-masuk.edit', [
            'barangs' => Barang::where('nama_barang', 'like', '%' . $this->searchBarang . '%')
                                ->limit(5)
                                ->get(),
            'admins' => Admin::where('nama_admin', 'like', '%' . $this->searchAdmin . '%')
                              ->limit(5)
                              ->get(),
        ]);
    }
}
