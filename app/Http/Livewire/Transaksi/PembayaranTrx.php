<?php

namespace App\Http\Livewire\Transaksi;

use Livewire\Component;
use App\Models\Transaksi;

class PembayaranTrx extends Component
{
    public $transaksiId;
    public $transaksi;
    public $showForm    = false;
    public $jumlah_bayar;
    public $kembalian   = 0;

    protected $listeners = [
        'openPaymentForm' => 'handleOpenPaymentForm',
        'paymentSaved'    => 'loadTransaksi',
    ];

    protected function rules()
    {
        return [
            'jumlah_bayar' => 'required|numeric|min:0',
        ];
    }

    // make the mount parameter optional
    public function mount($transaksiId = null)
    {
        $this->transaksiId = $transaksiId;
        if ($transaksiId) {
            $this->loadTransaksi();
        }
    }

    public function loadTransaksi()
    {
        if (! $this->transaksiId) return;

        $this->transaksi    = Transaksi::findOrFail($this->transaksiId);
        $this->jumlah_bayar = $this->transaksi->jumlah_bayar;
        $this->calculateKembalian();
    }

    public function handleOpenPaymentForm($payload)
    {
        // payload should contain transaksiId
        if (! empty($payload['transaksiId'])) {
            $this->transaksiId = $payload['transaksiId'];
            $this->loadTransaksi();
            $this->showForm = true;
        }
    }

    public function openForm()
    {
        // still allow manual open via wire:click
        if ($this->transaksiId) {
            $this->showForm = true;
        }
    }

    public function cancel()
    {
        $this->showForm = false;
        $this->loadTransaksi();
    }

    public function updatedJumlahBayar($value)
    {
        $this->calculateKembalian();
    }

    private function calculateKembalian()
    {
        if (! $this->transaksi) return;
        $this->kembalian = max(0, $this->jumlah_bayar - $this->transaksi->total_harga);
    }

    public function savePayment()
    {
        $this->validate();

        $this->transaksi->update([
            'jumlah_bayar'      => $this->jumlah_bayar,
            'kembalian'         => $this->kembalian,
            'status_pembayaran' => 'Lunas',
        ]);

        session()->flash('success', 'Pembayaran berhasil disimpan.');

        $this->showForm = false;
        $this->loadTransaksi();

        // notify parent/detail to refresh totals
        $this->emitUp('paymentSaved');
    }

    public function render()
    {
        return view('livewire.transaksi.pembayaran-trx');
    }
}
