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

    /**
     * Inisialisasi data pelanggan berdasarkan ID pelanggan.
     *
     * @param int $id_pelanggan
     * @return void
     */
    public function mount($id_pelanggan)
    {
        $pelanggan = Pelanggan::findOrFail($id_pelanggan);
        $this->id_pelanggan = $pelanggan->id_pelanggan;
        $this->nama_pelanggan = $pelanggan->nama_pelanggan;
        $this->no_telp = $pelanggan->no_telp;
        $this->alamat = $pelanggan->alamat;
        $this->keterangan = $pelanggan->keterangan;
    }

    /**
     * Perbarui data pelanggan di database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        $this->validate();

        // Ensure no_telp starts with 62
        if (substr($this->no_telp, 0, 1) === '0') {
            $this->no_telp = '62' . substr($this->no_telp, 1);
        }

        Pelanggan::where('id_pelanggan', $this->id_pelanggan)->update([
            'nama_pelanggan' => $this->nama_pelanggan,
            'no_telp' => $this->no_telp,
            'alamat' => $this->alamat,
            'keterangan' => $this->keterangan,
        ]);

        return redirect('/pelanggan');
    }

    /**
     * Render tampilan komponen Livewire.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.pelanggan.edit');
    }
}
