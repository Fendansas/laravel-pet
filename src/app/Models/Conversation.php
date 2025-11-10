<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    protected $fillable = ['user_one_id', 'user_two_id'];

    public function messages(){
        return $this->hasMany(Message::class);
    }

    public function userOne(){
        return $this->belongsTo(User::class, 'user_one_id');
    }
    public function userTwo(){
        return $this->belongsTo(User::class, 'user_two_id');
    }

    public function scopeBetween($query, $user1, $user2)
    {
        return $query->where(function ($q) use ($user1, $user2) {
            $q->where('user_one_id', $user1)->where('user_two_id', $user2);
        })->orWhere(function ($q) use ($user1, $user2) {
            $q->where('user_one_id', $user2)->where('user_two_id', $user1);
        });
    }


}
