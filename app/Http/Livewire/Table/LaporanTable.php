<?php

namespace App\Http\Livewire\Table;

use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use App\Models\Transaksi;
use Illuminate\Support\Carbon;

class LaporanTable extends LivewireDatatable
{
    public $model = Transaksi::class;
    public $filterType, $filterDate, $filterYear, $filterMonth, $filterWeek, $filterStartDate, $filterEndDate;

    protected $listeners = ['filterUpdated' => 'updateFilters', 'refreshLivewireDatatable' => '$refresh'];

    /**
     * Memperbarui filter berdasarkan input pengguna.
     *
     * @param array $filters Data filter yang diperbarui.
     * @return void
     */
    public function updateFilters($filters)
    {
        $this->filterType = $filters['filterType'];
        $this->filterDate = $filters['filterDate'];
        $this->filterYear = $filters['filterYear'];
        $this->filterMonth = $filters['filterMonth'];
        $this->filterWeek = $filters['filterWeek'];
        $this->filterStartDate = $filters['filterStartDate'];
        $this->filterEndDate = $filters['filterEndDate'];

        $this->emit('refreshLivewireDatatable');
    }

    /**
     * Membangun query builder untuk tabel Laporan.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function builder()
    {
        $query = Transaksi::with('detailTransaksi.paket');

        if ($this->filterType === 'daily' && $this->filterDate) {
            $query->whereDate('tanggal_transaksi', $this->filterDate);
        }

        if ($this->filterType === 'weekly' && $this->filterWeek) {
            $query->whereBetween('tanggal_transaksi', [$this->filterStartDate, $this->filterEndDate]);
        }

        if ($this->filterType === 'monthly' && $this->filterMonth) {
            $this->filterStartDate = Carbon::createFromFormat('Y-m', $this->filterMonth)->startOfMonth()->toDateString();
            $this->filterEndDate = Carbon::createFromFormat('Y-m', $this->filterMonth)->endOfMonth()->toDateString();
            $query->whereBetween('tanggal_transaksi', [$this->filterStartDate, $this->filterEndDate]);
        }

        if ($this->filterType === 'yearly' && $this->filterYear) {
            $query->whereYear('tanggal_transaksi', $this->filterYear);
        }

        if ($this->filterType === 'range' && $this->filterStartDate && $this->filterEndDate) {
            $query->whereBetween('tanggal_transaksi', [$this->filterStartDate, $this->filterEndDate]);
        }

        return $query;
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
            Column::name('tanggal_transaksi')->label('Tanggal Transaksi')->sortable()->searchable(),
            Column::name('status_pembayaran')->label('Status Pembayaran')->sortable(),
            Column::name('metode_pembayaran')->label('Metode Pembayaran')->sortable(),
            Column::name('detailTransaksi.total_diskon')->label('Total Diskon')->sortable(),
            Column::name('detailTransaksi.sub_total')->label('Sub Total')->sortable(),
            Column::name('status_transaksi')->label('Status Transaksi')->sortable(),
            Column::name('total_harga')->label('Total Harga (Rp)')->sortable()->searchable(),
        ];
    }
}
