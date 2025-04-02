<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admins';
    protected $primaryKey = 'id_admin';
    protected $fillable = [
        'nama_admin',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relasi ke tabel trx_barang_masuks.
     * Mengembalikan semua transaksi barang masuk yang terkait dengan admin ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trxBarangMasuk()
    {
        return $this->hasMany(TrxBarangMasuk::class, 'id_admin');
    }

    /**
     * Relasi ke tabel trx_barang_keluars.
     * Mengembalikan semua transaksi barang keluar yang terkait dengan admin ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trxBarangKeluar()
    {
        return $this->hasMany(TrxBarangKeluar::class, 'id_admin');
    }
}
