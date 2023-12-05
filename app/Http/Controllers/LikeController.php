<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
USE Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store($postId)
    {
        Auth::user()->like($postId);
        return 'ok!'; //レスポンス内容
//        return response()->json(['message' => 'like ok', 'post_id' => $postId]);
    }

    public function destroy($postId)
    {
        Auth::user()->unlike($postId);
        return 'ok!'; //レスポンス内容
    }
}
