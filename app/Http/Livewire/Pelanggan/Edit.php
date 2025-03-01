<?php

namespace App\Http\Livewire\Pelanggan;

use Livewire\Component;
use App\Models\Pelanggan;

class Edit extends Component
{
    public $id_pelanggan, $nama_pelanggan, $no_telp, $alamat, $keterangan;

    protected $rules = [
        'nama_pelanggan' => 'required|string|max:255',
        'no_telp' => 'required|string|max:15',
        'alamat' => 'required|string|max:255',
        'keterangan' => 'nullable|string|max:255',
    ];

    public function mount($id_pelanggan)
    {
        $pelanggan = Pelanggan::findOrFail($id_pelanggan);
        $this->id_pelanggan = $pelanggan->id_pelanggan;
        $this->nama_pelanggan = $pelanggan->nama_pelanggan;
        $this->no_telp = $pelanggan->no_telp;
        $this->alamat = $pelanggan->alamat;
        $this->keterangan = $pelanggan->keterangan;
    }

    public function update()
    {
        $this->validate();

        Pelanggan::where('id_pelanggan', $this->id_pelanggan)->update([
            'nama_pelanggan' => $this->nama_pelanggan,
            'no_telp' => $this->no_telp,
            'alamat' => $this->alamat,
            'keterangan' => $this->keterangan,
        ]);

        return redirect('/pelanggan');
    }

    public function render()
    {
        return view('livewire.pelanggan.edit');
    }
}
