<?php

namespace App\Observers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Point;
use Illuminate\Support\Facades\Http;
use App\Jobs\SendWhatsAppAndGenerateImage;

class TransaksiObserver
{
    public function created(Transaksi $transaksi)
    {
        // ...existing code...
    }

    public function updated(Transaksi $transaksi)
{
    if ($transaksi->status_transaksi === 'siap_ambil') {
        // Kirim WA dan generate gambar secara async
        SendWhatsAppAndGenerateImage::dispatch($transaksi)->onQueue('default');
    }

    if (
        $transaksi->status_transaksi === 'terambil' &&
        $transaksi->status_pembayaran === 'Lunas'
    ) {
        // Berikan poin hanya jika status pembayaran sudah lunas
        $point = Point::where('id_pelanggan', $transaksi->pelanggan->id_pelanggan)->first();

        if ($point) {
            $point->increment('jumlah_point', 1);
        } else {
            Point::create([
                'id_pelanggan' => $transaksi->pelanggan->id_pelanggan,
                'tanggal' => now(),
                'jumlah_point' => 1,
            ]);
        }
    }
}


    public function deleted(Transaksi $transaksi)
    {
        DetailTransaksi::where('id_transaksi', $transaksi->id_transaksi)->delete();
    }
}
