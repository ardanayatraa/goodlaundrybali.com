<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Paket;
use App\Models\UnitPaket;
use App\Models\Pelanggan;
use App\Models\TrxBarangMasuk;
use App\Models\TrxBarangKeluar;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Barang;
use App\Models\Unit;
use App\Models\Point;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Paket::factory(50)->create();
        UnitPaket::factory(50)->create();
        Pelanggan::factory(50)->create();
        TrxBarangMasuk::factory(50)->create();
        TrxBarangKeluar::factory(50)->create();
        Transaksi::factory(50)->create();
        DetailTransaksi::factory(50)->create();
        Barang::factory(50)->create();
        Unit::factory(50)->create();
        Point::factory(50)->create();


        $this->call([
            AdminSeeder::class,
      
        ]);
    }
}
