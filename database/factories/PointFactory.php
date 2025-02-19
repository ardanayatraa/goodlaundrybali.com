<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PointFactory extends Factory {
    public function definition() {
        return [
            'id_pelanggan' => rand(1, 10),
            'tanggal' => $this->faker->date(),
            'jumlah_point' => rand(10, 500),
        ];
    }
}
