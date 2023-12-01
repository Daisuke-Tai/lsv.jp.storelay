<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Sequence extends Facade // 【1行目】ここのクラス名と
{
    protected static function getFacadeAccessor()
    {
        // Facade化したいクラスのクラス名を書く
        return \App\Services\SequenceService::class; // 【2行目】ここを書き換える
    }
}