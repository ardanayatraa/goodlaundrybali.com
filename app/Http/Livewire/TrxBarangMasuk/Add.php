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

    protected $rules = [
        'id_admin'         => 'required|exists:admins,id_admin',
        'tanggal_masuk'    => 'required|date',
        'items'            => 'required|array|min:1',
        'items.*.id_barang'=> 'required|exists:barangs,id_barang',
        'items.*.jumlah'   => 'required|integer|min:1',
    ];

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

            // recalc subtotal
            $j = $this->items[$i]['jumlah'] ?? 1;
            $h = $this->items[$i]['harga']  ?? 0;
            $this->items[$i]['subtotal'] = $j * $h;
        }
    }

    public function addItem()
    {
        $this->items[] = [
            'id_barang' => null,
            'jumlah'    => 1,
            'harga'     => 0,
            'subtotal'  => 0,
        ];
    }

    public function removeItem($idx)
    {
        unset($this->items[$idx]);
        $this->items = array_values($this->items);
    }

    public function save()
    {
        $this->validate();

        foreach ($this->items as $row) {
            TrxBarangMasuk::create([
                'id_barang'      => $row['id_barang'],
                'jumlah_brgmasuk'=> $row['jumlah'],
                'tanggal_masuk'  => $this->tanggal_masuk,
                'harga'          => $row['harga'],
                'total_harga'    => $row['subtotal'],
                'id_admin'       => $this->id_admin,
            ]);

            Barang::find($row['id_barang'])?->increment('stok', $row['jumlah']);
        }

        session()->flash('success','Beberapa barang masuk berhasil disimpan.');
        return redirect()->route('trx-barang-masuk');
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
