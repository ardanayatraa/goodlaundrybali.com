<?php

namespace App\Http\Livewire\TrxBarangKeluar;

use Livewire\Component;
use App\Models\TrxBarangKeluar;

class DetailByDate extends Component
{
    /** @var string yyyy-mm-dd */
    public $tanggal;

    /** @var \Illuminate\Database\Eloquent\Collection */
    public $records;

    /**
     * Mount dengan parameter tanggal dari route
     */
    public function mount($tanggal)
    {
        $this->tanggal = $tanggal;

        $this->records = TrxBarangKeluar::with(['barang.unit', 'admin'])
            ->whereDate('tanggal_keluar', $this->tanggal)
            ->orderBy('id_trx_brgkeluar', 'asc')
            ->get();
    }

    public function render()
    {
        return view('livewire.trx-barang-keluar.detail-by-date', [
            'records' => $this->records,
            'tanggal' => $this->tanggal,
        ]);
    }
}
