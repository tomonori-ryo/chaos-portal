<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RouletteController extends Controller
{
    public function index()
    {
        $links = Link::query()
            ->inRandomOrder()
            ->limit(50)
            ->get();

        return view('dashboard.index', [
            'links' => $links,
        ]);
    }

    public function spin(Request $request)
    {
        $id = $request->query('id');

        $link = $id
            ? Link::query()->findOrFail($id)
            : Link::query()->inRandomOrder()->firstOrFail();

        // トラップ or URLなし = 強制ログアウト
        if ($link->is_trap || empty($link->url)) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors(['email' => '未実装に触れた。強制ログアウト。']);
        }

        return redirect()->away($link->url);
    }
}
