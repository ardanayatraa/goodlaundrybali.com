<?php

namespace App\Observers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Jobs\SendWhatsAppAndGenerateImage;

class TransaksiObserver
{
    public function created(Transaksi $transaksi)
    {
        // Tambah poin kalau status pembayaran sudah 'Lunas'
        if ($transaksi->status_pembayaran === 'Lunas') {

            $pelanggan = $transaksi->pelanggan;
            if ($pelanggan->keterangan=='Member') {
                    $pelanggan->update([
            'point' => $pelanggan->point + 1,
        ]);
            }
        }
    }

    public function updated(Transaksi $transaksi)
    {
        // Kirim WhatsApp dan generate gambar kalau status jadi 'siap_ambil'
        if ($transaksi->status_transaksi === 'siap_ambil') {
            SendWhatsAppAndGenerateImage::dispatch($transaksi)->onQueue('default');
        }

        // Tambah poin kalau status pembayaran sudah 'Lunas'
        if ($transaksi->status_pembayaran === 'Lunas') {

            $pelanggan = $transaksi->pelanggan;
            if ($pelanggan->keterangan=='Member') {
                    $pelanggan->update([
            'point' => $pelanggan->point + 1,
        ]);
            }
        }
    }

    public function deleted(Transaksi $transaksi)
    {
        // Hapus detail transaksi yang berelasi saat transaksi dihapus
        DetailTransaksi::where('id_transaksi', $transaksi->id_transaksi)->delete();
    }
}
