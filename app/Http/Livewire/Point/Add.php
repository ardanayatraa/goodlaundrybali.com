<?php

namespace App\Http\Livewire\Point;

use Livewire\Component;
use App\Models\Point;

class Add extends Component
{
    public $id_pelanggan, $tanggal, $jumlah_point;
    public $searchPelanggan = '', $focusedPelanggan = false;

    protected $rules = [
        'id_pelanggan' => 'required|exists:pelanggans,id_pelanggan',
        'tanggal' => 'required|date',
        'jumlah_point' => 'required|integer|min:0',
    ];

    /**
     * Menyimpan data point baru ke database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save()
    {
        $this->validate();

        Point::create([
            'id_pelanggan' => $this->id_pelanggan,
            'tanggal' => $this->tanggal,
            'jumlah_point' => $this->jumlah_point,
        ]);

        $this->reset();
        return redirect('/point');
    }

    /**
     * Merender tampilan komponen Livewire.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.point.add', [
            'pelanggans' => \App\Models\Pelanggan::where('nama_pelanggan', 'like', '%' . $this->searchPelanggan . '%')
                                ->limit(5)
                                ->get(),
        ]);
    }
}
