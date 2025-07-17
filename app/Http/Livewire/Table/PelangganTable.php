<?php

namespace App\Http\Livewire\Table;

use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use App\Models\Pelanggan;
use Carbon\Carbon;

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
            Column::name('nama_pelanggan')
                ->label('Nama Pelanggan')
                ->sortable()
                ->searchable(),

            Column::name('no_telp')
                ->label('No Telepon')
                ->sortable(),

            Column::name('alamat')
                ->label('Alamat'),

            Column::name('point')
                ->label('Poin'),


            // 2. Keterangan Member / Non Member
            Column::name('keterangan')
                ->label('Keterangan'),

            // 3. Tanggal Mulai Jadi Member (member_start_at)
            Column::callback(['member_start_at', 'keterangan'], function ($start, $ket) {
                if ($ket === 'Member' && $start) {
                    return Carbon::parse($start)->format('d-m-Y');
                }
                return '-';
            })
                ->label('Member Sejak')
                ->sortable(),

            // 4. Actions
            Column::callback(['no_telp'], function ($id) {
                $pl = Pelanggan::find($id);
                return view('action.pelanggan', [
                    'pl'    => $pl,
                    'route' => 'pelanggan.edit',
                ]);
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
