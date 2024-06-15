<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Duck>
 */
class DuckFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName(),
            'color' => '#999999',
            'hair'  => $this->faker->randomElement(['hair_1', 'hair_2', 'hair_3']),
            'accessory'  => $this->faker->randomElement(['acc_1', 'acc_2', 'acc_3']),
            'shoes'  => $this->faker->randomElement(['shoes_1', 'shoes_2', 'shoes_3']),
        ];
    }
}
