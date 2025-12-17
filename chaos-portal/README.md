## 🚀 Getting Started

### 1. Clone repository

```bash
git pull
git clone https://github.com/tomonori-ryo/chaos-portal.git
cd .\chaos-portal\

composer install
cp .env.example .env
php artisan key:generate
php artisan serve

http://127.0.0.1:8000
```


### 2. Project structure 

chaos-portal/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── ChaosAuthController.php    ... [Login/Register] 特殊な認証処理、関西弁確認後のPOST受け口
│   │   │   ├── PurgatoryController.php    ... [Load] 労働ロード画面の表示
│   │   │   └── RouletteController.php     ... [Main] ランダム遷移、未実装トラップ、強制ログアウト処理
│   │   └── Requests/
│   │       └── ChaosLoginRequest.php      ... バリデーション（もし入力チェックで遊ぶならここ）
│   └── Models/
│       ├── User.php                       ... ユーザーモデル
│       └── Link.php                       ... [Main] 遷移先URLと「ハズレ（トラップ）」フラグを管理
│
├── database/
│   ├── migrations/
│   │   ├── xxxx_create_users_table.php
│   │   └── xxxx_create_links_table.php    ... リンク情報の定義
│   └── seeders/
│       └── LinkSeeder.php                 ... 50枚のカード用ダミーデータ（罠含む）を流し込む
│
├── public/
│   ├── audio/                             ... [素材] 音源データ
│   │   ├── scream.mp3                     ... バナー削除時の断末魔
│   │   ├── explosion.mp3                  ... バナー爆発音
│   │   └── mokugyo.mp3                    ... (予備) 徳を積む音など
│   └── images/                            ... [素材] 画像データ
│       ├── cursors/
│       │   └── fly-swatter.png            ... [Register] ハエ叩きカーソル画像
│       └── stickman/
│           ├── run.gif                    ... [Register] 走る棒人間
│           └── dead.png                   ... [Register] 潰れた棒人間
│
├── resources/
│   ├── css/
│   │   ├── app.css                        ... Tailwind CSSの読込
│   │   └── chaos-animations.css           ... [Main] カードが暴れる動きや点滅のキーフレーム定義
│   │
│   ├── js/
│   │   ├── app.js                         ... 全体のエントリーポイント
│   │   └── chaos/                         ... ★クソ機能専用JSモジュール
│   │       ├── login-evasion.js           ... [Login] 逃げるボタンの制御
│   │       ├── sentient-banner.js         ... [Login] 生きたバナー、断末魔再生
│   │       ├── kansai-confirm.js          ... [Login] 5回確認ダイアログ
│   │       ├── decaying-loader.js         ... [Load] 減衰バーと連打判定
│   │       └── stickman-battle.js         ... [Register] 棒人間とハエ叩きのCanvas制御
│   │
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php              ... ベースレイアウト（metaタグ、CSS/JS読込）
│       ├── auth/
│       │   ├── login.blade.php            ... [Login] ログイン画面
│       │   └── register.blade.php         ... [Register] 登録画面（点滅注意）
│       ├── purgatory/
│       │   └── loading.blade.php          ... [Load] 労働ロード画面
│       └── dashboard/
│           └── index.blade.php            ... [Main] ロシアンルーレット画面
│
├── routes/
│   └── web.php                            ... ルーティング定義（各コントローラーへの紐付け）
│
└── vite.config.js                         ... アセットのビルド設定
