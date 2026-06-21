<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Y')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-x-bg text-x-text min-h-screen">
    <div class="min-h-screen flex">
        {{-- 左側：ロゴエリア --}}
        <div class="hidden lg:flex flex-1 items-center justify-center bg-x-blue relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-x-blue via-blue-600 to-purple-700 opacity-90"></div>
            <div class="relative z-10 text-white text-center px-12">
                <div class="text-[160px] font-black leading-none mb-6 drop-shadow-2xl select-none">Y</div>
                <p class="text-2xl font-bold opacity-90">今すぐ起きていることを</p>
                <p class="text-2xl font-bold opacity-90">見てみよう。</p>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-black/20 to-transparent"></div>
        </div>

        {{-- 右側：フォームエリア --}}
        <div class="flex-1 flex items-center justify-center px-6 py-12">
            <div class="w-full max-w-md">
                <div class="lg:hidden text-5xl font-black text-x-blue mb-10 text-center">Y</div>
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
