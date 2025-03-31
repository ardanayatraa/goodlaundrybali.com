<?php

namespace App\Http\Livewire\Table;

use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use App\Models\Transaksi;

class TransaksiTable extends LivewireDatatable
{
    public $model = Transaksi::class;
    public $selectedTransaksiId, $selectedStatus, $modalType = '';

    protected $listeners = ['refreshLivewireDatatable' => '$refresh'];

    public function builder()
    {
        return Transaksi::query()->with('pelanggan');
    }

    public function columns()
    {
        return [
            Column::name('id_transaksi')->label('ID Transaksi')->sortable(),
            Column::name('pelanggan.nama_pelanggan')->label('Nama Pelanggan')->sortable()->searchable(),
            Column::name('tanggal_transaksi')->label('Tanggal Transaksi')->sortable()->searchable(),
            Column::name('total_harga')->label('Total Harga (Rp)')->sortable()->searchable(),

            Column::callback(['id_transaksi', 'status_pembayaran'], function ($id, $status) {
                return view('components.table-transaksi-pembayaran', compact('id', 'status'));
            })
                ->label('Status Pembayaran')
                ->excludeFromExport(),

            Column::callback(['id_transaksi', 'status_transaksi'], function ($id, $status) {
                return view('components.table-transaksi-status', compact('id', 'status'));
            })
                ->label('Status Transaksi')
                ->excludeFromExport(),

        ];
    }

    public function updateStatus($id, $status, $type)
    {
        $column = $type === 'pembayaran' ? 'status_pembayaran' : 'status_transaksi';

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update([$column => $status]);

        $this->emit('refreshLivewireDatatable'); 
    }

    public function updateStatusTransaksiConfirm($id)
    {
        $this->emit('updateStatus', $id);
    }
}
