@extends('layouts.app')
@section('title', 'ホーム - Y')
@section('content')

<div class="border-b border-x-border px-4 py-3 sticky top-0 bg-x-bg/80 backdrop-blur-md z-10">
    <h1 class="text-[20px] font-bold">ホーム</h1>
</div>

{{-- クイック投稿エリア --}}
<div class="border-b border-x-border px-4 py-3 hidden sm:block">
    <div class="flex gap-3">
        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-x-blue to-purple-500 flex items-center justify-center font-bold text-sm shrink-0">
            {{ mb_substr(auth()->user()->name, 0, 1) }}
        </div>
        <button onclick="document.getElementById('post-modal').classList.remove('hidden')"
            class="flex-1 text-left text-x-muted/70 text-xl py-2 hover:text-x-muted transition-colors">
            いまどうしてる？
        </button>
    </div>
</div>

@if($posts->isEmpty())
<div class="text-center py-20 px-8">
    <div class="w-16 h-16 rounded-full bg-x-blue/10 flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-x-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
    </div>
    <p class="text-xl font-bold mb-2">ようこそ！</p>
    <p class="text-x-muted text-sm">フォローするか、最初の投稿をしてみましょう</p>
    <button onclick="document.getElementById('post-modal').classList.remove('hidden')"
        class="btn-primary mt-4 px-6">投稿する</button>
</div>
@endif

@foreach($posts as $post)
    @include('components.post-card', ['post' => $post])
@endforeach

@if($posts->hasPages())
<div class="px-4 py-4 flex justify-center">
    {{ $posts->links() }}
</div>
@endif

@endsection
