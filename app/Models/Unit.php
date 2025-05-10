<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $table = 'units';
    protected $primaryKey = 'id_unit';
    protected $fillable = ['nama_unit', 'keterangan'];

    /**
     * Relasi ke tabel barangs.
     * Mengembalikan semua barang yang terkait dengan unit ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function barangs()
    {
        return $this->hasMany(Barang::class, 'id_unit');
    }
}
