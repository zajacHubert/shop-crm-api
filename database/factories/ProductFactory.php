<?php

declare(strict_types=1);

namespace Database\Factories;

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
            'id' => Str::uuid(),
            'title' => $this->faker->words(rand(2, 4), true),
            'description' => $this->faker->text,
            'image' => $this->faker->imageUrl(),
            'price' => $this->faker->randomFloat(2, 100, 500),
            'category_id' => $this->faker->randomElement(['25dd6427-7757-48ec-9cc6-cd456eadd2d6', '3f96777e-e09d-4c46-a6d6-345dee91c0fa', '79f74ad3-fccd-4f22-b4d4-d90d2b4c52ab']),
        ];
    }
}
