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
     * Model Transaksi dengan relasi pelanggan, paket, dan detailTransaksi.
     *
     * @var \App\Models\Transaksi
     */
    public $transaksi;

    /**
     * Inisialisasi komponen dengan ID transaksi.
     *
     * @param int $transaksiId ID transaksi yang diberikan dari route
     * @return void
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     *         Jika transaksi dengan ID tersebut tidak ditemukan.
     */
    public function mount($transaksiId)
    {
        $this->transaksiId = $transaksiId;
        // Muat transaksi beserta relasi pelanggan, paket, dan detailTransaksi
        $this->transaksi = Transaksi::with(['pelanggan', 'paket', 'detailTransaksi'])
            ->findOrFail($this->transaksiId);
    }

    /**
     * Render view untuk komponen ini.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.transaksi.detail');
    }
}
