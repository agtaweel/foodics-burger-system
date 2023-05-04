<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ingredient>
 */
class IngredientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ingredients = ['beef','onion','cheese','chicken'];
        return [
            'id'=>$this->faker->randomNumber(),
            'name'=>$this->faker->randomElement($ingredients),
            'stock'=>$this->faker->numerify(),
            'percentage'=>100,
        ];
    }
}
