<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Like;
use App\Models\Hate;
use Illuminate\Support\Facades\Auth;

class Book extends Model
{

    protected $table = 'books';

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // indexでexistsを取ってくるとき用
    public function isLike()
    {
        return $this->likes()->where('user_id', Auth::user()->id);
    }

    public function hates()
    {
        return $this->hasMany(Hate::class);
    }

    // indexでexistsを取ってくるとき用
    public function isHate()
    {
        return $this->hates()->where('user_id', Auth::user()->id);
    }

    //    use HasFactory;
    const STATUS = [
        1 => ['label' => '未着手', 'class' => 'label-danger'],
        2 => ['label' => '着手中', 'class' => 'label-info'],
        3 => ['label' => '完了', 'class' => ''],
    ];

    public function getStatusLabelAttribute(){
        // 状態値
        $status = $this->attributes['del_f'];
        // 定義されていなければ空文字を返す
        if(!isset(self::STATUS[$status])){
            return 9;
        }

        return self::STATUS[$status]['del_f'];
    }

    //  状態を表すHTMLクラス @return string
    public function getStatusClassAttribute(){
        // 状態値
        $status = $this->attributes['del_f'];
        // 定義されていなければ空文字を返す
        if(!isset(self::STATUS[$status])){
            return 'AA';
        }

        return self::STATUS[$status]['class'];
    }

    // 整形した期限日 @return string
    public function getFormattedcreated_atAttribute(){
//        return Carbon::createFromFormat('Y-m-d', $this->attributes['due_date'])->format('Y/m/d');
        return Carbon::createFromFormat('Y-m-d', $this->attributes['created_at'])->format('Y/m/d');
    
    }
}
