<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Russian Roulette Portal</title>

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    body { background: radial-gradient(1200px 700px at 20% 10%, #2a0a2a 0%, #050010 45%, #000 100%); color: #fff; }
    .wrap { max-width: 1100px; margin: 0 auto; padding: 28px 18px 60px; }
    .top { display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom: 18px; }
    .title { font-size: 22px; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; }
    .desc { opacity:.85; font-size: 13px; margin-top: 6px; }
    .grid { display:grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: 12px; margin-top: 18px; }
    @media (max-width: 900px) { .grid { grid-template-columns: repeat(4, minmax(0, 1fr)); } }
    @media (max-width: 680px) { .grid { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
    @media (max-width: 460px) { .grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }

    .card {
      display:flex; align-items:center; justify-content:center;
      height: 92px;
      border-radius: 14px;
      border: 1px solid rgba(255,255,255,.16);
      background: linear-gradient(180deg, rgba(255,255,255,.10), rgba(255,255,255,.03));
      box-shadow: 0 18px 40px rgba(0,0,0,.45);
      text-decoration:none;
      font-weight: 800;
      letter-spacing: .12em;
      transition: transform .12s ease, filter .12s ease;
      user-select:none;
      color: #fff;
    }
    .card:hover { transform: scale(1.02) rotate(-0.5deg); filter: brightness(1.15); }
    .card:active { transform: scale(0.98) rotate(0.8deg); }

    .logoutBtn {
      border-radius: 10px;
      padding: 10px 12px;
      border: 1px solid rgba(255,255,255,.2);
      background: rgba(255,255,255,.06);
      color: #fff;
      font-weight: 700;
      cursor: pointer;
    }
    .logoutBtn:hover { filter: brightness(1.15); }
  </style>
</head>
<body>
  <main class="wrap">
    <div class="top">
      <div>
        <div class="title">Russian Roulette Portal</div>
        <div class="desc">ロードを抜けた者だけが、カードを引ける。1枚選べ。</div>
      </div>

      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="logoutBtn" type="submit">Logout</button>
      </form>
    </div>

    <section class="grid" aria-label="Roulette cards">
      @foreach ($links as $link)
        <a
          class="card chaos-card"
          href="{{ route('roulette.spin', ['id' => $link->id]) }}"
          style="animation-delay: {{ ($loop->index % 12) * 0.07 }}s"
        >
          CARD {{ str_pad((string)($loop->iteration), 2, '0', STR_PAD_LEFT) }}
        </a>
      @endforeach
    </section>
  </main>
</body>
</html>

