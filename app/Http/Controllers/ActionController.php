<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Pelanggan;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\TrxBarangMasuk;
use App\Models\TrxBarangKeluar;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $pelanggan = Pelanggan::findOrFail($id);

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


    /**
     * Cetak detail transaksi dalam bentuk PDF.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cetakTransaksi($id)
    {
        // Ambil transaksi dengan relasi pelanggan, point, dan detailTransaksi beserta paket+unit
        $transaksi = Transaksi::with([
            'pelanggan',

            'detailTransaksi.paket.unitPaket'
        ])->findOrFail($id);

        // Muat view PDF (resources/views/pdf/transaksi-cetak.blade.php)
        $pdf = PDF::loadView('pdf.transaksi-cetak', compact('transaksi'))
            ->setPaper('a4', 'portrait');

        // Stream ke browser
        return $pdf->stream("transaksi_{$id}.pdf");
    }


        /**
     * Cetak PDF detail transaksi barang keluar.
     */
    public function cetakBarangKeluar($id)
    {
        $keluar = TrxBarangKeluar::with(['barang', 'admin'])
                  ->findOrFail($id);

        $pdf = PDF::loadView('pdf.trx-barang-keluar-cetak', compact('keluar'))
                  ->setPaper('a4', 'portrait');

        return $pdf->stream("barang_keluar_{$id}.pdf");
    }

    /**
     * Cetak PDF detail transaksi barang masuk.
     */
    public function cetakBarangMasuk($id)
    {
        $masuk = TrxBarangMasuk::with(['barang', 'admin'])
                  ->findOrFail($id);

        $pdf = PDF::loadView('pdf.trx-barang-masuk-cetak', compact('masuk'))
                  ->setPaper('a4', 'portrait');

        return $pdf->stream("barang_masuk_{$id}.pdf");
    }

     /**
     * Cetak PDF detail transaksi barang masuk per tanggal.
     *
     * @param  string  $tanggal  format YYYY-MM-DD
     * @return \Illuminate\Http\Response
     */
    public function cetakBarangMasukByDate($tanggal)
    {
        $records = TrxBarangMasuk::with(['barang.unit', 'admin'])
            ->whereDate('tanggal_masuk', $tanggal)
            ->orderBy('id_trx_brgmasuk')
            ->get();

        $pdf = Pdf::loadView('pdf.trx-barang-masuk-cetak-by-date', compact('records', 'tanggal'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream("barang_masuk_{$tanggal}.pdf");
    }


        /**
     * Cetak PDF detail transaksi barang keluar per tanggal.
     *
     * @param  string  $tanggal  format YYYY-MM-DD
     * @return \Illuminate\Http\Response
     */
    public function cetakBarangKeluarByDate($tanggal)
    {
        $records = TrxBarangKeluar::with(['barang.unit', 'admin'])
            ->whereDate('tanggal_keluar', $tanggal)
            ->orderBy('id_trx_brgkeluar')
            ->get();

        $pdf = Pdf::loadView('pdf.trx-barang-keluar-cetak-by-date', compact('records', 'tanggal'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream("barang_keluar_{$tanggal}.pdf");
    }

}
