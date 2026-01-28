import './bootstrap'
import Alpine from 'alpinejs'

window.Alpine = Alpine

// ✅ ここで先に定義（Alpine.start()より前！）
window.stickmanBattle = function () {
  return {
    isWhite: false,
    isDead: false,
    chaosLevel: 0,
    canvasEnabled: false,

    canvas: null,
    ctx: null,
    strobeTimer: null,

    man: { x: 120, y: 0, vx: 6, r: 18 },
    lastResetAt: 0,

    init() {
      this.canvas = document.getElementById('stickmanCanvas');
      this.ctx = this.canvas.getContext('2d');
      this.resize();
      window.addEventListener('resize', () => this.resize());

      this.strobeTimer = setInterval(() => {
        this.isWhite = !this.isWhite;
      }, 120);

      this.canvas.addEventListener('click', (e) => this.hit(e));
      this.loop();
    },

    resize() {
      this.canvas.width = innerWidth;
      this.canvas.height = innerHeight;
      this.man.y = innerHeight - 120;
    },

    loop() {
      const ctx = this.ctx;
      const w = this.canvas.width;
      const h = this.canvas.height;

      ctx.clearRect(0,0,w,h);

      if (!this.isDead) {
        this.man.x += this.man.vx;
        if (this.man.x < 30 || this.man.x > w - 30) this.man.vx *= -1;

        const resetBtn = document.getElementById('resetButton');
        if (resetBtn) {
          const r = resetBtn.getBoundingClientRect();
          const tx = r.left + r.width/2;
          const ty = r.top + r.height/2;

          const dx = tx - this.man.x;
          const dy = ty - this.man.y;
          const dist = Math.hypot(dx, dy);

          this.canvasEnabled = dist < 220;

          const now = performance.now();
          if (dist < 110 && now - this.lastResetAt > 450) {
            resetBtn.click();
            this.lastResetAt = now;
            this.chaosLevel++;
          }

          if (Math.random() < 0.04) {
            this.man.vx = Math.sign(dx) * (5 + Math.random() * 5);
          }
        }

        ctx.beginPath();
        ctx.fillStyle = this.isWhite ? '#000' : '#fff';
        ctx.arc(this.man.x, this.man.y, this.man.r, 0, Math.PI*2);
        ctx.fill();

        ctx.strokeStyle = this.isWhite ? '#000' : '#fff';
        ctx.lineWidth = 3;
        ctx.beginPath();
        ctx.moveTo(this.man.x, this.man.y);
        ctx.lineTo(this.man.x - 18, this.man.y + 28);
        ctx.moveTo(this.man.x, this.man.y);
        ctx.lineTo(this.man.x + 18, this.man.y + 28);
        ctx.stroke();

      } else {
        this.canvasEnabled = false;
        ctx.fillStyle = 'red';
        ctx.fillRect(this.man.x - 30, this.man.y - 20, 60, 30);
        ctx.fillStyle = '#fff';
        ctx.font = 'bold 12px sans-serif';
        ctx.fillText('DEAD', this.man.x - 18, this.man.y);
      }

      requestAnimationFrame(() => this.loop());
    },

    hit(e) {
      if (!this.canvasEnabled || this.isDead) return;

      const dx = e.clientX - this.man.x;
      const dy = e.clientY - this.man.y;
      if (Math.hypot(dx, dy) < 45) {
        this.isDead = true;
        const old = this.isWhite;
        this.isWhite = true;
        setTimeout(() => { this.isWhite = old; }, 80);
        this.chaosLevel++;
      }
    }
  }
}

Alpine.start()
