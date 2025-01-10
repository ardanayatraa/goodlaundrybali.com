<?php

namespace App\Http\Livewire\Paket;

use Livewire\Component;
use App\Models\Paket;

class Add extends Component
{
    public $jenis_paket;
    public $harga;
    public $waktu_pengerjaan;
    public $showModal = false; // Untuk kontrol modal

    protected $rules = [
        'jenis_paket' => 'required|string|max:255',
        'harga' => 'required|numeric|min:0',
        'waktu_pengerjaan' => 'required|integer|min:1',
    ];

    public function submit()
    {
        $validatedData = $this->validate();

        Paket::create($validatedData);

        session()->flash('success', 'Paket berhasil ditambahkan.');
        $this->resetExcept('showModal'); // Hanya reset input, modal tetap terbuka
        $this->emit('refreshLivewireDatatable '); // Untuk refresh datatable
        $this->showModal = false; // Tutup modal setelah submit
    }

    public function render()
    {
        return view('livewire.paket.add');
    }
}
