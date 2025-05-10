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

    /**
     * Fungsi untuk menginisialisasi data berdasarkan ID transaksi barang masuk.
     *
     * @param int $id_trx_barang_masuk ID transaksi barang masuk.
     */
    public function mount($id_trx_barang_masuk)
    {
        $trx = TrxBarangMasuk::findOrFail($id_trx_barang_masuk);
        $this->id_trx_barang_masuk = $trx->id_trx_brgmasuk;
        $this->id_barang = $trx->id_barang;
        $this->jumlah = $trx->jumlah_brgmasuk;
        $this->tanggal_masuk = $trx->tanggal_masuk;
        $this->id_admin = $trx->id_admin;
        $this->harga = $trx->harga;
        $this->total_harga = $trx->total_harga;
    }

    /**
     * Fungsi ini akan dipanggil setiap properti yang di-bind diperbarui.
     * Menghitung total harga berdasarkan jumlah dan harga barang.
     *
     * @param string $propertyName Nama properti yang diperbarui.
     */
    public function updated($propertyName)
    {
        if (in_array($propertyName, ['id_barang', 'jumlah'])) {
            $this->harga = $this->id_barang ? Barang::find($this->id_barang)->harga ?? 0 : 0;
            $this->total_harga = $this->jumlah * $this->harga;
        }
    }

    /**
     * Fungsi untuk memperbarui data barang masuk di database.
     * Melakukan validasi, memperbarui data, dan memperbarui stok barang.
     *
     * @return \Illuminate\Http\RedirectResponse Redirect ke halaman daftar barang masuk dengan pesan sukses.
     */
    public function update()
    {
        $this->validate();

        $trxLama = TrxBarangMasuk::find($this->id_trx_barang_masuk);

        if ($trxLama) {
            Barang::find($trxLama->id_barang)->decrement('stok', $trxLama->jumlah_brgmasuk);

            $trxLama->update([
                'id_barang' => $this->id_barang,
                'jumlah_brgmasuk' => $this->jumlah,
                'tanggal_masuk' => $this->tanggal_masuk,
                'harga' => $this->harga,
                'total_harga' => $this->total_harga,
                'id_admin' => $this->id_admin,
            ]);

            Barang::find($this->id_barang)->increment('stok', $this->jumlah);
        }

        return redirect('/trx-barang-masuk')->with('success', 'Barang masuk berhasil diperbarui dan stok diperbarui!');
    }

    /**
     * Fungsi untuk merender tampilan komponen Livewire.
     * Mengambil data barang dan admin berdasarkan pencarian.
     *
     * @return \Illuminate\View\View View untuk komponen Livewire.
     */
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
