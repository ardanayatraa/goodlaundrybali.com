<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Pelanggan;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\TrxBarangMasuk;
use App\Models\TrxBarangKeluar;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    // ============================== PAKET ==================================

    public function paketDelete($id)
    {
        $paket = Paket::findOrFail($id);
        $paket->delete();

        return redirect()->back()->with('success', 'Paket berhasil dihapus.');
    }

    public function paketUpdate(Request $request, $id)
    {
        $paket = Paket::findOrFail($id);

        $paket->update([
            'jenis_paket' => $request->input('jenis_paket'),
            'harga' => $request->input('harga'),
            'waktu_pengerjaan' => $request->input('waktu_pengerjaan'),
        ]);

        return redirect()->back()->with('success', 'Paket berhasil diperbarui.');
    }

    // ============================ PELANGGAN ================================

    public function pelangganUpdate(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $pelanggan->update([
            'nama_pelanggan' => $request->input('nama_pelanggan'),
            'no_telp' => $request->input('no_telp'),
            'alamat' => $request->input('alamat'),
            'keterangan' => $request->input('keterangan'),
        ]);

        return redirect()->back()->with('success', 'Pelanggan berhasil diperbarui.');
    }

    public function pelangganDelete($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();

        return redirect()->back()->with('success', 'Pelanggan berhasil dihapus.');
    }

    public function printMember($id)
    {
        $pelanggan = Pelanggan::find($id);

        // Pastikan pelanggan ditemukan
        if (!$pelanggan) {
            abort(404, 'Pelanggan tidak ditemukan');
        }

 
        return view('print-member', compact('pelanggan'));
    }

    // ============================ BARANG ===================================

    public function barangUpdate(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $barang->update([
            'nama_barang' => $request->input('nama_barang'),
            'harga' => $request->input('harga'),
        ]);

        return redirect()->back()->with('success', 'Barang berhasil diperbarui.');
    }

    public function barangDelete($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->back()->with('success', 'Barang berhasil dihapus.');
    }

    // ====================== TRANSAKSI BARANG MASUK =========================

    public function barangMasukUpdate(Request $request, $id)
    {
        $barangMasuk = TrxBarangMasuk::findOrFail($id);

        $barangMasuk->update([
            'id_barang' => $request->input('id_barang'),
            'tanggal_masuk' => $request->input('tanggal_masuk'),
            'nama_admin' => $request->input('nama_admin'),
            'total_harga' => $request->input('total_harga'),
        ]);

        return redirect()->back()->with('success', 'Barang masuk berhasil diperbarui.');
    }

    public function barangMasukDelete($id)
    {
        
        $barangMasuk = TrxBarangMasuk::findOrFail($id);
        $barangMasuk->delete();

        return redirect()->back()->with('success', 'Barang masuk berhasil dihapus.');
    }

    // ====================== TRANSAKSI BARANG KELUAR ========================

    public function barangKeluarUpdate(Request $request, $id)
    {
        $barangKeluar = TrxBarangKeluar::findOrFail($id);

        $barangKeluar->update([
            'id_barang' => $request->input('id_barang'),
            'tanggal_keluar' => $request->input('tanggal_keluar'),
            'nama_admin' => $request->input('nama_admin'),
        ]);

        return redirect()->back()->with('success', 'Barang keluar berhasil diperbarui.');
    }

    public function barangKeluarDelete($id)
    {
        $barangKeluar = TrxBarangKeluar::findOrFail($id);
        $barangKeluar->delete();

        return redirect()->back()->with('success', 'Barang keluar berhasil dihapus.');
    }



    public function transaksiUpdate(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $transaksi->update([
            'nama_pelanggan' => $request->input('nama_pelanggan'),
            'tanggal_transaksi' => $request->input('tanggal_transaksi'),
            'total_harga' => $request->input('total_harga'),
            'metode_pembayaran' => $request->input('metode_pembayaran'),
            'status_pembayaran' => $request->input('status_pembayaran'),
            'status_transaksi' => $request->input('status_transaksi'),
            'jumlah_point' => $request->input('jumlah_point'),
            'status_bonus' => $request->input('status_bonus'),
        ]);

        return redirect()->back()->with('success', 'Transaksi berhasil diperbarui.');
    }

    // Fungsi untuk delete transaksi
    public function transaksiDelete($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
    }
}
