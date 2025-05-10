<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportBarangController extends Controller
{
    public function generate(Request $request)
    {
        $query = Barang::query();

        switch ($request->filterType) {
            case 'daily':
                $query->whereDate('created_at', $request->filterDate);
                break;

            case 'weekly':
                $query->whereBetween('created_at', [$request->filterStartDate, $request->filterEndDate]);
                break;

            case 'monthly':
                $query->whereMonth('created_at', Carbon::parse($request->filterMonth)->month)
                      ->whereYear('created_at', Carbon::parse($request->filterMonth)->year);
                break;

            case 'yearly':
                $query->whereYear('created_at', $request->filterYear);
                break;

            case 'range':
                if ($request->filterStartDate && $request->filterEndDate) {
                    $query->whereBetween('created_at', [$request->filterStartDate, $request->filterEndDate]);
                }
                break;

            default:
                break;
        }

        $data = $query->get();

        // Tambahkan deskripsi filter
        $filterDescription = match ($request->filterType) {
            'daily' => "Harian: " . ($request->filterDate ?? 'Tidak dipilih'),
            'monthly' => "Bulanan: " . ($request->filterMonth ?? 'Tidak dipilih'),
            'yearly' => "Tahunan: " . ($request->filterYear ?? 'Tidak dipilih'),
            'weekly' => "Mingguan: " . ($request->filterWeek ?? 'Tidak dipilih'),
            'range' => "Rentang Tanggal: " . ($request->filterStartDate ?? '-') . " s/d " . ($request->filterEndDate ?? '-'),
            default => "Tidak ada filter yang dipilih",
        };

        $pdf = Pdf::loadView('pdf.barang-report', compact('data', 'request', 'filterDescription'))
                  ->setPaper('a4', 'landscape')
                  ->setOption('dpi', 96)
                  ->setOption('isHtml5ParserEnabled', true)
                  ->setOption('isRemoteEnabled', true);

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'Laporan_Barang_' . now()->format('YmdHis') . '.pdf',
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="Laporan_Barang_' . now()->format('YmdHis') . '.pdf"',
            ]
        );
    }
}
