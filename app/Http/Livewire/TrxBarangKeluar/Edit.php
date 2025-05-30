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
        'id_barang'       => 'required|exists:barangs,id_barang',
        'jumlah'          => 'required|integer|min:1',
        'tanggal_keluar'  => 'required|date',
        'id_admin'        => 'required|exists:admins,id_admin',
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
        $this->id_trx_barang_keluar = $trx->id_trx_brgkeluar;
        $this->id_barang           = $trx->id_barang;
        $this->jumlah              = $trx->jumlah_brgkeluar;
        $this->tanggal_keluar      = $trx->tanggal_keluar;
        $this->id_admin            = $trx->id_admin;
        $this->harga               = $trx->barang->harga;
        $this->total_harga         = $trx->jumlah_brgkeluar * $trx->barang->harga;
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        // validasi dasar
        $this->validate();

        // cek stok sebelum proses update
        $barang = Barang::find($this->id_barang);
        if (! $barang) {
            $this->addError('id_barang', 'Barang tidak ditemukan.');
            return;
        }
        if ($this->jumlah > $barang->stok + TrxBarangKeluar::find($this->id_trx_barang_keluar)->jumlah_brgkeluar) {
            // tambahkan stok lama ke logika, karena stok akan ditambah dulu dari transaksi lama
            $sisa = $barang->stok + TrxBarangKeluar::find($this->id_trx_barang_keluar)->jumlah_brgkeluar;
            $this->addError('jumlah', "Stok tersisa {$sisa}, tidak cukup untuk keluar {$this->jumlah}.");
            return;
        }

        // rollback stok dari transaksi lama
        $trxLama = TrxBarangKeluar::findOrFail($this->id_trx_barang_keluar);
        Barang::where('id_barang', $trxLama->id_barang)
               ->increment('stok', $trxLama->jumlah_brgkeluar);

        // hitung harga & total baru
        $this->harga       = $barang->harga;
        $this->total_harga = $this->jumlah * $this->harga;

        // update transaksi
        TrxBarangKeluar::where('id_trx_brgkeluar', $this->id_trx_barang_keluar)
            ->update([
                'id_barang'        => $this->id_barang,
                'jumlah_brgkeluar' => $this->jumlah,
                'tanggal_keluar'   => $this->tanggal_keluar,
                'id_admin'         => $this->id_admin,
            ]);

        // kurangi stok sesuai jumlah baru
        Barang::where('id_barang', $this->id_barang)
               ->decrement('stok', $this->jumlah);

        return redirect('/trx-barang-keluar')
               ->with('success', 'Barang keluar berhasil diperbarui dan stok diperbarui!');
    }

    /**
     * Merender tampilan Livewire untuk mengedit transaksi barang keluar.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.trx-barang-keluar.edit', [
            'barangs' => Barang::where('nama_barang', 'like', '%' . $this->searchBarang . '%')
                               ->limit(5)
                               ->get(),
            'admins'  => Admin::where('nama_admin', 'like', '%' . $this->searchAdmin . '%')
                               ->limit(5)
                               ->get(),
        ]);
    }
}
