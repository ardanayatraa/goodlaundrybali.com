<?php

namespace App\Http\Livewire\Table;

use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use App\Models\TrxBarangKeluar;

class TrxBarangKeluarTable extends LivewireDatatable
{
    public $model = TrxBarangKeluar::class;

    public function builder()
    {
        return TrxBarangKeluar::query()
            ->with(['barang.unit', 'admin']); // eager-load relasi
    }

    public function columns()
    {
        return [

             Column::raw('null')->label('No')->callback(['barang.nama_barang'], function () {
            static $no = 0;
            return ++$no;
        }),

    Column::callback(
                ['tanggal_keluar', 'id_trx_brgkeluar'],
                fn($tgl, $id) => view('datatables::link', [
                    'href' => route('trx-barang-keluar.detail', $id),
                    'slot' => $tgl,
                ])
            )
            ->label('Tanggal Keluar')
            ->sortable()
            ->searchable(),

            Column::name('barang.nama_barang')
                  ->label('Nama Barang')
                  ->sortable()
                  ->searchable(),




            // Column::callback(
            //     ['id_trx_brgkeluar'],
            //     fn($id) => view('components.table-action', [
            //         'id'    => $id,
            //         'route' => 'trx-barang-keluar.edit'
            //     ])
            // )
            // ->label('Actions')
            // ->excludeFromExport(),
        ];
    }

    public function deleteConfirm($id)
    {
        $this->emit('deleteModal', $id);
    }
}
