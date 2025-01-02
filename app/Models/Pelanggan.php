<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pelanggan';
    protected $fillable = ['nama_pelanggan', 'no_telp', 'alamat', 'keterangan'];

    public function penukaranBonus()
    {
        return $this->hasMany(PenukaranBonus::class, 'id_pelanggan');
    }
}