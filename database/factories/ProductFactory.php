<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Category;
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
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'image' => '01J56PP67FEQ6KQBBET1M7GNM0.png',
            'gallery' => ['01J56PP67FEQ6KQBBET1M7GNM0.png', '01J56PPQH2JR08GJ6KDFAEZ3CF.png'],
            'slug' => fake()->slug(),
            'price' => random_int(1000, 100000),
            'oldPrice' => random_int(1000, 100000),
            'description' => fake()->text(100),
            'author_id' => Author::all()->random(),
            'category_id' => Category::all()->random()
        ];
    }
}
