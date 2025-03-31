<?php

namespace App\Http\Livewire\Table;

use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use App\Models\Unit;

class UnitTable extends LivewireDatatable
{
    public $model = Unit::class;

    public function builder()
    {
        return Unit::query();
    }

    public function columns()
    {
        return [
            Column::name('id_unit')->label('ID')->sortable(),
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

    public function deleteConfirm($id)
    {
        $this->emit('deleteModal', $id);
    }
}
