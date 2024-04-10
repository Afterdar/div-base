<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

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

    protected $model = Product::class;

    public function definition(): array
    {
        return [
            Product::TITLE => fake()->title(),
            Product::PRICE => fake()->numberBetween(1, 17) * 10,
            Product::IMAGE => [fake()->imageUrl],
            Product::ACTIVE => fake()->boolean,
            Product::ORDER => fake()->numberBetween(1, 5),
        ];
    }
}
