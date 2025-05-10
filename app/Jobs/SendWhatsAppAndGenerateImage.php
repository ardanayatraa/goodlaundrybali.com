<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Transaksi;

class SendWhatsAppAndGenerateImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $transaksi;

    public function __construct(Transaksi $transaksi)
    {
        $this->transaksi = $transaksi;
    }

    public function handle()
    {
        $transaksi = $this->transaksi;

        // Generate image
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
                Storage::disk('public')->put($filename, $response->getBody()->getContents());
                Log::info("Gambar berhasil disimpan: storage/app/public/{$filename}");
            } else {
                Log::error("Gagal generate gambar: " . $response->getBody()->getContents());
                return;
            }
        } catch (\Exception $e) {
            Log::error('Error API HTML to Image: ' . $e->getMessage());
            return;
        }

        // Send WhatsApp message
        $number = $transaksi->pelanggan->no_telp;
        $message = "Halo *{$transaksi->pelanggan->nama_pelanggan}*, laundry Anda sudah siap diambil! 🚀";

        try {
            $response = Http::post(env('WA_API_URL') . '/send-message', [
                'number' => $number,
                'message' => $message,
                'mediaUrl' => env('APP_URL') . '/storage/' . $filename
            ]);

            Log::info('WA Response:', $response->json());
        } catch (\Exception $e) {
            Log::error('WA Error: ' . $e->getMessage());
        }
    }
}
