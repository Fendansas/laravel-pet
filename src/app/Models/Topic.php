<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Topic extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function posts(){
        return $this->hasMany(Post::class);
    }

    protected static function boot(){
        parent::boot();

        static::creating(function($topic){
            if (empty($topic->slug)) {
                $topic->slug = Str::slug($topic->name);
            }
        });
    }


}
