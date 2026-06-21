@extends('layouts.app')
@section('title', $post->user->name . 'の投稿 - Y')
@section('content')

<div class="border-b border-x-border px-4 py-3 sticky top-0 bg-x-bg/80 backdrop-blur-sm z-10 flex items-center gap-4">
    <a href="{{ url()->previous() }}" class="p-2 -ml-1 rounded-full hover:bg-white/10 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <h1 class="text-xl font-bold">投稿</h1>
</div>

{{-- 投稿本文 --}}
<div class="px-4 pt-4 pb-0 border-b border-x-border">
    <div class="flex gap-3 mb-3">
        <a href="{{ route('profile.show', $post->user->username) }}">
            <div class="w-11 h-11 rounded-full bg-gradient-to-br from-x-blue to-purple-500 flex items-center justify-center font-bold shrink-0 overflow-hidden hover:opacity-80 transition-opacity">
                @if($post->user->avatar)
                    <img src="{{ Storage::url($post->user->avatar) }}" alt="" class="w-full h-full object-cover">
                @else
                    {{ mb_substr($post->user->name, 0, 1) }}
                @endif
            </div>
        </a>
        <div>
            <a href="{{ route('profile.show', $post->user->username) }}" class="font-bold hover:underline leading-tight block">{{ $post->user->name }}</a>
            <span class="text-x-muted text-sm">{{ '@' . $post->user->username }}</span>
        </div>
        @if(auth()->id() === $post->user_id)
        <div class="ml-auto flex gap-0.5 text-x-muted" x-data="{ editing: false }">
            <button @click="editing = !editing"
                class="p-2 rounded-full hover:bg-x-blue/10 hover:text-x-blue transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </button>
            {{-- 削除ボタン --}}
            <div x-data="{ confirmOpen: false }">
                <button type="button" @click="confirmOpen = true"
                    class="p-2 rounded-full hover:bg-x-red/10 hover:text-x-red transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
                <template x-if="confirmOpen">
                    <div class="fixed inset-0 z-50 flex items-center justify-center"
                        style="background:rgba(0,0,0,0.6);backdrop-filter:blur(4px);"
                        @click.self="confirmOpen = false">
                        <div class="bg-x-surface border border-x-border rounded-2xl w-[320px] p-6 shadow-2xl">
                            <h3 class="text-[19px] font-bold mb-2">投稿を削除しますか？</h3>
                            <p class="text-x-muted text-sm mb-6 leading-relaxed">この操作は取り消せません。</p>
                            <div class="flex flex-col gap-3">
                                <form method="POST" action="{{ route('posts.destroy', $post) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-full py-3 rounded-full bg-x-red text-white font-bold text-sm hover:bg-x-red/80 transition-colors">削除する</button>
                                </form>
                                <button @click="confirmOpen = false"
                                    class="w-full py-3 rounded-full border border-x-border text-x-text font-bold text-sm hover:bg-white/5 transition-colors">キャンセル</button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
        @endif
    </div>

    {{-- 本文 / 編集フォーム --}}
    @if(auth()->id() === $post->user_id)
    <div x-data="{ editing: false, editContent: @js($post->content) }">
        <div x-show="!editing">
            <p class="text-[19px] leading-relaxed whitespace-pre-wrap break-words mb-3">{{ $post->content }}</p>
        </div>
        <div x-show="editing" x-cloak class="mb-3">
            <form method="POST" action="{{ route('posts.update', $post) }}">
                @csrf @method('PATCH')
                <textarea name="content" maxlength="280" rows="4" x-model="editContent"
                    class="input resize-none text-[17px] leading-relaxed w-full" required></textarea>
                <div class="flex gap-2 mt-2">
                    <button type="submit" class="btn-primary text-sm px-4 py-1.5">保存</button>
                    <button type="button" @click="editing = false" class="btn-outline text-sm px-4 py-1.5">キャンセル</button>
                </div>
            </form>
        </div>
    </div>
    @else
    <p class="text-[19px] leading-relaxed whitespace-pre-wrap break-words mb-3">{{ $post->content }}</p>
    @endif

    @if($post->image)
    <div class="mb-3 rounded-2xl overflow-hidden border border-x-border">
        <img src="{{ Storage::url($post->image) }}" alt="投稿画像" class="w-full max-h-[500px] object-cover">
    </div>
    @endif

    <p class="text-x-muted text-sm pb-3 border-b border-x-border">
        {{ $post->created_at->format('Y年n月j日 H:i') }}
    </p>

    {{-- カウント --}}
    <div class="flex gap-5 py-3 border-b border-x-border text-sm">
        <span><span class="font-bold text-x-text">{{ number_format($post->likes_count) }}</span> <span class="text-x-muted">いいね</span></span>
        <span><span class="font-bold text-x-text">{{ number_format($post->comments_count) }}</span> <span class="text-x-muted">返信</span></span>
    </div>

    {{-- アクション --}}
    <div class="flex items-center gap-2 py-1 border-b border-x-border">
        <form method="POST" action="{{ route('posts.like', $post) }}">
            @csrf
            <button type="submit"
                class="flex items-center gap-1.5 transition-colors group {{ $post->liked ? 'text-x-red' : 'text-x-muted hover:text-x-red' }}">
                <span class="p-2 rounded-full {{ $post->liked ? 'bg-x-red/10' : 'group-hover:bg-x-red/10' }} transition-colors">
                    <svg class="w-5 h-5" fill="{{ $post->liked ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
                </span>
                <span class="text-sm">{{ $post->liked ? 'いいね済み' : 'いいね' }}</span>
            </button>
        </form>
    </div>
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
    <form method="POST" action="{{ route('posts.comments.store', $post) }}" class="flex-1 flex gap-2 items-center">
        @csrf
        <input type="text" name="content" maxlength="280" placeholder="返信する..."
            class="input py-2 text-sm rounded-full px-4 flex-1" required>
        <button type="submit" class="btn-primary text-sm px-4 py-2 shrink-0">返信</button>
    </form>
</div>

{{-- コメント一覧 --}}
@forelse($post->comments as $comment)
<div class="flex gap-3 px-4 py-3 border-b border-x-border hover:bg-white/[0.02] transition-colors">
    <a href="{{ route('profile.show', $comment->user->username) }}" class="shrink-0">
        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-x-blue to-purple-500 flex items-center justify-center font-bold text-sm overflow-hidden hover:opacity-80 transition-opacity">
            @if($comment->user->avatar)
                <img src="{{ Storage::url($comment->user->avatar) }}" alt="" class="w-full h-full object-cover">
            @else
                {{ mb_substr($comment->user->name, 0, 1) }}
            @endif
        </div>
    </a>
    <div class="flex-1 min-w-0">
        <div class="flex items-center justify-between gap-2">
            <div class="flex items-center gap-1.5 flex-wrap min-w-0">
                <a href="{{ route('profile.show', $comment->user->username) }}" class="font-bold text-sm hover:underline truncate">{{ $comment->user->name }}</a>
                <span class="text-x-muted text-xs shrink-0">{{ '@' . $comment->user->username }}</span>
                <span class="text-x-muted text-xs shrink-0">· {{ $comment->created_at->diffForHumans() }}</span>
            </div>
            @if(auth()->id() === $comment->user_id)
            <div x-data="{ open: false }" class="shrink-0">
                <button type="button" @click="open = true"
                    class="p-1.5 text-x-muted hover:text-x-red hover:bg-x-red/10 rounded-full transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                <template x-if="open">
                    <div class="fixed inset-0 z-50 flex items-center justify-center"
                        style="background:rgba(0,0,0,0.6);backdrop-filter:blur(4px);"
                        @click.self="open = false">
                        <div class="bg-x-surface border border-x-border rounded-2xl w-[320px] p-6 shadow-2xl">
                            <h3 class="text-[19px] font-bold mb-2">返信を削除しますか？</h3>
                            <p class="text-x-muted text-sm mb-6 leading-relaxed">この操作は取り消せません。</p>
                            <div class="flex flex-col gap-3">
                                <form method="POST" action="{{ route('posts.comments.destroy', [$post, $comment]) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-full py-3 rounded-full bg-x-red text-white font-bold text-sm hover:bg-x-red/80 transition-colors">削除する</button>
                                </form>
                                <button @click="open = false"
                                    class="w-full py-3 rounded-full border border-x-border text-x-text font-bold text-sm hover:bg-white/5 transition-colors">キャンセル</button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            @endif
        </div>
        <p class="text-sm leading-relaxed mt-0.5 whitespace-pre-wrap break-words">{{ $comment->content }}</p>
    </div>
</div>
@empty
<div class="px-4 py-12 text-center text-x-muted text-sm">まだ返信はありません</div>
@endforelse

@endsection
