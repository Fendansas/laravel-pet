<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserProfileController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // UserProfile (расширенный профиль)
    Route::get('/user-profile', [UserProfileController::class, 'edit'])->name('user-profile.edit');
    Route::post('/user-profile', [UserProfileController::class, 'store'])->name('user-profile.store');
    Route::put('/user-profile', [UserProfileController::class, 'update'])->name('user-profile.update');
});

Route::middleware(['auth'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/users', [UserController::class, 'index'])
            ->middleware(RoleMiddleware::class . ':admin,manager')
            ->name('admin.users.index');
        Route::get('/users/{id}', [UserController::class, 'show'])
            ->middleware(RoleMiddleware::class . ':admin,manager')
            ->name('admin.users.show');
    });



require __DIR__.'/auth.php';
