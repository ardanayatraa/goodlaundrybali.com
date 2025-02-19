<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrxBarangMasuk extends Model
{
    use HasFactory;

    protected $table = 'trx_barang_masuks';
    protected $primaryKey = 'id_trx_brgmasuk';
    protected $fillable = ['id_barang', 'tanggal_masuk', 'id_admin', 'unit', 'jumlah_brgmasuk'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin');
    }
}
