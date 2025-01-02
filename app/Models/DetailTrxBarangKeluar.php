<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTrxBarangKeluar extends Model
{
    use HasFactory;

    protected $table = 'detail_trx_barang_keluar';
    protected $primaryKey = 'id_detail_trx_brgkeluar';
    protected $fillable = [
        'id_trx_brgkeluar', 'tanggal_keluar', 'nama_admin', 'nama_barang', 'jumlah_brgkeluar'
    ];

    public function trxBarangKeluar()
    {
        return $this->belongsTo(TrxBarangKeluar::class, 'id_trx_brgkeluar');
    }
}