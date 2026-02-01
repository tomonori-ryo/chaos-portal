(() => {
  const barFill = document.getElementById('barFill');
  const barLabel = document.getElementById('barLabel');
  const injectBtn = document.getElementById('injectBtn');
  const taunt = document.getElementById('taunt');
  const redirectTo = window.__PURGATORY_REDIRECT_TO__ || '/';

  let value = 0;          // 0..100
  let ticking = true;

  // простая “травля”
  const taunts = [
    'ほら、手止まってるで？',
    '指、弱ない？',
    'もっと必死になれや',
    'それで100%いける思ってんの？',
    '減る方が早いで？ｗ',
  ];

  function clamp(n, min, max) {
    return Math.max(min, Math.min(max, n));
  }

  function render() {
    value = clamp(value, 0, 100);
    barFill.style.width = value + '%';
    barLabel.textContent = value + '%';
    const bar = document.querySelector('[role="progressbar"]');
    if (bar) bar.setAttribute('aria-valuenow', String(value));
  }

  function winNow() {
    if (!ticking) return;
    ticking = false;
    // “момент достижения 100%”
    value = 100;
    render();

    // маленькая пауза чтобы пользователь успел увидеть 100% (можешь убрать, если хочешь прям “瞬間”)
    setTimeout(() => {
      window.location.href = redirectTo;
    }, 150);
  }

  // Каждую секунду -10%
  const decayTimer = setInterval(() => {
    if (!ticking) return;
    value -= 10;
    render();
  }, 1000);

  // Клик +2%
  let lastClickTs = 0;
  let combo = 0;

  injectBtn.addEventListener('click', () => {
    if (!ticking) return;

    const now = performance.now();
    const dt = now - lastClickTs;
    lastClickTs = now;

    // если кликаешь быстро — растёт комбо
    if (dt <= 220) combo = Math.min(combo + 1, 8);     // примерно 4-5 кликов/сек
    else if (dt <= 350) combo = Math.min(combo, 6);    // держим
    else combo = Math.max(combo - 2, 0);               // медленно — комбо падает

    // базово +2% как в ТЗ, бонус зависит от комбо
    const bonus = combo >= 6 ? 2 : combo >= 3 ? 1 : 0; // +1% или +2% бонусом
    value += (2 + bonus);

    render();

    taunt.textContent = taunts[(Math.random() * taunts.length) | 0] + ` (combo:${combo})`;

    if (value >= 100) {
      clearInterval(decayTimer);
      winNow();
    }
  });

  // стартовый рендер
  render();
})();
