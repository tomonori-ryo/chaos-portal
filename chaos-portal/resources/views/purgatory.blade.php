<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>The Purgatory</title>

  {{-- Если у тебя уже есть общий layout — можно встроить туда.
       Для простоты тут standalone страница. --}}
  <link rel="stylesheet" href="{{ asset('css/purgatory.css') }}">
  @vite('resources/js/purgatory.js')

</head>
<body>
    <div class="noise" aria-hidden="true"></div>

  <main class="wrap" aria-label="The Purgatory">
    <h1 class="title">The Purgatory</h1>
    <p class="subtitle">ログイン成功。だが、まだ終わらん。</p>

    <section class="panel">
      <div class="bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
        <div class="bar__fill" id="barFill"></div>
        <div class="bar__label" id="barLabel">0%</div>
      </div>

      <div class="stats">
        <div>減衰: <b>毎秒 -10%</b></div>
        <div>注入: <b>1クリック +2%</b></div>
        <div class="hint">※ 秒間5回以上の連打が推奨</div>
      </div>

      <button id="injectBtn" class="inject" type="button">
        注入（連打しろ）
      </button>

      <p class="taunt" id="taunt">ほら、手止まってるで？</p>
    </section>
  </main>

  <script>
    window.__PURGATORY_REDIRECT_TO__ = "{{ url('/') }}"; // <- сюда перейти при 100%
  </script>
</body>
</html>
