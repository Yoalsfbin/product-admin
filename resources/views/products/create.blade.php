<x-app-layout>
    <x-slot name="header">
        <h2 class="h4">商品登録</h2>
    </x-slot>

    <div class="container py-4">
        <form method="POST" action="{{ route('products.store') }}">
            @csrf
            @include('products._form', ['product' => null])
        </form>
    </div>
</x-app-layout>
