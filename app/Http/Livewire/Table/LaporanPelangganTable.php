<?php

namespace App\Http\Livewire\Table;

use App\Models\Pelanggan;
use Carbon\Carbon;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\Column;

class LaporanPelangganTable extends LivewireDatatable
{
    public $model = Pelanggan::class;
    public $filterStartDate;
    public $filterEndDate;

    protected $listeners = ['filterUpdated' => 'updateFilters'];

    public function updateFilters($filters)
    {
        $this->filterStartDate = $filters['filterStartDate'];
        $this->filterEndDate = $filters['filterEndDate'];
    }

    public function builder()
    {
        $query = Pelanggan::query()->where('keterangan', 'Member');

        if ($this->filterStartDate && $this->filterEndDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($this->filterStartDate)->startOfDay(),
                Carbon::parse($this->filterEndDate)->endOfDay(),
            ]);
        }

        return $query;
    }

    public function columns()
    {
        return [
            Column::name('nama_pelanggan')->label('Nama Pelanggan')->searchable(),
            Column::callback('created_at', function ($date) {
                return Carbon::parse($date)->format('d-m-Y');
            })->label('Tanggal Pendaftaran')->sortable(),
             Column::raw('"Rp 10.000"')->label('Harga Pendaftaran'),
        ];

    }
}
