<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
USE Illuminate\Support\Facades\Auth;
use App\Models\kind;

class HomeController extends Controller
{
    public function index(){
 //       return view('home');

//        $user = Auth::user();

        // ログインユーザーに基づくフォルダを一つ取得
//        $kind = $user->kinds()->first();
        // 選択されたフォルダを取得
//        $kinds = kind::all();

        // まだひとつもフォルダを作っていなければホームページをレスポンス
//        if(is_null($user)){
//            return view('home');
//        }

        // フォルダがあればタスク一覧にリダイレクト
        return redirect()->route('books.index', [
            'kind_id' => 1,
        ]);
    }
}
