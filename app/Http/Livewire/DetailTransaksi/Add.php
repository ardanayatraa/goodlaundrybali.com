<?php

namespace App\Http\Livewire\DetailTransaksi;

use Livewire\Component;
use App\Models\DetailTransaksi;

class Add extends Component
{
    public $id_transaksi, $id_paket, $jumlah, $subtotal;
    public $showModal = false;

    public function openModal()
    {
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'id_transaksi' => 'required|exists:transaksis,id_transaksi',
            'id_paket' => 'required|exists:pakets,id_paket',
            'jumlah' => 'required|integer|min:1',
            'subtotal' => 'required|numeric',
        ]);

        DetailTransaksi::create([
            'id_transaksi' => $this->id_transaksi,
            'id_paket' => $this->id_paket,
            'jumlah' => $this->jumlah,
            'subtotal' => $this->subtotal,
        ]);

        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.detail-transaksi.add');
    }
}
