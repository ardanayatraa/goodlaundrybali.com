<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BarangFactory extends Factory {
    public function definition() {
        return [
            'nama_barang' => $this->faker->word(),
            'harga' => $this->faker->randomFloat(2, 5000, 100000),
            'stok' => rand(1, 500),
        ];
    }
}
