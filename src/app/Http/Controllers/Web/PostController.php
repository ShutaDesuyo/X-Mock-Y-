<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => ['required', 'string', 'max:280'],
            'image'   => ['nullable', File::image()->max(5 * 1024)->dimensions(Rule::dimensions()->maxWidth(4096)->maxHeight(4096))],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        Post::create([
            'user_id' => Auth::id(),
            'content' => $validated['content'],
            'image'   => $imagePath,
        ]);

        return back();
    }

    public function update(Request $request, Post $post)
    {
        abort_if(Auth::id() !== $post->user_id, 403);

        $validated = $request->validate([
            'content' => ['required', 'string', 'max:280'],
        ]);

        $post->update(['content' => $validated['content']]);

        return back();
    }

    public function destroy(Post $post)
    {
        abort_if(Auth::id() !== $post->user_id, 403);

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return back();
    }

    public function show(Post $post)
    {
        $post->load(['user', 'likes', 'comments.user']);
        $post->liked          = $post->likes->contains('user_id', Auth::id());
        $post->likes_count    = $post->likes->count();
        $post->comments_count = $post->comments->count();

        return view('post.show', compact('post'));
    }

    public function like(Post $post)
    {
        $authUser = Auth::user();
        $existing = Like::where('user_id', $authUser->id)->where('post_id', $post->id)->first();

        if ($existing) {
            $existing->delete();
        } else {
            Like::create(['user_id' => $authUser->id, 'post_id' => $post->id]);
            $post->user->notify('like', $authUser, $post);
        }

        return back();
    }

    public function storeComment(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => ['required', 'string', 'max:280'],
        ]);

        $authUser = Auth::user();

        $comment = Comment::create([
            'user_id' => $authUser->id,
            'post_id' => $post->id,
            'content' => $validated['content'],
        ]);

        $post->load('user');
        $post->user->notify('comment', $authUser, $post);

        return back();
    }

    public function destroyComment(Post $post, Comment $comment)
    {
        abort_if(Auth::id() !== $comment->user_id, 403);
        $comment->delete();

        return back();
    }
}
