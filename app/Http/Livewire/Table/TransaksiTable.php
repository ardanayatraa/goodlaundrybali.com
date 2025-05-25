<?php

namespace App\Http\Livewire\Table;

use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use App\Models\Transaksi;

class TransaksiTable extends LivewireDatatable
{
    public $model = Transaksi::class;
    public $selectedTransaksiId, $selectedStatus, $modalType = '';
    public $filterTanggal;
    public $filterPembayaran;
    public $filterTransaksi;

    protected $listeners = ['refreshLivewireDatatable' => '$refresh'];

    /**
     * Membangun query builder untuk tabel Transaksi.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function builder()
    {

        return Transaksi::query()
            ->with('pelanggan')
            ->when($this->filterTanggal, fn($q) =>
                $q->whereDate('tanggal_transaksi', $this->filterTanggal)
            )
            ->when($this->filterPembayaran, fn($q) =>
                $q->where('status_pembayaran', $this->filterPembayaran)
            )
            ->when($this->filterTransaksi, fn($q) =>
                $q->where('status_transaksi', $this->filterTransaksi)
            );
    }

    /**
     * Mendefinisikan kolom-kolom yang akan ditampilkan di tabel.
     *
     * @return array
     */
    public function columns()
    {
        return [
            Column::name('id_transaksi')->label('ID Transaksi')->sortable(),
            Column::name('pelanggan.nama_pelanggan')->label('Nama Pelanggan')->sortable()->searchable(),
            Column::callback(
                ['tanggal_transaksi', 'id_transaksi'],
                function ($tanggal, $id) {
                    return view('datatables::link', [
                        'href' => route('transaksi.detail', $id),
                        'slot' => $tanggal,
                    ]);
                }
            )
            ->label('Tanggal Transaksi')
            ->sortable()
            ->searchable(),
            Column::name('total_harga')->label('Total Harga (Rp)')->sortable()->searchable(),
            Column::name('keterangan')->label('Keterangan')->sortable()->searchable()->editable(),
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

    /**
     * Memperbarui status pembayaran atau transaksi.
     *
     * @param int $id ID transaksi.
     * @param string $status Status baru.
     * @param string $type Jenis status (pembayaran/transaksi).
     * @return void
     */
    public function updateStatus($id, $status, $type)
    {
        $column = $type === 'pembayaran' ? 'status_pembayaran' : 'status_transaksi';

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update([$column => $status]);

        $this->emit('refreshLivewireDatatable');
    }

    /**
     * Memancarkan event untuk konfirmasi pembaruan status transaksi.
     *
     * @param int $id ID transaksi.
     * @return void
     */
    public function updateStatusTransaksiConfirm($id)
    {
        $this->emit('updateStatus', $id);
    }
}
