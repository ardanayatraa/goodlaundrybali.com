<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\TrxBarangMasuk;
use App\Models\TrxBarangKeluar;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportBarangController extends Controller
{
    public function generate(Request $request)
    {
        // Tentukan rentang tanggal filter
        $start = $request->filterStartDate
            ? Carbon::parse($request->filterStartDate)->startOfDay()
            : null;
        $end   = $request->filterEndDate
            ? Carbon::parse($request->filterEndDate)->endOfDay()
            : null;

        // Ambil semua barang
        $barangs = Barang::all();

        // Bangun data report per barang
        $report = $barangs->map(function($b) use ($start, $end) {
            $masukBefore = TrxBarangMasuk::where('id_barang', $b->id_barang)
                ->when($start, fn($q) => $q->where('tanggal_masuk', '<', $start))
                ->sum('jumlah_brgmasuk');

            $keluarBefore = TrxBarangKeluar::where('id_barang', $b->id_barang)
                ->when($start, fn($q) => $q->where('tanggal_keluar', '<', $start))
                ->sum('jumlah_brgkeluar');

            $stokAwal = $masukBefore - $keluarBefore;

            $masukPeriod = TrxBarangMasuk::where('id_barang', $b->id_barang)
                ->when($start && $end, fn($q) => $q->whereBetween('tanggal_masuk', [$start, $end]))
                ->sum('jumlah_brgmasuk');

            $keluarPeriod = TrxBarangKeluar::where('id_barang', $b->id_barang)
                ->when($start && $end, fn($q) => $q->whereBetween('tanggal_keluar', [$start, $end]))
                ->sum('jumlah_brgkeluar');

            $stokAkhir = $stokAwal + $masukPeriod - $keluarPeriod;

            return [
                'nama'           => $b->nama_barang,
                'harga'          => $b->harga,
                'stok_awal'      => $stokAwal,
                'jumlah_masuk'   => $masukPeriod,
                'jumlah_keluar'  => $keluarPeriod,
                'stok_akhir'     => $stokAkhir,
            ];
        });

        // Deskripsi filter untuk header
        $filterDesc = ($start && $end)
            ? "Rentang: {$start->format('Y-m-d')} s/d {$end->format('Y-m-d')}"
            : 'Semua Periode';

        // Generate PDF
        $pdf = Pdf::loadView('pdf.barang-report', compact('report', 'filterDesc'))
                  ->setPaper('a4', 'landscape');

        $filename = 'Laporan_Barang_' . now()->format('YmdHis') . '.pdf';

        /** @var StreamedResponse $response */
        $response = response()->stream(function() use ($pdf) {
            echo $pdf->output();
        }, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => "inline; filename=\"{$filename}\"",
        ]);

        return $response;
    }
}
