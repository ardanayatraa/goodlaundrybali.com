<?php

namespace App\Http\Livewire\Pelanggan;

use Livewire\Component;
use App\Models\Pelanggan;

class Add extends Component
{
    public $nama_pelanggan, $no_telp, $alamat, $keterangan;

    protected $rules = [
        'nama_pelanggan' => 'required|string|max:100',
        'no_telp' => 'required|string|max:15',
        'alamat' => 'required|string|max:255',
        'keterangan' => 'nullable|string|max:255',
    ];

    /**
     * Simpan data pelanggan baru ke database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save()
    {
        $this->validate();

        // Format no_telp to start with 62 if it begins with 0
        if (substr($this->no_telp, 0, 1) === '0') {
            $this->no_telp = '62' . substr($this->no_telp, 1);
        }

        Pelanggan::create([
            'nama_pelanggan' => $this->nama_pelanggan,
            'no_telp' => $this->no_telp,
            'alamat' => $this->alamat,
            'keterangan' => $this->keterangan,
        ]);

        // Reset form setelah simpan
        $this->reset();
        return redirect('/pelanggan');
    }

    /**
     * Render tampilan komponen Livewire.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.pelanggan.add');
    }
}
