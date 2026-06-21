<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Post $post): JsonResponse
    {
        $comments = $post->comments()
            ->with('user')
            ->latest()
            ->paginate(20);

        return response()->json($comments);
    }

    public function store(StoreCommentRequest $request, Post $post): JsonResponse
    {
        $comment = Comment::create([
            'user_id' => $request->user()->id,
            'post_id' => $post->id,
            'content' => $request->content,
        ]);

        $comment->load('user');

        return response()->json($comment, 201);
    }

    public function destroy(Request $request, Post $post, Comment $comment): JsonResponse
    {
        if ($request->user()->id !== $comment->user_id) {
            return response()->json(['message' => '権限がありません。'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'コメントを削除しました。']);
    }
}
