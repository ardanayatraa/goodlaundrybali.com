<?php

namespace App\Observers;

use App\Models\TrxBarangMasuk;
use App\Models\DetailTrxBarangMasuk;

class TrxBarangMasukObserver
{
    /**
     * Handle the TrxBarangMasuk "created" event.
     *
     * @param  \App\Models\TrxBarangMasuk  $trxBarangMasuk
     * @return void
     */
    public function created(TrxBarangMasuk $trxBarangMasuk)
    {
        DetailTrxBarangMasuk::create([
            'id_trx_brgmasuk' => $trxBarangMasuk->id_trx_brgmasuk,
            'tanggal_masuk' => $trxBarangMasuk->tanggal_masuk,
            'nama_admin' => $trxBarangMasuk->nama_admin,
            'nama_barang' => $trxBarangMasuk->barang->nama_barang,  // Assuming `barang` has a `nama_barang` attribute
            'jumlah_brgmasuk' => 0,  // Default value, adjust if needed
            'harga' => 0,  // Default value, adjust if needed
            'total_harga' => 0,  // Default value, adjust if needed
        ]);
    }

    /**
     * Handle the TrxBarangMasuk "updated" event.
     *
     * @param  \App\Models\TrxBarangMasuk  $trxBarangMasuk
     * @return void
     */
    public function updated(TrxBarangMasuk $trxBarangMasuk)
    {
        $trxBarangMasuk->detailTrxBarangMasuk->each(function($detail) use ($trxBarangMasuk) {
            $detail->update([
                'tanggal_masuk' => $trxBarangMasuk->tanggal_masuk,
                'nama_admin' => $trxBarangMasuk->nama_admin,
                'nama_barang' => $trxBarangMasuk->barang->nama_barang,  
            ]);
        });
    }

    /**
     * Handle the TrxBarangMasuk "deleted" event.
     *
     * @param  \App\Models\TrxBarangMasuk  $trxBarangMasuk
     * @return void
     */
    public function deleted(TrxBarangMasuk $trxBarangMasuk)
    {
        $trxBarangMasuk->detailTrxBarangMasuk->each(function($detail) {
            $detail->delete();
        });
    }

    /**
     * Handle the TrxBarangMasuk "restored" event.
     *
     * @param  \App\Models\TrxBarangMasuk  $trxBarangMasuk
     * @return void
     */
    public function restored(TrxBarangMasuk $trxBarangMasuk)
    {
        //
    }

    /**
     * Handle the TrxBarangMasuk "force deleted" event.
     *
     * @param  \App\Models\TrxBarangMasuk  $trxBarangMasuk
     * @return void
     */
    public function forceDeleted(TrxBarangMasuk $trxBarangMasuk)
    {
        //
    }
}
