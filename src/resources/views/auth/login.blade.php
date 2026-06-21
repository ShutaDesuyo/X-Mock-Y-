@extends('layouts.guest')
@section('title', 'ログイン - Y')
@section('content')

<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold tracking-tight mb-1">おかえりなさい</h1>
        <p class="text-x-muted text-sm">アカウントにサインイン</p>
    </div>

    @if($errors->any())
    <div class="bg-x-red/10 border border-x-red/30 text-x-red rounded-xl px-4 py-3 text-sm flex items-center gap-2">
        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
        {{ $errors->first() }}
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <div class="space-y-1">
            <label class="text-sm font-medium text-x-muted">メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}"
                placeholder="you@example.com" class="input" required autocomplete="email">
        </div>
        <div class="space-y-1">
            <label class="text-sm font-medium text-x-muted">パスワード</label>
            <input type="password" name="password"
                placeholder="パスワード" class="input" required autocomplete="current-password">
        </div>
        <div class="flex items-center gap-2 pt-1">
            <input type="checkbox" name="remember" id="remember"
                class="w-4 h-4 rounded border-x-border bg-transparent accent-x-blue cursor-pointer">
            <label for="remember" class="text-sm text-x-muted cursor-pointer select-none">ログイン状態を保持する</label>
        </div>
        <button type="submit" class="btn-primary w-full py-3 text-[15px]">ログイン</button>
    </form>

    <div class="relative flex items-center gap-4">
        <div class="flex-1 border-t border-x-border"></div>
        <span class="text-x-muted text-sm">または</span>
        <div class="flex-1 border-t border-x-border"></div>
    </div>

    <p class="text-center text-x-muted text-sm">
        アカウントをお持ちでない方は
        <a href="{{ route('register') }}" class="text-x-blue hover:underline font-medium ml-1">新規登録</a>
    </p>
</div>

@endsection
