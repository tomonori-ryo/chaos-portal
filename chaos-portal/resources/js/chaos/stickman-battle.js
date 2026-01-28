window.stickmanBattle = function () {
  return {
    confirmed: false,
    isWhite: false,
    isDead: false,

    _strobeTimer: null,
    _rafId: null,

    canvas: null,
    ctx: null,

    runImg: null,
    deadImg: null,
    imgReady: false,

    x: 80,
    y: 0,
    vx: 6,
    w: 96,
    h: 96,

    attackRadius: 40,
    hitRadius: 55,

    init() {
      this.canvas = document.getElementById("stickmanCanvas");
      this.ctx = this.canvas.getContext("2d");

      this.resize();
      window.addEventListener("resize", () => this.resize());
      this.canvas.addEventListener("click", (e) => this.onClick(e));

      this.runImg = new Image();
      this.deadImg = new Image();

      let loaded = 0;
      const done = () => { loaded++; if (loaded >= 2) this.imgReady = true; };

      this.runImg.onload = done;
      this.deadImg.onload = done;

      this.runImg.src = "/images/stickman/run.png";
      this.deadImg.src = "/images/stickman/dead.png";
    },

    resize() {
      this.canvas.width = window.innerWidth;
      this.canvas.height = window.innerHeight;
      this.y = this.canvas.height - 140;
    },

    startStrobe() {
      if (this._strobeTimer) return;
      this._strobeTimer = setInterval(() => {
        this.isWhite = !this.isWhite;
      }, 100);
      this.loop();
    },

    getResetCenter() {
      const el = document.getElementById("resetButton");
      if (!el) return null;
      const r = el.getBoundingClientRect();
      return { x: r.left + r.width / 2, y: r.top + r.height / 2, el };
    },

    onClick(e) {
      if (!this.confirmed || this.isDead) return;

      const rect = this.canvas.getBoundingClientRect();
      const mx = e.clientX - rect.left;
      const my = e.clientY - rect.top;

      const cx = this.x + this.w / 2;
      const cy = this.y + this.h / 2;

      const dx = mx - cx;
      const dy = my - cy;

      if (dx * dx + dy * dy <= this.hitRadius * this.hitRadius) {
        this.isDead = true;
      }
    },

    update() {
      if (this.isDead) return;

      this.x += this.vx;
      if (this.x <= 0 || this.x >= this.canvas.width - this.w) this.vx *= -1;

      const target = this.getResetCenter();
      if (target) {
        const cx = this.x + this.w / 2;
        const dir = target.x - cx;
        this.x += Math.sign(dir) * 1.2;

        const dx = target.x - cx;
        const dy = target.y - (this.y + this.h / 2);
        if (dx * dx + dy * dy <= this.attackRadius * this.attackRadius) {
          target.el.click(); // 妨害：勝手にreset
        }
      }
    },

    draw() {
      const w = this.canvas.width, h = this.canvas.height;
      this.ctx.clearRect(0, 0, w, h);

      if (!this.imgReady) return;

      if (!this.isDead) this.ctx.drawImage(this.runImg, this.x, this.y, this.w, this.h);
      else this.ctx.drawImage(this.deadImg, this.x, this.y, this.w, this.h);
    },

    loop() {
      if (!this.confirmed) return;
      this.update();
      this.draw();
      this._rafId = requestAnimationFrame(() => this.loop());
    },
  };
};
