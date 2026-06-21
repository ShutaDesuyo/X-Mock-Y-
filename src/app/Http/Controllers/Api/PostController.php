<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $posts = Post::with(['user', 'likes', 'comments.user'])
            ->latest()
            ->paginate(20);

        $posts->getCollection()->transform(function ($post) use ($request) {
            $post->liked = $request->user()
                ? $post->likes->contains('user_id', $request->user()->id)
                : false;
            $post->likes_count = $post->likes->count();
            $post->comments_count = $post->comments->count();
            return $post;
        });

        return response()->json($posts);
    }

    public function store(StorePostRequest $request): JsonResponse
    {
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create([
            'user_id' => $request->user()->id,
            'content' => $request->content,
            'image' => $imagePath,
        ]);

        $post->load('user');

        return response()->json($post, 201);
    }

    public function show(Request $request, Post $post): JsonResponse
    {
        $post->load(['user', 'likes', 'comments.user']);
        $post->liked = $request->user()
            ? $post->likes->contains('user_id', $request->user()->id)
            : false;
        $post->likes_count = $post->likes->count();
        $post->comments_count = $post->comments->count();

        return response()->json($post);
    }

    public function update(UpdatePostRequest $request, Post $post): JsonResponse
    {
        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $post->image = $request->file('image')->store('posts', 'public');
        }

        $post->content = $request->content;
        $post->save();

        $post->load('user');

        return response()->json($post);
    }

    public function destroy(Request $request, Post $post): JsonResponse
    {
        if ($request->user()->id !== $post->user_id) {
            return response()->json(['message' => '権限がありません。'], 403);
        }

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return response()->json(['message' => '投稿を削除しました。']);
    }

    public function userPosts(Request $request, string $username): JsonResponse
    {
        $posts = Post::whereHas('user', fn($q) => $q->where('username', $username))
            ->with(['user', 'likes', 'comments'])
            ->latest()
            ->paginate(20);

        $posts->getCollection()->transform(function ($post) use ($request) {
            $post->liked = $request->user()
                ? $post->likes->contains('user_id', $request->user()->id)
                : false;
            $post->likes_count = $post->likes->count();
            $post->comments_count = $post->comments->count();
            return $post;
        });

        return response()->json($posts);
    }

    public function timeline(Request $request): JsonResponse
    {
        $followingIds = $request->user()->following()->pluck('users.id');
        $followingIds->push($request->user()->id);

        $posts = Post::whereIn('user_id', $followingIds)
            ->with(['user', 'likes', 'comments'])
            ->latest()
            ->paginate(20);

        $posts->getCollection()->transform(function ($post) use ($request) {
            $post->liked = $post->likes->contains('user_id', $request->user()->id);
            $post->likes_count = $post->likes->count();
            $post->comments_count = $post->comments->count();
            return $post;
        });

        return response()->json($posts);
    }
}
