<?php

namespace App\Http\Livewire\Table;

use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use App\Models\Point;

class PointTable extends LivewireDatatable
{
    public $model = Point::class;

    /**
     * Membangun query builder untuk tabel Point.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function builder()
    {
        return Point::query()->with('pelanggan');
    }

    /**
     * Mendefinisikan kolom-kolom yang akan ditampilkan di tabel.
     *
     * @return array
     */
    public function columns()
    {
        return [
            Column::name('pelanggan.nama_pelanggan')->label('Nama Pelanggan')->sortable()->searchable(),
            Column::name('tanggal')->label('Tanggal')->sortable(),
            Column::name('jumlah_point')->label('Jumlah Point')->sortable(),

            Column::callback(['id_point'], function ($id) {
                return view('components.table-action', [
                    'id' => $id,
                    'route'=>'point.edit'
                ]);
            })
                ->label('Actions')
                ->excludeFromExport(),
        ];
    }

    /**
     * Memancarkan event untuk menampilkan modal konfirmasi penghapusan.
     *
     * @param int $id ID point yang akan dihapus.
     * @return void
     */
    public function deleteConfirm($id)
    {
        $this->emit('deleteModal', $id);
    }
}
