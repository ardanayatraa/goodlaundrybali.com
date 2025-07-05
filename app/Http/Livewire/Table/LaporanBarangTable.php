<?php

namespace App\Http\Livewire\Table;

use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;
use App\Models\Barang;
use App\Models\TrxBarangMasuk;
use App\Models\TrxBarangKeluar;
use Illuminate\Support\Carbon;

class LaporanBarangTable extends LivewireDatatable
{
    public $model = Barang::class;
    public $filterType, $filterDate, $filterYear, $filterMonth, $filterWeek, $filterStartDate, $filterEndDate;

    protected $listeners = ['filterUpdated' => 'updateFilters', 'refreshLivewireDatatable' => '$refresh'];

    public function updateFilters($filters)
    {
        $this->filterType     = $filters['filterType'];
        $this->filterDate     = $filters['filterDate'];
        $this->filterYear     = $filters['filterYear'];
        $this->filterMonth    = $filters['filterMonth'];
        $this->filterWeek     = $filters['filterWeek'];
        $this->filterStartDate= $filters['filterStartDate'];
        $this->filterEndDate  = $filters['filterEndDate'];

        // untuk monthly, tentukan start/end jika belum
        if ($this->filterType === 'monthly' && $this->filterMonth) {
            $m = Carbon::createFromFormat('Y-m', $this->filterMonth);
            $this->filterStartDate = $m->startOfMonth()->toDateString();
            $this->filterEndDate   = $m->endOfMonth()->toDateString();
        }

        $this->emit('refreshLivewireDatatable');
    }

    public function builder()
    {
        $query = Barang::query();

        if ($this->filterType === 'daily' && $this->filterDate) {
            $query->whereDate('created_at', $this->filterDate);
        }

        if ($this->filterType === 'weekly' && $this->filterStartDate && $this->filterEndDate) {
            $query->whereBetween('created_at', [$this->filterStartDate, $this->filterEndDate]);
        }

        if ($this->filterType === 'monthly' && $this->filterStartDate && $this->filterEndDate) {
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

    protected function getPeriodStartDate(): ?string
    {
        // kembalikan tanggal mulai periode sebagai string Y-m-d
        if ($this->filterType === 'daily' && $this->filterDate) {
            return $this->filterDate;
        }
        if (in_array($this->filterType, ['weekly','monthly','range']) && $this->filterStartDate) {
            return $this->filterStartDate;
        }
        if ($this->filterType === 'yearly' && $this->filterYear) {
            // stok awal tahun: sebelum 1 Jan tahun itu
            return Carbon::create($this->filterYear, 1, 1)->toDateString();
        }
        return null;
    }

    public function columns()
    {
        return [
            Column::name('id_barang')->label('ID Barang')->sortable(),
            Column::name('nama_barang')->label('Nama Barang')->sortable()->searchable(),
            Column::name('harga')->label('Harga (Rp)')->sortable(),

            // kolom Stok Awal
            Column::callback(['id_barang'], function ($id) {
                $start = $this->getPeriodStartDate();
                if (! $start) {
                    return '-';
                }
                $startDt = Carbon::parse($start)->startOfDay();

                $masukBefore = TrxBarangMasuk::where('id_barang', $id)
                    ->where('tanggal_masuk', '<', $startDt)
                    ->sum('jumlah_brgmasuk');

                $keluarBefore = TrxBarangKeluar::where('id_barang', $id)
                    ->where('tanggal_keluar', '<', $startDt)
                    ->sum('jumlah_brgkeluar');

                return $masukBefore - $keluarBefore;
            })
            ->label('Stok Awal')
            ->unsortable()
            ->wrap(),

            Column::name('trxBarangKeluar.jumlah_brgkeluar:sum')
                  ->label('Transaksi Keluar')
                  ->sortable(),
            Column::name('trxBarangMasuk.jumlah_brgmasuk:sum')
                  ->label('Transaksi Masuk')
                  ->sortable(),
            Column::name('stok')->label('Stok')->sortable(),
            Column::name('created_at')->label('Dibuat')->sortable(),
        ];
    }
}
