<?php

namespace App\Http\Livewire\Table;

use Livewire\Component;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use App\Models\Transaksi;

class TransaksiTable extends LivewireDatatable
{
    // Model yang dipakai
    public $model = Transaksi::class;

    // Filter opsional
    public $filterTanggal;
    public $filterPembayaran;
    public $filterTransaksi;

    // Dengarkan event untuk refresh dan simpan pembayaran dari modal
    protected $listeners = [
        'refreshLivewireDatatable' => '$refresh',
        'savePaymentFromTable'     => 'savePaymentFromTable',
    ];

    /**
     * Query builder: siapkan eager-load dan filter.
     */
    public function builder()
    {
        return Transaksi::query()
            ->with('pelanggan')
            ->when($this->filterTanggal,    fn($q) => $q->whereDate('tanggal_transaksi', $this->filterTanggal))
            ->when($this->filterPembayaran, fn($q) => $q->where('status_pembayaran', $this->filterPembayaran))
            ->when($this->filterTransaksi,  fn($q) => $q->where('status_transaksi',   $this->filterTransaksi));
    }

    /**
     * Definisi kolom.
     */
    public function columns()
    {
        return [
            Column::name('pelanggan.nama_pelanggan')
                  ->label('Pelanggan')
                  ->sortable()
                  ->searchable(),

            Column::name('detailTransaksi.jam_ambil')
                  ->label('Jam Ambil')
                  ->sortable()
                  ->searchable(),

            Column::callback(
                ['tanggal_transaksi','id_transaksi'],
                fn($tgl, $id) => view('datatables::link', [
                    'href' => route('transaksi.detail', $id),
                    'slot' => $tgl,
                ])
            )
            ->label('Tanggal')
            ->sortable()
            ->searchable(),

            Column::name('total_harga')
                  ->label('Total (Rp)')
                  ->sortable()
                  ->searchable(),

            Column::name('keterangan')
                  ->label('Keterangan')
                  ->sortable()
                  ->searchable()
                  ->editable(),

            // Kolom Status Pembayaran dengan modal bayar
            Column::callback(
                ['id_transaksi','status_pembayaran','total_harga'],
                fn($id, $status, $total) => view('components.table-transaksi-pembayaran', compact('id','status','total'))
            )
            ->label('Pembayaran')
            ->excludeFromExport(),

            Column::callback(['id_transaksi', 'status_transaksi'], function ($id, $status) {
                return view('components.table-transaksi-status', compact('id', 'status'));
            })
                ->label('Status Transaksi')
                ->excludeFromExport(),



        ];
    }

    /**
     * Method yang dipanggil oleh modal saat klik "Simpan".
     *
     * @param int    $id
     * @param float  $jumlahBayar
     * @param float  $kembalian
     */
    public function savePaymentFromTable($id, $jumlahBayar, $kembalian)
    {
        $trx = Transaksi::findOrFail($id);
        $trx->update([
            'jumlah_bayar'      => $jumlahBayar,
            'kembalian'         => $kembalian,
            'status_pembayaran' => 'Lunas',
        ]);

        // Refresh tabel
        $this->emit('refreshLivewireDatatable');
    }
}
