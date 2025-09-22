<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostRating extends Model
{
    protected $fillable = ['post_id', 'user_id', 'rating'];

    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
