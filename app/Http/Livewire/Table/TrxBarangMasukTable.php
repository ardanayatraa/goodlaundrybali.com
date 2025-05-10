<?php

namespace App\Http\Livewire\Table;

use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use App\Models\TrxBarangMasuk;

class TrxBarangMasukTable extends LivewireDatatable
{
    public $model = TrxBarangMasuk::class;

    /**
     * Membangun query builder untuk tabel Transaksi Barang Masuk.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function builder()
    {
        return TrxBarangMasuk::query()
            ->join('barangs', 'trx_barang_masuks.id_barang', '=', 'barangs.id_barang');
    }

    /**
     * Mendefinisikan kolom-kolom yang akan ditampilkan di tabel.
     *
     * @return array
     */
    public function columns()
    {
        return [
            Column::name('trx_barang_masuks.id_trx_brgmasuk')->label('ID Transaksi')->sortable(),
            Column::name('barangs.nama_barang')->label('Nama Barang')->sortable()->searchable(),

            Column::callback(
                ['trx_barang_masuks.tanggal_masuk', 'id_trx_brgmasuk'],
                function ($tanggal, $id) {
                    return view('datatables::link', [
                        'href' => route('trx-barang-masuk.detail', $id),
                        'slot' => $tanggal,
                    ]);
                }
            )
            ->label('Tanggal Masuk')
            ->sortable()
            ->searchable(),
            Column::name('admin.nama_admin')->label('Nama Admin')->searchable(),
            Column::name('trx_barang_masuks.total_harga')->label('Total Harga')->sortable(),

            Column::callback(['id_trx_brgmasuk'], function ($id) {
                return view('components.table-action', [
                    'id' => $id,
                 'route'=>'trx-barang-masuk.edit'
                ]);
            })
                ->label('Actions')
                ->excludeFromExport(),

        ];
    }

    /**
     * Memancarkan event untuk menampilkan modal konfirmasi penghapusan.
     *
     * @param int $id ID transaksi barang masuk yang akan dihapus.
     * @return void
     */
    public function deleteConfirm($id)
    {
        $this->emit('deleteModal', $id);
    }
}
