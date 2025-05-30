<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrxBarangKeluar extends Model
{
    use HasFactory;

    protected $table = 'trx_barang_keluars';
    protected $primaryKey = 'id_trx_brgkeluar';
    protected $fillable = ['id_barang', 'tanggal_keluar', 'id_admin', 'unit', 'jumlah_brgkeluar'];

    /**
     * Relasi ke tabel barangs.
     * Mengembalikan barang yang terkait dengan transaksi barang keluar ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    /**
     * Relasi ke tabel admins.
     * Mengembalikan admin yang terkait dengan transaksi barang keluar ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin');
    }
}
