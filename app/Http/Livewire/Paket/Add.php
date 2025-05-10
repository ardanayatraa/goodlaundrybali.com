<?php

namespace App\Http\Livewire\Paket;

use Livewire\Component;
use App\Models\Paket;
use App\Models\UnitPaket;

class Add extends Component
{
    public $jenis_paket, $harga, $waktu_pengerjaan, $id_unit_paket;
    public $searchUnitPaket = '';
    public $focusedUnitPaket = false;

    protected $rules = [
        'jenis_paket' => 'required|string|max:50',
        'harga' => 'required|numeric|min:0',
        'waktu_pengerjaan' => 'required|string|max:50',
        'id_unit_paket' => 'required',
    ];

    /**
     * Menyimpan data paket baru ke database.
     * Melakukan validasi terlebih dahulu sebelum menyimpan.
     * Jika id_unit_paket tidak valid, akan menampilkan pesan error.
     */
    public function save()
    {
        $this->validate();

        // Ensure id_unit_paket is set and valid
        if (!UnitPaket::find($this->id_unit_paket)) {
            session()->flash('error', 'Invalid Unit Paket selected.');
            return;
        }

        Paket::create([
            'jenis_paket' => $this->jenis_paket,
            'harga' => $this->harga,
            'waktu_pengerjaan' => $this->waktu_pengerjaan,
            'id_unit_paket' => $this->id_unit_paket,
        ]);

        // Reset form after save
        $this->reset();
        return redirect('/paket');
    }

    /**
     * Merender tampilan komponen Livewire.
     * Mengambil daftar UnitPaket berdasarkan pencarian.
     * Jika id_unit_paket dipilih tetapi tidak ada dalam daftar, tambahkan ke awal daftar.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $unitPakets = UnitPaket::where('nama_unit', 'like', '%' . $this->searchUnitPaket . '%')
            ->limit(5)
            ->get();

        // Perbaiki pencocokan menggunakan id_unit_paket
        if ($this->id_unit_paket && !$unitPakets->contains('id_unit_paket', $this->id_unit_paket)) {
            $selectedUnit = UnitPaket::where('id_unit_paket', $this->id_unit_paket)->first();
            if ($selectedUnit) {
                $unitPakets->prepend($selectedUnit); // Tambahkan ke awal daftar
            }
        }

        return view('livewire.paket.add', [
            'unitPakets' => $unitPakets,
        ]);
    }
}
