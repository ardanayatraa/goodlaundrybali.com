<?php

namespace App\Http\Livewire\Transaksi;

use Livewire\Component;
use App\Models\Transaksi;

class Add extends Component
{
    public $nama_pelanggan;
    public $tanggal_transaksi;
    public $total_harga;
    public $metode_pembayaran;
    public $status_pembayaran;
    public $status_transaksi;
    public $jumlah_point = 0;
    public $status_bonus;
    public $showModal = false;

    protected $rules = [
        'nama_pelanggan' => 'required|string|max:255',
        'tanggal_transaksi' => 'required|date',
        'total_harga' => 'required|numeric|min:0',
        'metode_pembayaran' => 'required|string|max:255',
        'status_pembayaran' => 'required|string|max:255',
        'status_transaksi' => 'required|string|max:255',
        'jumlah_point' => 'nullable|integer|min:0',
        'status_bonus' => 'nullable|string|max:255',
    ];

    public function submit()
    {
        $this->validate();

        Transaksi::create([
            'nama_pelanggan' => $this->nama_pelanggan,
            'tanggal_transaksi' => $this->tanggal_transaksi,
            'total_harga' => $this->total_harga,
            'metode_pembayaran' => $this->metode_pembayaran,
            'status_pembayaran' => $this->status_pembayaran,
            'status_transaksi' => $this->status_transaksi,
            'jumlah_point' => $this->jumlah_point,
            'status_bonus' => $this->status_bonus,
        ]);

        $this->reset(['nama_pelanggan', 'tanggal_transaksi', 'total_harga', 'metode_pembayaran', 'status_pembayaran', 'status_transaksi', 'jumlah_point', 'status_bonus']);
        $this->showModal = false;
        session()->flash('success', 'Transaksi berhasil ditambahkan!');
    }

    public function render()
    {
        return view('livewire.transaksi.add');
    }
}
