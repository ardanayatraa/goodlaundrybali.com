<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_barang';
    protected $fillable = ['nama_barang', 'harga', 'id_unit', 'stok'];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'id_unit');
    }

    public function trxBarangMasuk()
    {
        return $this->hasMany(TrxBarangMasuk::class, 'id_barang');
    }

    public function trxBarangKeluar()
    {
        return $this->hasMany(TrxBarangKeluar::class, 'id_barang');
    }
}
