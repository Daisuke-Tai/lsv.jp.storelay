<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Book;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{

/*
    public function kinds()
    {
        return $this->hasMany(Kind::class);
        // =   $this->hasMany('App\Book', 'kind_id', 'id');
    }
*/  
    //多対多のリレーションを書く
    public function likes(): BelongsToMany
    {
       return $this->belongsToMany(Book::class,'likes','user_id','post_id')->withTimestamps();

    }

    //この投稿に対して既にlikeしたかどうかを判別する
    public function isLike($postId)
    {
        return $this->likes()->wherePivot('post_id',$postId)->exists();
    }

    //isLikeを使って、既にlikeしたか確認したあと、いいねする（重複させない）
    public function like($postId)
    {
    if($this->isLike($postId)){
        //もし既に「いいね」していたら何もしない
        $test = 1;
    } else {
        $this->likes()->attach($postId);
        $test = 2;
    }
    }

    //isLikeを使って、既にlikeしたか確認して、もししていたら解除する
    public function unlike($postId)
    {
    if($this->isLike($postId)){
        //もし既に「いいね」していたら消す
        $this->likes()->detach($postId);
    } else {
    }
    }

    public function sendPasswordResetNotification($token){
        Mail::to($this)->send(new ResetPassword($token));
    }
    
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

}
