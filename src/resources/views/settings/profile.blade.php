@extends('layouts.app')
@section('title', 'プロフィール編集 - Y')
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
        <h2 class="text-lg font-bold mb-6">プロフィール編集</h2>

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

        <form method="POST" action="{{ route('settings.profile.update') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PATCH')

            {{-- ヘッダー画像 --}}
            <div>
                <label class="block text-sm font-medium text-x-muted mb-2">ヘッダー画像</label>
                <label class="relative block h-32 rounded-2xl overflow-hidden bg-gradient-to-r from-x-blue/60 via-purple-600/50 to-x-blue/30 border border-x-border group cursor-pointer">
                    @if($user->header_image)
                    <img src="{{ Storage::url($user->header_image) }}" alt="" class="w-full h-full object-cover">
                    @endif
                    <div class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity">
                        <div class="text-white text-center">
                            <svg class="w-7 h-7 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="text-sm font-medium">変更</span>
                        </div>
                    </div>
                    <input type="file" name="header_image" accept="image/jpeg,image/png,image/gif,image/webp" class="hidden">
                </label>
            </div>

            {{-- アイコン --}}
            <div>
                <label class="block text-sm font-medium text-x-muted mb-2">プロフィール画像</label>
                <div class="flex items-center gap-4">
                    <label class="relative w-20 h-20 rounded-full cursor-pointer group">
                        <div class="w-20 h-20 rounded-full bg-gradient-to-br from-x-blue to-purple-500 flex items-center justify-center text-2xl font-bold overflow-hidden">
                            @if($user->avatar)
                                <img src="{{ Storage::url($user->avatar) }}" alt="" class="w-full h-full object-cover">
                            @else
                                {{ mb_substr($user->name, 0, 1) }}
                            @endif
                        </div>
                        <div class="absolute inset-0 rounded-full flex items-center justify-center bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <input type="file" name="avatar" accept="image/jpeg,image/png,image/gif,image/webp" class="hidden">
                    </label>
                    <p class="text-x-muted text-xs leading-relaxed">JPG, PNG, GIF, WebP<br>最大 2MB</p>
                </div>
            </div>

            {{-- 名前 --}}
            <div class="space-y-1">
                <label class="text-sm font-medium text-x-muted">表示名</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="input" required maxlength="50">
            </div>

            {{-- ユーザー名 --}}
            <div class="space-y-1">
                <label class="text-sm font-medium text-x-muted">ユーザー名</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-x-muted">@</span>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}" class="input pl-8" required maxlength="20" pattern="[a-zA-Z0-9_]+">
                </div>
                <p class="text-x-muted text-xs">英数字とアンダースコアのみ</p>
            </div>

            {{-- Bio --}}
            <div class="space-y-1">
                <label class="text-sm font-medium text-x-muted">自己紹介</label>
                <textarea name="bio" maxlength="160" rows="3" class="input resize-none" placeholder="自己紹介（160文字以内）">{{ old('bio', $user->bio) }}</textarea>
            </div>

            <button type="submit" class="btn-primary px-6 py-2.5">保存する</button>
        </form>
    </div>
</div>

@endsection
