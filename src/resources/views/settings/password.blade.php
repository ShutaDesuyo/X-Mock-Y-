@extends('layouts.app')
@section('title', 'パスワード変更 - Y')
@section('content')

<div class="border-b border-x-border px-4 py-3 sticky top-0 bg-x-bg/80 backdrop-blur-md z-10">
    <h1 class="text-[20px] font-bold">設定</h1>
</div>

<div class="flex min-h-[calc(100vh-56px)]">
    {{-- 設定サイドナビ --}}
    <div class="w-[180px] shrink-0 border-r border-x-border py-2">
        <a href="{{ route('settings.profile') }}"
            class="flex items-center gap-3 px-4 py-3 text-sm transition-colors {{ request()->routeIs('settings.profile') ? 'font-bold text-x-text' : 'text-x-muted hover:bg-white/5 hover:text-x-text' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
            プロフィール
        </a>
        <a href="{{ route('settings.password') }}"
            class="flex items-center gap-3 px-4 py-3 text-sm transition-colors {{ request()->routeIs('settings.password') ? 'font-bold text-x-text' : 'text-x-muted hover:bg-white/5 hover:text-x-text' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
            パスワード
        </a>
    </div>

    {{-- コンテンツ --}}
    <div class="flex-1 p-6 max-w-lg">
        <h2 class="text-lg font-bold mb-6">パスワード変更</h2>

        @if(session('success'))
        <div class="bg-x-green/10 border border-x-green/30 text-x-green rounded-xl px-4 py-3 text-sm mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="bg-x-red/10 border border-x-red/30 text-x-red rounded-xl px-4 py-3 text-sm mb-4 space-y-1">
            @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('settings.password.update') }}" class="space-y-4 max-w-md">
            @csrf @method('PATCH')

            <div class="space-y-1">
                <label class="text-sm font-medium text-x-muted">現在のパスワード</label>
                <input type="password" name="current_password" class="input" required autocomplete="current-password">
            </div>

            <div class="space-y-1">
                <label class="text-sm font-medium text-x-muted">新しいパスワード</label>
                <input type="password" name="password" class="input" required autocomplete="new-password">
                <p class="text-x-muted text-xs">8文字以上、大文字・小文字・数字を含む</p>
            </div>

            <div class="space-y-1">
                <label class="text-sm font-medium text-x-muted">新しいパスワード（確認）</label>
                <input type="password" name="password_confirmation" class="input" required autocomplete="new-password">
            </div>

            <button type="submit" class="btn-primary px-6 py-2.5">変更する</button>
        </form>
    </div>
</div>

@endsection
