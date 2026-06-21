@extends('layouts.app')
@section('title', $user->name . 'のいいね - X Mock')
@section('content')

<div class="border-b border-x-border px-4 py-3 sticky top-0 bg-x-bg/80 backdrop-blur-sm z-10 flex items-center gap-4">
    <a href="{{ url()->previous() }}" class="p-2 rounded-full hover:bg-white/10 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <div>
        <h1 class="text-xl font-bold leading-tight">{{ $user->name }}</h1>
        <p class="text-x-muted text-sm">{{ '@' . $user->username }}</p>
    </div>
</div>

@include('components.profile-header', ['user' => $user, 'isFollowing' => $isFollowing])

@foreach($posts as $post)
    @include('components.post-card', ['post' => $post])
@endforeach

@if($posts->isEmpty())
<div class="text-center text-x-muted py-16">
    <p>いいねした投稿はありません</p>
</div>
@endif

<div class="px-4 py-4">{{ $posts->links() }}</div>

@endsection
