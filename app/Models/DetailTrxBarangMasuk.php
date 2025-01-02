<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTrxBarangMasuk extends Model
{
    use HasFactory;

    protected $table = 'detail_trx_barang_masuk';
    protected $primaryKey = 'id_detail_trx_brgmasuk';
    protected $fillable = [
        'id_trx_brgmasuk', 'tanggal_masuk', 'nama_admin', 'nama_barang',
        'jumlah_brgmasuk', 'harga', 'total_harga'
    ];

    public function trxBarangMasuk()
    {
        return $this->belongsTo(TrxBarangMasuk::class, 'id_trx_brgmasuk');
    }
}