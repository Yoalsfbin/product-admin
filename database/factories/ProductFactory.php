<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'          => $this->faker->unique()->words(2, true), 
            'description'   => $this->faker->optional()->realText(100),
            'sku_code'      => strtoupper(Str::random(3)) . '-' . $this->faker->unique()->numberBetween(10000, 99999),
            'price'         => $this->faker->numberBetween(500, 50000),
            'category_id'   => Category::inRandomOrder()->value('id') ?? Category::factory(),
            'status'        => $this->faker->randomElement(['published', 'draft']),
            'published_at'  => $this->faker->optional()->dateTimeBetween('-30 days', 'now'),
            'created_by'    => User::inRandomOrder()->value('id') ?? User::factory(),
            'uploaded_by'   => User::inRandomOrder()->value('id') ?? null,
        ];
    }
}
