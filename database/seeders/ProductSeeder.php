<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\StockHistory;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory()->count(10)->create()->each(function ($p) {
            StockHistory::create([
                'product_id' => $p->id,
                'amount'     => $amount = fake()->numberBetween(0, 50),
                'reason'     => 'initial',
                'created_at' => now(),
            ]);
        });
    }
}
