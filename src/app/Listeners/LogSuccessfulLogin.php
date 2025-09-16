<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Request;

class LogSuccessfulLogin {
    public function handle(Login $event): void{
        $user = $event->user;
        $user->last_login_at = now();
        $user->last_login_ip = Request::ip();
        $user->save();
    }
}
