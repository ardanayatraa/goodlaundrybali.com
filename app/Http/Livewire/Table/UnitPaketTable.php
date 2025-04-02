<?php

namespace App\Http\Livewire\Table;

use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use App\Models\UnitPaket;

class UnitPaketTable extends LivewireDatatable
{
    public $model = UnitPaket::class;

    /**
     * Membangun query builder untuk tabel Unit Paket.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function builder()
    {
        return UnitPaket::query();
    }

    /**
     * Mendefinisikan kolom-kolom yang akan ditampilkan di tabel.
     *
     * @return array
     */
    public function columns()
    {
        return [
            Column::name('id_unit_paket')->label('ID')->sortable(),
            Column::name('nama_unit')->label('Nama Unit')->sortable()->searchable(),
            Column::name('keterangan')->label('Keterangan'),

            Column::callback(['id_unit_paket'], function ($id) {
                return view('components.table-action', [
                    'id' => $id,
                      'route'=>'unit-paket.edit'
                ]);
            })
                ->label('Actions')
                ->excludeFromExport(),
        ];
    }

    /**
     * Memancarkan event untuk menampilkan modal konfirmasi penghapusan.
     *
     * @param int $id ID unit paket yang akan dihapus.
     * @return void
     */
    public function deleteConfirm($id)
    {
        $this->emit('deleteModal', $id);
    }
}
