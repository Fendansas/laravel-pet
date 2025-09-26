<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TopicController;
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
            ->can('viewAny-user', \App\Models\User::class)
            ->name('admin.users.index');

        Route::get('/users/{user}', [UserController::class, 'show'])
            ->can('view-user', 'user')
            ->name('admin.users.show');

//        Route::get('/users/{user}/edit', [UserController::class, 'edit'])
//            ->can('update-user', 'user')
//            ->name('admin.users.edit');

//        Route::delete('/users/{user}', [UserController::class, 'destroy'])
//            ->can('delete-user', 'user')
//            ->name('admin.users.destroy');
    });

Route::middleware('auth')->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

});

Route::middleware('auth')->group(function () {
    Route::get('/topics', [TopicController::class, 'index'])->name('topics.index');
    Route::get('/topics/create', [TopicController::class, 'create'])->name('topics.create');
    Route::post('/topics', [TopicController::class, 'store'])->name('topics.store');
    Route::get('/topics/{topic}/edit', [TopicController::class, 'edit'])->name('topics.edit');
    Route::put('/topics/{topic}', [TopicController::class, 'update'])->name('topics.update');
    Route::delete('/topics/{topic}', [TopicController::class, 'destroy'])->name('topics.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/components', function () {
        return view('components.index');
    })->name('components.index');
});

Route::post('/posts/{post}/rate', [PostController::class, 'rate'])->name('posts.rate')->middleware('auth');



require __DIR__.'/auth.php';
