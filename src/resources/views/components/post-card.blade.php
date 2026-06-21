@php
$postData = json_encode([
    'id'             => $post->id,
    'content'        => $post->content,
    'image'          => $post->image,
    'liked'          => $post->liked,
    'likes_count'    => $post->likes_count,
    'comments_count' => $post->comments_count,
    'created_at'     => $post->created_at->format('Y年n月j日 H:i'),
    'like_url'       => route('posts.like', $post),
    'comment_url'    => route('posts.comments.store', $post),
    'user' => [
        'name'     => $post->user->name,
        'username' => $post->user->username,
        'avatar'   => $post->user->avatar,
    ],
    'comments' => $post->comments->map(fn($c) => [
        'content' => $c->content,
        'user'    => ['name' => $c->user->name, 'username' => $c->user->username, 'avatar' => $c->user->avatar],
    ]),
]);
@endphp

<article class="border-b border-x-border hover:bg-white/[0.02] transition-colors duration-200 px-4 py-4 cursor-pointer"
    x-data="{ editing: false, editContent: @js($post->content), deleteOpen: false }"
    data-post="{{ $postData }}"
    @click="openPostModal($el.dataset.post)">

    {{-- 削除確認モーダル --}}
    <template x-if="deleteOpen">
        <div class="fixed inset-0 z-50 flex items-center justify-center"
            style="background:rgba(0,0,0,0.6);backdrop-filter:blur(4px);"
            @click.self="deleteOpen = false">
            <div class="bg-x-surface border border-x-border rounded-2xl w-[320px] p-6 shadow-2xl">
                <h3 class="text-[19px] font-bold mb-2">投稿を削除しますか？</h3>
                <p class="text-x-muted text-sm mb-6 leading-relaxed">この操作は取り消せません。投稿はタイムラインから削除されます。</p>
                <div class="flex flex-col gap-3">
                    <form method="POST" action="{{ route('posts.destroy', $post) }}" @click.stop>
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full py-3 rounded-full bg-x-red text-white font-bold text-sm hover:bg-x-red/80 transition-colors">
                            削除する
                        </button>
                    </form>
                    <button @click.stop="deleteOpen = false"
                        class="w-full py-3 rounded-full border border-x-border text-x-text font-bold text-sm hover:bg-white/5 transition-colors">
                        キャンセル
                    </button>
                </div>
            </div>
        </div>
    </template>

    <div class="flex gap-3">
        {{-- アバター --}}
        <a href="{{ route('profile.show', $post->user->username) }}"
            class="block w-10 h-10 shrink-0" @click.stop>
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-x-blue to-purple-500 flex items-center justify-center font-bold text-sm overflow-hidden hover:opacity-80 transition-opacity">
                @if($post->user->avatar)
                    <img src="{{ Storage::url($post->user->avatar) }}" alt="" class="w-full h-full object-cover">
                @else
                    {{ mb_substr($post->user->name, 0, 1) }}
                @endif
            </div>
        </a>

        <div class="flex-1 min-w-0">
            {{-- ヘッダー --}}
            <div class="flex items-start justify-between gap-2">
                <div class="flex items-center gap-1.5 flex-wrap min-w-0">
                    <a href="{{ route('profile.show', $post->user->username) }}"
                        class="font-bold hover:underline truncate" @click.stop>{{ $post->user->name }}</a>
                    <span class="text-x-muted text-sm shrink-0">{{ '@' . $post->user->username }}</span>
                    <span class="text-x-muted text-sm shrink-0">·</span>
                    <span class="text-x-muted text-sm shrink-0" title="{{ $post->created_at->format('Y年m月d日 H:i') }}">
                        {{ $post->created_at->diffForHumans() }}
                    </span>
                </div>
                @if(auth()->id() === $post->user_id)
                <div class="flex gap-0.5 text-x-muted shrink-0" @click.stop>
                    <button @click.stop="editing = !editing"
                        class="p-2 rounded-full hover:bg-x-blue/10 hover:text-x-blue transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </button>
                    <button type="button" @click.stop="deleteOpen = true"
                        class="p-2 rounded-full hover:bg-x-red/10 hover:text-x-red transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
                @endif
            </div>

            {{-- 本文（通常） --}}
            <div x-show="!editing">
                <p class="text-[15px] leading-relaxed whitespace-pre-wrap break-words text-x-text mt-0.5">{{ $post->content }}</p>
                @if($post->image)
                <div class="mt-3 rounded-2xl overflow-hidden border border-x-border">
                    <img src="{{ Storage::url($post->image) }}" alt="投稿画像"
                        class="w-full max-h-96 object-cover hover:opacity-95 transition-opacity">
                </div>
                @endif
            </div>

            {{-- 編集フォーム --}}
            <div x-show="editing" x-cloak class="mt-2" @click.stop>
                <form method="POST" action="{{ route('posts.update', $post) }}">
                    @csrf @method('PATCH')
                    <textarea name="content" maxlength="280" rows="3" x-model="editContent"
                        class="input resize-none text-[15px] leading-relaxed" required></textarea>
                    <div class="flex gap-2 mt-2">
                        <button type="submit" class="btn-primary text-sm px-4 py-1.5">保存</button>
                        <button type="button" @click.stop="editing = false" class="btn-outline text-sm px-4 py-1.5">キャンセル</button>
                    </div>
                </form>
            </div>

            {{-- アクションボタン --}}
            <div class="flex items-center gap-1 mt-3 -ml-2">
                {{-- コメント --}}
                <button type="button" @click.stop="openPostModal($el.closest('article').dataset.post)"
                    class="post-action-btn">
                    <span class="icon-wrap">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </span>
                    <span class="text-sm tabular-nums">{{ $post->comments_count }}</span>
                </button>

                {{-- いいね --}}
                <form method="POST" action="{{ route('posts.like', $post) }}" @click.stop>
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-1.5 transition-colors duration-200 group {{ $post->liked ? 'text-x-red' : 'text-x-muted hover:text-x-red' }}">
                        <span class="p-2 rounded-full {{ $post->liked ? 'bg-x-red/10' : 'group-hover:bg-x-red/10' }} transition-colors duration-200">
                            <svg class="w-[18px] h-[18px]" fill="{{ $post->liked ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
                        </span>
                        <span class="text-sm tabular-nums">{{ $post->likes_count }}</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</article>
