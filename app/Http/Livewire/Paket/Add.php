<?php

namespace App\Http\Livewire\Paket;

use Livewire\Component;
use App\Models\Paket;
use App\Models\Unit;

class Add extends Component
{
    public $jenis_paket, $harga, $waktu_pengerjaan, $id_unit;
    public $searchUnitPaket = '';
    public $focusedUnitPaket = false;

    protected $rules = [
        'jenis_paket' => 'required|string|max:50',
        'harga' => 'required|numeric|min:0',
        'waktu_pengerjaan' => 'required|string|max:50',

    ];

    /**
     * Menyimpan data paket baru ke database.
     * Melakukan validasi terlebih dahulu sebelum menyimpan.
     * Jika id_unit tidak valid, akan menampilkan pesan error.
     */
    public function save()
    {
        $this->validate();

        // Ensure id_unit is set and valid
        if (!Unit::find($this->id_unit)) {
            session()->flash('error', 'Invalid Unit Paket selected.');
            return;
        }

        Paket::create([
            'jenis_paket' => $this->jenis_paket,
            'harga' => $this->harga,
            'waktu_pengerjaan' => $this->waktu_pengerjaan,
            'id_unit' => $this->id_unit,
        ]);

        // Reset form after save
        $this->reset();
        return redirect('/paket');
    }

    /**
     * Merender tampilan komponen Livewire.
     * Mengambil daftar Unit berdasarkan pencarian.
     * Jika id_unit dipilih tetapi tidak ada dalam daftar, tambahkan ke awal daftar.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $unitPakets = Unit::where('nama_unit', 'like', '%' . $this->searchUnitPaket . '%')
            ->limit(5)
            ->get();

        // Perbaiki pencocokan menggunakan id_unit
        if ($this->id_unit && !$unitPakets->contains('id_unit', $this->id_unit)) {
            $selectedUnit = Unit::where('id_unit', $this->id_unit)->first();
            if ($selectedUnit) {
                $unitPakets->prepend($selectedUnit); // Tambahkan ke awal daftar
            }
        }

        return view('livewire.paket.add', [
            'unitPakets' => $unitPakets,
        ]);
    }
}
