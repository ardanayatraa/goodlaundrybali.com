<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UnitPaketFactory extends Factory {
    public function definition() {
        return [
            'nama_paket' => $this->faker->word(),
            'keterangan' => $this->faker->text(200),
        ];
    }
}
