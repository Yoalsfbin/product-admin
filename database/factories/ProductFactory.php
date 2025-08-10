<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPhoto;
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
            'name'          => fake()->unique()->words(3, true),
            'description'   => fake()->optional()->paragraph(),
            'sku_code'      => strtoupper(Str::random(3)) . '-' . fake()->unique()->numberBetween(10000, 99999),
            'price'         => fake()->numberBetween(500, 50000),
            'category_id'   => Category::inRandomOrder()->value('id') ?? Category::factory(),
            'main_photo_id' => ProductPhoto::factory(),
            'status'        => fake()->randomElement(['published', 'draft']),
            'published_at'  => fake()->optional()->dateTimeBetween('-30 days', 'now'),
            'created_by'    => User::inRandomOrder()->value('id') ?? User::factory(),
            'uploaded_by'   => User::inRandomOrder()->value('id') ?? null,
        ];
    }
}
