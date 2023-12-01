<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;
use App\Models\User;

class Kind extends Model
{
    
    public function user()
	{
		return $this->belongsTo(User::class);
	}
    
    use HasFactory;

    public function books(){
        return $this->hasMany(Book::class);
        // =   $this->hasMany('App\book', 'kind_id', 'id');
    }
}
