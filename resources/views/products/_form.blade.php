<div class="mb-3">
  <label class="form-label">商品名</label>
  <input name="name" value="{{ old('name', $product->name ?? '') }}" class="form-control" required>
  @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
  <label class="form-label">SKU</label>
  <input name="sku_code" value="{{ old('sku_code', $product->sku_code ?? '') }}" class="form-control" required>
  @error('sku_code')<div class="text-danger small">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
  <label class="form-label">価格</label>
  <input type="number"
         name="price"
         value="{{ old('price', $product->price ?? 0) }}"
         class="form-control"
         required
         min="0">   
  @error('price')<div class="text-danger small">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
  <label class="form-label">カテゴリ</label>
  <select name="category_id" class="form-select">
    <option value="">未選択</option>
    @foreach($categories as $id => $name)
      <option value="{{ $id }}" @selected(old('category_id', $product->category_id ?? '') == $id)>{{ $name }}</option>
    @endforeach
  </select>
</div>

<div class="mb-3">
  <label class="form-label">状態</label>
  <select name="status" class="form-select">
    <option value="draft" @selected(old('status', $product->status ?? '') === 'draft')>下書き</option>
    <option value="published" @selected(old('status', $product->status ?? '') === 'published')>公開</option>
  </select>
</div>

<div class="mb-3">
  <label class="form-label">説明</label>
  <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description ?? '') }}</textarea>
</div>

<div class="d-flex gap-2">
  <button class="btn btn-primary">保存</button>
  <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">戻る</a>
</div>
