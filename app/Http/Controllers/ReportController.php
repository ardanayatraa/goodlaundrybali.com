<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\TrxBarangKeluar;
use App\Models\TrxBarangMasuk;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
   public function generate(Request $request): StreamedResponse
    {
        // Baca langsung dari query-string start_date/end_date/search
        $start  = $request->query('start_date', Carbon::today()->toDateString());
        $end    = $request->query('end_date',   Carbon::today()->toDateString());
        $search = $request->query('search', '');

        // Jika ingin juga filter by nama_barang
        $barangs = Barang::query()
            ->when($search, fn($q) => $q->where('nama_barang', 'like', "%{$search}%"))
            ->orderBy('nama_barang')
            ->get();

        // Hitung ringkasan stok per barang
        $stockSummary = $barangs->map(function($b) use($start, $end) {
            $masuk = TrxBarangMasuk::where('id_barang', $b->id_barang)
                ->whereDate('tanggal_masuk','>=',$start)
                ->whereDate('tanggal_masuk','<=',$end)
                ->sum('jumlah_brgmasuk');

            $keluar = TrxBarangKeluar::where('id_barang', $b->id_barang)
                ->whereDate('tanggal_keluar','>=',$start)
                ->whereDate('tanggal_keluar','<=',$end)
                ->sum('jumlah_brgkeluar');

            $stokAkhir = $b->stok;
            $stokAwal  = $stokAkhir - $masuk + $keluar;

            return (object)[
                'nama'       => $b->nama_barang,
                'stok_awal'  => $stokAwal,
                'masuk'      => $masuk,
                'keluar'     => $keluar,
                'stok_akhir' => $stokAkhir,
            ];
        });

        // Total untuk footer
        $totalAwal  = $stockSummary->sum('stok_awal');
        $totalMasuk = $stockSummary->sum('masuk');
        $totalKeluar= $stockSummary->sum('keluar');
        $totalAkhir = $stockSummary->sum('stok_akhir');

        // Generate PDF, pass exactly these variabel ke view
        $filterLabel = "Periode: " . Carbon::parse($start)->format('d M Y') . " s.d. " . Carbon::parse($end)->format('d M Y');

        $pdf = Pdf::loadView('pdf.barang-report', compact(
            'stockSummary',
            'start',
            'end',
            'search',
            'totalAwal',
            'totalMasuk',
            'totalKeluar',
            'totalAkhir',
            'filterLabel'
        ))->setPaper('a4','landscape');

        $filename = "Laporan_Stok_{$start}_to_{$end}.pdf";

        return response()->stream(function() use($pdf) {
            echo $pdf->output();
        }, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => "inline; filename=\"{$filename}\"",
        ]);
    }

    public function generatePelanggan(Request $request)
    {
        $query = \App\Models\Pelanggan::query()
            ->where('keterangan', 'Member');

        if ($request->filterStartDate && $request->filterEndDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->filterStartDate)->startOfDay(),
                Carbon::parse($request->filterEndDate)->endOfDay(),
            ]);
        }

        $data = $query->get();

        $pdf = Pdf::loadView('pdf.pelanggan-report', compact('data'))
            ->setPaper('a4', 'portrait');

        $filename = 'Laporan_Pelanggan_' . now()->format('YmdHis') . '.pdf';

        return response()->stream(function () use ($pdf) {
            echo $pdf->output();
        }, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => "inline; filename=\"{$filename}\"",
        ]);
    }
}
