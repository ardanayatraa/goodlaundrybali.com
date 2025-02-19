<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_transaksi';
    protected $fillable = [
        'id_pelanggan', 
        'id_point', 
        'id_paket', 
        'tanggal_transaksi', 
        'total_harga', 
        'metode_pembayaran',
        'status_pembayaran', 
        'status_transaksi', 
        'jumlah_point'
    ];
    
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class, 'id_paket');
    }

    public function point()
    {
        return $this->belongsTo(Point::class, 'id_point');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }
}
