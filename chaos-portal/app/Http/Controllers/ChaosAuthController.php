<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ChaosAuthController extends Controller
{
    /**
     * ログイン画面 (The Gate of Despair) を表示
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * ログイン処理
     * フロントエンドの妨害（逃げるボタン・関西弁確認）を突破したリクエストのみがここに届く。
     */
    public function login(Request $request)
    {
        // バリデーション（入力チェック）
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 認証試行
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // ★ここがポイント
            // 通常なら 'dashboard' へ行くところを、強制的に 'purgatory' (労働ロード画面) へ飛ばす
            return redirect()->route('purgatory');
        }

        // 失敗時：エラーメッセージを返してログイン画面へ戻す
        return back()->withErrors([
            'email' => 'メールアドレスかパスワードが間違っています。（もっと気合入れて入力してください）',
        ])->onlyInput('email');
    }

    /**
     * 新規登録画面 (Epilepsy & Violence) を表示
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * 新規登録処理
     */
    public function register(Request $request)
    {
        // 入力チェック
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'], // ここで「素数のみ」などの独自ルールを追加することも可能
        ]);

        // ユーザー作成
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // そのままログインさせる
        Auth::login($user);

        // 登録後もやはり煉獄へ送る
        return redirect()->route('purgatory');
    }

    /**
     * ログアウト処理
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ログイン画面へ戻す
        return redirect()->route('login');
    }
}