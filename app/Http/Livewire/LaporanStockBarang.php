<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Barang;
use App\Models\TrxBarangMasuk;
use App\Models\TrxBarangKeluar;
use Carbon\Carbon;

class LaporanStockBarang extends Component
{
    use WithPagination;

    public $search       = '';
    public $start_date;
    public $end_date;
    public $perPage      = 10;

    protected $updatesQueryString = [
        'search','start_date','end_date','page'
    ];

    public function mount()
    {
        $today = Carbon::now()->toDateString();
        $this->start_date = $this->start_date ?? $today;
        $this->end_date   = $this->end_date   ?? $today;
    }

    public function updating($field)
    {
        if (in_array($field,['search','start_date','end_date'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $barangs = Barang::query()
            ->when($this->search, fn($q)=>
                $q->where('nama_barang','like',"%{$this->search}%")
            )
            ->orderBy('nama_barang')
            ->paginate($this->perPage);

        $stockSummary = collect($barangs->items())->map(function($b) {
            $start = $this->start_date;
            $end   = $this->end_date;

            $masuk = TrxBarangMasuk::where('id_barang',$b->id_barang)
                ->whereDate('tanggal_masuk','>=',$start)
                ->whereDate('tanggal_masuk','<=',$end)
                ->sum('jumlah_brgmasuk');

            $keluar = TrxBarangKeluar::where('id_barang',$b->id_barang)
                ->whereDate('tanggal_keluar','>=',$start)
                ->whereDate('tanggal_keluar','<=',$end)
                ->sum('jumlah_brgkeluar');

            $stokAkhir = $b->stok;
            $stokAwal  = $stokAkhir - $masuk + $keluar;

            return (object)[
                'barang'     => $b,
                'stok_awal'  => $stokAwal,
                'masuk'      => $masuk,
                'keluar'     => $keluar,
                'stok_akhir' => $stokAkhir,
            ];
        });

        return view('livewire.laporan-stock-barang', compact('barangs','stockSummary'));
    }

    public function generatePdf()
    {
        $params = [
            'start_date' => $this->start_date,
            'end_date'   => $this->end_date,
            'search'     => $this->search,
        ];

        return $this->redirectRoute('report-barang.generate', $params);
    }
}
