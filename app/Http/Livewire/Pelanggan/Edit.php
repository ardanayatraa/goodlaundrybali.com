<?php

namespace App\Http\Livewire\Pelanggan;

use Livewire\Component;
use App\Models\Pelanggan;
use Illuminate\Support\Carbon;

class Edit extends Component
{
    public $id_pelanggan, $nama_pelanggan, $no_telp, $alamat, $keterangan;

    protected $rules = [
        'nama_pelanggan' => 'required|string|max:255',
        'no_telp'        => 'required|string|max:15',
        'alamat'         => 'required|string|max:255',
        'keterangan'     => 'nullable|string|max:255',
    ];

    public function mount($id_pelanggan)
    {
        $pel = Pelanggan::findOrFail($id_pelanggan);
        $this->id_pelanggan  = $pel->id_pelanggan;
        $this->nama_pelanggan = $pel->nama_pelanggan;
        $this->no_telp        = $pel->no_telp;
        $this->alamat         = $pel->alamat;
        $this->keterangan     = $pel->keterangan;
    }

    public function update()
    {
        $this->validate();

        // Format nomor telepon
        if (substr($this->no_telp, 0, 1) === '0') {
            $this->no_telp = '62'.substr($this->no_telp, 1);
        }

        // Ambil record lama untuk cek perubahan keterangan
        $pel = Pelanggan::findOrFail($this->no_telp);

        // Siapkan data update
        $data = [
            'nama_pelanggan' => $this->nama_pelanggan,
            'no_telp'        => $this->no_telp,
            'alamat'         => $this->alamat,
            'keterangan'     => $this->keterangan,
        ];

        // Jika berubah dari non‐Member → Member, isi member_start_at
        if (
            strtolower($pel->keterangan) !== 'member' &&
            strtolower($this->keterangan) === 'member'
        ) {
            $data['member_start_at'] = Carbon::now();
        }

        Pelanggan::where('no_telp', $this->no_telp)
                 ->update($data);

        return redirect()->route('pelanggan');
    }

    public function render()
    {
        return view('livewire.pelanggan.edit');
    }
}
