<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_barang';
    protected $fillable = ['nama_barang', 'harga'];

    public function trxBarangMasuk()
    {
        return $this->hasMany(TrxBarangMasuk::class, 'id_barang');
    }

    public function trxBarangKeluar()
    {
        return $this->hasMany(TrxBarangKeluar::class, 'id_barang');
    }
}