<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

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

    public function can($permissions, $arguments = [])
    {
        return $this->hasPermission($permissions);
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

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }


    public function assignRole($role){
        $role = Role::where('name', $role)->firstOrFail();

        return $this->roles()->syncWithoutDetaching([$role->id]);
    }

    public function removeRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->first();
            if (!$role) return $this;
        }
        $this->roles()->detach($role->id);
        return $this;
    }

    public function syncRoles(array $roles)
    {
        $roleIds = Role::whereIn('name', $roles)->pluck('id')->toArray();
        $this->roles()->sync($roleIds);
        return $this;
    }

    public function hasRole($roles){
        if (is_string($roles)) {
            $roles = [$roles];
        }
        return $this->roles()->whereIn('name', $roles)->exists();
    }


    public function hasPermission($permission){

        if(is_string($permission)){
            $permission = [$permission];
        }


        return $this->roles()
            ->whereHas('permissions', function ($query) use ($permission) {
               $query->whereIn('permissions.name', $permission);
            })
            ->exists();
    }

    public function canEditPost(Post $post): bool
    {
        if($this->isAdmin()){
            return true;
        }

        if ($this->hasPermission('edit posts')) {
            return true;
        }

        if ($this->id === $post->user_id && $this->hasPermission('edit own posts')) {
            return true;
        }

        return false;

    }

}
