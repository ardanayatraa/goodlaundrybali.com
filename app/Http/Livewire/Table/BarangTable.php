<?php

namespace App\Http\Livewire\Table;

use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use App\Models\Barang;

class BarangTable extends LivewireDatatable
{
    public function builder()
    {
        return Barang::query();
    }

    public function columns()
    {
        return [
            Column::name('id_barang')->label('ID')->sortable(),
            Column::name('nama_barang')->label('Nama Barang')->sortable()->searchable(),
            Column::name('harga')->label('Harga')->sortable(),
            Column::callback(['id_barang'], function($id) {
                $barang = Barang::find($id);
                return view('action.barang', ['barang' => $barang]); 
            })
                ->label('Actions')
                ->excludeFromExport(),
            
        ];
    }
}