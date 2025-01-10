<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaketSeeder extends Seeder
{
    public function run()
    {
        DB::table('pakets')->insert([
            [
                'jenis_paket' => 'Cuci Komplit Express',
                'harga' => 20000.00,
                'waktu_pengerjaan' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis_paket' => 'Cuci Komplit One Day',
                'harga' => 13000.00,
                'waktu_pengerjaan' => 24,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis_paket' => 'Cuci Komplit Regular',
                'harga' => 9000.00,
                'waktu_pengerjaan' => 48,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis_paket' => 'Cuci Lipat Express',
                'harga' => 15000.00,
                'waktu_pengerjaan' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis_paket' => 'Cuci Lipat One Day',
                'harga' => 10000.00,
                'waktu_pengerjaan' => 24,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis_paket' => 'Cuci Lipat Regular',
                'harga' => 7000.00,
                'waktu_pengerjaan' => 48,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis_paket' => 'Setrika Express',
                'harga' => 12000.00,
                'waktu_pengerjaan' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis_paket' => 'Setrika One Day',
                'harga' => 10000.00,
                'waktu_pengerjaan' => 24,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis_paket' => 'Setrika Regular',
                'harga' => 7000.00,
                'waktu_pengerjaan' => 48,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
