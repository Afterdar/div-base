<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Category::class;

    public function definition(): array
    {
        return [
            Category::TITLE => fake()->title,
            Category::ORDER => fake()->numberBetween(0, 5),
            Category::ACTIVE => fake()->boolean(),
            Category::IMAGE => [fake()->imageUrl],
            Category::PARENT_ID => null,
        ];
    }
}
