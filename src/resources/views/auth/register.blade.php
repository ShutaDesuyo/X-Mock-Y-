@extends('layouts.guest')
@section('title', '新規登録 - Y')
@section('content')

<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold tracking-tight mb-1">アカウントを作成</h1>
        <p class="text-x-muted text-sm">今すぐ参加して、最新情報をチェック</p>
    </div>

    @if($errors->any())
    <div class="bg-x-red/10 border border-x-red/30 text-x-red rounded-xl px-4 py-3 text-sm space-y-1">
        @foreach($errors->all() as $error)
        <p class="flex items-center gap-2">
            <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
            {{ $error }}
        </p>
        @endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf
        <div class="space-y-1">
            <label class="text-sm font-medium text-x-muted">表示名</label>
            <input type="text" name="name" value="{{ old('name') }}"
                placeholder="例：山田 太郎" class="input" required maxlength="50" autocomplete="name">
        </div>
        <div class="space-y-1">
            <label class="text-sm font-medium text-x-muted">ユーザー名</label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-x-muted font-medium">@</span>
                <input type="text" name="username" value="{{ old('username') }}"
                    placeholder="username" class="input pl-8" required maxlength="20" autocomplete="username">
            </div>
        </div>
        <div class="space-y-1">
            <label class="text-sm font-medium text-x-muted">メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}"
                placeholder="you@example.com" class="input" required autocomplete="email">
        </div>
        <div class="space-y-1">
            <label class="text-sm font-medium text-x-muted">パスワード</label>
            <input type="password" name="password"
                placeholder="8文字以上" class="input" required autocomplete="new-password">
        </div>
        <div class="space-y-1">
            <label class="text-sm font-medium text-x-muted">パスワード（確認）</label>
            <input type="password" name="password_confirmation"
                placeholder="もう一度入力" class="input" required autocomplete="new-password">
        </div>
        <button type="submit" class="btn-primary w-full py-3 text-[15px] mt-2">アカウントを作成</button>
    </form>

    <div class="relative flex items-center gap-4">
        <div class="flex-1 border-t border-x-border"></div>
        <span class="text-x-muted text-sm">または</span>
        <div class="flex-1 border-t border-x-border"></div>
    </div>

    <p class="text-center text-x-muted text-sm">
        すでにアカウントをお持ちですか？
        <a href="{{ route('login') }}" class="text-x-blue hover:underline font-medium ml-1">ログイン</a>
    </p>
</div>

@endsection
