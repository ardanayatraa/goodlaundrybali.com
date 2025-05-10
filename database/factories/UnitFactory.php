<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UnitFactory extends Factory {
    public function definition() {
        return [
            'nama_unit' => $this->faker->word(),
            'keterangan' => $this->faker->text(200),
        ];
    }
}
