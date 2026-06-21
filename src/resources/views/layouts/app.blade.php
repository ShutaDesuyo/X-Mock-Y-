<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Y')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak]{display:none!important}</style>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.9/dist/cdn.min.js" defer></script>
</head>
<body class="bg-x-bg text-x-text min-h-screen">

{{-- ===== ページ全体ラッパー ===== --}}
<div class="min-h-screen flex justify-center">

    {{-- ===== サイドバー（sm以上で表示） ===== --}}
    <aside class="hidden sm:flex flex-col fixed top-0 left-0 h-screen z-30
                  w-[68px] lg:w-[88px] xl:w-[275px]
                  xl:left-[calc(50%-632px)]
                  items-center xl:items-start
                  px-2 xl:px-4 py-2
                  border-r border-x-border bg-x-bg">

        {{-- Yロゴ --}}
        <a href="{{ route('timeline') }}"
            class="w-[52px] h-[52px] flex items-center justify-center rounded-full hover:bg-white/5 transition-colors mb-1">
            <span class="text-[28px] font-black text-x-blue leading-none select-none">Y</span>
        </a>

        {{-- ナビリンク --}}
        <div class="flex flex-col items-center xl:items-start gap-0.5 flex-1 w-full mt-1">

            <a href="{{ route('timeline') }}"
                class="nav-link w-full justify-center xl:justify-start {{ request()->routeIs('timeline') ? 'font-bold' : '' }}">
                @if(request()->routeIs('timeline'))
                    <svg class="w-[27px] h-[27px] shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 1.696L.622 8.807l1.06 1.696L3 9.679V19.5C3 20.881 4.119 22 5.5 22h4a1 1 0 001-1v-6h3v6a1 1 0 001 1h4c1.381 0 2.5-1.119 2.5-2.5V9.679l1.318.824 1.06-1.696L12 1.696z"/></svg>
                @else
                    <svg class="w-[27px] h-[27px] shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                @endif
                <span class="hidden xl:inline text-[19px]">ホーム</span>
            </a>

            <a href="{{ route('search') }}"
                class="nav-link w-full justify-center xl:justify-start {{ request()->routeIs('search') ? 'font-bold' : '' }}">
                @if(request()->routeIs('search'))
                    <svg class="w-[27px] h-[27px] shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M10.5 3.75a6.75 6.75 0 100 13.5 6.75 6.75 0 000-13.5zM2.25 10.5a8.25 8.25 0 1114.59 5.28l4.69 4.69a.75.75 0 11-1.06 1.06l-4.69-4.69A8.25 8.25 0 012.25 10.5z"/></svg>
                @else
                    <svg class="w-[27px] h-[27px] shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803 7.5 7.5 0 0016.803 15.803z"/></svg>
                @endif
                <span class="hidden xl:inline text-[19px]">検索</span>
            </a>

            <a href="{{ route('notifications.index') }}"
                class="nav-link w-full justify-center xl:justify-start relative {{ request()->routeIs('notifications.*') ? 'font-bold' : '' }}">
                <span class="relative">
                    @if(request()->routeIs('notifications.*'))
                        <svg class="w-[27px] h-[27px] shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M5.85 3.5a.75.75 0 00-1.117-1 9.719 9.719 0 00-2.348 4.876.75.75 0 001.479.248A8.219 8.219 0 015.85 3.5zM19.267 2.5a.75.75 0 10-1.118 1 8.22 8.22 0 011.987 4.124.75.75 0 001.48-.248A9.72 9.72 0 0019.266 2.5zM12 2.25A6.75 6.75 0 005.25 9v.75c0 2.123-.8 4.057-2.107 5.517A1.5 1.5 0 004.277 17.25h15.448a1.5 1.5 0 001.134-2.483A9.987 9.987 0 0118.75 9.75V9A6.75 6.75 0 0012 2.25zM12 21a2.25 2.25 0 01-2.248-2.25H14.25A2.25 2.25 0 0112 21z"/></svg>
                    @else
                        <svg class="w-[27px] h-[27px] shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                    @endif
                    @php $unread = auth()->user()->unreadNotificationsCount(); @endphp
                    @if($unread > 0)
                    <span class="absolute -top-1 -right-1 w-[18px] h-[18px] bg-x-blue text-white text-[10px] font-bold rounded-full flex items-center justify-center leading-none">
                        {{ $unread > 9 ? '9+' : $unread }}
                    </span>
                    @endif
                </span>
                <span class="hidden xl:inline text-[19px]">通知</span>
            </a>

            <a href="{{ route('profile.show', auth()->user()->username) }}"
                class="nav-link w-full justify-center xl:justify-start {{ request()->routeIs('profile.*') && request()->route('username') === auth()->user()->username ? 'font-bold' : '' }}">
                @php $isOwnProfile = request()->routeIs('profile.*') && request()->route('username') === auth()->user()->username; @endphp
                <svg class="w-[27px] h-[27px] shrink-0" fill="{{ $isOwnProfile ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                <span class="hidden xl:inline text-[19px]">プロフィール</span>
            </a>

            <a href="{{ route('settings.profile') }}"
                class="nav-link w-full justify-center xl:justify-start {{ request()->routeIs('settings.*') ? 'font-bold' : '' }}">
                <svg class="w-[27px] h-[27px] shrink-0" fill="{{ request()->routeIs('settings.*') ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span class="hidden xl:inline text-[19px]">設定</span>
            </a>
        </div>

        {{-- 投稿ボタン --}}
        <div class="w-full mb-3 flex justify-center xl:block">
            <button onclick="openModal('post-modal')"
                class="w-[34px] h-[34px] p-0 rounded-full xl:rounded-2xl xl:w-full xl:h-auto xl:py-3.5 xl:px-6 btn-primary flex items-center justify-center xl:block text-[17px] font-bold">
                <svg class="w-5 h-5 xl:hidden" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                <span class="hidden xl:inline">投稿する</span>
            </button>
        </div>

        {{-- ユーザーメニュー --}}
        <div x-data="{ open: false }" class="relative w-full mb-2">
            <button @click="open = !open"
                class="flex items-center gap-3 w-full justify-center xl:justify-start xl:px-3 py-2 rounded-full hover:bg-white/5 transition-colors">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-x-blue to-purple-500 flex items-center justify-center font-bold text-sm shrink-0 overflow-hidden">
                    @if(auth()->user()->avatar)
                        <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="" class="w-full h-full object-cover">
                    @else
                        {{ mb_substr(auth()->user()->name, 0, 1) }}
                    @endif
                </div>
                <div class="hidden xl:flex flex-col items-start flex-1 min-w-0">
                    <span class="font-bold text-sm truncate w-full">{{ auth()->user()->name }}</span>
                    <span class="text-x-muted text-sm truncate w-full">{{ '@' . auth()->user()->username }}</span>
                </div>
                <svg class="hidden xl:block w-4 h-4 text-x-muted shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"/></svg>
            </button>
            <div x-show="open" x-cloak @click.away="open = false"
                class="absolute bottom-full left-0 mb-2 w-72 bg-x-surface border border-x-border rounded-2xl shadow-2xl overflow-hidden z-50">
                <div class="px-4 py-3 border-b border-x-border">
                    <p class="font-bold text-sm">{{ auth()->user()->name }}</p>
                    <p class="text-x-muted text-sm">{{ '@' . auth()->user()->username }}</p>
                </div>
                <a href="{{ route('settings.profile') }}" @click="open = false"
                    class="flex items-center gap-3 px-4 py-3 text-sm hover:bg-white/5 transition-colors">
                    <svg class="w-4 h-4 text-x-muted" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    プロフィール編集
                </a>
                <a href="{{ route('settings.password') }}" @click="open = false"
                    class="flex items-center gap-3 px-4 py-3 text-sm hover:bg-white/5 transition-colors">
                    <svg class="w-4 h-4 text-x-muted" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                    パスワード変更
                </a>
                <div class="border-t border-x-border"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left flex items-center gap-3 px-4 py-3 text-sm text-x-red hover:bg-white/5 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/></svg>
                        {{ '@' . auth()->user()->username }} からログアウト
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- ===== メインコンテンツ ===== --}}
    {{-- サイドバー分だけ左にオフセット --}}
    <div class="flex w-full max-w-[1265px]">
        {{-- サイドバーのスペーサー --}}
        <div class="hidden sm:block w-[68px] lg:w-[88px] xl:w-[275px] shrink-0"></div>

        <main class="flex-1 min-h-screen border-x border-x-border pb-16 sm:pb-0" style="max-width: 600px;">
            @yield('content')
        </main>

        {{-- 右パネル --}}
        <div class="hidden xl:block w-[275px] shrink-0 px-6 py-4">
        </div>
    </div>
</div>

{{-- ===== ボトムナビ（sm未満のみ） ===== --}}
<nav class="sm:hidden fixed bottom-0 inset-x-0 bg-x-bg/95 backdrop-blur-md border-t border-x-border z-40">
    <div class="flex items-center justify-around max-w-lg mx-auto px-6 py-2">

        <a href="{{ route('timeline') }}"
            class="flex flex-col items-center gap-0.5 p-2 rounded-xl {{ request()->routeIs('timeline') ? 'text-x-text' : 'text-x-muted' }}">
            @if(request()->routeIs('timeline'))
                <svg class="w-[26px] h-[26px]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 1.696L.622 8.807l1.06 1.696L3 9.679V19.5C3 20.881 4.119 22 5.5 22h4a1 1 0 001-1v-6h3v6a1 1 0 001 1h4c1.381 0 2.5-1.119 2.5-2.5V9.679l1.318.824 1.06-1.696L12 1.696z"/></svg>
            @else
                <svg class="w-[26px] h-[26px]" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
            @endif
        </a>

        <a href="{{ route('search') }}"
            class="flex flex-col items-center gap-0.5 p-2 rounded-xl {{ request()->routeIs('search') ? 'text-x-text' : 'text-x-muted' }}">
            <svg class="w-[26px] h-[26px]" fill="{{ request()->routeIs('search') ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803 7.5 7.5 0 0016.803 15.803z"/></svg>
        </a>

        <button onclick="openModal('post-modal')"
            class="w-[44px] h-[44px] rounded-full bg-x-blue flex items-center justify-center shadow-lg active:scale-95 transition-transform">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        </button>

        <a href="{{ route('notifications.index') }}"
            class="relative flex flex-col items-center gap-0.5 p-2 rounded-xl {{ request()->routeIs('notifications.*') ? 'text-x-text' : 'text-x-muted' }}">
            <svg class="w-[26px] h-[26px]" fill="{{ request()->routeIs('notifications.*') ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
            @if(auth()->user()->unreadNotificationsCount() > 0)
            <span class="absolute top-1 right-1 w-[18px] h-[18px] bg-x-blue text-white text-[10px] font-bold rounded-full flex items-center justify-center">
                {{ auth()->user()->unreadNotificationsCount() > 9 ? '9+' : auth()->user()->unreadNotificationsCount() }}
            </span>
            @endif
        </a>

        <a href="{{ route('profile.show', auth()->user()->username) }}"
            class="flex flex-col items-center gap-0.5 p-2 rounded-xl {{ request()->routeIs('profile.*') && request()->route('username') === auth()->user()->username ? 'text-x-text' : 'text-x-muted' }}">
            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-x-blue to-purple-500 flex items-center justify-center text-xs font-bold overflow-hidden
                {{ request()->routeIs('profile.*') && request()->route('username') === auth()->user()->username ? 'ring-2 ring-white' : '' }}">
                @if(auth()->user()->avatar)
                    <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="" class="w-full h-full object-cover">
                @else
                    {{ mb_substr(auth()->user()->name, 0, 1) }}
                @endif
            </div>
        </a>
    </div>
</nav>

{{-- ===== 投稿モーダル ===== --}}
<div id="post-modal"
    class="hidden fixed inset-0 z-50 flex items-start justify-center pt-12 sm:pt-16 px-4"
    style="background:rgba(0,0,0,0.6);backdrop-filter:blur(4px);"
    onclick="if(event.target===this)closeModal('post-modal')">
    <div class="bg-x-surface border border-x-border rounded-2xl w-full max-w-[600px] shadow-2xl">
        <div class="flex items-center px-4 pt-4 pb-0">
            <button onclick="closeModal('post-modal')"
                class="p-2 rounded-full hover:bg-white/10 transition-colors text-x-muted">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="flex gap-3 px-4 py-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-x-blue to-purple-500 flex items-center justify-center font-bold shrink-0 mt-1 overflow-hidden">
                    @if(auth()->user()->avatar)
                        <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="" class="w-full h-full object-cover">
                    @else
                        {{ mb_substr(auth()->user()->name, 0, 1) }}
                    @endif
                </div>
                <div class="flex-1 pt-2">
                    <textarea name="content" maxlength="280" rows="4" placeholder="いまどうしてる？"
                        class="w-full bg-transparent text-xl placeholder-x-muted/60 resize-none focus:outline-none leading-relaxed" required></textarea>
                    <div id="modal-image-preview" class="hidden mt-2">
                        <div class="relative inline-block">
                            <img id="modal-preview-img" src="" alt="" class="rounded-2xl max-h-60 object-cover border border-x-border">
                            <button type="button" onclick="clearModalImage()"
                                class="absolute top-2 right-2 w-7 h-7 bg-black/70 rounded-full flex items-center justify-center text-white hover:bg-black/90 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-t border-x-border/50 mx-4"></div>
            <div class="flex justify-between items-center px-4 py-3">
                <label class="cursor-pointer text-x-blue hover:text-x-blue-hover p-2 rounded-full hover:bg-x-blue/10 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <input type="file" name="image" id="modal-image-input" accept="image/jpeg,image/png,image/gif,image/webp" class="hidden" onchange="previewModalImage(this)">
                </label>
                <button type="submit" class="btn-primary px-5 py-2 text-[15px]">投稿</button>
            </div>
        </form>
    </div>
</div>

{{-- ===== 投稿詳細モーダル ===== --}}
<div id="post-detail-modal"
    class="hidden fixed inset-0 z-50 overflow-y-auto"
    style="background:rgba(0,0,0,0.6);backdrop-filter:blur(4px);"
    onclick="if(event.target===this)closeModal('post-detail-modal')">
    <div class="min-h-full flex items-start justify-center sm:py-8 sm:px-4" onclick="if(event.target===this)closeModal('post-detail-modal')">
        <div class="bg-x-surface sm:border border-x-border sm:rounded-2xl w-full max-w-[600px] shadow-2xl">

            {{-- ヘッダー --}}
            <div class="flex items-center px-4 py-3 border-b border-x-border sticky top-0 bg-x-surface z-10 sm:rounded-t-2xl">
                <button onclick="closeModal('post-detail-modal')"
                    class="p-2 -ml-1 rounded-full hover:bg-white/10 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <span class="ml-6 font-bold text-[19px]">投稿</span>
            </div>

            {{-- ローディング --}}
            <div id="post-detail-loading" class="flex items-center justify-center py-20">
                <div class="w-8 h-8 border-2 border-x-blue border-t-transparent rounded-full animate-spin"></div>
            </div>

            {{-- コンテンツ --}}
            <div id="post-detail-content" class="hidden">
                {{-- 投稿本文 --}}
                <div class="px-4 pt-4 pb-0">
                    <div class="flex gap-3 mb-3">
                        <div id="detail-avatar" class="w-10 h-10 rounded-full bg-gradient-to-br from-x-blue to-purple-500 flex items-center justify-center font-bold shrink-0 overflow-hidden text-white"></div>
                        <div>
                            <div id="detail-name" class="font-bold leading-tight"></div>
                            <div id="detail-username" class="text-x-muted text-sm"></div>
                        </div>
                    </div>
                    <p id="detail-body" class="text-[17px] leading-relaxed whitespace-pre-wrap break-words mb-3"></p>
                    <div id="detail-image-wrap" class="hidden mb-3 rounded-2xl overflow-hidden border border-x-border">
                        <img id="detail-image" src="" alt="" class="w-full max-h-96 object-cover">
                    </div>
                    <p id="detail-date" class="text-x-muted text-sm pb-3 border-b border-x-border"></p>
                    <div class="flex gap-5 py-3 border-b border-x-border text-sm">
                        <span><span id="detail-likes-count" class="font-bold text-x-text"></span> <span class="text-x-muted">いいね</span></span>
                        <span><span id="detail-comments-count" class="font-bold text-x-text"></span> <span class="text-x-muted">返信</span></span>
                    </div>
                    <div class="flex items-center py-1 border-b border-x-border" id="detail-actions"></div>
                </div>

                {{-- 返信フォーム --}}
                <div class="px-4 py-3 border-b border-x-border flex gap-3 items-center">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-x-blue to-purple-500 flex items-center justify-center font-bold shrink-0 overflow-hidden">
                        @if(auth()->user()->avatar)
                            <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="" class="w-full h-full object-cover">
                        @else
                            {{ mb_substr(auth()->user()->name, 0, 1) }}
                        @endif
                    </div>
                    <form id="detail-comment-form" method="POST" class="flex-1 flex gap-2 items-center">
                        @csrf
                        <input type="text" name="content" maxlength="280" placeholder="返信する..."
                            class="input py-2 text-sm rounded-full px-4 flex-1" required>
                        <button type="submit" class="btn-primary text-sm px-4 py-2 shrink-0">返信</button>
                    </form>
                </div>

                {{-- コメント一覧 --}}
                <div id="detail-comments" class="divide-y divide-x-border"></div>
            </div>
        </div>
    </div>
</div>

<script>
function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
    document.body.style.overflow = '';
}

function openPostModal(data) {
    const post = typeof data === 'string' ? JSON.parse(data) : data;
    const u = post.user;

    // アバター
    const av = document.getElementById('detail-avatar');
    if (u.avatar) {
        av.innerHTML = `<img src="/storage/${u.avatar}" alt="" style="width:100%;height:100%;object-fit:cover;">`;
    } else {
        av.innerHTML = '';
        av.textContent = u.name.charAt(0);
    }

    document.getElementById('detail-name').textContent = u.name;
    document.getElementById('detail-username').textContent = '@' + u.username;
    document.getElementById('detail-body').textContent = post.content;
    document.getElementById('detail-date').textContent = post.created_at;
    document.getElementById('detail-likes-count').textContent = post.likes_count;
    document.getElementById('detail-comments-count').textContent = post.comments_count;

    // 画像
    const imgWrap = document.getElementById('detail-image-wrap');
    if (post.image) {
        document.getElementById('detail-image').src = `/storage/${post.image}`;
        imgWrap.classList.remove('hidden');
    } else {
        imgWrap.classList.add('hidden');
    }

    // いいね
    document.getElementById('detail-actions').innerHTML = `
        <form method="POST" action="${post.like_url}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" class="flex items-center gap-1.5 ${post.liked ? 'text-x-red' : 'text-x-muted hover:text-x-red'} transition-colors group">
                <span class="p-2 rounded-full ${post.liked ? 'bg-x-red/10' : 'group-hover:bg-x-red/10'} transition-colors">
                    <svg class="w-5 h-5" fill="${post.liked ? 'currentColor' : 'none'}" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
                </span>
                <span class="text-sm">${post.liked ? 'いいね済み' : 'いいね'}</span>
            </button>
        </form>`;

    // 返信フォーム
    document.getElementById('detail-comment-form').action = post.comment_url;

    // コメント
    const commentsEl = document.getElementById('detail-comments');
    const comments = post.comments || [];
    if (comments.length === 0) {
        commentsEl.innerHTML = `<div class="px-4 py-10 text-center text-x-muted text-sm">まだ返信はありません</div>`;
    } else {
        commentsEl.innerHTML = comments.map(c => `
            <div class="flex gap-3 px-4 py-3 border-b border-x-border last:border-0">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-x-blue to-purple-500 flex items-center justify-center font-bold shrink-0 overflow-hidden text-sm text-white">
                    ${c.user.avatar ? `<img src="/storage/${c.user.avatar}" alt="" style="width:100%;height:100%;object-fit:cover;">` : escHtml(c.user.name.charAt(0))}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-1.5 flex-wrap">
                        <span class="font-bold text-sm">${escHtml(c.user.name)}</span>
                        <span class="text-x-muted text-xs">@${escHtml(c.user.username)}</span>
                    </div>
                    <p class="text-sm leading-relaxed mt-0.5 whitespace-pre-wrap break-words">${escHtml(c.content)}</p>
                </div>
            </div>`).join('');
    }

    // ローディング非表示・コンテンツ表示
    document.getElementById('post-detail-loading').classList.add('hidden');
    document.getElementById('post-detail-content').classList.remove('hidden');
    openModal('post-detail-modal');
}

function escHtml(str) {
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
function previewModalImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('modal-preview-img').src = e.target.result;
            document.getElementById('modal-image-preview').classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function clearModalImage() {
    document.getElementById('modal-image-input').value = '';
    document.getElementById('modal-image-preview').classList.add('hidden');
    document.getElementById('modal-preview-img').src = '';
}
</script>
</body>
</html>
