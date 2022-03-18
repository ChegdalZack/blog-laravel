<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory,SoftDeletes;
  


    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function user()
    {
        return $this->belongsTo(user::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes(){

        return $this->hasMany(Like::class);
    }

//event 
    // public static function boot()
    // {
    //     static::deleting(function($blog){
            
    //         $blog->comments()->delete();


    //     });
    // }
}
