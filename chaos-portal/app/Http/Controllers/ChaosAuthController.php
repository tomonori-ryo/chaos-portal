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
        // 基本的なバリデーション（入力チェック）
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        // ■ 隠しコマンド: メール欄に「masterkey」、パスワードに「opendoor」でデータベースを使わずログイン
        // 隠しコマンドの場合はメール形式チェックをスキップ
        if (strtolower($credentials['email']) === 'masterkey' && $credentials['password'] === 'opendoor') {
            // ダミーユーザーを作成してログイン（データベースは使用しない）
            $dummyUser = new User();
            $dummyUser->id = 999999; // ダミーID
            $dummyUser->name = 'Master User';
            $dummyUser->email = 'master@chaos.portal';
            
            // データベースに存在しないことを示す（これにより再取得を防ぐ）
            $dummyUser->exists = false;
            $dummyUser->wasRecentlyCreated = false;
            
            // データベースを使わずにログイン
            Auth::login($dummyUser, false); // remember meはfalse
            
            // セッションに直接ユーザー情報を保存（データベース再取得を回避）
            $request->session()->put('auth.dummy_user', [
                'id' => $dummyUser->id,
                'name' => $dummyUser->name,
                'email' => $dummyUser->email,
            ]);
            
            $request->session()->regenerate();

            // loading画面へリダイレクト
            return redirect()->route('loading');
        }

        // 通常のバリデーション（隠しコマンドでない場合のみemail形式をチェック）
        $request->validate([
            'email' => ['email'],
        ]);

        // 認証試行
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // ★ここがポイント
            // loading画面へリダイレクト
            return redirect()->route('loading');
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
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8','confirmed'], // ここで「素数のみ」などの独自ルールを追加することも可能
        ]);

        // ユーザー作成
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // そのままログインさせる
        Auth::login($user);

        // 登録後もloading画面へ送る
        return redirect()->route('loading');
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