<?php

namespace App\Http\Livewire\Table;

use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use App\Models\Paket;

class PaketTable extends LivewireDatatable
{
    public $model = Paket::class;

    /**
     * Membangun query builder untuk tabel Paket.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function builder()
    {
        return Paket::query();
    }

    /**
     * Mendefinisikan kolom-kolom yang akan ditampilkan di tabel.
     *
     * @return array
     */
    public function columns()
    {
        return [
            Column::name('id_paket')
                ->label('ID Paket')
                ->defaultSort('asc'),

            Column::name('jenis_paket')
                ->label('Jenis Paket')
                ->searchable(),

            Column::name('harga')
                ->label('Harga'),

            Column::name('waktu_pengerjaan')
                ->label('Waktu Pengerjaan'),

                Column::callback(['id_paket'], function ($id) {
                    return view('components.table-action', [
                        'id' => $id,
                        'route'=>'paket.edit'
                    ]);
                })
                    ->label('Actions')
                    ->excludeFromExport(),
        ];
    }

    /**
     * Memancarkan event untuk menampilkan modal konfirmasi penghapusan.
     *
     * @param int $id ID paket yang akan dihapus.
     * @return void
     */
    public function deleteConfirm($id)
    {
        $this->emit('deleteModal', $id);
    }
}
