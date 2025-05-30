<?php

namespace App\Http\Livewire\Unit;

use Livewire\Component;
use App\Models\Unit;

class Edit extends Component
{
    public $id_unit, $nama_unit, $keterangan;

    protected $rules = [
        'nama_unit' => 'required|string|max:50',
        'keterangan' => 'nullable|string|max:300',
    ];

    /**
     * Menginisialisasi data unit berdasarkan ID unit.
     *
     * @param int $id_unit
     * @return void
     */
    public function mount($id_unit)
    {
        $unit = Unit::findOrFail($id_unit);
        $this->id_unit = $unit->id_unit;
        $this->nama_unit = $unit->nama_unit;
        $this->keterangan = $unit->keterangan;
    }

    /**
     * Memperbarui data unit di dalam database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        $this->validate();

        Unit::where('id_unit', $this->id_unit)->update([
            'nama_unit' => $this->nama_unit,
            'keterangan' => $this->keterangan,
        ]);

        return redirect('/unit')->with('success', 'Unit berhasil diperbarui!');
    }

    /**
     * Merender tampilan untuk mengedit unit.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.unit.edit');
    }
}
