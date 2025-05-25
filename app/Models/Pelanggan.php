<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pelanggan';
    protected $fillable = ['nama_pelanggan', 'no_telp', 'alamat', 'keterangan','point'];

    /**
     * Relasi ke tabel transaksis.
     * Mengembalikan semua transaksi yang terkait dengan pelanggan ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_pelanggan');
    }

}
