<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use App\Models\TrxBarangMasuk;
use App\Models\TrxBarangKeluar;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total Pelanggan & Growth
        $totalPelanggan     = Pelanggan::count();
        $pelangganBulanLalu = Pelanggan::whereMonth('created_at', now()->subMonth()->month)->count();
        $growthPelanggan    = $pelangganBulanLalu > 0
            ? (($totalPelanggan - $pelangganBulanLalu) / $pelangganBulanLalu) * 100
            : 0;

        // 2. Pesanan Diproses & Baru
        $pesananDalamProses = Transaksi::where('status_transaksi', 'diproses')->count();
        $pesananBaru        = Transaksi::whereMonth('tanggal_transaksi', now()->month)->count();

        // 3. Total Transaksi & Growth
        $totalTransaksi     = Transaksi::sum('total_harga');
        $transaksiMingguLalu = Transaksi::whereBetween('tanggal_transaksi', [now()->subWeek(), now()])
            ->sum('total_harga');
        $growthTransaksi    = $transaksiMingguLalu > 0
            ? (($totalTransaksi - $transaksiMingguLalu) / $transaksiMingguLalu) * 100
            : 0;

        // 4. Barang Masuk: jumlah unit & nominal harga via relasi
        $totalBarangMasuk   = TrxBarangMasuk::whereMonth('tanggal_masuk', now()->month)
            ->sum('jumlah_brgmasuk');
        $nominalMasuk       = TrxBarangMasuk::join('barangs', 'trx_barang_masuks.id_barang', '=', 'barangs.id_barang')
            ->whereMonth('tanggal_masuk', now()->month)
            ->sum(DB::raw('barangs.harga * trx_barang_masuks.jumlah_brgmasuk'));

        // 5. Barang Keluar: jumlah unit & nominal harga via relasi
        $totalBarangKeluar  = TrxBarangKeluar::whereMonth('tanggal_keluar', now()->month)
            ->sum('jumlah_brgkeluar');
        $nominalKeluar      = TrxBarangKeluar::join('barangs', 'trx_barang_keluars.id_barang', '=', 'barangs.id_barang')
            ->whereMonth('tanggal_keluar', now()->month)
            ->sum(DB::raw('barangs.harga * trx_barang_keluars.jumlah_brgkeluar'));

        return view('dashboard', compact(
            'totalPelanggan',
            'growthPelanggan',
            'pesananDalamProses',
            'pesananBaru',
            'totalTransaksi',
            'growthTransaksi',
            'totalBarangMasuk',
            'nominalMasuk',
            'totalBarangKeluar',
            'nominalKeluar'
        ));
    }
}
