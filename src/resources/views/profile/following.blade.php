@extends('layouts.app')
@section('title', $user->name . 'のフォロー中 - Y')
@section('content')

<div class="border-b border-x-border px-4 py-3 sticky top-0 bg-x-bg/80 backdrop-blur-md z-10 flex items-center gap-4">
    <a href="{{ route('profile.show', $user->username) }}" class="p-2 rounded-full hover:bg-white/10 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <div>
        <h1 class="text-[17px] font-bold leading-tight">{{ $user->name }}</h1>
        <p class="text-x-muted text-sm">{{ '@' . $user->username }}</p>
    </div>
</div>

<div class="flex border-b border-x-border">
    <a href="{{ route('profile.followers', $user->username) }}"
        class="flex-1 text-center py-4 text-sm font-medium text-x-muted hover:text-x-text hover:bg-white/[0.03] transition-colors">
        フォロワー
    </a>
    <a href="{{ route('profile.following', $user->username) }}"
        class="flex-1 text-center py-4 text-sm font-medium relative text-x-text">
        フォロー中
        <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-16 h-1 bg-x-blue rounded-full"></span>
    </a>
</div>

@foreach($following as $followedUser)
<div class="flex items-center justify-between px-4 py-3 border-b border-x-border hover:bg-white/[0.02] transition-colors">
    <a href="{{ route('profile.show', $followedUser->username) }}" class="flex items-center gap-3 flex-1 min-w-0">
        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-x-blue to-purple-500 flex items-center justify-center font-bold shrink-0">
            {{ mb_substr($followedUser->name, 0, 1) }}
        </div>
        <div class="min-w-0">
            <div class="font-bold text-sm hover:underline truncate">{{ $followedUser->name }}</div>
            <div class="text-x-muted text-sm truncate">{{ '@' . $followedUser->username }}</div>
        </div>
    </a>
    @if(auth()->user()->username !== $followedUser->username)
    <form method="POST" action="{{ route('profile.follow', $followedUser->username) }}" class="ml-3 shrink-0">
        @csrf
        <button class="{{ auth()->user()->isFollowing($followedUser) ? 'btn-outline' : 'btn-white' }} text-sm px-4 py-1.5">
            {{ auth()->user()->isFollowing($followedUser) ? 'フォロー中' : 'フォロー' }}
        </button>
    </form>
    @endif
</div>
@endforeach

@if($following->isEmpty())
<div class="text-center text-x-muted py-20">
    <p class="text-lg font-bold text-x-text mb-1">フォロー中のユーザーはいません</p>
    <p class="text-sm">気になるユーザーをフォローしてみましょう</p>
</div>
@endif

@if($following->hasPages())
<div class="px-4 py-4 flex justify-center">{{ $following->links() }}</div>
@endif

@endsection
