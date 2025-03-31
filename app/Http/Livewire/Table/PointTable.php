<?php

namespace App\Http\Livewire\Table;

use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use App\Models\Point;

class PointTable extends LivewireDatatable
{
    public $model = Point::class;

    public function builder()
    {
        return Point::query()->with('pelanggan');
    }

    public function columns()
    {
        return [
            Column::name('id_point')->label('ID Point')->sortable(),
            Column::name('pelanggan.nama_pelanggan')->label('Nama Pelanggan')->sortable()->searchable(),
            Column::name('tanggal')->label('Tanggal')->sortable(),
            Column::name('jumlah_point')->label('Jumlah Point')->sortable(),

            Column::callback(['id_point'], function ($id) {
                return view('components.table-action', [
                    'id' => $id,
                    'route'=>'point.edit'
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
