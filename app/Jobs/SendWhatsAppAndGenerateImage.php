<?php

namespace App\Jobs;

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
        $apiBase   = rtrim(env('HTML_TO_IMAGE_API'), '/');      // e.g. http://localhost:3020
        $email     = env('HTML_TO_IMAGE_API_EMAIL');            // service account email
        $password  = env('HTML_TO_IMAGE_API_PASSWORD');         // service account password

        // 1. Login untuk dapat JWT
        try {
            $login = Http::post("{$apiBase}/api/login", [
                'email'    => $email,
                'password' => $password,
            ]);
            if (! $login->successful()) {
                Log::error('Screenshot API login failed', ['body'=>$login->body()]);
                return;
            }
            $token = $login->json('token');
        } catch (\Exception $e) {
            Log::error('Screenshot API login exception: '.$e->getMessage());
            return;
        }

        // 2. Request screenshot
        $url      = route('transaksi.image', ['id' => $transaksi->id_transaksi], true);
        $filename = 'transaksi_' . $transaksi->id_transaksi . '.png';

        try {
            $resp = Http::withToken($token)
                ->timeout(60)
                ->post("{$apiBase}/api/screenshot", [
                    'url'      => $url,
                    'width'    => 720,
                    'height'   => 1280,
                    'format'   => 'png',
                    'fullPage' => true,
                ]);

            if (! $resp->successful()) {
                Log::error('Screenshot API error', ['status'=>$resp->status(), 'body'=>$resp->body()]);
                return;
            }

            // Simpan binary image
            Storage::disk('public')->put($filename, $resp->body());
            Log::info("Gambar berhasil disimpan: storage/app/public/{$filename}");
        } catch (\Exception $e) {
            Log::error('Screenshot request exception: '.$e->getMessage());
            return;
        }

        // 3. Kirim WA dengan attachment
        $number  = $transaksi->pelanggan->no_telp;
        $message = "Halo *{$transaksi->pelanggan->nama_pelanggan}*, laundry Anda sudah siap diambil! 🚀";

        try {
            $waSession = env('WA_SESSION_ID', 'user123');
            $waApi     = rtrim(env('WA_API_URL'), '/');
            $filePath  = Storage::disk('public')->path($filename);

            $waResp = Http::acceptJson()
                ->attach('file', fopen($filePath, 'r'), $filename)
                ->post("{$waApi}/api/sessions/{$waSession}/messages/media", [
                    'number'  => $number,
                    'message' => $message,
                ]);

            if ($waResp->successful()) {
                Log::info('WA sent:', $waResp->json());
            } else {
                Log::error('WA send failed', ['status'=>$waResp->status(), 'body'=>$waResp->body()]);
            }
        } catch (\Exception $e) {
            Log::error('WA send exception: '.$e->getMessage());
        }
    }
}
