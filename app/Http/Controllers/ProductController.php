<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private ProductService $service)
    {
        // Policy使う場合はここで登録してもOK
        // $this->authorizeResource(Product::class, 'product');
    }

    public function index(Request $request)
    {
        $filters = $request->only(['keyword', 'category_id']);
        $sort = in_array($request->sort, ['name', 'price', 'created_at']) ? $request->sort : 'created_at';
        $order = $request->order === 'asc' ? 'asc' : 'desc';

        $products = $this->service->list($filters, $sort, $order);
        $categories = Category::orderBy('display_order')->get(['id', 'name']);
        $totalProducts = Product::count();

        return view('products.index', compact('products', 'categories', 'totalProducts', 'sort', 'order'));
    }

    public function create()
    {
        $categories = Category::orderBy('display_order')->pluck('name', 'id');
        return view('products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated() + ['created_by' => $request->user()->id];
        $this->service->create($data);

        return redirect()->route('products.index')->with('success', '商品を登録しました');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('display_order')->pluck('name', 'id');
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->service->update($product, $request->validated());

        return redirect()->route('products.index')->with('success', '商品を更新しました');
    }

    public function destroy(Product $product)
    {
        $this->service->delete($product);

        return response()->json(['ok' => true]);
    }
}
