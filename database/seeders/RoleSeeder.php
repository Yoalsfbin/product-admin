<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->upsert([
            ['id' => 1, 'name' => 'admin', 'description' => '管理者', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'staff', 'description' => '一般', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'viewer', 'description' => '閲覧のみ', 'created_at' => now(), 'updated_at' => now()],
        ], ['id'], ['name', 'description', 'updated_at']);
    }
}
