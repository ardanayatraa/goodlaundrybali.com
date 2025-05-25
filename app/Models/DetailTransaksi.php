<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_detail_transaksi';
    protected $fillable = [
       'id_transaksi',
        'id_paket',
        'tanggal_ambil',
        'jam_ambil',
        'jumlah',
        'sub_total',
        'total_diskon',
        'keterangan',
    ];

    /**
     * Relasi ke tabel transaksis.
     * Mengembalikan transaksi yang terkait dengan detail transaksi ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

     public function paket()
    {
        return $this->belongsTo(Paket::class, 'id_paket', 'id_paket');
    }
}
