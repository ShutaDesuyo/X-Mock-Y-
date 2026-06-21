<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimelineController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $followingIds = $user->following()->pluck('users.id');
        $followingIds->push($user->id);

        $posts = Post::whereIn('user_id', $followingIds)
            ->with(['user', 'likes', 'comments.user'])
            ->latest()
            ->paginate(20);

        $posts->getCollection()->transform(function ($post) use ($user) {
            $post->liked = $post->likes->contains('user_id', $user->id);
            $post->likes_count = $post->likes->count();
            $post->comments_count = $post->comments->count();
            return $post;
        });

        return view('timeline', compact('posts'));
    }
}
