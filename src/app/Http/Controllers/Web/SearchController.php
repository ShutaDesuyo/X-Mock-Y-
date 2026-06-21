<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->string('q')->toString();
        $tab   = $request->input('tab', 'posts');
        $posts = collect();
        $users = collect();

        if ($query !== '') {
            if ($tab === 'users') {
                $users = User::where('name', 'like', "%{$query}%")
                    ->orWhere('username', 'like', "%{$query}%")
                    ->withCount(['followers', 'following'])
                    ->paginate(20)
                    ->withQueryString();
            } else {
                $authUser = Auth::user();
                $posts = Post::where('content', 'like', "%{$query}%")
                    ->with(['user', 'likes', 'comments.user'])
                    ->latest()
                    ->paginate(20)
                    ->withQueryString();

                $posts->getCollection()->transform(function ($post) use ($authUser) {
                    $post->liked          = $post->likes->contains('user_id', $authUser->id);
                    $post->likes_count    = $post->likes->count();
                    $post->comments_count = $post->comments->count();
                    return $post;
                });
            }
        }

        return view('search.index', compact('query', 'tab', 'posts', 'users'));
    }
}
