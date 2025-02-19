<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    protected $table = 'pakets';
    protected $primaryKey = 'id_paket';
    protected $fillable = ['jenis_paket', 'harga', 'unit', 'waktu_pengerjaan'];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_paket');
    }
}
