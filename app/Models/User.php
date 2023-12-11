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
       return $this->belongsToMany(Book::class, 'likes', 'user_id', 'book_id')->withTimestamps();

    }

    //この投稿に対して既にlikeしたかどうかを判別する
    public function isLike($bookId)
    {
        return $this->likes()->wherePivot('book_id', $bookId)->exists();
    }

    //isLikeを使って、既にlikeしたか確認したあと、いいねする（重複させない）
    public function like($bookId)
    {
        if($this->isLike($bookId)){
            //もし既に「いいね」していたら解除
            $this->likes()->detach($bookId);
            return false;
        } else {
            $this->likes()->attach($bookId);
            return true;
        }
    }

    //多対多のリレーションを書く
    public function hates(): BelongsToMany
    {
       return $this->belongsToMany(Book::class, 'hates', 'user_id', 'book_id')->withTimestamps();

    }

    //この投稿に対して既にhateしたかどうかを判別する
    public function isHate($bookId)
    {
        return $this->hates()->wherePivot('book_id', $bookId)->exists();
    }

    //isHateを使って、既にhateしたか確認したあと、きらいする（重複させない）
    public function hate($bookId)
    {
        if($this->isHate($bookId)){
            $this->hates()->detach($bookId);
            return false;
        } else {
            $this->hates()->attach($bookId);
            return true;
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
