<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class RestoreDummyUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // セッションにダミーユーザー情報が保存されている場合、復元
        if (session()->has('auth.dummy_user')) {
            $userData = session()->get('auth.dummy_user');
            $user = Auth::user();
            
            // 現在のユーザーがダミーユーザーのIDで、かつデータベースから取得できなかった場合
            if (!$user || ($user && $user->id === $userData['id'] && !$user->exists)) {
                $dummyUser = new User();
                $dummyUser->id = $userData['id'];
                $dummyUser->name = $userData['name'];
                $dummyUser->email = $userData['email'];
                $dummyUser->exists = false;
                
                // ユーザーを設定
                Auth::setUser($dummyUser);
            }
        }
        
        return $next($request);
    }
}

