<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrxBarangKeluar extends Model
{
    use HasFactory;

    protected $table = 'trx_barang_keluar';
    protected $primaryKey = 'id_trx_brgkeluar';
    protected $fillable = ['id_barang', 'tanggal_keluar', 'nama_admin'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    public function detailTrxBarangKeluar()
    {
        return $this->hasMany(DetailTrxBarangKeluar::class, 'id_trx_brgkeluar');
    }
}