<x-app-layout>
  <x-slot name="header">
    <h2 class="h4">商品編集</h2>
  </x-slot>

  <div class="container py-4">
    <form method="POST" action="{{ route('products.update', $product) }}">
      @method('PUT')
      @csrf
      @include('products._form', ['product' => $product])
    </form>
  </div>
</x-app-layout>
