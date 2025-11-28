<?php


use App\Http\Controllers\Admin\UserController;

Route::middleware(['auth', 'role:admin'])
->prefix('admin')
->group(function () {
Route::get('/users', [UserController::class, 'index'])
//            ->can('viewAny-user', \App\Models\User::class)
->name('admin.users.index');

Route::get('/users/{user}', [UserController::class, 'show'])
//            ->can('view-user', 'user')
->name('admin.users.show');
});
