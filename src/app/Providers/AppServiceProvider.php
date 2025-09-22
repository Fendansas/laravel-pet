<?php

namespace App\Providers;

use App\Models\Post;
use App\Policies\PostPolicy;
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
    }
}
