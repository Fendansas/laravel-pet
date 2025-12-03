<?php


use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\UserRoleController;

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

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('roles', RoleController::class)
            ->only(['index','create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('permissions', PermissionController::class)
            ->only(['index','create', 'store', 'edit', 'update', 'destroy']);

        Route::get('users/{user}/roles', [UserRoleController::class, 'edit'])->name('users.role.edit');
        Route::put('users/{user}/roles', [UserRoleController::class, 'update'])->name('users.role.update');
    });
