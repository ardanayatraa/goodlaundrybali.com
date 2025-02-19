<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TrxBarangKeluarFactory extends Factory {
    public function definition() {
        return [
            'id_admin' => rand(1, 10),
            'id_barang' => rand(1, 10),
            'tanggal_keluar' => $this->faker->date(),
            'unit' => $this->faker->randomElement(['PCS', 'KG', 'ML']),
            'jumlah_brgkeluar' => rand(1, 100),
        ];
    }
}
