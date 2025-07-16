<?php

namespace App\Http\Livewire\TrxBarangMasuk;

use Livewire\Component;
use App\Models\TrxBarangMasuk;
use App\Models\Barang;
use App\Models\Admin;

class Add extends Component
{
    // global fields
    public $tanggal_masuk;
    public $id_admin;

    // multi-item
    public $items = []; // tiap elemen: ['id_barang','jumlah','harga','subtotal']

    // search/autocomplete
    public $searchBarang = '', $searchAdmin = '';
    public $focusedBarang = false, $focusedAdmin = false;

    protected function rules()
    {
        return [
            'id_admin'         => 'required|exists:admins,id_admin',
            'tanggal_masuk'    => 'required|date',
            'items'            => 'required|array|min:1',
            'items.*.id_barang'=> 'required|exists:barangs,id_barang',
            'items.*.jumlah'   => 'required|integer|min:1',
        ];
    }

    // Custom validation messages
    protected function messages()
    {
        return [
            'id_admin.required' => 'Admin harus dipilih.',
            'tanggal_masuk.required' => 'Tanggal masuk harus diisi.',
            'items.required' => 'Minimal harus ada satu item barang.',
            'items.*.id_barang.required' => 'Barang harus dipilih.',
            'items.*.jumlah.required' => 'Jumlah harus diisi.',
            'items.*.jumlah.min' => 'Jumlah minimal adalah 1.',
        ];
    }

    public function mount()
    {
        $this->tanggal_masuk = now()->format('Y-m-d');
        $this->addItem();
    }

    public function updated($name, $value)
    {
        // autocomplete admin
        if ($name === 'id_admin') {
            $this->searchAdmin = '';
        }

        // handle dynamic items.* fields
        if (preg_match('/^items\.(\d+)\.(\w+)$/', $name, $m)) {
            [$all,$i,$field] = $m;

            // when id_barang changes, load harga
            if ($field === 'id_barang') {
                $barang = Barang::find($value);
                $this->items[$i]['harga'] = $barang?->harga ?? 0;
            }

            // Pastikan jumlah tidak kosong atau null
            if ($field === 'jumlah' && (empty($value) || $value === '' || $value === null)) {
                $this->items[$i]['jumlah'] = 0;
            }

            // recalc subtotal
            $j = $this->items[$i]['jumlah'] ?? 0;
            $h = $this->items[$i]['harga']  ?? 0;

            // Konversi ke numeric untuk memastikan kalkulasi yang benar
            $j = is_numeric($j) ? (int)$j : 0;
            $h = is_numeric($h) ? (float)$h : 0;

            $this->items[$i]['subtotal'] = $j * $h;
        }
    }

    public function addItem()
    {
        $this->items[] = [
            'id_barang' => null,
            'jumlah'    => 0,
            'harga'     => 0,
            'subtotal'  => 0,
        ];
    }

    public function removeItem($idx)
    {
        unset($this->items[$idx]);
        $this->items = array_values($this->items);
    }

    /**
     * Validasi items sebelum menyimpan
     * Memastikan ada minimal satu item dengan jumlah > 0
     */
    private function validateItems()
    {
        $validItems = 0;

        foreach ($this->items as $index => $item) {
            if (!empty($item['id_barang'])) {
                $jumlah = is_numeric($item['jumlah']) ? (int)$item['jumlah'] : 0;

                if ($jumlah > 0) {
                    $validItems++;
                }
            }
        }

        if ($validItems === 0) {
            $this->addError('items', 'Minimal harus ada satu item dengan jumlah lebih dari 0.');
            return false;
        }

        return true;
    }

    public function save()
    {
        // Validasi input dasar
        $this->validate();

        // Validasi items
        if (!$this->validateItems()) {
            return; // Berhenti jika tidak ada item valid
        }

        // Mulai database transaction untuk memastikan konsistensi data
        \DB::beginTransaction();

        try {
            foreach ($this->items as $row) {
                // Skip item jika jumlah 0 atau kosong
                $jumlah = is_numeric($row['jumlah']) ? (int)$row['jumlah'] : 0;
                if ($jumlah <= 0) {
                    continue;
                }

                // Buat record TrxBarangMasuk
                TrxBarangMasuk::create([
                    'id_barang'      => $row['id_barang'],
                    'jumlah_brgmasuk'=> $jumlah,
                    'tanggal_masuk'  => $this->tanggal_masuk,
                    'harga'          => $row['harga'],
                    'total_harga'    => $row['subtotal'],
                    'id_admin'       => $this->id_admin,
                ]);

                // Tambah stok barang
                Barang::find($row['id_barang'])?->increment('stok', $jumlah);
            }

            \DB::commit();
            session()->flash('success','Beberapa barang masuk berhasil disimpan.');
            return redirect()->route('trx-barang-masuk');

        } catch (\Exception $e) {
            \DB::rollback();
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.trx-barang-masuk.add', [
            'barangs' => Barang::where('nama_barang','like',"%{$this->searchBarang}%")
                               ->limit(5)->get(),
            'admins'  => Admin::where('nama_admin','like',"%{$this->searchAdmin}%")
                              ->limit(5)->get(),
        ]);
    }
}
