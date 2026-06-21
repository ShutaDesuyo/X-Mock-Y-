@extends('layouts.app')
@section('title', '通知 - Y')
@section('content')

<div class="border-b border-x-border px-4 py-3 sticky top-0 bg-x-bg/80 backdrop-blur-md z-10">
    <h1 class="text-[20px] font-bold">通知</h1>
</div>

@if($notifications->isEmpty())
<div class="text-center py-20 px-8">
    <div class="w-16 h-16 rounded-full bg-x-blue/10 flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-x-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
    </div>
    <p class="text-xl font-bold mb-2">通知はありません</p>
    <p class="text-x-muted text-sm">いいねやフォローがあると、ここに表示されます</p>
</div>
@endif

@foreach($notifications as $notification)
@php
    $actor = $notification->actor;
    $target = $notification->target;
@endphp
<div class="flex gap-3 px-4 py-4 border-b border-x-border hover:bg-white/[0.02] transition-colors {{ $notification->isRead() ? '' : 'bg-x-blue/[0.05]' }}">
    {{-- アイコン --}}
    <div class="shrink-0 mt-1">
        @if($notification->type === 'like')
        <div class="w-9 h-9 rounded-full bg-x-red/10 flex items-center justify-center">
            <svg class="w-5 h-5 text-x-red" fill="currentColor" viewBox="0 0 24 24"><path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
        </div>
        @elseif($notification->type === 'follow')
        <div class="w-9 h-9 rounded-full bg-x-blue/10 flex items-center justify-center">
            <svg class="w-5 h-5 text-x-blue" fill="currentColor" viewBox="0 0 24 24"><path d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
        </div>
        @elseif($notification->type === 'comment')
        <div class="w-9 h-9 rounded-full bg-x-green/10 flex items-center justify-center">
            <svg class="w-5 h-5 text-x-green" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
        </div>
        @endif
    </div>

    {{-- 内容 --}}
    <div class="flex-1 min-w-0">
        <a href="{{ route('profile.show', $actor->username) }}" class="inline-flex items-center gap-2 mb-1 group">
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-x-blue to-purple-500 flex items-center justify-center text-xs font-bold shrink-0 overflow-hidden">
                @if($actor->avatar)
                    <img src="{{ Storage::url($actor->avatar) }}" alt="" class="w-full h-full object-cover">
                @else
                    {{ mb_substr($actor->name, 0, 1) }}
                @endif
            </div>
            <span class="font-bold text-sm group-hover:underline">{{ $actor->name }}</span>
        </a>

        <p class="text-sm text-x-muted">
            @if($notification->type === 'like')
                あなたの投稿をいいねしました
            @elseif($notification->type === 'follow')
                あなたをフォローしました
            @elseif($notification->type === 'comment')
                あなたの投稿にコメントしました
            @endif
            <span class="ml-1">· {{ $notification->created_at->diffForHumans() }}</span>
        </p>

        @if($target && $notification->type !== 'follow')
        <a href="{{ route('posts.show', $target) }}" class="mt-2 block text-sm text-x-muted border border-x-border rounded-xl px-3 py-2 hover:bg-white/5 transition-colors truncate">
            {{ $target->content }}
        </a>
        @endif
    </div>
</div>
@endforeach

@if($notifications->hasPages())
<div class="px-4 py-4 flex justify-center">{{ $notifications->links() }}</div>
@endif

@endsection
