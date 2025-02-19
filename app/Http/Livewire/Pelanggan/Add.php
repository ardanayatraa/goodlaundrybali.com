<?php

namespace App\Http\Livewire\Pelanggan;

use Livewire\Component;
use App\Models\Pelanggan;

class Add extends Component
{
    public $showModal = false;
    public $nama_pelanggan, $no_telp, $alamat, $keterangan;

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->reset(['showModal', 'nama_pelanggan', 'no_telp', 'alamat', 'keterangan']);
    }

    public function save()
    {
        Pelanggan::create([
            'nama_pelanggan' => $this->nama_pelanggan,
            'no_telp' => $this->no_telp,
            'alamat' => $this->alamat,
            'keterangan' => $this->keterangan,
        ]);

        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.pelanggan.add');
    }
}
