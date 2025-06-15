<?php

namespace App\Http\Livewire\Table;

use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use Illuminate\Support\Facades\DB;
use App\Models\TrxBarangMasuk;

class GroupTrxBarangMasukTable extends LivewireDatatable
{
    public $model = TrxBarangMasuk::class;

    public function builder()
    {
        return TrxBarangMasuk::query()
            ->select([
                DB::raw('DATE(tanggal_masuk) as tanggal_masuk'),
                DB::raw('COUNT(*) as total_transaksi'),
                DB::raw('SUM(jumlah_brgmasuk) as total_jumlah'),
                DB::raw('SUM(total_harga) as total_harga'),
            ])
            ->groupBy(DB::raw('DATE(tanggal_masuk)'))
            ->orderBy('tanggal_masuk', 'desc');
    }

    public function columns()
    {
        return [
            Column::name('tanggal_masuk')
                  ->label('Tanggal Masuk')
                  ->filterable()
                  ->sortable(),

            Column::name('total_transaksi')
                  ->label('Jumlah Transaksi')
                  ->sortable(),

            Column::name('total_jumlah')
                  ->label('Total Jumlah Masuk')
                  ->sortable(),

            Column::callback(['total_harga'], function($harga) {
                return 'Rp '.number_format($harga, 0, ',', '.');
            })
            ->label('Total Harga')
            ->sortable(),
        ];
    }
}
