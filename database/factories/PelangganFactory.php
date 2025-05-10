<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PelangganFactory extends Factory {
    public function definition() {
        return [
            'nama_pelanggan' => $this->faker->name(),
            'no_telp' => $this->faker->phoneNumber(),
            'alamat' => $this->faker->streetAddress(),
            'keterangan' => $this->faker->randomElement(['Member', 'Non-Member']),
        ];
    }
}
