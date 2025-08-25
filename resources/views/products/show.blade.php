<x-app-layout>
    <x-slot name="header">
        <h2 class="h4">商品詳細</h2>
    </x-slot>

    <div class="container py-4">

        <a href="{{ route('products.index') }}" class="btn btn-secondary mb-3">← 一覧に戻る</a>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text text-muted">{{ $product->product_code }}</p>

                <p><strong>価格：</strong> {{ number_format($product->price) }}円</p>
                <p><strong>カテゴリ：</strong> {{ $product->category?->name ?? '-' }}</p>
                <p><strong>状態：</strong>
                    @if ($product->status === 'published')
                        <span class="badge bg-success">公開</span>
                    @else
                        <span class="badge bg-secondary">下書き</span>
                    @endif
                </p>
                <p><strong>説明：</strong><br>{{ $product->description }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
