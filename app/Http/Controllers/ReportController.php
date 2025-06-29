<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function generate(Request $request)
    {
        $query = Transaksi::with([
            'pelanggan',
            'detailTransaksi.paket',
        ]);

        switch ($request->filterType) {
            case 'daily':
                $query->whereDate('tanggal_transaksi', $request->filterDate);
                break;
            case 'weekly':
                $query->whereBetween('tanggal_transaksi', [$request->filterStartDate, $request->filterEndDate]);
                break;
            case 'monthly':
                $query->whereMonth('tanggal_transaksi', Carbon::parse($request->filterMonth)->month)
                      ->whereYear('tanggal_transaksi', Carbon::parse($request->filterMonth)->year);
                break;
            case 'yearly':
                $query->whereYear('tanggal_transaksi', $request->filterYear);
                break;
            case 'range':
                if ($request->filterStartDate && $request->filterEndDate) {
                    $query->whereBetween('tanggal_transaksi', [$request->filterStartDate, $request->filterEndDate]);
                }
                break;
        }

        $data = $query->get();

        $filterDescription = match ($request->filterType) {
            'daily' => "Harian: " . ($request->filterDate ?? 'Tidak dipilih'),
            'monthly' => "Bulanan: " . ($request->filterMonth ?? 'Tidak dipilih'),
            'yearly' => "Tahunan: " . ($request->filterYear ?? 'Tidak dipilih'),
            'weekly' => "Mingguan: " . ($request->filterStartDate ?? '-') . " s/d " . ($request->filterEndDate ?? '-'),
            'range' => "Rentang Tanggal: " . ($request->filterStartDate ?? '-') . " s/d " . ($request->filterEndDate ?? '-'),
            default => "Tidak ada filter yang dipilih",
        };

        $pdf = Pdf::loadView('pdf.transaksi-report', compact('data', 'request', 'filterDescription'))
            ->setPaper('a4', 'landscape')
            ->setOption('dpi', 96)
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true);

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'Laporan_Transaksi_' . now()->format('YmdHis') . '.pdf',
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="Laporan_Transaksi_' . now()->format('YmdHis') . '.pdf"',
            ]
        );
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

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.pelanggan-report', compact('data'))
        ->setPaper('a4', 'portrait');

    return response()->streamDownload(
        fn () => print($pdf->output()),
        'Laporan_Pelanggan_' . now()->format('YmdHis') . '.pdf'
    );
}

}
