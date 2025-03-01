<?php

namespace App\Http\Livewire\Transaksi;

use Livewire\Component;
use App\Models\Transaksi;
use Carbon\Carbon;

class Add extends Component
{
    public $id_pelanggan, $id_point, $id_paket, $tanggal_transaksi, $total_harga, $metode_pembayaran, $status_pembayaran, $status_transaksi, $jumlah_point;

    protected $rules = [
        'id_pelanggan' => 'required|exists:pelanggans,id_pelanggan',
        'id_point' => 'nullable|exists:points,id_point',
        'id_paket' => 'required|exists:pakets,id_paket',
        'tanggal_transaksi' => 'required|date',
        'total_harga' => 'required|numeric',
        'metode_pembayaran' => 'required|string|max:50',
        'status_pembayaran' => 'required|string|max:50',
        'status_transaksi' => 'required|string|max:50',
        'jumlah_point' => 'nullable|integer',
    ];

    public function save()
    {
        $this->validate();

        Transaksi::create([
            'id_pelanggan' => $this->id_pelanggan,
            'id_point' => $this->id_point,
            'id_paket' => $this->id_paket,
            'tanggal_transaksi' => $this->tanggal_transaksi,
            'total_harga' => $this->total_harga,
            'metode_pembayaran' => $this->metode_pembayaran,
            'status_pembayaran' => $this->status_pembayaran,
            'status_transaksi' => $this->status_transaksi,
            'jumlah_point' => $this->jumlah_point,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $this->reset();
        return redirect('/transaksi');
    }

    public function render()
    {
        return view('livewire.transaksi.add');
    }
}
