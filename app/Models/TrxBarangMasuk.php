<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrxBarangMasuk extends Model
{
    use HasFactory;

    protected $table = 'trx_barang_masuk';
    protected $primaryKey = 'id_trx_brgmasuk';
    protected $fillable = ['id_barang', 'tanggal_masuk', 'nama_admin', 'total_harga'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    public function detailTrxBarangMasuk()
    {
        return $this->hasMany(DetailTrxBarangMasuk::class, 'id_trx_brgmasuk');
    }
}