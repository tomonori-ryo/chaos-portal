<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Gate of Despair - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* 逃げるボタンのアニメーションを滑らかにする */
        .escape-btn { transition: top 0.1s, left 0.1s; }
        /* 逃げるバナーのアニメーション */
        .escape-banner { transition: top 0.15s, left 0.15s; }
        /* 背景の不穏な空気 */
        body { background-color: #1a1a1a; color: #fff; font-family: 'Courier New', monospace; }
        /* チカチカするグラデーション背景（見やすい色に変更） */
        .scam-gradient {
            background: linear-gradient(45deg, #ffff00, #ff6b00, #ff0000, #ff6b00, #ffff00, #ff6b00);
            background-size: 400% 400%;
            animation: scamFlash 1.5s ease infinite;
        }

        @keyframes scamFlash {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body class="h-screen w-screen overflow-hidden relative flex items-center justify-center">

    <!-- バナー1 -->
    <div x-data="annoyingBanner(10, 10, 'left', 'top', 'away', '100億円当選!!')" x-show="isVisible" 
         x-ref="banner"
         :style="`position: fixed; top: ${bannerTop}px; left: ${bannerLeft}px; transform: rotate(2deg);`"
         class="escape-banner w-80 h-48 scam-gradient border-4 border-red-600 shadow-2xl z-[9999] flex flex-col items-center justify-center p-4 text-black font-bold">
        <p x-text="currentText" class="text-xl text-center mb-4 animate-pulse"></p>
        <p x-text="mainText" class="text-3xl text-red-600 font-black"></p>
        <button @mouseover="moveCloseButton" @click="destroyBanner"
                :class="closeBtnPos"
                class="absolute w-8 h-8 bg-black text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-all duration-75">
            ×
        </button>
    </div>

    <!-- バナー2 -->
    <div x-data="annoyingBanner(10, null, 'right', 'top', 'random', '無料で1000万円！')" x-show="isVisible" 
         x-ref="banner"
         :style="`position: fixed; top: ${bannerTop}px; left: ${bannerLeft}px; transform: rotate(-2deg);`"
         class="escape-banner w-80 h-48 scam-gradient border-4 border-red-600 shadow-2xl z-[9999] flex flex-col items-center justify-center p-4 text-black font-bold">
        <p x-text="currentText" class="text-xl text-center mb-4 animate-pulse"></p>
        <p x-text="mainText" class="text-3xl text-red-600 font-black"></p>
        <button @mouseover="moveCloseButton" @click="destroyBanner"
                :class="closeBtnPos"
                class="absolute w-8 h-8 bg-black text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-all duration-75">
            ×
        </button>
    </div>

    <!-- バナー3 -->
    <div x-data="annoyingBanner(null, 10, 'left', 'bottom', 'clockwise', '今すぐ当たる！')" x-show="isVisible" 
         x-ref="banner"
         :style="`position: fixed; top: ${bannerTop}px; left: ${bannerLeft}px; transform: rotate(3deg);`"
         class="escape-banner w-80 h-48 scam-gradient border-4 border-red-600 shadow-2xl z-[9999] flex flex-col items-center justify-center p-4 text-black font-bold">
        <p x-text="currentText" class="text-xl text-center mb-4 animate-pulse"></p>
        <p x-text="mainText" class="text-3xl text-red-600 font-black"></p>
        <button @mouseover="moveCloseButton" @click="destroyBanner"
                :class="closeBtnPos"
                class="absolute w-8 h-8 bg-black text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-all duration-75">
            ×
        </button>
    </div>

    <!-- バナー4 -->
    <div x-data="annoyingBanner(null, null, 'right', 'bottom', 'counterclockwise', '1秒で億万長者！')" x-show="isVisible" 
         x-ref="banner"
         :style="`position: fixed; top: ${bannerTop}px; left: ${bannerLeft}px; transform: rotate(-3deg);`"
         class="escape-banner w-80 h-48 scam-gradient border-4 border-red-600 shadow-2xl z-[9999] flex flex-col items-center justify-center p-4 text-black font-bold">
        <p x-text="currentText" class="text-xl text-center mb-4 animate-pulse"></p>
        <p x-text="mainText" class="text-3xl text-red-600 font-black"></p>
        <button @mouseover="moveCloseButton" @click="destroyBanner"
                :class="closeBtnPos"
                class="absolute w-8 h-8 bg-black text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-all duration-75">
            ×
        </button>
    </div>

    <!-- バナー5 -->
    <div x-data="annoyingBanner('50%', 20, 'left', 'top', 'up', '奇跡の当選！')" x-show="isVisible" 
         x-ref="banner"
         :style="`position: fixed; top: ${bannerTop}px; left: ${bannerLeft}px; transform: rotate(1deg);`"
         class="escape-banner w-72 h-40 scam-gradient border-4 border-red-600 shadow-2xl z-[9999] flex flex-col items-center justify-center p-4 text-black font-bold">
        <p x-text="currentText" class="text-xl text-center mb-4 animate-pulse"></p>
        <p x-text="mainText" class="text-3xl text-red-600 font-black"></p>
        <button @mouseover="moveCloseButton" @click="destroyBanner"
                :class="closeBtnPos"
                class="absolute w-8 h-8 bg-black text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-all duration-75">
            ×
        </button>
    </div>

    <!-- バナー6 -->
    <div x-data="annoyingBanner('50%', null, 'right', 'top', 'down', '今だけ限定！')" x-show="isVisible" 
         x-ref="banner"
         :style="`position: fixed; top: ${bannerTop}px; left: ${bannerLeft}px; transform: rotate(-1deg);`"
         class="escape-banner w-72 h-40 scam-gradient border-4 border-red-600 shadow-2xl z-[9999] flex flex-col items-center justify-center p-4 text-black font-bold">
        <p x-text="currentText" class="text-xl text-center mb-4 animate-pulse"></p>
        <p x-text="mainText" class="text-3xl text-red-600 font-black"></p>
        <button @mouseover="moveCloseButton" @click="destroyBanner"
                :class="closeBtnPos"
                class="absolute w-8 h-8 bg-black text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-all duration-75">
            ×
        </button>
    </div>

    <!-- バナー7 -->
    <div x-data="annoyingBanner('25%', '50%', 'center', 'top', 'left', '超特大当たり！')" x-show="isVisible" 
         x-ref="banner"
         :style="`position: fixed; top: ${bannerTop}px; left: ${bannerLeft}px; transform: rotate(2deg);`"
         class="escape-banner w-80 h-44 scam-gradient border-4 border-red-600 shadow-2xl z-[9999] flex flex-col items-center justify-center p-4 text-black font-bold">
        <p x-text="currentText" class="text-xl text-center mb-4 animate-pulse"></p>
        <p x-text="mainText" class="text-3xl text-red-600 font-black"></p>
        <button @mouseover="moveCloseButton" @click="destroyBanner"
                :class="closeBtnPos"
                class="absolute w-8 h-8 bg-black text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-all duration-75">
            ×
        </button>
    </div>

    <!-- バナー8 -->
    <div x-data="annoyingBanner(null, '50%', 'center', 'bottom', 'right', '確実に当たる！')" x-show="isVisible" 
         x-ref="banner"
         :style="`position: fixed; top: ${bannerTop}px; left: ${bannerLeft}px; transform: rotate(-2deg);`"
         class="escape-banner w-80 h-44 scam-gradient border-4 border-red-600 shadow-2xl z-[9999] flex flex-col items-center justify-center p-4 text-black font-bold">
        <p x-text="currentText" class="text-xl text-center mb-4 animate-pulse"></p>
        <p x-text="mainText" class="text-3xl text-red-600 font-black"></p>
        <button @mouseover="moveCloseButton" @click="destroyBanner"
                :class="closeBtnPos"
                class="absolute w-8 h-8 bg-black text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-all duration-75">
            ×
        </button>
    </div>

    <div class="w-full max-w-md p-8 bg-gray-800 rounded-lg shadow-lg border border-gray-700 relative z-10">
        <h2 class="text-3xl font-bold text-center mb-8 text-red-500 tracking-widest">LOGIN</h2>

        <form id="loginForm" method="POST" action="/login" @submit.prevent="submitCheck" x-data="loginForm()">
            @csrf
            
            <div class="mb-6">
                <label class="block text-gray-400 mb-2">Email</label>
                <input type="text" name="email" class="w-full p-3 bg-gray-900 border border-gray-600 rounded text-white focus:outline-none focus:border-red-500" placeholder="user@example.com" required>
            </div>

            <div class="mb-8">
                <label class="block text-gray-400 mb-2">Password</label>
                <input type="password" 
                       name="password" 
                       id="passwordInput"
                       @keyup.escape="$dispatch('freeze-button')"
                       @input="checkStopCommand($event.target.value)"
                       class="w-full p-3 bg-gray-900 border border-gray-600 rounded text-white focus:outline-none focus:border-red-500" 
                       required>
            </div>

            <div x-data="escapingButton()" class="relative h-16">
                <button type="submit" 
                        x-ref="btn"
                        @mouseover="escape"
                        :style="`position: absolute; top: ${top}px; left: ${left}px;`"
                        class="escape-btn w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded shadow-lg transform transition hover:scale-105">
                    LOGIN
                </button>
            </div>
        </form>
    </div>

    <audio id="screamSound" src="/audio/scream.mp3"></audio>
    <audio id="explosionSound" src="/audio/Explosion07/Explosion07-2(Close).mp3"></audio>

    <script>
        // ------------------------------------------
        // 機能2: 妨害バナーの制御 (Alpine Component)
        // ------------------------------------------
        function annoyingBanner(initTop = null, initLeft = null, horizontalAlign = 'left', verticalAlign = 'top', escapePattern = 'away', initialMainText = '広告') {
            return {
                isVisible: true,
                currentText: 'ここをクリック！',
                mainText: initialMainText, // 初期のメインテキスト
                closeBtnPos: 'top-2 right-2', // Tailwindクラスで位置管理
                taunts: ['消せると思ってるん？', '指震えてるで？', '必死やなｗ', 'マウス遅っ！', '諦めなはれ'],
                pleas: ['やめてくれ...', '見逃してくれ...', 'お願い...', '助けて...', '許して...', 'もうやめて...', '見逃してください...', '命だけは...'],
                bannerTop: 0,
                bannerLeft: 0,
                horizontalAlign: horizontalAlign,
                verticalAlign: verticalAlign,
                escapePattern: escapePattern,
                isFrozen: false,
                escapeAngle: 0, // 回転パターン用の角度
                isPleading: false, // 命乞いモードかどうか
                pleadingInterval: null, // 命乞いテキスト変更用のインターバル

                init() {
                    this.$nextTick(() => {
                        const banner = this.$refs.banner;
                        if (banner) {
                            const rect = banner.getBoundingClientRect();
                            
                            // 初期位置を設定
                            if (typeof initTop === 'number') {
                                this.bannerTop = initTop;
                            } else if (initTop === '50%') {
                                this.bannerTop = window.innerHeight / 2 - rect.height / 2;
                            } else if (initTop === '25%') {
                                this.bannerTop = window.innerHeight * 0.25 - rect.height / 2;
                            } else {
                                this.bannerTop = verticalAlign === 'bottom' 
                                    ? window.innerHeight - rect.height - 40 
                                    : 40;
                            }
                            
                            if (typeof initLeft === 'number') {
                                this.bannerLeft = initLeft;
                            } else if (initLeft === '50%') {
                                this.bannerLeft = window.innerWidth / 2 - rect.width / 2;
                            } else {
                                if (horizontalAlign === 'right') {
                                    this.bannerLeft = window.innerWidth - rect.width - 40;
                                } else if (horizontalAlign === 'center') {
                                    this.bannerLeft = window.innerWidth / 2 - rect.width / 2;
                                } else {
                                    this.bannerLeft = 40;
                                }
                            }
                            
                            // 画面内に収める
                            this.bannerTop = Math.max(0, Math.min(this.bannerTop, window.innerHeight - rect.height));
                            this.bannerLeft = Math.max(0, Math.min(this.bannerLeft, window.innerWidth - rect.width));
                        }
                    });
                    
                    // 画面全体でマウスを監視
                    const handleMouseMove = (e) => this.escapeBanner(e);
                    document.addEventListener('mousemove', handleMouseMove);
                    
                    // クリーンアップ（必要に応じて）
                    this.$watch('isVisible', (visible) => {
                        if (!visible) {
                            document.removeEventListener('mousemove', handleMouseMove);
                        }
                    });
                    
                    // ■ 追加: 広告停止イベントの受信
                    window.addEventListener('stop-banners', () => {
                        this.isFrozen = true;
                    });
                    
                    // ■ 追加: 他のバナーが消えたときのイベント受信
                    window.addEventListener('banner-destroyed', () => {
                        if (this.isVisible && !this.isPleading) {
                            this.isPleading = true;
                            // 命乞いのテキストに変更
                            this.updatePleadingText();
                            this.currentText = 'お願いします...';
                            
                            // 定期的に命乞いのテキストを変更（再帰的にsetTimeoutを使用）
                            this.scheduleNextPleadingUpdate();
                        }
                    });
                },
                
                updatePleadingText() {
                    // 命乞いのテキストをランダムに選択
                    this.mainText = this.pleas[Math.floor(Math.random() * this.pleas.length)];
                },
                
                scheduleNextPleadingUpdate() {
                    if (this.isPleading && this.isVisible) {
                        // 2-4秒のランダム間隔で次の更新をスケジュール
                        const delay = 2000 + Math.random() * 2000;
                        this.pleadingInterval = setTimeout(() => {
                            if (this.isPleading && this.isVisible) {
                                this.updatePleadingText();
                                this.scheduleNextPleadingUpdate(); // 再帰的に次の更新をスケジュール
                            }
                        }, delay);
                    }
                },

                
                moveCloseButton() {
                    // 広告が凍結されている場合は閉じるボタンも動かさない
                    if (this.isFrozen) return;
                    
                    // 煽りテキスト変更
                    this.currentText = this.taunts[Math.floor(Math.random() * this.taunts.length)];
                    
                    // 4隅のクラス定義
                    const positions = ['top-2 right-2', 'top-2 left-2', 'bottom-2 right-2', 'bottom-2 left-2'];
                    // 現在と違う場所へ移動
                    let newPos;
                    do {
                        newPos = positions[Math.floor(Math.random() * positions.length)];
                    } while (newPos === this.closeBtnPos);
                    
                    this.closeBtnPos = newPos;
                },

                escapeBanner(e) {
                    if (this.isFrozen) return;
                    
                    const banner = this.$refs.banner;
                    if (!banner) return;
                    
                    const rect = banner.getBoundingClientRect();
                    
                    // バナーの中心座標
                    const bannerX = rect.left + rect.width / 2;
                    const bannerY = rect.top + rect.height / 2;

                    // マウス座標
                    const mouseX = e.clientX;
                    const mouseY = e.clientY;

                    // 距離を計算
                    const deltaX = bannerX - mouseX;
                    const deltaY = bannerY - mouseY;
                    const distance = Math.sqrt(deltaX * deltaX + deltaY * deltaY);

                    // マウスが近づいたら逃げる（距離200px以内）
                    if (distance < 200) {
                        const escapeDistance = 120;
                        let angle = 0;

                        // 逃げるパターンに応じて角度を決定
                        switch(this.escapePattern) {
                            case 'away':
                                // マウスから離れる方向
                                angle = Math.atan2(deltaY, deltaX);
                                break;
                            case 'random':
                                // ランダムな方向
                                angle = Math.random() * Math.PI * 2;
                                break;
                            case 'clockwise':
                                // 時計回りに回転
                                this.escapeAngle += 0.3;
                                angle = this.escapeAngle;
                                break;
                            case 'counterclockwise':
                                // 反時計回りに回転
                                this.escapeAngle -= 0.3;
                                angle = this.escapeAngle;
                                break;
                            case 'up':
                                // 上に逃げる
                                angle = -Math.PI / 2;
                                break;
                            case 'down':
                                // 下に逃げる
                                angle = Math.PI / 2;
                                break;
                            case 'left':
                                // 左に逃げる
                                angle = Math.PI;
                                break;
                            case 'right':
                                // 右に逃げる
                                angle = 0;
                                break;
                            default:
                                // デフォルトはマウスから離れる
                                angle = Math.atan2(deltaY, deltaX);
                        }

                        // 現在の位置から逃げる
                        let newLeft = this.bannerLeft + Math.cos(angle) * escapeDistance;
                        let newTop = this.bannerTop + Math.sin(angle) * escapeDistance;

                        // 画面内に収める
                        const maxX = window.innerWidth - rect.width;
                        const maxY = window.innerHeight - rect.height;

                        newLeft = Math.max(0, Math.min(newLeft, maxX));
                        newTop = Math.max(0, Math.min(newTop, maxY));

                        this.bannerLeft = newLeft;
                        this.bannerTop = newTop;
                    }
                },

                destroyBanner() {
                    // ■ 機能2: 断末魔の実装 - 悲鳴と爆発音を同時に再生
                    const screamAudio = document.getElementById('screamSound');
                    const explosionAudio = document.getElementById('explosionSound');
                    
                    if(screamAudio) {
                        screamAudio.volume = 1.0; // 最大音量
                        screamAudio.currentTime = 0; // 最初から再生
                        screamAudio.play().catch(e => console.log('Scream audio playback failed', e));
                    }
                    
                    if(explosionAudio) {
                        explosionAudio.volume = 0.8; // 爆発音は少し低めに
                        explosionAudio.currentTime = 0; // 最初から再生
                        explosionAudio.play().catch(e => console.log('Explosion audio playback failed', e));
                    }
                    
                    // インターバルをクリア
                    if (this.pleadingInterval) {
                        clearTimeout(this.pleadingInterval);
                        this.pleadingInterval = null;
                    }
                    
                    // 他のバナーに通知（命乞いモードに切り替え）
                    window.dispatchEvent(new CustomEvent('banner-destroyed'));
                    
                    // 爆発エフェクトっぽく消える
                    alert('ギャァァァァァァ！！！！'); // 簡易的な演出
                    this.isVisible = false;
                }
            }
        }

        // ------------------------------------------
        // 機能1: 逃げるボタンの制御 (Alpine Component)
        // ------------------------------------------
        // 機能1: 逃げるボタン（改・ベクトル回避版）
function escapingButton() {
    return {
        top: 0,
        left: 0,
        isFrozen: false, // ■ 追加: 停止フラグ

        init() {
            // 初期位置をフォーム内にセット（画面ロード時）
            this.$nextTick(() => {
                const btn = this.$refs.btn;
                // 最初は親要素内（フォーム内）に表示
                this.top = 0; 
                this.left = 0;
            });
            
            // ■ 追加: 裏口イベントの受信
            window.addEventListener('freeze-button', () => {
                this.isFrozen = true;
                alert('【開発者モード】ボタンを凍結しました。今のうちに押してください。');
            });
        },
        escape(e) {
            if (this.isFrozen) return; // ■ 追加: 凍結中は逃げない
            
            const btn = this.$refs.btn;
            
            // ボタンが初めて逃げる時、fixedに切り替えて画面全体を使えるようにする
            if (btn.style.position !== 'fixed') {
                btn.style.position = 'fixed';
                btn.style.zIndex = '10000';
                // 現在の画面座標を取得
                const rect = btn.getBoundingClientRect();
                this.top = Math.max(0, Math.min(rect.top, window.innerHeight - rect.height));
                this.left = Math.max(0, Math.min(rect.left, window.innerWidth - rect.width));
                return; // 初回は位置調整だけして終了
            }
            
            const rect = btn.getBoundingClientRect();
            
            // ボタンの中心座標
            const btnX = rect.left + rect.width / 2;
            const btnY = rect.top + rect.height / 2;

            // マウス座標
            const mouseX = e.clientX;
            const mouseY = e.clientY;

            // 距離と角度を計算
            const deltaX = btnX - mouseX;
            const deltaY = btnY - mouseY;
            
            // 「逃げる距離」を固定（例: 150px）
            // マウスが近づく方向の「逆」にこの距離分だけ移動させる
            const distance = 150; 
            const angle = Math.atan2(deltaY, deltaX);

            let newLeft = this.left + Math.cos(angle) * distance;
            let newTop = this.top + Math.sin(angle) * distance;

            // ■ 画面外に出ないように壁際でバウンドさせる処理
            const btnWidth = rect.width;
            const btnHeight = rect.height;
            const maxX = window.innerWidth - btnWidth;
            const maxY = window.innerHeight - btnHeight;

            // 画面内に確実に収める
            newLeft = Math.max(0, Math.min(newLeft, maxX));
            newTop = Math.max(0, Math.min(newTop, maxY));

            // 座標更新
            this.left = newLeft;
            this.top = newTop;
        }
    }
}

        // ------------------------------------------
        // 機能: ログインフォームの制御 (Alpine Component)
        // ------------------------------------------
        function loginForm() {
            return {
                checkStopCommand(value) {
                    if (!value) return;
                    
                    // 停止コマンドのリスト（大文字小文字を区別しない）
                    const stopCommands = ['stop', '助けて', 'たすけて', 'help', 'ヘルプ', 'とめて', '止めて', 'やめて', 'ストップ'];
                    
                    const lowerValue = value.toLowerCase();
                    
                    // 入力値に停止コマンドが含まれているかチェック
                    for (let cmd of stopCommands) {
                        if (lowerValue.includes(cmd.toLowerCase()) || value.includes(cmd)) {
                            // 全てのバナーを停止するイベントを発行
                            window.dispatchEvent(new CustomEvent('stop-banners'));
                            
                            // メッセージを表示
                            const messages = [
                                '【助けを求めた】広告を凍結しました。今のうちに閉じてください。',
                                '【緊急停止】広告が動かなくなりました。',
                                '【SOS受信】広告を一時停止しました。',
                                '【停止命令】広告がフリーズしました。',
                                '【救済措置】広告の動きを止めました。'
                            ];
                            const message = messages[Math.floor(Math.random() * messages.length)];
                            alert(message);
                            
                            // 入力欄をクリア
                            const input = document.getElementById('passwordInput');
                            if (input) {
                                input.value = '';
                            }
                            
                            return; // 処理を終了
                        }
                    }
                }
            }
        }

        // ------------------------------------------
        // 機能3: 関西弁・執念の確認ダイアログ (Vanilla JS)
        // ------------------------------------------
        async function submitCheck(e) {
            const messages = [
                "ほんまにログインすんの？",
                "間違いちゃうか？ 手滑ったんやろ？",
                "今なら引き返せるで。やめとくか？", // ※ここは罠要素（文言通りなら「はい」でやめるべきだが統一性を優先）
                "知らんで？ 後悔しても知らんで？",
                "覚悟決まったんか？ ほんまにええのんか？"
            ];

            // 5回ループ
            for (let i = 0; i < messages.length; i++) {
                // confirm は「OK」でtrue、「キャンセル」でfalse
                // 3番目の「やめとくか？」だけはロジックを変えるとさらに鬼畜ですが、
                // まずは「全てOKしないと進めない」仕様にします。
                if (!confirm(messages[i])) {
                    alert("ほな、やめとき！");
                    resetForm();
                    return; // 送信中止
                }
            }

            // 5回すべて乗り越えたら送信
            document.getElementById('loginForm').submit();
        }

        function resetForm() {
            // フォームのリセット
            document.getElementById('loginForm').reset();
            // ページのリロードでボタン位置などを初期化させるのが手っ取り早い
            location.reload(); 
        }
    </script>
</body>
</html>