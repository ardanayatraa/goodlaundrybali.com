<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'jenis_laporan'   => 'required|in:harian,bulanan,tahunan,rentang',
            'tanggal_mulai'   => 'nullable|date|required_if:jenis_laporan,rentang',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai|required_if:jenis_laporan,rentang',
        ]);

        $query = Transaksi::with(['pelanggan', 'paket', 'point', 'detailTransaksi']);

        switch ($request->jenis_laporan) {
            case 'harian':
                $query->whereDate('tanggal_transaksi', Carbon::today());
                break;
            case 'bulanan':
                $query->whereMonth('tanggal_transaksi', Carbon::now()->month)
                      ->whereYear('tanggal_transaksi', Carbon::now()->year);
                break;
            case 'tahunan':
                $query->whereYear('tanggal_transaksi', Carbon::now()->year);
                break;
            case 'rentang':
                $query->whereBetween('tanggal_transaksi', [
                    $request->tanggal_mulai,
                    $request->tanggal_selesai
                ]);
                break;
        }

        $laporan = $query->get();

        return view('laporan.hasil', compact('laporan', 'request'));
    }

    public function downloadPDF(Request $request): StreamedResponse
    {
        // Build same query as generate()
        $query = Transaksi::with(['pelanggan', 'paket', 'point', 'detailTransaksi']);

        switch ($request->jenis_laporan) {
            case 'harian':
                $query->whereDate('tanggal_transaksi', Carbon::today());
                break;
            case 'bulanan':
                $query->whereMonth('tanggal_transaksi', Carbon::now()->month)
                      ->whereYear('tanggal_transaksi', Carbon::now()->year);
                break;
            case 'tahunan':
                $query->whereYear('tanggal_transaksi', Carbon::now()->year);
                break;
            case 'rentang':
                $query->whereBetween('tanggal_transaksi', [
                    $request->tanggal_mulai,
                    $request->tanggal_selesai
                ]);
                break;
        }

        $laporan = $query->get();

        // Generate PDF
        $pdf = Pdf::loadView('laporan.pdf', compact('laporan', 'request'))
                  ->setPaper('a4', 'landscape');

        $filename = 'Laporan_Transaksi_' . now()->format('YmdHis') . '.pdf';

        return response()->stream(function() use ($pdf) {
            echo $pdf->output();
        }, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => "inline; filename=\"{$filename}\"",
        ]);
    }
}
