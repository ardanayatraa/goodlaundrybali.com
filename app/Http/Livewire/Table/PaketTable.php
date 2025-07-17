<?php

namespace App\Http\Livewire\Table;

use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use App\Models\Paket;

class PaketTable extends LivewireDatatable
{
    public $model = Paket::class;

    public function builder()
    {
        // siapkan relasi unitPaket
        return Paket::query()->with('unitPaket');
    }

    public function columns()
    {
        return [
            Column::name('jenis_paket')
                  ->label('Jenis Paket')
                  ->searchable(),

            // kolom Unit
            Column::name('unit.nama_unit')
                  ->label('Unit')
                  ->searchable(),

            // harga dengan format Rp
            Column::callback(['harga'], function ($harga) {
                return 'Rp ' . number_format($harga, 0, ',', '.');
            })
            ->label('Harga')
            ->sortable(),

            Column::name('waktu_pengerjaan')
                  ->label('Waktu Pengerjaan (Jam)')
                  ->sortable(),

            // tombol edit/hapus
            Column::callback(['id_paket'], function ($id) {
                return view('components.table-action', [
                    'id'    => $id,
                    'route' => 'paket.edit'
                ]);
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
