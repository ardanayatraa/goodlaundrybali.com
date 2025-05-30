<?php

namespace App\Http\Livewire\Table;

use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use App\Models\Pelanggan;

class PelangganTable extends LivewireDatatable
{
    public $model = Pelanggan::class;

    /**
     * Membangun query builder untuk tabel Pelanggan.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function builder()
    {
        return Pelanggan::query();
    }

    /**
     * Mendefinisikan kolom-kolom yang akan ditampilkan di tabel.
     *
     * @return array
     */
    public function columns()
    {
        return [
            Column::name('id_pelanggan')->label('ID Pelanggan')->sortable(),
            Column::name('nama_pelanggan')->label('Nama Pelanggan')->sortable()->searchable(),
            Column::name('no_telp')->label('No Telepon')->sortable(),
            Column::name('alamat')->label('Alamat'),
            Column::name('point')->label('Poin'),
            Column::name('keterangan')->label('Keterangan'),

            Column::callback(['id_pelanggan'], function ($id) {
                $pl=Pelanggan::where('id_pelanggan',$id)->first();

                return view('action.pelanggan', ['pl' => $pl,'route'=>'pelanggan.edit' ]);
            })
                ->label('Actions')
                ->excludeFromExport(),
        ];
    }

    /**
     * Memancarkan event untuk menampilkan modal konfirmasi penghapusan.
     *
     * @param int $id ID pelanggan yang akan dihapus.
     * @return void
     */
    public function deleteConfirm($id)
    {
        $this->emit('deleteModal', $id);
    }
}
