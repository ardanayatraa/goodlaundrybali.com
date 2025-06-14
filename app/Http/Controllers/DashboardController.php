<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use App\Models\TrxBarangMasuk;
use App\Models\TrxBarangKeluar;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Pelanggan
        $totalPelanggan = Pelanggan::count();
        $pelangganBulanLalu = Pelanggan::whereMonth('created_at', now()->subMonth()->month)->count();
        $growthPelanggan = $pelangganBulanLalu > 0 ? (($totalPelanggan - $pelangganBulanLalu) / $pelangganBulanLalu) * 100 : 0;

        // Total Pesanan dalam Proses
        $pesananDalamProses = Transaksi::where('status_transaksi', 'diproses')->count();
        $pesananBaru = Transaksi::whereMonth('tanggal_transaksi', now()->month)->count();

        // Total Transaksi
        $totalTransaksi = Transaksi::sum('total_harga');
        $transaksiMingguLalu = Transaksi::whereBetween('tanggal_transaksi', [now()->subWeek(), now()])->sum('total_harga');
        $growthTransaksi = $transaksiMingguLalu > 0 ? (($totalTransaksi - $transaksiMingguLalu) / $transaksiMingguLalu) * 100 : 0;

        // Barang Masuk & Keluar Bulan Ini
        $totalBarangMasuk = TrxBarangMasuk::whereMonth('tanggal_masuk', now()->month)->sum('jumlah_brgmasuk');
        $totalBarangKeluar = TrxBarangKeluar::whereMonth('tanggal_keluar', now()->month)->sum('jumlah_brgkeluar');

        return view('dashboard', compact(
            'totalPelanggan',
            'growthPelanggan',
            'pesananDalamProses',
            'pesananBaru',
            'totalTransaksi',
            'growthTransaksi',
            'totalBarangMasuk',
            'totalBarangKeluar'
        ));
    }
}
