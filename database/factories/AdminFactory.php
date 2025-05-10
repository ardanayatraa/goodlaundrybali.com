<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class AdminFactory extends Factory {
    public function definition() {
        return [
            'nama_admin' => $this->faker->name(),
            'username' => $this->faker->userName(),
            'password' => Hash::make('password123'),
        ];
    }
}
