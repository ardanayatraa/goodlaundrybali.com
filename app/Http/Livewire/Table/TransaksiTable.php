<?php

namespace App\Http\Livewire\Table;

use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use App\Models\Transaksi;

class TransaksiTable extends LivewireDatatable
{
    public function builder()
    {
        return Transaksi::query();
    }

    public function columns()
    {
        return [
            Column::name('id_transaksi')->label('ID Transaksi')->sortable(),
            Column::name('nama_pelanggan')->label('Nama Pelanggan')->sortable()->searchable(),
            Column::name('tanggal_transaksi')->label('Tanggal Transaksi')->sortable(),
            Column::name('total_harga')->label('Total Harga (Rp)')->sortable(),
            Column::name('metode_pembayaran')->label('Metode Pembayaran')->searchable(),
            Column::name('status_pembayaran')->label('Status Pembayaran')->searchable(),
            Column::name('status_transaksi')->label('Status Transaksi')->searchable(),
            Column::name('jumlah_point')->label('Point')->sortable(),
            Column::callback(['id_transaksi'], function($id) {
                $tr = Transaksi::find($id);
                return view('action.transaksi', ['transaksi' => $tr]); 
            })
                ->label('Actions')
                ->excludeFromExport(),
        ];
    }
}
