<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\TrxBarangMasuk;
use App\Models\TrxBarangKeluar;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
            // Hitung transaksi masuk sebelum periode => stok awal
            $masukBefore = TrxBarangMasuk::where('id_barang', $b->id_barang)
                ->when($start, fn($q) => $q->where('tanggal_masuk', '<', $start))
                ->sum('jumlah_brgmasuk');

            // Hitung transaksi keluar sebelum periode => stok awal
            $keluarBefore = TrxBarangKeluar::where('id_barang', $b->id_barang)
                ->when($start, fn($q) => $q->where('tanggal_keluar', '<', $start))
                ->sum('jumlah_brgkeluar');

            $stokAwal = $masukBefore - $keluarBefore;

            // Hitung transaksi masuk di periode
            $masukPeriod = TrxBarangMasuk::where('id_barang', $b->id_barang)
                ->when($start && $end, fn($q) => $q->whereBetween('tanggal_masuk', [$start, $end]))
                ->sum('jumlah_brgmasuk');

            // Hitung transaksi keluar di periode
            $keluarPeriod = TrxBarangKeluar::where('id_barang', $b->id_barang)
                ->when($start && $end, fn($q) => $q->whereBetween('tanggal_keluar', [$start, $end]))
                ->sum('jumlah_brgkeluar');

            // Stok akhir = stok awal + masukPeriod − keluarPeriod
            $stokAkhir = $stokAwal + $masukPeriod - $keluarPeriod;

            return [
                'nama'           => $b->nama_barang,
                'harga'          => $b->harga,
                'jumlah_masuk'   => $masukPeriod,
                'jumlah_keluar'  => $keluarPeriod,
                'stok_awal'      => $stokAwal,
                'stok_akhir'     => $stokAkhir,
            ];
        });

        // Deskripsi filter untuk header
        $filterDesc = $start && $end
            ? "Rentang: {$start->format('Y-m-d')} s/d {$end->format('Y-m-d')}"
            : 'Semua Periode';

        // Generate PDF
        $pdf = Pdf::loadView('pdf.barang-report', compact('report', 'filterDesc'))
                  ->setPaper('a4', 'landscape');

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'Laporan_Barang_'.now()->format('YmdHis').'.pdf',
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="Laporan_Barang_'.now()->format('YmdHis').'.pdf"',
            ]
        );
    }
}
