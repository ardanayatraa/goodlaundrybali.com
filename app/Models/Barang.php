<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_barang';
    protected $fillable = ['nama_barang', 'harga', 'id_unit', 'stok', 'stok_minimum'];

    /**
     * Relasi ke tabel units.
     * Mengembalikan unit yang terkait dengan barang ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'id_unit');
    }

    /**
     * Relasi ke tabel trx_barang_masuks.
     * Mengembalikan semua transaksi barang masuk yang terkait dengan barang ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trxBarangMasuk()
    {
        return $this->hasMany(TrxBarangMasuk::class, 'id_barang');
    }

    /**
     * Relasi ke tabel trx_barang_keluars.
     * Mengembalikan semua transaksi barang keluar yang terkait dengan barang ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trxBarangKeluar()
    {
        return $this->hasMany(TrxBarangKeluar::class, 'id_barang');
    }
}
