{{-- resources/views/auth/register.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Epilepsy & Violence - Register</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="m-0">
<div
  x-data="stickmanBattle()"
  x-init="init()"
  :class="isWhite ? 'bg-white' : 'bg-black'"
  class="transition-none min-h-screen overflow-hidden"
>
  {{-- HUD --}}
  <div class="fixed top-4 left-4 z-[90] text-xs px-3 py-2 rounded bg-white/70">
    背景: <b x-text="isWhite ? '白' : '黒'"></b> /
    棒人間: <b x-text="isDead ? '死亡' : '生存'"></b> /
    妨害Lv: <b x-text="chaosLevel"></b> /
    Canvas: <b x-text="canvasEnabled ? 'YES' : 'NO'"></b>
  </div>

  {{-- フラッシュ（叩いた瞬間） --}}
  <div
    class="fixed inset-0 z-[80] pointer-events-none"
    x-show="flash"
    x-transition.opacity.duration.80ms
    style="background: rgba(255,255,255,0.8); display:none;"
  ></div>

  {{-- FORM --}}
  <div class="relative z-10 p-8 md:p-20">
    <div class="max-w-xl bg-white/80 backdrop-blur rounded-2xl p-6 md:p-8 shadow">
      <h2 class="text-3xl font-black mb-6">Epilepsy &amp; Violence</h2>

      {{-- Laravelの登録ルート（あなたの環境に合わせて） --}}
      <form id="registerForm" action="{{ route('register.post') }}" method="POST" class="space-y-4">
        @csrf

        <div>
          <label class="text-sm font-bold">Name</label>
          <input name="name" value="{{ old('name') }}" class="w-full rounded border px-3 py-2" required />
        </div>

        <div>
          <label class="text-sm font-bold">Email</label>
          <input name="email" type="email" value="{{ old('email') }}" class="w-full rounded border px-3 py-2" required />
        </div>

        <div>
          <label class="text-sm font-bold">Password</label>
          <input name="password" type="password" class="w-full rounded border px-3 py-2" required />
        </div>

        <div>
          <label class="text-sm font-bold">Password Confirm</label>
          <input name="password_confirmation" type="password" class="w-full rounded border px-3 py-2" required />
        </div>

        {{-- Buttons --}}
        <div class="pt-4 flex items-center justify-between gap-3">
          <button
            type="reset"
            id="resetButton"
            class="bg-red-500 text-white px-4 py-3 rounded font-bold"
          >
            全てを無に帰す（Reset）
          </button>

          <button
            type="submit"
            :disabled="!isDead"
            :class="(!isDead) ? 'opacity-10 cursor-not-allowed' : 'opacity-100'"
            class="bg-blue-600 text-white text-xl md:text-2xl px-6 py-4 rounded font-black"
          >
            <span x-text="isDead ? '魂の登録（解放）' : '魂の登録（封印）'"></span>
          </button>
        </div>

        <p class="text-xs mt-2">
          条件: 棒人間を倒したら登録できる（背景は関係なし）
          <br>
          ✅ 倒したら白が0.9秒固定（押しやすい）
        </p>
      </form>
    </div>
  </div>

  {{-- CANVAS --}}
  <canvas
    id="stickmanCanvas"
    style="width:100vw;height:100vh;"
    :class="canvasEnabled ? 'pointer-events-auto' : 'pointer-events-none'"
    class="fixed inset-0 z-[50] fly-swat"
  ></canvas>
</div>

<script>
window.stickmanBattle = function () {
  return {
    // ====== state ======
    isWhite: false,
    isDead: false,
    canvasEnabled: false,
    chaosLevel: 0,
    flash: false,

    // ====== timers ======
    _strobeTimer: null,
    _raf: null,

    // ====== canvas ======
    canvas: null,
    ctx: null,

    // ====== images ======
    runImg: null,
    deadImg: null,

    // ====== stickman ======
    man: {
      x: 100,
      y: 0,
      vx: 4.2,
      w: 72,
      h: 72,
      hitR: 55,
      targetBias: 0.035, // resetへ寄る確率
    },

    init() {
      // canvas init
      this.canvas = document.getElementById('stickmanCanvas');
      this.ctx = this.canvas.getContext('2d');

      // images
      this.runImg = new Image();
      // run.gifでもOK（存在する方に合わせて）
      this.runImg.src = '/images/stickman/run.png';
      // this.runImg.src = '/images/stickman/run.gif';

      this.deadImg = new Image();
      this.deadImg.src = '/images/stickman/dead.png';

      // resize (DPR対応)
      this.resize();
      window.addEventListener('resize', () => this.resize());

      // click
      this.canvas.addEventListener('click', (e) => this.hit(e));

      // strobe start
      this.startStrobe();

      // animation start
      this.loop();
    },

    startStrobe() {
      if (this._strobeTimer) return;
      this._strobeTimer = setInterval(() => {
        this.isWhite = !this.isWhite;
      }, 120);
    },

    // ✅ DPR対応・CSS実サイズ一致
    resize() {
      const dpr = window.devicePixelRatio || 1;
      const rect = this.canvas.getBoundingClientRect();

      const cssW = Math.max(1, rect.width);
      const cssH = Math.max(1, rect.height);

      this.canvas.width = Math.floor(cssW * dpr);
      this.canvas.height = Math.floor(cssH * dpr);

      // CSS座標系で描けるように
      this.ctx.setTransform(dpr, 0, 0, dpr, 0, 0);

      this.man.y = cssH - 130;
      // 端にいたら戻す
      this.man.x = Math.min(Math.max(this.man.x, 40), cssW - 40);
    },

    loop() {
      const rect = this.canvas.getBoundingClientRect();
      const w = rect.width;
      const h = rect.height;

      // clear
      this.ctx.clearRect(0, 0, w, h);

      // alive
      if (!this.isDead) {
        // move left-right
        this.man.x += this.man.vx;

        // edge flip
        if (this.man.x < 40) { this.man.x = 40; this.man.vx *= -1; }
        if (this.man.x > w - 40) { this.man.x = w - 40; this.man.vx *= -1; }

        // resetへ寄せる（妨害強化）
        if (Math.random() < this.man.targetBias) {
          const r = this.getRect(document.getElementById('resetButton'));
          const tx = r.x + r.w / 2;
          this.man.vx = Math.sign(tx - this.man.x) * (4.0 + Math.random() * 4.0);
        }

        // resetに近づいたら canvas ON + 自動reset
        this.tryAttackReset();

        // draw run
        this.drawMan(false);
      } else {
        // dead draw
        this.drawMan(true);
      }

      this._raf = requestAnimationFrame(() => this.loop());
    },

    getRect(el) {
      const r = el.getBoundingClientRect();
      return { x: r.left, y: r.top, w: r.width, h: r.height };
    },

    tryAttackReset() {
      const resetBtn = document.getElementById('resetButton');
      if (!resetBtn) return;

      const r = this.getRect(resetBtn);
      const cx = r.x + r.w / 2;
      const cy = r.y + r.h / 2;

      const dx = cx - this.man.x;
      const dy = cy - this.man.y;
      const dist = Math.hypot(dx, dy);

      // 叩ける範囲：近い時だけcanvas有効
      if (dist < 220) {
        this.canvasEnabled = true;
        this.chaosLevel = Math.min(999, this.chaosLevel + 1);
      } else {
        this.canvasEnabled = false;
      }

      // 近すぎたら勝手にreset（鬼畜）
      if (dist < 95) {
        resetBtn.click();
      }
    },

    // ✅ 叩いたら死亡 + フラッシュ + 白固定（押しやすく）
    hit(e) {
      if (!this.canvasEnabled) return;
      if (this.isDead) return;

      const dx = e.clientX - this.man.x;
      const dy = e.clientY - this.man.y;
      const dist = Math.hypot(dx, dy);

      if (dist < this.man.hitR) {
        this.isDead = true;
        this.canvasEnabled = false;

        // flash
        this.flash = true;
        setTimeout(() => (this.flash = false), 90);

        // ✅ 押しやすさUP: 倒したら白を固定する時間（900→1200でさらに楽）
        const HOLD_MS = 900; // ← ここを 1200 にするともっと押しやすい
        const prev = this.isWhite;
        this.isWhite = true;
        setTimeout(() => {
          // その後、点滅に戻す（元の色に戻すだけ）
          this.isWhite = prev;
        }, HOLD_MS);
      }
    },

    drawMan(dead) {
      const ctx = this.ctx;
      const w = this.man.w;
      const h = this.man.h;

      // 画像がロード済みなら画像優先
      if (dead && this.deadImg && this.deadImg.complete) {
        ctx.drawImage(this.deadImg, this.man.x - w/2, this.man.y - h/2, w, h);
        return;
      }
      if (!dead && this.runImg && this.runImg.complete) {
        ctx.drawImage(this.runImg, this.man.x - w/2, this.man.y - h/2, w, h);
        return;
      }

      // フォールバック（ロード前）
      ctx.font = '48px sans-serif';
      ctx.textAlign = 'center';
      ctx.textBaseline = 'middle';
      ctx.fillStyle = this.isWhite ? '#000' : '#fff';
      ctx.fillText(dead ? '💀' : '🏃', this.man.x, this.man.y);
    },
  };
};
</script>
</body>
</html>
