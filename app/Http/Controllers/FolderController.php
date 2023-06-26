<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folder;
use App\Http\Requests\CreateFolder;
use Illuminate\Support\Facades\Auth\User;
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller
{
    public function showCreateForm(){
        return view('folders/create');
    }

    public function create(CreateFolder $request){
         
        // フォルダモデルのインスタンスを作成
        $folder = new Folder;
        // タイトルに入力値を代入する
        $folder->title = $request->title;
        // インスタンスの状態をデータベースに書き込む
        $user = Auth::user();
        
        if (is_null($user)){
//            throw new Exception('非ログイン状態では利用できません。');
        }

        $user->folders()->save($folder);

        return redirect()->route('tasks.index', [
            'id' => $folder->id,
        ]);
    }
}
