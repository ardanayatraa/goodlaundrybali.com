<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PaketFactory extends Factory {
    public function definition() {
        return [
            'jenis_paket' => $this->faker->word(),
            'harga' => $this->faker->randomFloat(2, 10000, 500000),
            'unit' => $this->faker->randomElement(['PCS', 'KG', 'SET']),
            'waktu_pengerjaan' => $this->faker->randomElement(['1 Hari', '2 Hari', '3 Hari'])
        ];
    }
}
