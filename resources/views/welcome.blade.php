<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ config('app.name', 'Laravel') }}</title>
  <style>
    :root { --bg:#ffffff; --fg:#222; --muted:#555; --accent:#ff2d20; }
    *{box-sizing:border-box} html,body{height:100%}
    body{margin:0;background:var(--bg);color:var(--fg);
         font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif;}
    .wrap{min-height:100%;display:grid;place-items:center;padding:2rem}
    .topnav{position:fixed;top:0;right:0;padding:1rem}
    .topnav a{color:var(--fg);margin-left:.75rem;text-decoration:none;font-weight:600;opacity:.8}
    .topnav a:hover{opacity:1;text-decoration:underline}
    .card{max-width:880px;width:100%;padding:3rem 2rem;border-radius:12px;
          background:#fff;box-shadow:0 8px 20px rgba(0,0,0,.08)}
    .hero{display:flex;flex-direction:column;gap:1rem;align-items:flex-start}
    .title{font-size:clamp(28px,4vw,40px);margin:0}
    .subtitle{color:var(--muted);margin:0 0 1rem}
    .actions{display:flex;flex-wrap:wrap;gap:.75rem}
    .btn{display:inline-block;border:1px solid #ddd;padding:.7rem 1rem;border-radius:8px;
         text-decoration:none;font-weight:600;transition:.2s}
    .btn-primary{background:var(--accent);border-color:var(--accent);color:#fff}
    .btn-primary:hover{filter:brightness(1.05)}
    .btn-ghost{background:#fff;color:var(--fg)}
    .btn-ghost:hover{background:#f7f7f7}
    .meta{margin-top:2rem;font-size:.85rem;color:var(--muted)}
    @media (min-width: 720px){
      .hero{flex-direction:row;align-items:center;justify-content:space-between}
      .hero-text{max-width:540px}
    }
  </style>
</head>
<body>
  <div class="wrap">
    <main class="card">
      <section class="hero">
        <div class="hero-text">
          <h1 class="title">{{ config('app.name', 'Laravel App') }}</h1>
          <p class="subtitle">
            ポートフォリオ用のデモ環境です。
          </p>
          <div class="actions">
            @auth
              <a class="btn btn-primary" href="{{ route('products.index') }}">商品管理へ</a>
            @else
              <a class="btn btn-primary" href="{{ route('login') }}">ログイン</a>
              @if (Route::has('register'))
                <a class="btn btn-ghost" href="{{ route('register') }}">新規登録</a>
              @endif
            @endauth
          </div>
          <p class="meta">
            Laravel v{{ Illuminate\Foundation\Application::VERSION }} / PHP v{{ PHP_VERSION }}
          </p>
        </div>

       