<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    protected $table = 'pakets';
    protected $primaryKey = 'id_paket';
    protected $fillable = ['jenis_paket', 'harga', 'waktu_pengerjaan', 'id_unit'];

    /**
     * Relasi ke tabel transaksis.
     * Mengembalikan semua transaksi yang terkait dengan paket ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_paket');
    }

    /**
     * Relasi ke tabel units.
     * Mengembalikan unit yang terkait dengan paket ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'id_unit', 'id_unit');
    }
}
