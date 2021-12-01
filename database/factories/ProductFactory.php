<?php

namespace Database\Factories;

use App\Enum\Currency;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'name' => rtrim($this->faker->sentence(random_int(1, 4)), '.'),
            'description' => $this->faker->realText(),
            'price' => $this->faker->numberBetween(10, 500),
            'currency' => Currency::default()->getId(),
        ];
    }
}
