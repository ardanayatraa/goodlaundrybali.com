<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';
    protected $primaryKey = 'id_transaksi';
    public $timestamps = false; // set true jika pakai created_at/updated_at

    protected $fillable = [
        'no_telp',
        'tanggal_transaksi',
        'total_harga',
        'metode_pembayaran',
        'status_pembayaran',
        'status_transaksi',
        'jumlah_point',
        'keterangan',
        'jumlah_bayar',
        'kembalian',
    ];

    // agar accessor ikut di-serialize saat datatable
    protected $appends = [
        'paket_jumlah',
        'harga_paket',
        'total_diskon',
        'subtotal_setelah_diskon',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'no_telp', 'no_telp');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }

    public function getPaketJumlahAttribute()
    {
        return $this->detailTransaksi
                    ->map(fn($d) => "{$d->paket->jenis_paket} x{$d->jumlah}")
                    ->implode(', ');
    }

    public function getHargaPaketAttribute()
    {
        return $this->detailTransaksi
                    ->map(fn($d) => number_format($d->paket->harga, 0, ',', '.'))
                    ->implode(', ');
    }

    public function getTotalDiskonAttribute()
    {
        return $this->detailTransaksi->sum('total_diskon');
    }

    public function getSubtotalSetelahDiskonAttribute()
    {
        return $this->detailTransaksi
                    ->sum(fn($d) => $d->sub_total - $d->total_diskon);
    }
}
