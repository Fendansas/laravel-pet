<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\Task;
use App\Models\User;
use App\Models\UserPhoto;
use App\Policies\PostPolicy;
use App\Policies\TaskPolicy;
use App\Policies\UserPolicy;
use App\Policies\UserPhotoPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(UserPhoto::class, UserPhotoPolicy::class);
        Gate::policy(Post::class, PostPolicy::class);
        Gate::policy(Task::class, TaskPolicy::class);
        Gate::policy(User::class, UserPolicy::class);

        Event::listen(Login::class, function ($event) {
            $user = $event->user;
            $user->last_login_at = now();
            $user->last_login_ip = request()->ip();
            $user->last_activity_at = now();
            $user->save();
        });

        Event::listen(Logout::class, function ($event) {
            if ($event->user) {
                $event->user->update([
                    'last_activity_at' => now(),
                ]);
            }
        });

        Gate::define('viewAny-user', fn (User $user) =>
        $user->hasRole(['admin', 'manager'])
        );

        Gate::define('view-user', fn (User $user, User $model) =>
        $user->hasRole(['admin', 'manager'])
        );

        Gate::define('update-user', fn (User $user, User $model) =>
        $user->hasRole('admin')
        );

        Gate::define('delete-user', fn (User $user, User $model) =>
        $user->hasRole('admin')
        );
    }
}
