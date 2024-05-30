<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'modified_by' => User::factory(),
            'name' => $this->faker->word(),
            'brand' => $this->faker->word(),
            'slug' => $this->faker->slug(),
            'images' => json_encode([Str::random(40)]),
            'description' => $this->faker->sentence(),
        ];
    }
}
