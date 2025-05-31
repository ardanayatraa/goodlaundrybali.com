<?php

namespace App\Http\Livewire\TrxBarangKeluar;

use Livewire\Component;
use App\Models\TrxBarangKeluar;
use App\Models\Barang;
use App\Models\Admin;

class Add extends Component
{
    // Global fields
    public $tanggal_keluar;
    public $id_admin;

    // Multi‐item: tiap elemen ['id_barang', 'jumlah', 'harga', 'subtotal']
    public $items = [];

    // Search/autocomplete
    public $searchBarang = '';
    public $searchAdmin  = '';
    public $focusedBarang = false;
    public $focusedAdmin  = false;

    // Aturan validasi
    protected function rules()
    {
        return [
            'id_admin'           => 'required|exists:admins,id_admin',
            'tanggal_keluar'     => 'required|date',
            'items'              => 'required|array|min:1',
            'items.*.id_barang'  => 'required|exists:barangs,id_barang',
            'items.*.jumlah'     => 'required|integer|min:1',
        ];
    }

    public function mount()
    {
        // Set default tanggal ke hari ini
        $this->tanggal_keluar = now()->format('Y-m-d');
        $this->addItem();
    }

    /**
     * Ketika properti berubah,
     * - Jika field id_admin di‐set, kosongkan searchAdmin
     * - Jika items.* field berubah:
     *   • saat id_barang berubah → load harga
     *   • recalc subtotal = jumlah * harga
     */
    public function updated($name, $value)
    {
        // Autocomplete admin
        if ($name === 'id_admin') {
            $this->searchAdmin = '';
        }

        // Tangani perubahan pada items.[index].*
        if (preg_match('/^items\.(\d+)\.(\w+)$/', $name, $m)) {
            [$all, $i, $field] = $m;

            // Jika id_barang berubah → load harga
            if ($field === 'id_barang') {
                $barang = Barang::find($value);
                $this->items[$i]['harga'] = $barang?->harga ?? 0;
            }

            // Ambil nilai jumlah & harga saat ini, lalu recalc subtotal
            $j = $this->items[$i]['jumlah'] ?? 1;
            $h = $this->items[$i]['harga']  ?? 0;
            $this->items[$i]['subtotal'] = $j * $h;
        }
    }

    /** Tambah baris item baru */
    public function addItem()
    {
        $this->items[] = [
            'id_barang' => null,
            'jumlah'    => 1,
            'harga'     => 0,
            'subtotal'  => 0,
        ];
    }

    /** Hapus satu baris item (by index) */
    public function removeItem($idx)
    {
        unset($this->items[$idx]);
        $this->items = array_values($this->items);
    }

    /** Simpan seluruh items ke tabel trx_barang_keluar dan kurangi stok */
    public function save()
    {
        $this->validate();

        foreach ($this->items as $row) {
            // Buat record TrxBarangKeluar
            TrxBarangKeluar::create([
                'id_barang'        => $row['id_barang'],
                'jumlah_brgkeluar' => $row['jumlah'],
                'tanggal_keluar'   => $this->tanggal_keluar,
                'harga'            => $row['harga'],
                'total_harga'      => $row['subtotal'],
                'id_admin'         => $this->id_admin,
            ]);

            // Kurangi stok barang
            Barang::find($row['id_barang'])?->decrement('stok', $row['jumlah']);
        }

        session()->flash('success', 'Beberapa barang keluar berhasil disimpan.');
        return redirect()->route('trx-barang-keluar');
    }

    public function render()
    {
        return view('livewire.trx-barang-keluar.add', [
            'barangs' => Barang::where('nama_barang', 'like', "%{$this->searchBarang}%")
                               ->limit(5)
                               ->get(),
            'admins'  => Admin::where('nama_admin', 'like', "%{$this->searchAdmin}%")
                              ->limit(5)
                              ->get(),
        ]);
    }
}
