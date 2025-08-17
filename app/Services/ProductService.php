<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Interface\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function __construct(private ProductRepositoryInterface $products) {}

    public function list(array $filters = [], string $sort = 'created_at', string $order = 'desc', int $perPage = 10)
    {
        return $this->products->paginate($filters, $sort, $order, $perPage);
    }

    public function create(array $data): Product
    {
        return DB::transaction(fn() => $this->products->create($data));
    }

    public function update(Product $product, array $data): Product
    {
        return DB::transaction(fn() => $this->products->update($product, $data));
    }

    public function delete(Product $product): void
    {
        DB::transaction(fn() => $this->products->delete($product));
    }
}
