@extends('layouts.app')
@section('title', $query ? "「{$query}」の検索結果 - Y" : '検索 - Y')
@section('content')

<div class="border-b border-x-border px-4 py-3 sticky top-0 bg-x-bg/80 backdrop-blur-md z-10">
    <form method="GET" action="{{ route('search') }}" class="flex gap-2">
        <div class="flex-1 relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-x-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="q" value="{{ $query }}" placeholder="検索"
                class="input pl-10 py-2.5 rounded-full bg-white/5 border-x-border/50 focus:bg-x-surface"
                autofocus>
            <input type="hidden" name="tab" value="{{ $tab }}">
        </div>
    </form>
</div>

@if($query)
{{-- タブ --}}
<div class="flex border-b border-x-border">
    <a href="{{ route('search', ['q' => $query, 'tab' => 'posts']) }}"
        class="flex-1 text-center py-4 text-sm font-medium relative transition-colors {{ $tab === 'posts' ? 'text-x-text' : 'text-x-muted hover:text-x-text hover:bg-white/[0.03]' }}">
        投稿
        @if($tab === 'posts')<span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-12 h-1 bg-x-blue rounded-full"></span>@endif
    </a>
    <a href="{{ route('search', ['q' => $query, 'tab' => 'users']) }}"
        class="flex-1 text-center py-4 text-sm font-medium relative transition-colors {{ $tab === 'users' ? 'text-x-text' : 'text-x-muted hover:text-x-text hover:bg-white/[0.03]' }}">
        ユーザー
        @if($tab === 'users')<span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-12 h-1 bg-x-blue rounded-full"></span>@endif
    </a>
</div>

@if($tab === 'posts')
    @forelse($posts as $post)
        @include('components.post-card', ['post' => $post])
    @empty
        <div class="text-center text-x-muted py-16">
            <p class="font-bold text-x-text mb-1">「{{ $query }}」に一致する投稿はありません</p>
        </div>
    @endforelse
    @if($posts->hasPages())
    <div class="px-4 py-4 flex justify-center">{{ $posts->links() }}</div>
    @endif
@else
    @forelse($users as $user)
    <div class="flex items-center justify-between px-4 py-3 border-b border-x-border hover:bg-white/[0.02] transition-colors">
        <a href="{{ route('profile.show', $user->username) }}" class="flex items-center gap-3 flex-1 min-w-0">
            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-x-blue to-purple-500 flex items-center justify-center font-bold shrink-0 overflow-hidden">
                @if($user->avatar)
                    <img src="{{ Storage::url($user->avatar) }}" alt="" class="w-full h-full object-cover">
                @else
                    {{ mb_substr($user->name, 0, 1) }}
                @endif
            </div>
            <div class="min-w-0">
                <div class="font-bold hover:underline truncate">{{ $user->name }}</div>
                <div class="text-x-muted text-sm truncate">{{ '@' . $user->username }}</div>
                @if($user->bio)
                <div class="text-sm text-x-muted mt-0.5 truncate">{{ $user->bio }}</div>
                @endif
                <div class="text-xs text-x-muted mt-0.5">
                    {{ number_format($user->followers_count) }} フォロワー
                </div>
            </div>
        </a>
        @if(auth()->user()->username !== $user->username)
        <form method="POST" action="{{ route('profile.follow', $user->username) }}" class="ml-3 shrink-0">
            @csrf
            <button class="{{ auth()->user()->isFollowing($user) ? 'btn-outline' : 'btn-white' }} text-sm px-4 py-1.5">
                {{ auth()->user()->isFollowing($user) ? 'フォロー中' : 'フォロー' }}
            </button>
        </form>
        @endif
    </div>
    @empty
        <div class="text-center text-x-muted py-16">
            <p class="font-bold text-x-text mb-1">「{{ $query }}」に一致するユーザーはいません</p>
        </div>
    @endforelse
    @if($users->hasPages())
    <div class="px-4 py-4 flex justify-center">{{ $users->links() }}</div>
    @endif
@endif

@else
<div class="text-center py-20 px-8">
    <div class="w-16 h-16 rounded-full bg-x-blue/10 flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-x-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
    </div>
    <p class="text-xl font-bold mb-2">検索してみよう</p>
    <p class="text-x-muted text-sm">投稿やユーザーを検索できます</p>
</div>
@endif

@endsection
