<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
USE Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
 //       return view('home');

        $user = Auth::user();

        // ログインユーザーに基づくフォルダを一つ取得
        $folder = $user->folders()->first();

        // まだひとつもフォルダを作っていなければホームページをレスポンス
        if(is_null($folder)){
            return view('home');
        }

        // フォルダがあればタスク一覧にリダイレクト
        return redirect()->route('tasks.index', [
            'id' => $folder->id,
        ]);
    }
}
