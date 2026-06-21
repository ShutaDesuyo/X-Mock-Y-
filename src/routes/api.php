<?php

use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\FollowController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

// 認証不要（ブルートフォース対策: 1分あたり10回まで）
Route::middleware('throttle:10,1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// 認証必須（1分あたり60回まで）
Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
    // 認証
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // 投稿
    Route::get('/timeline', [PostController::class, 'timeline']);
    Route::apiResource('posts', PostController::class)->names('api.posts');
    Route::get('/users/{username}/posts', [PostController::class, 'userPosts']);

    // いいね
    Route::post('/posts/{post}/like', [LikeController::class, 'toggle']);
    Route::get('/likes', [LikeController::class, 'index']);
    Route::get('/posts/{post}/likes', [LikeController::class, 'postLikes']);

    // コメント
    Route::get('/posts/{post}/comments', [CommentController::class, 'index']);
    Route::post('/posts/{post}/comments', [CommentController::class, 'store']);
    Route::delete('/posts/{post}/comments/{comment}', [CommentController::class, 'destroy']);

    // フォロー
    Route::post('/users/{username}/follow', [FollowController::class, 'toggle']);
    Route::get('/users/{username}/followers', [FollowController::class, 'followers']);
    Route::get('/users/{username}/following', [FollowController::class, 'following']);

    // ユーザー
    Route::get('/users/search', [UserController::class, 'search']);
    Route::get('/users/{username}', [UserController::class, 'show']);
});
