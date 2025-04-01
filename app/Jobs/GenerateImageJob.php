<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class GenerateImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $transaksiId;

    public function __construct($transaksiId)
    {
        $this->transaksiId = $transaksiId;
    }

    public function handle()
    {
        $transaksi = \App\Models\Transaksi::find($this->transaksiId);
        if (!$transaksi) {
            \Log::error("Transaksi not found: {$this->transaksiId}");
            return;
        }

        $url = route('transaksi.image', ['id' => $this->transaksiId], true);
        $imagePath = storage_path('app/public/transaksi_' . $this->transaksiId . '.png');

        try {
            // Determine the API base URL based on the environment
            $apiBaseUrl = env('SCREENSHOT_API_URL', 'http://localhost:3000/screenshot');

            // Send request to the screenshot API
            $response = Http::get($apiBaseUrl, [
                'url' => $url,
                'width' => 1280,
                'height' => 720,
                'format' => 'png',
            ]);

            if ($response->successful()) {
                // Save the image to the specified path
                file_put_contents($imagePath, $response->body());
                \Log::info("Image successfully saved to: $imagePath");
            } else {
                \Log::error('Error generating image via API: ' . $response->body());
            }
        } catch (\Exception $e) {
            \Log::error('Error generating image via API: ' . $e->getMessage());
        }
    }
}
