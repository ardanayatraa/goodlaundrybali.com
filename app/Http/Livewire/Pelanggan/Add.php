<?php

namespace App\Http\Livewire\Pelanggan;

use Livewire\Component;
use App\Models\Pelanggan;
use Illuminate\Support\Carbon;

class Add extends Component
{
    public $nama_pelanggan, $no_telp, $alamat, $keterangan;

    protected $rules = [
        'nama_pelanggan' => 'required|string|max:100',
        'no_telp'        => 'required|string|max:15',
        'alamat'         => 'required|string|max:255',
        'keterangan'     => 'nullable|string|max:255',
    ];

    public function save()
    {
        $this->validate();

        // Format nomor telepon
        if (substr($this->no_telp, 0, 1) === '0') {
            $this->no_telp = '62'.substr($this->no_telp, 1);
        }

        // Siapkan data dasar
        $data = [
            'nama_pelanggan'  => $this->nama_pelanggan,
            'no_telp'         => $this->no_telp,
            'alamat'          => $this->alamat,
            'keterangan'      => $this->keterangan,
        ];
        // Jika memilih “Member”, tambahkan member_start_at
        if (strtolower($this->keterangan) === 'member') {
            $data['member_start_at'] = Carbon::now();
        }

        Pelanggan::create($data);

        $this->reset();
        return redirect()->route('pelanggan');
    }

    public function render()
    {
        return view('livewire.pelanggan.add');
    }
}
