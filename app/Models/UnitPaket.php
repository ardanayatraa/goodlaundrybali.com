<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitPaket extends Model
{
    use HasFactory;

    protected $table = 'unit_pakets';
    protected $primaryKey = 'id_unit_paket';
    protected $fillable = ['nama_paket', 'keterangan'];
}
