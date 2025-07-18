<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use HasFactory;

    protected $table = 'points';
    protected $primaryKey = 'id_point';
    protected $fillable = ['no_telp', 'tanggal', 'jumlah_point'];

    /**
     * Mendefinisikan relasi ke model Pelanggan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'no_telp', 'no_telp');
    }
}
