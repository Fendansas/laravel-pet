<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use App\Models\UserPhoto;
use App\Policies\PostPolicy;
use App\Policies\UserPolicy;
use App\Policies\UserPhotoPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(UserPhoto::class, UserPhotoPolicy::class);

        Event::listen(Login::class, function ($event) {
            $user = $event->user;
            $user->last_login_at = now();
            $user->last_login_ip = request()->ip();
            $user->last_activity_at = now();
            $user->save();
        });

        Event::listen(Logout::class, function ($event) {
            $user = $event->user;
            if ($user) {
                $user->last_activity_at = now();
                $user->save();
            }
        });

        Gate::policy(Post::class, PostPolicy::class);

        Gate::define('viewAny-user', function (User $authUser) {
            return $authUser->hasRole(['admin', 'manager']);
        });

        // Просмотр отдельного пользователя
        Gate::define('view-user', function (User $authUser, User $model) {
            return $authUser->hasRole(['admin', 'manager']);
        });

        // Редактирование (только admin)
        Gate::define('update-user', function (User $authUser, User $model) {
            return $authUser->hasRole('admin');
        });

        // Удаление (только admin)
        Gate::define('delete-user', function (User $authUser, User $model) {
            return $authUser->hasRole('admin');
        });


    }
}
