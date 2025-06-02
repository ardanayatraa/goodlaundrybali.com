<?php

namespace App\Http\Livewire\Table;

use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use App\Models\Barang;
use Illuminate\Support\Carbon;

class LaporanBarangTable extends LivewireDatatable
{
    public $model = Barang::class;
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
     * Membangun query builder untuk tabel Laporan Barang.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function builder()
    {
        $query = Barang::query();

        if ($this->filterType === 'daily' && $this->filterDate) {
            $query->whereDate('created_at', $this->filterDate);
        }

        if ($this->filterType === 'weekly' && $this->filterWeek) {
            $query->whereBetween('created_at', [$this->filterStartDate, $this->filterEndDate]);
        }

        if ($this->filterType === 'monthly' && $this->filterMonth) {
            $this->filterStartDate = Carbon::createFromFormat('Y-m', $this->filterMonth)->startOfMonth()->toDateString();
            $this->filterEndDate = Carbon::createFromFormat('Y-m', $this->filterMonth)->endOfMonth()->toDateString();
            $query->whereBetween('created_at', [$this->filterStartDate, $this->filterEndDate]);
        }

        if ($this->filterType === 'yearly' && $this->filterYear) {
            $query->whereYear('created_at', $this->filterYear);
        }

        if ($this->filterType === 'range' && $this->filterStartDate && $this->filterEndDate) {
            $query->whereBetween('created_at', [$this->filterStartDate, $this->filterEndDate]);
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
            Column::name('id_barang')->label('ID Barang')->sortable(),
            Column::name('nama_barang')->label('Nama Barang')->sortable()->searchable(),
            Column::name('harga')->label('Harga (Rp)')->sortable(),
            Column::name('trxBarangKeluar.jumlah_brgkeluar')->label('Transaksi Keluar')->sortable(),
            Column::name('trxBarangMasuk.jumlah_brgmasuk')->label('Transaksi Masuk')->sortable(),
            Column::name('stok')->label('Stok')->sortable(),
            Column::name('created_at')->label('Dibuat')->sortable(),
        ];

    }
}
