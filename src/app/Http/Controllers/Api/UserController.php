<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(Request $request, string $username): JsonResponse
    {
        $user = User::where('username', $username)
            ->withCount(['posts', 'followers', 'following'])
            ->firstOrFail();

        $user->is_following = $request->user()
            ? $request->user()->isFollowing($user)
            : false;

        return response()->json($user);
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->input('q', '');

        $users = User::where('username', 'like', "%{$query}%")
            ->orWhere('name', 'like', "%{$query}%")
            ->select('id', 'name', 'username', 'avatar', 'bio')
            ->withCount(['followers', 'following'])
            ->limit(20)
            ->get();

        return response()->json($users);
    }
}
