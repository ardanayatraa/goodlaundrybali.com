<?php

namespace App\Http\Livewire\Table;

use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use App\Models\Pelanggan;

class PelangganTable extends LivewireDatatable
{
    public $model = Pelanggan::class;

    public function builder()
    {
        return Pelanggan::query();
    }

    public function columns()
    {
        return [
            Column::name('id_pelanggan')->label('ID Pelanggan')->sortable(),
            Column::name('nama_pelanggan')->label('Nama Pelanggan')->sortable()->searchable(),
            Column::name('no_telp')->label('No Telepon')->sortable(),
            Column::name('alamat')->label('Alamat'),
            Column::name('keterangan')->label('Keterangan'),

            Column::callback(['id_pelanggan'], function ($id) {
                $pl=Pelanggan::where('id_pelanggan',$id)->first();

                return view('action.pelanggan', ['pl' => $pl,'route'=>'pelanggan.edit' ]);
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
