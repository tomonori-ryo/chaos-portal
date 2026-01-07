<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChaosAuthController;
use App\Http\Controllers\PurgatoryController;
use App\Http\Controllers\RouletteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Chaos Portal のルーティング定義。
| 通常のWebアプリと異なり、「煉獄（Purgatory）」を経由させるのが特徴。
|
*/

// ルートアクセスは問答無用でログイン画面へ飛ばす
Route::get('/', function () {
    return redirect()->route('login');
});

// ----------------------------------------------------------------
// ■ ゲスト用ルート（未ログイン時のみアクセス可能）
// ----------------------------------------------------------------
Route::middleware('guest')->group(function () {
    
    // 2.1 ログイン画面 (The Gate of Despair)
    // ※Bladeを表示するコントローラーへ繋ぐ
    Route::get('/login', [ChaosAuthController::class, 'showLogin'])->name('login');
    
    // ログイン処理（関西弁確認を突破した猛者が来る場所）
    Route::post('/login', [ChaosAuthController::class, 'login']);

    // 2.3 新規登録画面 (Epilepsy & Violence)
    Route::get('/register', [ChaosAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [ChaosAuthController::class, 'register']);
});

// ----------------------------------------------------------------
// ■ 認証済みルート（ログイン後にアクセス可能）
// ----------------------------------------------------------------
Route::middleware('auth')->group(function () {

    // 2.2 ロード画面 (The Purgatory)
    // ログイン成功後はまずここにリダイレクトされる仕様にする
    Route::get('/purgatory', [PurgatoryController::class, 'index'])->name('purgatory');

    // 2.4 メイン画面 (Russian Roulette Portal)
    // 煉獄の労働（連打）を終えた者だけが辿り着ける
    Route::get('/dashboard', [RouletteController::class, 'index'])->name('dashboard');

    // ★ ロシアンルーレット実行処理
    // カードをクリックした時に呼ばれる。「アタリ」か「強制ログアウト罠」かを判定
    Route::get('/roulette/spin', [RouletteController::class, 'spin'])->name('roulette.spin');

    // ログアウト処理
    Route::post('/logout', [ChaosAuthController::class, 'logout'])->name('logout');
});