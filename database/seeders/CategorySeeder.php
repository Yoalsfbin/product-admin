<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (['食品', '日用品', '家電', '書籍'] as $i => $name) {
            Category::updateOrCreate(['name' => $name], ['display_order' => $i]);
        }
    }
}
