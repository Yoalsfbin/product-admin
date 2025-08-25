<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\Artisan;

class ResetDemoData extends Command
{
    protected $signature = 'demo:reset';
    protected $description = 'デモ用に商品データをリセットする';

    public function handle()
    {
        // 商品テーブルのデータを全削除し、デモデータを投入
        Artisan::call('migrate:fresh', ['--seed' => true, '--force' => true]);
        $this->info('デモデータをリセットしました。');
    }
}
