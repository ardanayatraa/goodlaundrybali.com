<?php

namespace App\Http\Livewire\Paket;

use Livewire\Component;
use App\Models\Paket;
use App\Models\UnitPaket;

class Edit extends Component
{
    public $id_paket, $jenis_paket, $harga, $waktu_pengerjaan, $id_unit_paket;
    public $searchUnitPaket = '';
    public $focusedUnitPaket = false;

    protected $rules = [
        'jenis_paket' => 'required|string|max:50',
        'harga' => 'required|numeric|min:0',
        'unit' => 'required|string|max:10',
        'waktu_pengerjaan' => 'required|string|max:50',
        'id_unit_paket' => 'required',
    ];

    /**
     * Menginisialisasi data paket berdasarkan id_paket.
     *
     * @param int $id_paket ID dari paket yang akan diedit.
     */
    public function mount($id_paket)
    {
        $paket = Paket::findOrFail($id_paket);
        $this->id_paket = $paket->id_paket;
        $this->jenis_paket = $paket->jenis_paket;
        $this->harga = $paket->harga;
        $this->waktu_pengerjaan = $paket->waktu_pengerjaan;
        $this->id_unit_paket = $paket->id_unit_paket;
    }

    /**
     * Memperbarui data paket di database.
     * Melakukan validasi terlebih dahulu sebelum memperbarui.
     */
    public function update()
    {
        $this->validate();

        Paket::where('id_paket', $this->id_paket)->update([
            'jenis_paket' => $this->jenis_paket,
            'harga' => $this->harga,
            'waktu_pengerjaan' => $this->waktu_pengerjaan,
            'id_unit_paket' => $this->id_unit_paket,
        ]);

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

        if ($this->id_unit_paket && !$unitPakets->contains('id_unit_paket', $this->id_unit_paket)) {
            $selectedUnit = UnitPaket::where('id_unit_paket', $this->id_unit_paket)->first();
            if ($selectedUnit) {
                $unitPakets->prepend($selectedUnit);
            }
        }

        return view('livewire.paket.edit', [
            'unitPakets' => $unitPakets,
        ]);
    }
}
