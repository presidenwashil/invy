<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
final class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'stock' => $this->faker->numberBetween(10, 100),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'status' => $this->faker->boolean,
        ];
    }
}
