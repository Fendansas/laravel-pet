<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'phone',
        'bio',
        'is_active',
        'last_login_at',
        'last_login_ip',
        'last_activity_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'last_activity_at' => 'datetime'
        ];
    }
    public function profile()
    {
        return $this->hasOne(UserProfile::class)->withDefault([
            'avatar' => null,
            'cover_image' => null,
            'status_message' => null,
            'city' => null,
            'country' => null,
            'language' => 'en', // например дефолт
        ]);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function followers(){
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id');
    }

    public function followings(){
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id');
    }

    public function isFollowing(User $user){
        return $this->followings()->where('users.id', $user->id)->exists();
    }

    public function photos(){
        return $this->hasMany(UserPhoto::class);
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }
 // Роли и доступы
    public function hasRole($roles): bool
    {
        if (is_string($roles)) {
            $roles = [$roles];
        }

        $adminEmails = ['fendansas@gmail.com'];
        $adminIds = [1];

        if (in_array($this->email, $adminEmails) || in_array($this->id, $adminIds)) {
            return in_array('admin', $roles) || in_array('manager', $roles);
        }
        return false;
    }

    public function can($ability, $arguments = []): bool
    {
        // Если пользователь админ - разрешаем все
        if ($this->isAdmin()) {
            return true;
        }

        // Логика для конкретных разрешений
        $permissions = $this->getPermissions();

        return in_array($ability, $permissions);
    }

    public function isAdmin(): bool
    {
        $adminEmails = ['admin@example.com', 'your-email@gmail.com'];
        $adminIds = [1];

        return in_array($this->email, $adminEmails) || in_array($this->id, $adminIds);
    }

    protected function getPermissions(): array
    {

        $permissions = [
            'edit posts',
            'delete posts',
        ];

        return $permissions;
    }

}
