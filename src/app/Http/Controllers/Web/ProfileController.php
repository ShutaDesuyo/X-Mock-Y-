<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(string $username)
    {
        $user = User::where('username', $username)
            ->withCount(['posts', 'followers', 'following'])
            ->firstOrFail();

        $authUser = Auth::user();

        $posts = Post::where('user_id', $user->id)
            ->with(['user', 'likes', 'comments'])
            ->latest()
            ->paginate(20);

        $posts->getCollection()->transform(function ($post) use ($authUser) {
            $post->liked          = $post->likes->contains('user_id', $authUser->id);
            $post->likes_count    = $post->likes->count();
            $post->comments_count = $post->comments->count();
            return $post;
        });

        $isFollowing = $authUser->isFollowing($user);

        return view('profile.show', compact('user', 'posts', 'isFollowing'));
    }

    public function likes(string $username)
    {
        $user = User::where('username', $username)
            ->withCount(['posts', 'followers', 'following'])
            ->firstOrFail();

        $authUser = Auth::user();

        $posts = Post::whereHas('likes', fn($q) => $q->where('user_id', $user->id))
            ->with(['user', 'likes', 'comments'])
            ->latest()
            ->paginate(20);

        $posts->getCollection()->transform(function ($post) use ($authUser) {
            $post->liked          = $post->likes->contains('user_id', $authUser->id);
            $post->likes_count    = $post->likes->count();
            $post->comments_count = $post->comments->count();
            return $post;
        });

        $isFollowing = $authUser->isFollowing($user);

        return view('profile.likes', compact('user', 'posts', 'isFollowing'));
    }

    public function follow(string $username)
    {
        $target   = User::where('username', $username)->firstOrFail();
        $authUser = Auth::user();

        if ($authUser->id === $target->id) {
            return back();
        }

        if ($authUser->isFollowing($target)) {
            $authUser->following()->detach($target->id);
        } else {
            $authUser->following()->attach($target->id);
            $target->notify('follow', $authUser);
        }

        return back();
    }

    public function followers(string $username)
    {
        $user = User::where('username', $username)
            ->withCount(['posts', 'followers', 'following'])
            ->firstOrFail();

        $followers = $user->followers()->paginate(20);

        return view('profile.followers', compact('user', 'followers'));
    }

    public function following(string $username)
    {
        $user = User::where('username', $username)
            ->withCount(['posts', 'followers', 'following'])
            ->firstOrFail();

        $following = $user->following()->paginate(20);

        return view('profile.following', compact('user', 'following'));
    }
}
