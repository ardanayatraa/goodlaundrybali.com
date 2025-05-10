<?php

namespace App\Http\Livewire\TrxBarangKeluar;

use Livewire\Component;
use App\Models\TrxBarangKeluar;
use App\Models\Barang;
use App\Models\Admin;

class Edit extends Component
{
    public $id_trx_barang_keluar, $id_barang, $jumlah, $tanggal_keluar, $id_admin, $harga, $total_harga;
    public $searchBarang = '', $searchAdmin = '';
    public $focusedBarang = false, $focusedAdmin = false;

    protected $rules = [
        'id_barang' => 'required|exists:barangs,id_barang',
        'jumlah' => 'required|integer|min:1',
        'tanggal_keluar' => 'required|date',
        'id_admin' => 'required|exists:admins,id_admin',
    ];

    /**
     * Menginisialisasi data transaksi barang keluar berdasarkan ID.
     *
     * @param int $id_trx_barang_keluar ID transaksi barang keluar.
     * @return void
     */
    public function mount($id_trx_barang_keluar)
    {
        $trx = TrxBarangKeluar::findOrFail($id_trx_barang_keluar);
        $this->id_trx_barang_keluar = $trx->id_trx_barang_keluar;
        $this->id_barang = $trx->id_barang;
        $this->jumlah = $trx->jumlah;
        $this->tanggal_keluar = $trx->tanggal_keluar;
        $this->id_admin = $trx->id_admin;
        $this->harga = $trx->harga;
        $this->total_harga = $trx->total_harga;
    }

    /**
     * Memperbarui properti tertentu dan menghitung total harga jika diperlukan.
     *
     * @param string $propertyName Nama properti yang diperbarui.
     * @return void
     */
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

    /**
     * Memperbarui data transaksi barang keluar di database dan memperbarui stok barang.
     *
     * @return \Illuminate\Http\RedirectResponse Redirect ke halaman transaksi barang keluar dengan pesan sukses.
     */
    public function update()
    {
        $this->validate();

        $this->harga = Barang::where('id_barang', $this->id_barang)->first()->harga;
        $this->total_harga = $this->jumlah * $this->harga;

        $trxLama = TrxBarangKeluar::where('id_trx_barang_keluar', $this->id_trx_barang_keluar)->first();

        Barang::where('id_barang', $trxLama->id_barang)->increment('stok', $trxLama->jumlah_brgkeluar);

        TrxBarangKeluar::where('id_trx_barang_keluar', $this->id_trx_barang_keluar)->update([
            'id_barang' => $this->id_barang,
            'jumlah_brgkeluar' => $this->jumlah,
            'tanggal_keluar' => $this->tanggal_keluar,
            'id_admin' => $this->id_admin,
            'harga' => $this->harga,
            'total_harga' => $this->total_harga,
        ]);

        Barang::where('id_barang', $this->id_barang)->decrement('stok', $this->jumlah);

        return redirect('/trx-barang-keluar')->with('success', 'Barang keluar berhasil diperbarui dan stok diperbarui!');
    }

    /**
     * Merender tampilan Livewire untuk mengedit transaksi barang keluar.
     *
     * @return \Illuminate\View\View Tampilan Livewire.
     */
    public function render()
    {
        return view('livewire.trx-barang-keluar.edit', [
            'barangs' => Barang::where('nama_barang', 'like', '%' . $this->searchBarang . '%')
                                ->limit(5)
                                ->get(),
            'admins' => Admin::where('nama_admin', 'like', '%' . $this->searchAdmin . '%')
                              ->limit(5)
                              ->get(),
        ]);
    }
}
