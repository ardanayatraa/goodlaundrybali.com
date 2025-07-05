<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use App\Models\TrxBarangMasuk;
use App\Models\TrxBarangKeluar;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ============================
        //  A. DATA HARI INI
        // ============================
        $today = Carbon::today()->toDateString();

        // 1. Pelanggan baru hari ini
        $pelangganHariIni = Pelanggan::whereDate('created_at', $today)->count();

        // 2. Transaksi hari ini (count & nominal)
        $transaksiHariIniCount   = Transaksi::whereDate('tanggal_transaksi', $today)->count();
        $transaksiHariIniNominal = Transaksi::whereDate('tanggal_transaksi', $today)
            ->sum('total_harga');

        // 3. Barang Masuk hari ini (unit & nominal)
        $totalBarangMasukHariIni = TrxBarangMasuk::whereDate('tanggal_masuk', $today)
            ->sum('jumlah_brgmasuk');
        $nominalMasukHariIni = TrxBarangMasuk::join('barangs', 'trx_barang_masuks.id_barang', '=', 'barangs.id_barang')
            ->whereDate('tanggal_masuk', $today)
            ->sum(DB::raw('barangs.harga * trx_barang_masuks.jumlah_brgmasuk'));

        // 4. Barang Keluar hari ini (unit & nominal)
        $totalBarangKeluarHariIni = TrxBarangKeluar::whereDate('tanggal_keluar', $today)
            ->sum('jumlah_brgkeluar');
        $nominalKeluarHariIni = TrxBarangKeluar::join('barangs', 'trx_barang_keluars.id_barang', '=', 'barangs.id_barang')
            ->whereDate('tanggal_keluar', $today)
            ->sum(DB::raw('barangs.harga * trx_barang_keluars.jumlah_brgkeluar'));

        // ============================
        //  B. DATA KESELURUHAN
        // ============================
        // 1. Total Pelanggan & Growth
        $totalPelanggan     = Pelanggan::count();
        $pelangganBulanLalu = Pelanggan::whereMonth('created_at', now()->subMonth()->month)->count();
        $growthPelanggan    = $pelangganBulanLalu > 0
            ? (($totalPelanggan - $pelangganBulanLalu) / $pelangganBulanLalu) * 100
            : 0;

        // 2. Pesanan Diproses & Baru (bulanan)
        $pesananDalamProses = Transaksi::where('status_transaksi', 'diproses')->count();
        $pesananBaru        = Transaksi::whereMonth('tanggal_transaksi', now()->month)->count();

        // 3. Total Transaksi & Growth (all-time vs minggu lalu)
        $totalTransaksi        = Transaksi::sum('total_harga');
        $transaksiMingguLalu   = Transaksi::whereBetween('tanggal_transaksi', [now()->subWeek(), now()])
                                          ->sum('total_harga');
        $growthTransaksi       = $transaksiMingguLalu > 0
            ? (($totalTransaksi - $transaksiMingguLalu) / $transaksiMingguLalu) * 100
            : 0;

        // 4. Barang Masuk (bulanan)
        $totalBarangMasuk   = TrxBarangMasuk::whereMonth('tanggal_masuk', now()->month)
            ->sum('jumlah_brgmasuk');
        $nominalMasuk       = TrxBarangMasuk::join('barangs', 'trx_barang_masuks.id_barang', '=', 'barangs.id_barang')
            ->whereMonth('tanggal_masuk', now()->month)
            ->sum(DB::raw('barangs.harga * trx_barang_masuks.jumlah_brgmasuk'));

        // 5. Barang Keluar (bulanan)
        $totalBarangKeluar  = TrxBarangKeluar::whereMonth('tanggal_keluar', now()->month)
            ->sum('jumlah_brgkeluar');
        $nominalKeluar      = TrxBarangKeluar::join('barangs', 'trx_barang_keluars.id_barang', '=', 'barangs.id_barang')
            ->whereMonth('tanggal_keluar', now()->month)
            ->sum(DB::raw('barangs.harga * trx_barang_keluars.jumlah_brgkeluar'));

        return view('dashboard', compact(
            // hari ini
            'pelangganHariIni',
            'transaksiHariIniCount',
            'transaksiHariIniNominal',
            'totalBarangMasukHariIni',
            'nominalMasukHariIni',
            'totalBarangKeluarHariIni',
            'nominalKeluarHariIni',
            // keseluruhan
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
