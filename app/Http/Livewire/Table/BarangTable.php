<?php

namespace App\Http\Livewire\Table;

use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use App\Models\Barang;

class BarangTable extends LivewireDatatable
{
    public $model = Barang::class;

    /**
     * Membangun query builder untuk tabel Barang.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function builder()
    {
        return Barang::query();
    }

    /**
     * Mendefinisikan kolom-kolom yang akan ditampilkan di tabel.
     *
     * @return array
     */
    public function columns()
    {
        return [
            Column::name('id_barang')->label('ID')->sortable(),
            Column::name('nama_barang')->label('Nama Barang')->sortable()->searchable(),
            Column::name('stok')->label('Stok')->sortable()->searchable(),
            Column::name('harga')->label('Harga')->sortable(),
            Column::name('unit.nama_unit')->label('Unit')->sortable(),

            Column::callback(['id_barang'], function ($id) {

                return view('components.table-action', [
                    'id' => $id,
                    'route'=>'barang.edit'
                ]);
            })
                ->label('Actions')
                ->excludeFromExport(),
        ];
    }

    /**
     * Memancarkan event untuk menampilkan modal konfirmasi penghapusan.
     *
     * @param int $id ID barang yang akan dihapus.
     * @return void
     */
    public function deleteConfirm($id)
    {
        $this->emit('deleteModal', $id);
    }
}
