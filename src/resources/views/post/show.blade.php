@extends('layouts.app')
@section('title', '投稿 - X Mock')
@section('content')

<div class="border-b border-x-border px-4 py-3 sticky top-0 bg-x-bg/80 backdrop-blur-sm z-10 flex items-center gap-4">
    <a href="{{ url()->previous() }}" class="p-2 rounded-full hover:bg-white/10 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <h1 class="text-xl font-bold">投稿</h1>
</div>

@include('components.post-card', ['post' => $post])

@endsection
