<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurgatoryController extends Controller
{
    /**
     * loading画面を表示
     */
    public function loading()
    {
        return view('purgatory.loading');
    }
    
    /**
     * purgatory画面を表示（既存のメソッド）
     */
    public function index()
    {
        return view('purgatory.loading'); // または適切なビュー
    }
}

