<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductPhoto>
 */
class ProductPhotoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // ダミーのパス
            'path' => '/storage/products/sample-' . fake()->numberBetween(1, 50) . '.jpg',
            'is_main' => false,
        ];
    }
}
