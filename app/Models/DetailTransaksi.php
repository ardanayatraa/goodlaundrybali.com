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
       'tanggal_ambil',
       'jam_ambil',
       'jumlah',
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
}
