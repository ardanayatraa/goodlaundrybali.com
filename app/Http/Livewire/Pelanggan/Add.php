<?php

namespace App\Http\Livewire\Pelanggan;

use App\Models\Pelanggan;
use Livewire\Component;

class Add extends Component
{
    public $nama_pelanggan;
    public $no_telp;
    public $alamat;
    public $keterangan;

    public $isOpen = false;

    protected $rules = [
        'nama_pelanggan' => 'required|string|max:255',
        'no_telp' => 'required|string|max:20',
        'alamat' => 'required|string',
        'keterangan' => 'nullable|string',
    ];

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->reset(['nama_pelanggan', 'no_telp', 'alamat', 'keterangan']);
        $this->isOpen = false;
    }

    public function save()
    {
        $this->validate();

        Pelanggan::create([
            'nama_pelanggan' => $this->nama_pelanggan,
            'no_telp' => $this->no_telp,
            'alamat' => $this->alamat,
            'keterangan' => $this->keterangan,
        ]);

        session()->flash('message', 'Pelanggan berhasil ditambahkan.');

        $this->closeModal();

        $this->emit('refreshPelangganTable');
    }

    public function render()
    {
        return view('livewire.pelanggan.add');
    }
}
