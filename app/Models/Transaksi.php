<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_transaksi';
    protected $fillable = [
        'nama_pelanggan', 'tanggal_transaksi', 'total_harga', 'metode_pembayaran',
        'status_pembayaran', 'status_transaksi', 'jumlah_point', 'status_bonus'
    ];

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }
}