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
        $this->authorizeResource(Product::class, 'product');
        $this->middleware('throttle:product-create')->only('store');
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

        try {
            $this->service->create($data);
        } catch (\Throwable $e) {
            return redirect()
                ->route('products.index')
                ->withInput()
                ->with('error', $e->getMessage() ?: '登録できませんでした。');
        }

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

    public function show(Product $product)
    {
        $product->load(['category', 'creator', 'photos', 'activities']);
        return view('products.show', compact('product'));
    }
}
