<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Transaksi; // Pastikan model ini di-import

class DetailTransaksiFactory extends Factory {
    public function definition() {
        return [
            'id_transaksi' => Transaksi::inRandomOrder()->value('id_transaksi') ?? Transaksi::factory()->create()->id,
            'tanggal_ambil' => $this->faker->dateTime(),
            'jam_ambil' => $this->faker->dateTime(),
            'jumlah' => $this->faker->randomNumber(2), // Max 50 karakter
            'total_diskon' => $this->faker->randomFloat(2, 1000, 50000),
            'keterangan' => $this->faker->regexify('[A-Z0-9]{10}'), // No Ref (Max 50 karakter)
        ];
    }
}
