<?php

namespace App\Http\Livewire\TrxBarangMasuk;

use Livewire\Component;
use App\Models\TrxBarangMasuk;
use Illuminate\Support\Carbon;

class DetailByDate extends Component
{
    /** @var string */
    public $tanggal;

    /** @var \Illuminate\Database\Eloquent\Collection */
    public $records;

    /**
     * Inisialisasi komponen dengan tanggal dari route
     *
     * @param  string  $tanggal  format YYYY-MM-DD
     * @return void
     */
    public function mount($tanggal)
    {
        // Simpan tanggal
        $this->tanggal = $tanggal;

        // Ambil semua transaksi masuk di tanggal tersebut
        $this->records = TrxBarangMasuk::with(['barang.unit', 'admin'])
            ->whereDate('tanggal_masuk', $this->tanggal)
            ->orderBy('id_trx_brgmasuk', 'asc')
            ->get();
    }

    public function render()
    {
        return view('livewire.trx-barang-masuk.detail-by-date', [
            'records'  => $this->records,
            'tanggal'  => $this->tanggal,
        ]);
    }
}
