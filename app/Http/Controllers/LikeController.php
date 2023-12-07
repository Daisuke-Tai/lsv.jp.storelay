<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
USE Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store($bookId)
    {
        Auth::user()->like($bookId);
        return 'ok!'; //レスポンス内容
//        return response()->json(['message' => 'like ok', 'book_id' => $bookId]);
    }

    public function destroy($bookId)
    {
        Auth::user()->unlike($bookId);
        return 'ok!'; //レスポンス内容
    }
}
