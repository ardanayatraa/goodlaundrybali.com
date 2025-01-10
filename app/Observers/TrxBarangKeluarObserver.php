<?php

namespace App\Observers;

use App\Models\TrxBarangKeluar;
use App\Models\DetailTrxBarangKeluar;

class TrxBarangKeluarObserver
{
    /**
     * Handle the TrxBarangKeluar "created" event.
     *
     * @param  \App\Models\TrxBarangKeluar  $trxBarangKeluar
     * @return void
     */
    public function created(TrxBarangKeluar $trxBarangKeluar)
    {
        DetailTrxBarangKeluar::create([
            'id_trx_brgkeluar' => $trxBarangKeluar->id_trx_brgkeluar,
            'tanggal_keluar' => $trxBarangKeluar->tanggal_keluar,
            'nama_admin' => $trxBarangKeluar->nama_admin,
            'nama_barang' => $trxBarangKeluar->barang->nama_barang, 
            'jumlah_brgkeluar' => 0, 
        ]);
    }

    /**
     * Handle the TrxBarangKeluar "updated" event.
     *
     * @param  \App\Models\TrxBarangKeluar  $trxBarangKeluar
     * @return void
     */
    public function updated(TrxBarangKeluar $trxBarangKeluar)
    {
        $trxBarangKeluar->detailTrxBarangKeluar->each(function($detail) use ($trxBarangKeluar) {
            $detail->update([
                'tanggal_keluar' => $trxBarangKeluar->tanggal_keluar,
                'nama_admin' => $trxBarangKeluar->nama_admin,
                'nama_barang' => $trxBarangKeluar->barang->nama_barang,
            ]);
        });
    }

    /**
     * Handle the TrxBarangKeluar "deleted" event.
     *
     * @param  \App\Models\TrxBarangKeluar  $trxBarangKeluar
     * @return void
     */
    public function deleted(TrxBarangKeluar $trxBarangKeluar)
    {
        $trxBarangKeluar->detailTrxBarangKeluar->each(function($detail) {
            $detail->delete();
        });
    }

    /**
     * Handle the TrxBarangKeluar "restored" event.
     *
     * @param  \App\Models\TrxBarangKeluar  $trxBarangKeluar
     * @return void
     */
    public function restored(TrxBarangKeluar $trxBarangKeluar)
    {
        //
    }

    /**
     * Handle the TrxBarangKeluar "force deleted" event.
     *
     * @param  \App\Models\TrxBarangKeluar  $trxBarangKeluar
     * @return void
     */
    public function forceDeleted(TrxBarangKeluar $trxBarangKeluar)
    {
        //
    }
}
