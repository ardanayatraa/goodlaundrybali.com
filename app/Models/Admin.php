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

    public function trxBarangMasuk()
    {
        return $this->hasMany(TrxBarangMasuk::class, 'id_admin');
    }

    public function trxBarangKeluar()
    {
        return $this->hasMany(TrxBarangKeluar::class, 'id_admin');
    }
}
