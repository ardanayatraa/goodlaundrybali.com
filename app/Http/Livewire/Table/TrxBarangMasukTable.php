<?php

namespace App\Http\Livewire\Table;

use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use App\Models\TrxBarangMasuk;

class TrxBarangMasukTable extends LivewireDatatable
{
    public $model = TrxBarangMasuk::class;

    public function builder()
    {
        // eager-load relasi barang->unit & admin (jika ada)
        return TrxBarangMasuk::query()
            ->with(['barang.unit', 'admin']);
    }

    public function columns()
    {
        return [
           

            Column::callback(
                ['tanggal_masuk', 'id_trx_brgmasuk'],
                fn($tgl, $id) => view('datatables::link', [
                    'href' => route('trx-barang-masuk.detail', $id),
                    'slot' => $tgl,
                ])
            )
            ->label('Tanggal Masuk')
            ->sortable()
            ->searchable(),


            Column::name('barang.nama_barang')
            ->label('Nama Barang')
            ->sortable()
            ->searchable(),



            // Column::callback(['id_trx_brgmasuk'], fn($id) => view('components.table-action', [
            //         'id'    => $id,
            //         'route' => 'trx-barang-masuk.edit'
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
