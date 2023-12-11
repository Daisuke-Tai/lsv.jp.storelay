<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
USE Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store($bookId)
    {
        
        $result =  (Auth::user()->like($bookId));
        if($result){
            return response()->json(['result' => '1']);
        } else {
            return response()->json(['result' => '-1']);
        };

    }

    public function store2($bookId)
    {
        
        $result =  (Auth::user()->hate($bookId));
        if($result){
            return response()->json(['result' => '1']);
        } else {
            return response()->json(['result' => '-1']);
        };

    }
}
