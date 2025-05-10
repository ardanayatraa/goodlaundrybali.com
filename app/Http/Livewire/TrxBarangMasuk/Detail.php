<?php

namespace App\Http\Livewire\TrxBarangMasuk;

use Livewire\Component;
use App\Models\TrxBarangMasuk;

class Detail extends Component
{
    /**
     * ID transaksi barang masuk
     *
     * @var int
     */
    public $trxMasukId;

    /**
     * Model TrxBarangMasuk yang dimuat
     *
     * @var \App\Models\TrxBarangMasuk
     */
    public TrxBarangMasuk $masuk;

    /**
     * Inisialisasi komponen dengan ID transaksi.
     *
     * @param  int  $trxMasukId  Parameter {id} dari route
     * @return void
     */
    public function mount($trxMasukId)
    {
        $this->trxMasukId = $trxMasukId;
        $this->masuk = TrxBarangMasuk::with(['barang', 'admin'])
            ->findOrFail($this->trxMasukId);
    }

    /**
     * Render view untuk komponen ini.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.trx-barang-masuk.detail', [
            'masuk'        => $this->masuk,
            'trxMasukId'   => $this->trxMasukId,
        ]);
    }
}
