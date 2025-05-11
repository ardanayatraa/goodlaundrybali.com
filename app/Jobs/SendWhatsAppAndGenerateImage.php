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
use Spatie\Browsershot\Browsershot;

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

    $htmlContent = view('transaksi.template', ['transaksi' => $transaksi])->render();
    $filename = 'transaksi_' . $transaksi->id_transaksi . '.png';
    $filePath = storage_path('app/public/' . $filename);

    try {
        // Generate gambar
        Browsershot::html($htmlContent)
            ->windowSize(720, 1280)
            ->setOption('fullPage', true)
            ->save($filePath);

        if (!file_exists($filePath)) {
            Log::error("Gagal generate gambar: file $filePath tidak ditemukan.");
            return;
        }
sleep(5);
        // Kirim ke WA
        $number = $transaksi->pelanggan->no_telp;
        $message = "Halo *{$transaksi->pelanggan->nama_pelanggan}*, laundry Anda sudah siap diambil! 🚀";

        $response = Http::post(env('WA_API_URL') . '/send-message', [
            'number' => $number,
            'message' => $message,
            'mediaUrl' => env('APP_URL') . '/storage/' . $filename,
        ]);

        if ($response->successful()) {
            Log::info('WA Response:', $response->json());

            // Hapus file setelah sukses kirim
            unlink($filePath);
            Log::info("File $filename berhasil dihapus.");
        } else {
            Log::error("Gagal kirim WA. Status: {$response->status()}", $response->json());
        }
    } catch (\Exception $e) {
        Log::error('Terjadi error di job WA: ' . $e->getMessage());
    }
}

}
