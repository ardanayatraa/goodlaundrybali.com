<?php

namespace App\Observers;

use App\Models\DetailTransaksi;
use App\Models\Transaksi;

class TransaksiObserver
{
    /**
     * Handle the Transaksi "created" event.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return void
     */
    public function created(Transaksi $transaksi)
    {
        DetailTransaksi::create([
            'id_transaksi' => $transaksi->id_transaksi,
            'tanggal_transaksi' => $transaksi->tanggal_transaksi,
            'nama_pelanggan' => $transaksi->nama_pelanggan,
            'metode_pembayaran' => $transaksi->metode_pembayaran,
            'status_pembayaran' => $transaksi->status_pembayaran,
            'status_transaksi' => $transaksi->status_transaksi,
            'jumlah_point' => $transaksi->jumlah_point,
            'status_bonus' => $transaksi->status_bonus,
            'total_harga' => $transaksi->total_harga,
        ]);
    }

    /**
     * Handle the Transaksi "updated" event.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return void
     */
    public function updated(Transaksi $transaksi)
    {
        $transaksi->detailTransaksi->each(function($detail) use ($transaksi) {
            $detail->update([
                'tanggal_transaksi' => $transaksi->tanggal_transaksi,
                'nama_pelanggan' => $transaksi->nama_pelanggan,
                'metode_pembayaran' => $transaksi->metode_pembayaran,
                'status_pembayaran' => $transaksi->status_pembayaran,
                'status_transaksi' => $transaksi->status_transaksi,
                'jumlah_point' => $transaksi->jumlah_point,
                'status_bonus' => $transaksi->status_bonus,
                'total_harga' => $transaksi->total_harga,
            ]);
        });
    }

    /**
     * Handle the Transaksi "deleted" event.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return void
     */
    public function deleted(Transaksi $transaksi)
    {
        $transaksi->detailTransaksi->each(function($detail) {
            $detail->delete();
        });
    }

    /**
     * Handle the Transaksi "restored" event.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return void
     */
    public function restored(Transaksi $transaksi)
    {
        //
    }

    /**
     * Handle the Transaksi "force deleted" event.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return void
     */
    public function forceDeleted(Transaksi $transaksi)
    {
        //
    }
}
