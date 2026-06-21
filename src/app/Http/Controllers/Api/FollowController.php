<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function toggle(Request $request, string $username): JsonResponse
    {
        $target = User::where('username', $username)->firstOrFail();

        if ($request->user()->id === $target->id) {
            return response()->json(['message' => '自分自身をフォローできません。'], 422);
        }

        if ($request->user()->isFollowing($target)) {
            $request->user()->following()->detach($target->id);
            $following = false;
            $message = 'フォローを解除しました。';
        } else {
            $request->user()->following()->attach($target->id);
            $following = true;
            $message = 'フォローしました。';
        }

        return response()->json([
            'following' => $following,
            'followers_count' => $target->followers()->count(),
            'message' => $message,
        ]);
    }

    public function followers(string $username): JsonResponse
    {
        $user = User::where('username', $username)->firstOrFail();

        $followers = $user->followers()
            ->select('users.id', 'users.name', 'users.username', 'users.avatar', 'users.bio')
            ->paginate(20);

        return response()->json($followers);
    }

    public function following(string $username): JsonResponse
    {
        $user = User::where('username', $username)->firstOrFail();

        $following = $user->following()
            ->select('users.id', 'users.name', 'users.username', 'users.avatar', 'users.bio')
            ->paginate(20);

        return response()->json($following);
    }
}
