<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductPhoto;
use App\Models\StockHistory;
use App\Models\Category;
use App\Models\User;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = FakerFactory::create(config('app.faker_locale'));

        for ($i = 0; $i < 10; $i++) {
            $product = Product::create([
                'name' => $faker->realText(20),
                'description' => $faker->realText(100),
                'product_code'     => strtoupper(Str::random(3)) . '-' . $faker->unique()->numberBetween(10000, 99999),
                'price'        => $faker->numberBetween(500, 50000),
                'category_id'  => Category::inRandomOrder()->value('id') ?? Category::factory()->create()->id,
                'status'       => $faker->randomElement(['published', 'draft']),
                'published_at' => $faker->optional()->dateTimeBetween('-30 days', 'now'),
                'created_by'   => User::inRandomOrder()->value('id') ?? User::factory()->create()->id,
                'uploaded_by'  => User::inRandomOrder()->value('id') ?? null,
            ]);

            // 在庫履歴
            StockHistory::create([
                'product_id' => $product->id,
                'amount'     => $faker->numberBetween(0, 50),
                'reason'     => 'initial',
                'created_at' => now(),
            ]);

            // メイン写真
            ProductPhoto::create([
                'product_id' => $product->id,
                'path'       => '/storage/products/sample-' . $faker->numberBetween(1, 30) . '.jpg',
                'is_main'    => true,
            ]);

            // サブ写真
            ProductPhoto::create([
                'product_id' => $product->id,
                'path'       => '/storage/products/sample-' . $faker->numberBetween(31, 60) . '.jpg',
                'is_main'    => false,
            ]);
        }
    }
}
