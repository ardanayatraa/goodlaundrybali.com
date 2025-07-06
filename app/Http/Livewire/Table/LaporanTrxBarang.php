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
    public $filterType = 'harian';    // opsi: 'harian' atau 'mingguan'
    public $filterDate;               // YYYY-MM-DD

    public function mount()
    {
        // default filterDate = hari ini
        $this->filterDate = now()->toDateString();
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
        if ($this->filterType === 'harian') {
            $query->whereDate($column, $this->filterDate);
        } else {
            $start = Carbon::parse($this->filterDate)->startOfWeek(); // Senin
            $end   = Carbon::parse($this->filterDate)->endOfWeek();   // Minggu
            $query->whereBetween($column, [
                $start->toDateString(),
                $end->toDateString(),
            ]);
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
        $filterLabel = $this->filterType === 'harian'
            ? 'Tanggal: '.Carbon::parse($this->filterDate)->format('d M Y')
            : 'Minggu: '
                .Carbon::parse($this->filterDate)->startOfWeek()->format('d M Y')
                .' – '
                .Carbon::parse($this->filterDate)->endOfWeek()->format('d M Y');

        $pdf = Pdf::loadView('pdf.barang-report', compact('barangs', 'filterLabel'))
                  ->setPaper('a4', 'landscape');

        return Response::streamDownload(
            fn() => print($pdf->output()),
            'laporan-barang-'.now()->format('Ymd_His').'.pdf'
        );
    }
}
