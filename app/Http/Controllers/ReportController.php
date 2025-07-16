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
   public function generate(Request $request)
    {
        $query = Transaksi::with([
            'pelanggan',
            'detailTransaksi.paket',
        ]);

        // filter berdasarkan tipe
        switch ($request->filterType) {
            case 'daily':
                $query->whereDate('tanggal_transaksi', $request->filterDate);
                break;
            case 'weekly':
                $query->whereBetween('tanggal_transaksi', [
                    $request->filterStartDate,
                    $request->filterEndDate
                ]);
                break;
            case 'monthly':
                $m = Carbon::parse($request->filterMonth);
                $query->whereMonth('tanggal_transaksi', $m->month)
                      ->whereYear('tanggal_transaksi', $m->year);
                break;
            case 'yearly':
                $query->whereYear('tanggal_transaksi', $request->filterYear);
                break;
            case 'range':
                if ($request->filterStartDate && $request->filterEndDate) {
                    $query->whereBetween('tanggal_transaksi', [
                        $request->filterStartDate,
                        $request->filterEndDate
                    ]);
                }
                break;
        }

        $data = $query->get();

        $filterDescription = match ($request->filterType) {
            'daily'   => "Harian: " . ($request->filterDate ?? '-'),
            'weekly'  => "Mingguan: {$request->filterStartDate} s/d {$request->filterEndDate}",
            'monthly' => "Bulanan: " . ($request->filterMonth ?? '-'),
            'yearly'  => "Tahunan: " . ($request->filterYear ?? '-'),
            'range'   => "Rentang: {$request->filterStartDate} s/d {$request->filterEndDate}",
            default   => "Tanpa filter",
        };

        $pdf = Pdf::loadView('pdf.transaksi-report', compact('data', 'request', 'filterDescription'))
            ->setPaper('a4', 'landscape')
            ->setOption('dpi', 96)
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true);

        $filename = 'Laporan_Transaksi_' . now()->format('YmdHis') . '.pdf';

        /** @var StreamedResponse $response */
        $response = response()->stream(function () use ($pdf) {
            echo $pdf->output();
        }, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => "inline; filename=\"{$filename}\"",
        ]);

        return $response;
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
