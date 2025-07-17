<?php

namespace App\Http\Livewire\Table;

use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use App\Models\Unit;

class UnitTable extends LivewireDatatable
{
    public $model = Unit::class;

    /**
     * Membangun query builder untuk tabel Unit.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function builder()
    {
        return Unit::query();
    }

    /**
     * Mendefinisikan kolom-kolom yang akan ditampilkan di tabel.
     *
     * @return array
     */
    public function columns()
    {
        return [
             Column::raw('null')->label('No')->callback(['nama_unit'], function () {
            static $no = 0;
            return ++$no;
        }),

            Column::name('nama_unit')->label('Nama Unit')->sortable()->searchable(),
            Column::name('keterangan')->label('Keterangan'),

            Column::callback(['id_unit'], function ($id) {
                return view('components.table-action', [
                    'id' => $id,    'route'=>'unit.edit'
                ]);
            })
                ->label('Actions')
                ->excludeFromExport(),
        ];
    }

    /**
     * Memancarkan event untuk menampilkan modal konfirmasi penghapusan.
     *
     * @param int $id ID unit yang akan dihapus.
     * @return void
     */
    public function deleteConfirm($id)
    {
        $this->emit('deleteModal', $id);
    }
}
