<?php

namespace App\Http\Livewire\Table;

use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use App\Models\Paket;

class PaketTable extends LivewireDatatable
{
    public $model = Paket::class;

    public function builder()
    {
        return Paket::query();
    }

    public function delete($id)
{
    $this->dispatchBrowserEvent('paket-delete', [
        'id' => $id
    ]);
}
    public function columns()
    {
        return [
            Column::name('id_paket')
                ->label('ID Paket')
                ->defaultSort('asc'),

            Column::name('jenis_paket')
                ->label('Jenis Paket')
                ->searchable(),

            Column::name('harga')
                ->label('Harga'),

            Column::name('waktu_pengerjaan')
                ->label('Waktu Pengerjaan'),

            Column::callback(['id_paket'], function($id) {
                $paket = Paket::find($id);
                return view('action.paket', ['paket' => $paket]);
            })
                ->label('Actions')
                ->excludeFromExport(),



        ];
    }
}
