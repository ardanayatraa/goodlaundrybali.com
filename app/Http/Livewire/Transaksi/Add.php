<?php

namespace App\Http\Livewire\Transaksi;

use Livewire\Component;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Pelanggan;
use App\Models\Point;
use App\Models\Paket;
use Carbon\Carbon;

class Add extends Component
{
    public $id_pelanggan, $jumlah_point, $id_paket, $tanggal_transaksi, $total_harga, $metode_pembayaran, $status_pembayaran, $status_transaksi;
    public $tanggal_ambil, $jam_ambil, $jumlah, $total_diskon, $keterangan;
    public $searchPelanggan = '', $searchPaket = '';
    public $focusedPelanggan = false, $focusedPaket = false;

    protected $rules = [
        'id_pelanggan' => 'required|exists:pelanggans,id_pelanggan',
        'id_paket' => 'required|exists:pakets,id_paket',
        'tanggal_transaksi' => 'required|date',
        'total_harga' => 'required|numeric',
        'metode_pembayaran' => 'required|string|max:50',
        'status_pembayaran' => 'required|string|max:50',
        'status_transaksi' => 'required|string|max:50',
        'jumlah_point' => 'nullable|integer',
        'tanggal_ambil' => 'required|date',
        'jam_ambil' => 'required|date_format:H:i',
        'jumlah' => 'required|integer',
        'total_diskon' => 'nullable|numeric',
        'keterangan' => 'nullable|string|max:255',
    ];

    public function updatedIdPelanggan()
    {
        // Automatically fetch the latest jumlah_point for the selected pelanggan
        $this->jumlah_point = Point::where('id_pelanggan', $this->id_pelanggan)->latest('tanggal')->value('jumlah_point');
    }

    public function save()
    {
        $this->validate(); // Ensure all fields, including id_paket, are validated

        if (is_null($this->id_paket)) {
            session()->flash('error', 'Paket harus dipilih sebelum menyimpan transaksi.');
            return;
        }

        $transaksi = Transaksi::create([
            'id_pelanggan' => $this->id_pelanggan,
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

        DetailTransaksi::create([
            'id_transaksi' => $transaksi->id,
            'tanggal_ambil' => $this->tanggal_ambil,
            'jam_ambil' => $this->jam_ambil,
            'jumlah' => $this->jumlah,
            'total_diskon' => $this->total_diskon,
            'keterangan' => $this->keterangan,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $this->reset();
        return redirect('/transaksi');
    }

    public function render()
    {
        return view('livewire.transaksi.add', [
            'pelanggans' => Pelanggan::where('nama_pelanggan', 'like', '%' . $this->searchPelanggan . '%')->limit(5)->get(),
            'pakets' => Paket::where('jenis_paket', 'like', '%' . $this->searchPaket . '%')->limit(5)->get(),
        ]);
    }
}
