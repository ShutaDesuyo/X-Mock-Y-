<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\NotificationController;
use App\Http\Controllers\Web\PostController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\SearchController;
use App\Http\Controllers\Web\SettingsController;
use App\Http\Controllers\Web\TimelineController;
use Illuminate\Support\Facades\Route;

// 未認証のみ
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// 認証必須
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // タイムライン
    Route::get('/', [TimelineController::class, 'index'])->name('timeline');

    // 検索
    Route::get('/search', [SearchController::class, 'index'])->name('search');

    // 通知
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

    // 設定
    Route::get('/settings/profile', [SettingsController::class, 'showProfile'])->name('settings.profile');
    Route::patch('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile.update');
    Route::get('/settings/password', [SettingsController::class, 'showPassword'])->name('settings.password');
    Route::patch('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password.update');

    // 投稿
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::patch('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
    Route::post('/posts/{post}/comments', [PostController::class, 'storeComment'])->name('posts.comments.store');
    Route::delete('/posts/{post}/comments/{comment}', [PostController::class, 'destroyComment'])->name('posts.comments.destroy');

    // プロフィール（動的ルートは最後）
    Route::get('/{username}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/{username}/likes', [ProfileController::class, 'likes'])->name('profile.likes');
    Route::post('/{username}/follow', [ProfileController::class, 'follow'])->name('profile.follow');
    Route::get('/{username}/followers', [ProfileController::class, 'followers'])->name('profile.followers');
    Route::get('/{username}/following', [ProfileController::class, 'following'])->name('profile.following');
});
