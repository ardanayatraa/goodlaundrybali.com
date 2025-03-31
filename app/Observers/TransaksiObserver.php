<?php

namespace App\Observers;
use Illuminate\Support\Facades\Http;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;

class TransaksiObserver
{
    public function created(Transaksi $transaksi)
    {
        DetailTransaksi::create([
            'id_transaksi' => $transaksi->id_transaksi,
            'tanggal_ambil' => now()->toDateString(),
            'jam_ambil' => now()->toTimeString(),
            'jumlah' => 1,
            'total_diskon' => 0,
            'keterangan' => 'Detail transaksi otomatis dibuat',
        ]);
    }

    public function updated(Transaksi $transaksi)
    {

        $detail = DetailTransaksi::where('id_transaksi', $transaksi->id_transaksi)->first();
        if ($detail) {
            $detail->update([
                'tanggal_ambil' => now()->toDateString(),
                'jam_ambil' => now()->toTimeString(),
                'keterangan' => 'Detail transaksi diperbarui',
            ]);
        }

        if ($transaksi->status_transaksi=== 'siap_ambil') {

            $number = '6285172003970'; 
            $message = "Halo *{$transaksi->pelanggan->nama_pelanggan}*, laundry Anda sudah siap diambil! 🚀";
        
            try {
                $response = Http::post(env('WA_API_URL') . '/send-message', [
                    'number' => $number,
                    'message' => $message,
                    'mediaUrl' => 'https://res.cloudinary.com/doxsia81t/image/upload/v1741367955/blog_posts/wxmhjquutozadumcniwi.png' 
                ]);
        
                // Debug response
                \Log::info('WA Response:', $response->json());
            } catch (\Exception $e) {
                \Log::error('WA Error: ' . $e->getMessage());
            }
        }
        
    }

    public function deleted(Transaksi $transaksi)
    {
        DetailTransaksi::where('id_transaksi', $transaksi->id_transaksi)->delete();
    }
}
