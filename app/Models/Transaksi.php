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

    /**
     * Relasi ke tabel pelanggans.
     * Mengembalikan pelanggan yang terkait dengan transaksi ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    /**
     * Relasi ke tabel pakets.
     * Mengembalikan paket yang terkait dengan transaksi ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paket()
    {
        return $this->belongsTo(Paket::class, 'id_paket');
    }

    /**
     * Relasi ke tabel points.
     * Mengembalikan point yang terkait dengan transaksi ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function point()
    {
        return $this->belongsTo(Point::class, 'id_point');
    }

    /**
     * Relasi ke tabel detail_transaksis.
     * Mengembalikan semua detail transaksi yang terkait dengan transaksi ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }
}
