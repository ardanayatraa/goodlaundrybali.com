<?php

namespace App\Http\Livewire\TrxBarangKeluar;

use Livewire\Component;
use App\Models\TrxBarangKeluar;
use App\Models\Barang;
use App\Models\Admin;

class Add extends Component
{
    public $id_barang, $jumlah, $tanggal_keluar, $id_admin, $harga = 0, $total_harga = 0;
    public $searchBarang = '', $searchAdmin = '';
    public $focusedBarang = false, $focusedAdmin = false;

    protected $rules = [
        'id_barang' => 'required|exists:barangs,id_barang',
        'jumlah' => 'required|integer|min:1',
        'tanggal_keluar' => 'required|date',
        'id_admin' => 'required|exists:admins,id_admin',
    ];

    /**
     * Memperbarui properti tertentu dan menghitung total harga jika diperlukan.
     *
     * @param string $propertyName Nama properti yang diperbarui.
     * @return void
     */
    public function updated($propertyName)
    {
        if ($propertyName === 'id_barang' && $this->id_barang) {
            $this->harga = Barang::where('id_barang', $this->id_barang)->value('harga') ?? 0;
        }

        if (in_array($propertyName, ['id_barang', 'jumlah'])) {
            $this->total_harga = $this->jumlah * $this->harga;
        }
    }

    /**
     * Menyimpan data transaksi barang keluar ke database dan memperbarui stok barang.
     *
     * @return \Illuminate\Http\RedirectResponse Redirect ke halaman transaksi barang keluar dengan pesan sukses.
     */
    public function save()
    {
        $this->validate();

        // Simpan transaksi barang keluar
        TrxBarangKeluar::create([
            'id_barang' => $this->id_barang,
            'jumlah_brgkeluar' => $this->jumlah,
            'tanggal_keluar' => $this->tanggal_keluar,
            'harga' => $this->harga,
            'total_harga' => $this->total_harga,
            'id_admin' => $this->id_admin,
        ]);

        // Kurangi stok barang
        Barang::where('id_barang', $this->id_barang)->decrement('stok', $this->jumlah);

        $this->reset(['id_barang', 'jumlah', 'tanggal_keluar', 'id_admin', 'harga', 'total_harga']);
        return redirect('/trx-barang-keluar')->with('success', 'Barang keluar berhasil ditambahkan dan stok diperbarui!');
    }

    /**
     * Merender tampilan Livewire untuk menambahkan transaksi barang keluar.
     *
     * @return \Illuminate\View\View Tampilan Livewire.
     */
    public function render()
    {
        return view('livewire.trx-barang-keluar.add', [
            'barangs' => Barang::where('nama_barang', 'like', '%' . $this->searchBarang . '%')
                                ->limit(5)
                                ->get(),
            'admins' => Admin::where('nama_admin', 'like', '%' . $this->searchAdmin . '%')
                              ->limit(5)
                              ->get(),
        ]);
    }
}
