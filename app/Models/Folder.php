<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;
use App\Models\user;

class Folder extends Model
{
    
    public function user()
	{
		return $this->belongsTo(User::class);
	}

    use HasFactory;

    public function tasks(){
        return $this->hasMany(Task::class);
        // =   $this->hasMany('App\Task', 'folder_id', 'id');
    }
}
