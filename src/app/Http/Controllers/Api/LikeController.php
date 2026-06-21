<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Request $request, Post $post): JsonResponse
    {
        $existing = Like::where('user_id', $request->user()->id)
            ->where('post_id', $post->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $liked = false;
            $message = 'いいねを取り消しました。';
        } else {
            Like::create([
                'user_id' => $request->user()->id,
                'post_id' => $post->id,
            ]);
            $liked = true;
            $message = 'いいねしました。';
        }

        return response()->json([
            'liked' => $liked,
            'likes_count' => $post->likes()->count(),
            'message' => $message,
        ]);
    }

    public function index(Request $request): JsonResponse
    {
        $likedPosts = Post::whereHas('likes', fn($q) => $q->where('user_id', $request->user()->id))
            ->with(['user', 'likes', 'comments'])
            ->latest('likes.created_at')
            ->paginate(20);

        $likedPosts->getCollection()->transform(function ($post) use ($request) {
            $post->liked = true;
            $post->likes_count = $post->likes->count();
            $post->comments_count = $post->comments->count();
            return $post;
        });

        return response()->json($likedPosts);
    }

    public function postLikes(Post $post): JsonResponse
    {
        $likes = $post->likes()->with('user')->latest()->get();

        return response()->json([
            'post_id' => $post->id,
            'likes_count' => $likes->count(),
            'users' => $likes->map(fn($like) => $like->user),
        ]);
    }
}
