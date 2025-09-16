<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date_of_birth',
        'gender',
        'address',
        'city',
        'country',
        'zipcode',
        'website',
        'social_links',
        'timezone',
        'language',
        'status_message',
        'avatar',
        'cover_image',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'social_links' => 'array',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    protected function avatarUrl(): Attribute
    {
        return Attribute::get(fn () =>
        $this->avatar
            ? asset('storage/' . $this->avatar)
            : asset('images/default-avatar.png')
        );
    }

    protected function coverImageUrl(): Attribute
    {
        return Attribute::get(fn () =>
        $this->cover_image
            ? asset('storage/' . $this->cover_image)
            : asset('images/default-cover.jpg')
        );
    }
}
