<?php

namespace App\Http\Livewire\TrxBarangKeluar;

use Livewire\Component;
use App\Models\TrxBarangKeluar;

/**
 * Komponen Livewire untuk menampilkan detail satu transaksi barang keluar.
 */
class Detail extends Component
{
    /**
     * ID transaksi barang keluar
     *
     * @var int
     */
    public $trxKeluarId;

    /**
     * Model TrxBarangKeluar yang dimuat
     *
     * @var \App\Models\TrxBarangKeluar
     */
    public TrxBarangKeluar $keluar;

    /**
     * Inisialisasi komponen dengan ID dari route.
     *
     * @param  int  $trxKeluarId  Placeholder {id} dari route
     * @return void
     */
    public function mount($trxKeluarId)
    {
        $this->trxKeluarId = $trxKeluarId;
        $this->keluar = TrxBarangKeluar::with(['barang', 'admin'])
            ->findOrFail($this->trxKeluarId);
    }

    /**
     * Render view untuk komponen ini.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.trx-barang-keluar.detail', [
            'keluar'       => $this->keluar,
            'trxKeluarId'  => $this->trxKeluarId,
        ]);
    }
}
