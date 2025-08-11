<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lot>
 */
class LotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'numero_lot' => strtoupper($this->faker->randomLetter) . $this->faker->numberBetween(1, 200),
            'nombre_tantiemes' => $this->faker->numberBetween(5, 500),
        ];
    }
}
