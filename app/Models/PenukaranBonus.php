<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenukaranBonus extends Model
{
    use HasFactory;

    protected $table = 'penukaran_bonus';
    protected $fillable = ['tanggal', 'id_pelanggan', 'jumlah_point'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }
}