<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kind;
use App\Http\Requests\CreateKind;
use Illuminate\Support\Facades\Auth\User;
use Illuminate\Support\Facades\Auth;

class KindController extends Controller
{
    public function showCreateForm(){
        return view('kinds/create');
    }

    public function create(CreateKind $request){
         
        // フォルダモデルのインスタンスを作成
        $kind = new Kind;
        // タイトルに入力値を代入する
        $kind->name = $request->name;
        // ユーザー取得
//        $user = Auth::user();
        
//        if (is_null($user)){
//            throw new Exception('非ログイン状態では利用できません。');
//        }

        $kind->save();

        return redirect()->route('books.index', [
            'kind_id' => $kind->id,
        ]);
    }
}
