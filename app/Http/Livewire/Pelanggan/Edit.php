<?php

namespace App\Http\Livewire\Pelanggan;

use Livewire\Component;
use App\Models\Pelanggan;

class Edit extends Component
{
    public $showModal = false;
    public $id_pelanggan, $nama_pelanggan, $no_telp, $alamat, $keterangan;

    public function mount($id_pelanggan)
    {
        $pelanggan = Pelanggan::findOrFail($id_pelanggan);
        $this->id_pelanggan = $pelanggan->id_pelanggan;
        $this->nama_pelanggan = $pelanggan->nama_pelanggan;
        $this->no_telp = $pelanggan->no_telp;
        $this->alamat = $pelanggan->alamat;
        $this->keterangan = $pelanggan->keterangan;
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function update()
    {
        Pelanggan::where('id_pelanggan', $this->id_pelanggan)->update([
            'nama_pelanggan' => $this->nama_pelanggan,
            'no_telp' => $this->no_telp,
            'alamat' => $this->alamat,
            'keterangan' => $this->keterangan,
        ]);

        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.pelanggan.edit');
    }
}

