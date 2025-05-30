<?php

namespace App\Http\Livewire\TrxBarangKeluar;

use Livewire\Component;
use App\Models\TrxBarangKeluar;
use App\Models\Barang;
use App\Models\Admin;

class Add extends Component
{
    public $id_barang;
    public $jumlah;
    public $tanggal_keluar;
    public $id_admin;
    public $harga = 0;
    public $total_harga = 0;

    public $searchBarang = '';
    public $searchAdmin = '';
    public $focusedBarang = false;
    public $focusedAdmin = false;

    protected function rules()
    {
        return [
            'id_barang'       => 'required|exists:barangs,id_barang',
            'jumlah'          => [
                'required',
                'integer',
                'min:1',
                // closure rule untuk cek stok
                function ($attribute, $value, $fail) {
                    $barang = Barang::find($this->id_barang);
                    if (! $barang) {
                        return $fail('Barang tidak ditemukan.');
                    }
                    if ($value > $barang->stok) {
                        $fail("Stok tersisa {$barang->stok}, tidak cukup untuk keluar {$value}.");
                    }
                },
            ],
            'tanggal_keluar'  => 'required|date',
            'id_admin'        => 'required|exists:admins,id_admin',
        ];
    }

    // setiap properti update, recalc harga dan total
    public function updated($property)
    {
        if ($property === 'id_barang' && $this->id_barang) {
            $this->harga = Barang::find($this->id_barang)->harga ?? 0;
        }

        if (in_array($property, ['id_barang', 'jumlah'])) {
            $this->total_harga = $this->jumlah * $this->harga;
        }
    }

    public function save()
    {
        $this->validate();

        // simpan transaksi keluar
        TrxBarangKeluar::create([
            'id_barang'        => $this->id_barang,
            'jumlah_brgkeluar' => $this->jumlah,
            'tanggal_keluar'   => $this->tanggal_keluar,
            'harga'            => $this->harga,
            'total_harga'      => $this->total_harga,
            'id_admin'         => $this->id_admin,
        ]);

        // kurangi stok
        Barang::where('id_barang', $this->id_barang)
              ->decrement('stok', $this->jumlah);

        // reset form
        $this->reset(['id_barang', 'jumlah', 'tanggal_keluar', 'id_admin', 'harga', 'total_harga']);
        session()->flash('success', 'Barang keluar berhasil ditambahkan.');
        return redirect()->route('trx-barang-keluar.index');
    }

    public function render()
    {
        return view('livewire.trx-barang-keluar.add', [
            'barangs' => Barang::where('nama_barang', 'like', '%'.$this->searchBarang.'%')
                               ->limit(5)->get(),
            'admins'  => Admin::where('nama_admin', 'like', '%'.$this->searchAdmin.'%')
                               ->limit(5)->get(),
        ]);
    }
}
