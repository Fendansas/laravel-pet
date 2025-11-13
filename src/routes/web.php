<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UserPhotoController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserProfileController;
use Stripe\Stripe;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', [PostController::class, 'dashboard'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // UserProfile (расширенный профиль)
    Route::get('/user-profile', [UserProfileController::class, 'edit'])->name('user-profile.edit');
    Route::post('/user-profile', [UserProfileController::class, 'store'])->name('user-profile.store');
    Route::put('/user-profile', [UserProfileController::class, 'update'])->name('user-profile.update');

    Route::get('/users/{user}/followers', [FollowController::class, 'followers'])->name('user.followers');
    Route::get('/users/{user}/following', [FollowController::class, 'following'])->name('user.following');

});


Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UserProfileController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserProfileController::class, 'show'])->name('users.show');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/follow/{user}', [FollowController::class, 'follow'])->name('follow');
    Route::delete('/unfollow/{user}', [FollowController::class, 'unfollow'])->name('unfollow');
});

Route::middleware(['auth', 'admin'])
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


Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/photos', [UserPhotoController::class, 'index'])->name('user-photos.index');
    Route::post('/photos', [UserPhotoController::class, 'store'])->name('user-photos.store');
    Route::delete('/photos/{userPhoto}', [UserPhotoController::class, 'destroy'])->name('user-photos.destroy');
    Route::get('/photos/{user}', [UserPhotoController::class, 'show'])->name('user-photos.show');
});


Route::get('/deposit', [ProfileController::class, 'deposit'])
    ->middleware('auth')
    ->name('deposit');

Route::get('/stripe-test', function () {
    Stripe::setApiKey(config('services.stripe.secret'));

    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => 1000, // сумма в центах, т.е. $10.00
        'currency' => 'usd',
        'description' => 'Тестовый платеж через Stripe',
        'payment_method_types' => ['card'],
    ]);

    return response()->json($paymentIntent);
});

Route::middleware(['auth'])->group(function () {
    Route::post('/stripe/create-payment-intent', [StripeController::class, 'createPaymentIntent']);
});

Route::get('/payments', [\App\Http\Controllers\PaymentController::class, 'index'])
    ->middleware(['auth'])
    ->name('payments.index');

Route::middleware('auth')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{user}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');
});

Route::middleware(['auth'])->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::resource('events', EventController::class);
        Route::get('events/{event}/tasks', [TaskController::class, 'index'])->name('tasks.index');
        Route::get('tasks/create', [TaskController::class, 'create'])->name('tasks.create');
        Route::post('tasks', [TaskController::class, 'store'])->name('tasks.store');
        Route::get('tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
        Route::get('tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
        Route::put('tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
        Route::delete('tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    });
});

require __DIR__.'/auth.php';
