<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TransaksiFactory extends Factory {
    public function definition() {
        return [
            'id_pelanggan' => rand(1, 10),
            'id_point' => rand(1, 10),
            'id_paket' => rand(1, 10),
            'tanggal_transaksi' => $this->faker->date(),
            'total_harga' => $this->faker->randomFloat(2, 10000, 1000000),
            'metode_pembayaran' => $this->faker->randomElement(['Cash', 'Qris']),
            'status_pembayaran' => $this->faker->randomElement(['Belum Bayar', 'Lunas']),
            'status_transaksi' => $this->faker->randomElement(['Baru', 'Proses', 'Selesai', 'Diambil']),
            'jumlah_point' => rand(1, 100),
        ];
    }
}
