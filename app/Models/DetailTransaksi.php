<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_detail_transaksi';
    protected $fillable = [
        'id_transaksi', 'tanggal_transaksi', 'nama_pelanggan', 'alamat', 'no_telp',
        'metode_pembayaran', 'status_pembayaran', 'status_transaksi', 'tanggal_ambil',
        'jenis_paket', 'berat', 'harga', 'total_harga', 'total_diskon'
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }
}