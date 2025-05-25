<?php

namespace App\Http\Livewire\Transaksi;

use Livewire\Component;
use App\Models\Transaksi;

class Detail extends Component
{
    /**
     * ID transaksi yang akan diambil datanya.
     *
     * @var int
     */
    public $transaksiId;

    /**
     * Model Transaksi beserta relasi pelanggan dan detailTransaksi->paket.
     *
     * @var \App\Models\Transaksi
     */
    public $transaksi;

    /**
     * Inisialisasi komponen dengan ID transaksi.
     *
     * @param int $transaksiId
     */
    public function mount($transaksiId)
    {
        $this->transaksiId = $transaksiId;
        $this->transaksi = Transaksi::with([
                'pelanggan',
                'detailTransaksi.paket'
            ])
            ->findOrFail($this->transaksiId);
    }

    public function render()
    {
        return view('livewire.transaksi.detail');
    }
}
