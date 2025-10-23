<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'topic_id',
        'title',
        'content',
        'rating',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function topic(){
        return $this->belongsTo(Topic::class);
    }

    public function ratings(){
        return $this->hasMany(PostRating::class);
    }

    public function averageRating(){
        return $this->ratings()->avg('rating');
    }
    public function userRating($userId){
        return $this->ratings()->where('user_id', $userId)->first();
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function scopePublished($query){
        return $query->where('status', 'published')
            ->where(function($q){
                $q->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }
}
