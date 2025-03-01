<?php

namespace App\Http\Livewire\TrxBarangKeluar;

use Livewire\Component;
use App\Models\TrxBarangKeluar;

class Edit extends Component
{
    public $id_trx_barang_keluar, $id_barang, $jumlah, $tanggal_keluar;

    protected $rules = [
        'id_barang' => 'required|exists:barangs,id_barang',
        'jumlah' => 'required|integer|min:1',
        'tanggal_keluar' => 'required|date',
    ];

    public function mount($id_trx_barang_keluar)
    {
        $trx = TrxBarangKeluar::findOrFail($id_trx_barang_keluar);
        $this->id_trx_barang_keluar = $trx->id_trx_barang_keluar;
        $this->id_barang = $trx->id_barang;
        $this->jumlah = $trx->jumlah;
        $this->tanggal_keluar = $trx->tanggal_keluar;
    }

    public function update()
    {
        $this->validate();

        TrxBarangKeluar::where('id_trx_barang_keluar', $this->id_trx_barang_keluar)->update([
            'id_barang' => $this->id_barang,
            'jumlah' => $this->jumlah,
            'tanggal_keluar' => $this->tanggal_keluar,
        ]);

        return redirect('/trx-barang-keluar')->with('success', 'Barang keluar berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.trx-barang-keluar.edit');
    }
}
