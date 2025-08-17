<x-app-layout>
  <x-slot name="header">
    <h2 class="h4">商品一覧</h2>
  </x-slot>

  <div class="container py-4">
    <div class="d-flex justify-content-end mb-3">
      <a href="{{ route('products.create') }}" class="btn btn-primary">＋新規登録</a>
    </div>

    <form method="GET" class="row g-2 mb-3">
      <div class="col-sm-4">
        <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control" placeholder="商品名 / SKU">
      </div>
      <div class="col-sm-3">
        <select name="category_id" class="form-select">
          <option value="">すべてのカテゴリ</option>
          @foreach($categories as $c)
            <option value="{{ $c->id }}" @selected(request('category_id') == $c->id)>{{ $c->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-sm-3">
        <select name="sort" class="form-select">
          <option value="created_at" @selected($sort === 'created_at')>新着順</option>
          <option value="name" @selected($sort === 'name')>名前</option>
          <option value="price" @selected($sort === 'price')>価格</option>
        </select>
      </div>
      <div class="col-sm-2">
        <button class="btn btn-outline-secondary w-100">絞り込み</button>
      </div>
    </form>

    <div class="mb-2 text-muted">全 {{ $totalProducts }} 件</div>

    <table class="table table-hover align-middle">
      <thead>
        <tr>
          <th>商品名</th>
          <th>SKU</th>
          <th class="text-end">価格</th>
          <th>カテゴリ</th>
          <th>状態</th>
          <th style="width:140px;"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($products as $p)
        <tr id="row-{{ $p->id }}">
          <td>{{ $p->name }}</td>
          <td>{{ $p->sku_code }}</td>
          <td class="text-end">{{ number_format($p->price) }}円</td>
          <td>{{ $p->category?->name ?? '-' }}</td>
          <td>
            @if($p->status === 'published')
              <span class="badge bg-success">公開</span>
            @else
              <span class="badge bg-secondary">下書き</span>
            @endif
          </td>
          <td class="text-end">
            <a href="{{ route('products.edit', $p) }}" class="btn btn-sm btn-outline-primary">編集</a>
            <button type="button" class="btn btn-sm btn-outline-danger js-delete" data-id="{{ $p->id }}">削除</button>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    {{ $products->links() }}
  </div>

  {{-- トースト --}}
  <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index:1080">
    <div id="appToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body" id="appToastBody">完了しました</div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>

  {{-- 削除確認モーダル --}}
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">削除の確認</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
        </div>
        <div class="modal-body">
          この商品を削除します。よろしいですか？
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">キャンセル</button>
          <button type="button" class="btn btn-danger" id="deleteConfirmBtn">削除する</button>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
  <script>
    // ------- Toast -------
    window.showToast = function (message, type = 'success') {
      const toastEl = document.getElementById('appToast');
      const bodyEl  = document.getElementById('appToastBody');

      toastEl.classList.remove('bg-success','bg-danger','bg-warning','bg-info');
      toastEl.classList.add('bg-' + type);
      bodyEl.textContent = message;

      new bootstrap.Toast(toastEl, { delay: 2500 }).show();
    };

    // フラッシュメッセージ（作成/更新後のリダイレクト）を自動表示
    @if (session('success'))
      document.addEventListener('DOMContentLoaded', () => showToast(@json(session('success')), 'success'));
    @endif
    @if (session('error'))
      document.addEventListener('DOMContentLoaded', () => showToast(@json(session('error')), 'danger'));
    @endif

    // ------- Delete Modal + Ajax -------
    let deleteTargetId = null;

    // 削除ボタンクリック → モーダル表示
    $(document).on('click', '.js-delete', function () {
      deleteTargetId = $(this).data('id');
      const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
      modal.show();
    });

    // モーダルで「削除する」クリック → Ajax
    $('#deleteConfirmBtn').on('click', function () {
      if (!deleteTargetId) return;

      $.ajax({
        url: `/products/${deleteTargetId}`,
        type: 'DELETE',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        success: () => {
          $(`#row-${deleteTargetId}`).remove();
          showToast('削除しました', 'success');
          bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();
          deleteTargetId = null;
        },
        error: (xhr) => {
          console.error(xhr.responseText);
          showToast('削除に失敗しました', 'danger');
        }
      });
    });
  </script>
  @endpush
</x-app-layout>
