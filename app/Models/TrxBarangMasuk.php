<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrxBarangMasuk extends Model
{
    use HasFactory;

    protected $table = 'trx_barang_masuks';
    protected $primaryKey = 'id_trx_brgmasuk';
    protected $fillable = ['id_barang', 'tanggal_masuk','harga','total_harga', 'id_admin', 'jumlah_brgmasuk'];

    /**
     * Relasi ke tabel barangs.
     * Mengembalikan barang yang terkait dengan transaksi barang masuk ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    /**
     * Relasi ke tabel admins.
     * Mengembalikan admin yang terkait dengan transaksi barang masuk ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin');
    }
}
