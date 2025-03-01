<?php

namespace App\Http\Livewire\TrxBarangMasuk;

use Livewire\Component;
use App\Models\TrxBarangMasuk;

class Edit extends Component
{
    public $id_trx_barang_masuk, $id_barang, $jumlah, $tanggal_masuk;

    protected $rules = [
        'id_barang' => 'required|exists:barangs,id_barang',
        'jumlah' => 'required|integer|min:1',
        'tanggal_masuk' => 'required|date',
    ];

    public function mount($id_trx_barang_masuk)
    {
        $trx = TrxBarangMasuk::where('id_trx_brgmasuk', $id_trx_barang_masuk)->firstOrFail();
        $this->id_trx_barang_masuk = $trx->id_trx_brgmasuk;
        $this->id_barang = $trx->id_barang;
        $this->jumlah = $trx->jumlah;
        $this->tanggal_masuk = $trx->tanggal_masuk;
    }

    public function update()
    {
        $this->validate();

        TrxBarangMasuk::where('id_trx_brgmasuk', $this->id_trx_barang_masuk)->update([
            'id_barang' => $this->id_barang,
            'jumlah' => $this->jumlah,
            'tanggal_masuk' => $this->tanggal_masuk,
        ]);

        return redirect('/trx-barang-masuk')->with('success', 'Barang masuk berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.trx-barang-masuk.edit');
    }
}
