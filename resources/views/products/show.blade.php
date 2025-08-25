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

        {{-- 商品画像 --}}
        @if ($product->photos->count())
            <h5>商品画像</h5>
            <div class="row mb-4">
                @foreach ($product->photos as $photo)
                    <div class="col-md-3 mb-3">
                        <img src="{{ asset('storage/' . $photo->path) }}" class="img-fluid rounded border">
                    </div>
                @endforeach
            </div>
        @endif

        {{-- 商品履歴 --}}
        @if ($product->activities->count())
            <h5>履歴</h5>
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>操作</th>
                        <th>ユーザー</th>
                        <th>日時</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($product->activities as $activity)
                        <tr>
                            <td>{{ $activity->action }}</td>
                            <td>{{ $activity->user?->name ?? '―' }}</td>
                            <td>{{ $activity->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>
</x-app-layout>
