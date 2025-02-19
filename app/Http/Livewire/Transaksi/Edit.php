<?php

namespace App\Http\Livewire\Transaksi;

use Livewire\Component;
use App\Models\Transaksi;

class Edit extends Component
{
    public $id_transaksi, $id_pelanggan, $id_point, $id_paket, $tanggal_transaksi, $total_harga, $metode_pembayaran, $status_pembayaran, $status_transaksi, $jumlah_point;
    public $showModal = false;

    public function mount($id_transaksi)
    {
        $transaksi = Transaksi::findOrFail($id_transaksi);
        $this->id_transaksi = $transaksi->id_transaksi;
        $this->id_pelanggan = $transaksi->id_pelanggan;
        $this->id_point = $transaksi->id_point;
        $this->id_paket = $transaksi->id_paket;
        $this->tanggal_transaksi = $transaksi->tanggal_transaksi;
        $this->total_harga = $transaksi->total_harga;
        $this->metode_pembayaran = $transaksi->metode_pembayaran;
        $this->status_pembayaran = $transaksi->status_pembayaran;
        $this->status_transaksi = $transaksi->status_transaksi;
        $this->jumlah_point = $transaksi->jumlah_point;
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate([
            'id_pelanggan' => 'required|exists:pelanggans,id_pelanggan',
            'id_paket' => 'required|exists:pakets,id_paket',
            'tanggal_transaksi' => 'required|date',
            'total_harga' => 'required|numeric',
            'metode_pembayaran' => 'required|string|max:50',
            'status_pembayaran' => 'required|string|max:50',
            'status_transaksi' => 'required|string|max:50',
            'jumlah_point' => 'nullable|integer',
        ]);

        Transaksi::where('id_transaksi', $this->id_transaksi)->update([
            'id_pelanggan' => $this->id_pelanggan,
            'id_paket' => $this->id_paket,
            'tanggal_transaksi' => $this->tanggal_transaksi,
            'total_harga' => $this->total_harga,
            'metode_pembayaran' => $this->metode_pembayaran,
            'status_pembayaran' => $this->status_pembayaran,
            'status_transaksi' => $this->status_transaksi,
            'jumlah_point' => $this->jumlah_point,
        ]);

        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.transaksi.edit');
    }
}
