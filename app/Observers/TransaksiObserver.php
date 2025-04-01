<?php

namespace App\Observers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Point;
use Illuminate\Support\Facades\Http;

class TransaksiObserver
{
    public function created(Transaksi $transaksi)
    {
        // ...existing code...
    }

    public function updated(Transaksi $transaksi)
    {
        if ($transaksi->status_transaksi === 'siap_ambil') {
            // API Node.js untuk generate gambar
            $apiUrl = env('HTML_TO_IMAGE_API');
            $url = route('transaksi.image', ['id' => $transaksi->id_transaksi], true);
            $filename = 'transaksi_' . $transaksi->id_transaksi . '.png';

            try {
                $client = new Client(['timeout' => 60]);
                $response = $client->post($apiUrl, [
                    'headers' => ['Content-Type' => 'application/json'],
                    'json' => [
                        'url' => $url,
                        'width' => 720,
                        'height' => 1280,
                        'format' => 'png'
                    ]
                ]);

                if ($response->getStatusCode() === 200) {
                    // Menyimpan gambar ke storage/public
                    Storage::disk('public')->put($filename, $response->getBody()->getContents());
                    \Log::info("Gambar berhasil disimpan: storage/app/public/{$filename}");
                } else {
                    \Log::error("Gagal generate gambar: " . $response->getBody()->getContents());
                    return;
                }
            } catch (\Exception $e) {
                \Log::error('Error API HTML to Image: ' . $e->getMessage());
                return;
            }

            // Kirim WhatsApp dengan gambar

            $number = $transaksi->pelanggan->no_telp;
            $message = "Halo *{$transaksi->pelanggan->nama_pelanggan}*, laundry Anda sudah siap diambil! 🚀";

            try {
                $response = Http::post(env('WA_API_URL') . '/send-message', [
                    'number' => $number,
                    'message' => $message,
                    'mediaUrl' => env('APP_URL') . '/storage/' . $filename
                ]);

                // Debug response
                \Log::info('WA Response:', $response->json());
            } catch (\Exception $e) {
                \Log::error('WA Error: ' . $e->getMessage());
            }
        }

        if ($transaksi->status_transaksi === 'terambil') {
            // Mengelola poin setelah transaksi terambil
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
