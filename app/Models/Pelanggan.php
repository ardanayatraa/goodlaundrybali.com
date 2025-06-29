<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

class Pelanggan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pelanggan';
    protected $fillable = [
        'nama_pelanggan',
        'no_telp',
        'alamat',
        'keterangan',       // “Member” / “Non Member”
        'point',
        'member_start_at',  // kolom timestamp baru
    ];

    // biar Carbon otomatis cast ke objek DateTime
    protected $casts = [
        'member_start_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        // Saat create: kalau langsung pilih “Member”
        static::creating(function ($pelanggan) {
            if (strtolower($pelanggan->keterangan) === 'Member') {
                $pelanggan->member_start_at = Carbon::now();
            }
        });

        // Saat update: cek perubahan dari non-member → member
        static::updating(function ($pelanggan) {
            $original = $pelanggan->getOriginal('keterangan');
            if (
                strtolower($original) !== 'member'
                && strtolower($pelanggan->keterangan) === 'Member'
            ) {
                $pelanggan->member_start_at = Carbon::now();
            }
        });
    }

    /**
     * Relasi ke transaksi.
     */
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_pelanggan');
    }

    public function getHargaPendaftaranAttribute()
{
    return 10000;
}
}
