<?php

namespace App\Http\Livewire\Table;

use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use App\Models\TrxBarangMasuk;

class TrxBarangMasukTable extends LivewireDatatable
{
    public function builder()
    {
        return TrxBarangMasuk::query()->join('barangs', 'trx_barang_masuks.id_barang', '=', 'barangs.id_barang');
    }

    public function columns()
    {
        return [
            Column::name('trx_barang_masuks.id_trx_brgmasuk')->label('ID Transaksi')->sortable(),
            Column::name('barangs.nama_barang')->label('Nama Barang')->sortable()->searchable(),
            Column::name('trx_barang_masuks.tanggal_masuk')->label('Tanggal Masuk')->sortable(),
            Column::name('trx_barang_masuks.id_admin')->label('Nama Admin')->searchable(),
            Column::name('trx_barang_masuks.total_harga')->label('Total Harga')->sortable(),
            Column::callback(['id_trx_brgmasuk'], function($id) {
                $barang = TrxBarangMasuk::where('id_trx_brgmasuk',$id)->first();
                return view('action.barang-masuk', ['trxBarangMasuk' => $barang]); 
            })
                ->label('Actions')
                ->excludeFromExport(),
        ];
    }
}
