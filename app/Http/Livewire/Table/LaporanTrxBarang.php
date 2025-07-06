<?php

namespace App\Http\Livewire\Table;

use Livewire\Component;
use App\Models\Barang;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class LaporanTrxBarang extends Component
{
    public $search = '';
    public $filterType = 'harian';    // opsi: 'harian', 'mingguan', 'bulanan', 'tahunan', 'rentang'
    public $filterDate;               // YYYY-MM-DD (untuk harian & mingguan)
    public $filterMonth;              // YYYY-MM (untuk bulanan)
    public $filterYear;               // YYYY (untuk tahunan)
    public $startDate;                // YYYY-MM-DD (untuk rentang)
    public $endDate;                  // YYYY-MM-DD (untuk rentang)

    public function mount()
    {
        // default values
        $this->filterDate = now()->toDateString();
        $this->filterMonth = now()->format('Y-m');
        $this->filterYear = now()->format('Y');
        $this->startDate = now()->startOfMonth()->toDateString();
        $this->endDate = now()->toDateString();
    }

    public function render()
    {
        $barangs = $this->query()
            ->get()
            ->map(function($b) {
                // hitung stok awal & stok akhir
                $b->stok_awal  = $b->stok - ($b->total_masuk - $b->total_keluar);
                $b->stok_akhir = $b->stok;
                return $b;
            });

        return view('livewire.table.laporan-trx-barang', compact('barangs'));
    }

    protected function query()
    {
        // bangun query dengan sum kondisional
        $q = Barang::withSum(
                ['trxBarangMasuk as total_masuk' => fn($q) => $this->applyDateFilter($q, 'tanggal_masuk')],
                'jumlah_brgmasuk'
            )
            ->withSum(
                ['trxBarangKeluar as total_keluar' => fn($q) => $this->applyDateFilter($q, 'tanggal_keluar')],
                'jumlah_brgkeluar'
            );

        if ($this->search) {
            $q->where('nama_barang', 'like', '%'.$this->search.'%');
        }

        return $q;
    }

    protected function applyDateFilter($query, $column)
    {
        switch ($this->filterType) {
            case 'harian':
                $query->whereDate($column, $this->filterDate);
                break;

            case 'mingguan':
                $start = Carbon::parse($this->filterDate)->startOfWeek(); // Senin
                $end   = Carbon::parse($this->filterDate)->endOfWeek();   // Minggu
                $query->whereBetween($column, [
                    $start->toDateString(),
                    $end->toDateString(),
                ]);
                break;

            case 'bulanan':
                $start = Carbon::parse($this->filterMonth)->startOfMonth();
                $end   = Carbon::parse($this->filterMonth)->endOfMonth();
                $query->whereBetween($column, [
                    $start->toDateString(),
                    $end->toDateString(),
                ]);
                break;

            case 'tahunan':
                $start = Carbon::createFromFormat('Y', $this->filterYear)->startOfYear();
                $end   = Carbon::createFromFormat('Y', $this->filterYear)->endOfYear();
                $query->whereBetween($column, [
                    $start->toDateString(),
                    $end->toDateString(),
                ]);
                break;

            case 'rentang':
                if ($this->startDate && $this->endDate) {
                    $query->whereBetween($column, [
                        $this->startDate,
                        $this->endDate,
                    ]);
                }
                break;
        }
    }

    public function exportPdf()
    {
        $barangs = $this->query()
            ->get()
            ->map(function($b) {
                $b->stok_awal  = $b->stok - ($b->total_masuk - $b->total_keluar);
                $b->stok_akhir = $b->stok;
                return $b;
            });

        // label filter untuk header PDF
        $filterLabel = $this->getFilterLabel();

        $pdf = Pdf::loadView('pdf.barang-report', compact('barangs', 'filterLabel'))
                  ->setPaper('a4', 'landscape');

        return Response::streamDownload(
            fn() => print($pdf->output()),
            'laporan-barang-'.now()->format('Ymd_His').'.pdf'
        );
    }

    private function getFilterLabel()
    {
        switch ($this->filterType) {
            case 'harian':
                return 'Tanggal: '.Carbon::parse($this->filterDate)->format('d M Y');

            case 'mingguan':
                return 'Minggu: '
                    .Carbon::parse($this->filterDate)->startOfWeek()->format('d M Y')
                    .' – '
                    .Carbon::parse($this->filterDate)->endOfWeek()->format('d M Y');

            case 'bulanan':
                return 'Bulan: '.Carbon::parse($this->filterMonth)->format('F Y');

            case 'tahunan':
                return 'Tahun: '.$this->filterYear;

            case 'rentang':
                return 'Periode: '
                    .Carbon::parse($this->startDate)->format('d M Y')
                    .' – '
                    .Carbon::parse($this->endDate)->format('d M Y');

            default:
                return 'Filter: Tidak diketahui';
        }
    }

    // Method untuk reset filter ke default saat tipe filter berubah
    public function updatedFilterType()
    {
        switch ($this->filterType) {
            case 'harian':
            case 'mingguan':
                $this->filterDate = now()->toDateString();
                break;
            case 'bulanan':
                $this->filterMonth = now()->format('Y-m');
                break;
            case 'tahunan':
                $this->filterYear = now()->format('Y');
                break;
            case 'rentang':
                $this->startDate = now()->startOfMonth()->toDateString();
                $this->endDate = now()->toDateString();
                break;
        }
    }
}
