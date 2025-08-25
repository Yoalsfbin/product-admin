<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interface\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;



class ProductRepository implements ProductRepositoryInterface
{
    public function paginate(array $filters, string $sort, string $order, int $perPage): LengthAwarePaginator
    {
        $query = Product::query()->with(['category', 'creator']);

        if (!empty($filters['keyword'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['keyword'] . '%')
                    ->orWhere('product_code', 'like', '%' . $filters['keyword'] . '%');
            });
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        return $query->orderBy($sort, $order)
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);
        return $product->refresh();
    }

    public function delete(Product $product): void
    {
        $product->delete();
    }
}
