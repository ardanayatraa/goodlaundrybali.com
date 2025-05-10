<?php

namespace App\Http\Livewire\Table;

use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use App\Models\TrxBarangKeluar;

class TrxBarangKeluarTable extends LivewireDatatable
{
    public $model = TrxBarangKeluar::class;

    /**
     * Membangun query builder untuk tabel Transaksi Barang Keluar.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function builder()
    {
        return TrxBarangKeluar::query()->join('barangs', 'trx_barang_keluars.id_barang', '=', 'barangs.id_barang');
    }

    /**
     * Mendefinisikan kolom-kolom yang akan ditampilkan di tabel.
     *
     * @return array
     */
    public function columns()
    {
        return [
            Column::name('trx_barang_keluars.id_trx_brgkeluar')->label('ID Transaksi')->sortable(),
            Column::name('barangs.nama_barang')->label('Nama Barang')->sortable()->searchable(),
            Column::callback(
                ['trx_barang_keluars.tanggal_keluar', 'id_trx_brgkeluar'],
                function ($tanggal, $id) {
                    return view('datatables::link', [
                        'href' => route('trx-barang-keluar.detail', $id),
                        'slot' => $tanggal,
                    ]);
                }
            )
            ->label('Tanggal Keluar')
            ->sortable()
            ->searchable(),
            Column::name('trx_barang_keluars.id_admin')->label('Nama Admin')->searchable(),

            Column::callback(['id_trx_brgkeluar'], function ($id) {
                return view('components.table-action', ['id' => $id,    'route'=>'trx-barang-keluar.edit']);
            })
                ->label('Actions')
                ->excludeFromExport(),
        ];
    }

    /**
     * Memancarkan event untuk menampilkan modal konfirmasi penghapusan.
     *
     * @param int $id ID transaksi barang keluar yang akan dihapus.
     * @return void
     */
    public function deleteConfirm($id)
    {
        $this->emit('deleteModal', $id);
    }
}
