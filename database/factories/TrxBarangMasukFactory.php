<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TrxBarangMasukFactory extends Factory {
    public function definition() {
        return [
            'id_admin' => rand(1, 10),
            'id_barang' => rand(1, 10),
            'tanggal_masuk' => $this->faker->date(),
            'unit' => $this->faker->randomElement(['PCS', 'KG', 'ML']),
            'harga' => $this->faker->randomFloat(2, 5000, 500000),
            'total_harga' => $this->faker->randomFloat(2, 50000, 5000000),
            'jumlah_brgmasuk' => rand(1, 100),
        ];
    }
}
