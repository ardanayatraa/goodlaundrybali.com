<?php

namespace App\Http\Livewire\Table;

use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use App\Models\Pelanggan;

class PelangganTable extends LivewireDatatable
{
    public function builder()
    {
        // Mengambil data dari model Pelanggan
        return Pelanggan::query();
    }

    public function columns()
    {
        // Mendefinisikan kolom-kolom yang ingin ditampilkan
        return [
            Column::name('id_pelanggan')
                ->label('ID Pelanggan')
                ->sortable(),

            Column::name('nama_pelanggan')
                ->label('Nama Pelanggan')
                ->sortable(),

            Column::name('no_telp')
                ->label('No Telepon')
                ->sortable(),

            Column::name('alamat')
                ->label('Alamat'),

            Column::name('keterangan')
                ->label('Keterangan')
            ,

            Column::callback(['id_pelanggan'], function($id) {
                $pelanggan = Pelanggan::find($id);
                return view('action.pelanggan', ['pl' => $pelanggan]); 
            })
                ->label('Actions')
                ->excludeFromExport(),
            
        ];
    }
}
