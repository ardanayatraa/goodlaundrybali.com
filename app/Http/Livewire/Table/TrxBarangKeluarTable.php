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
        return TrxBarangKeluar::query()->join('barangs', 'trx_barang_keluars.id_barang', '=', 'barangs.id_barang');
    }

    public function columns()
    {
        return [
            Column::name('trx_barang_keluars.id_trx_brgkeluar')->label('ID Transaksi')->sortable(),
            Column::name('barangs.nama_barang')->label('Nama Barang')->sortable()->searchable(),
            Column::name('trx_barang_keluars.tanggal_keluar')->label('Tanggal Keluar')->sortable(),
            Column::name('trx_barang_keluars.id_admin')->label('Nama Admin')->searchable(),

            Column::callback(['id_trx_brgkeluar'], function ($id) {
                return view('components.table-action', ['id' => $id,    'route'=>'trx-barang-keluar.edit']);
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
