<article class="border-b border-x-border hover:bg-white/[0.02] transition-colors duration-200 px-4 py-4 cursor-pointer"
    x-data="{ editing: false, editContent: @js($post->content), showComments: false }">
    <div class="flex gap-3">
        <a href="{{ route('profile.show', $post->user->username) }}" class="shrink-0" onclick="event.stopPropagation()">
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-x-blue to-purple-500 flex items-center justify-center font-bold text-sm hover:opacity-80 transition-opacity">
                {{ mb_substr($post->user->name, 0, 1) }}
            </div>
        </a>
        <div class="flex-1 min-w-0">
            {{-- ヘッダー --}}
            <div class="flex items-start justify-between gap-2">
                <div class="flex items-center gap-1.5 flex-wrap min-w-0">
                    <a href="{{ route('profile.show', $post->user->username) }}"
                        class="font-bold hover:underline truncate" onclick="event.stopPropagation()">{{ $post->user->name }}</a>
                    <span class="text-x-muted text-sm shrink-0">{{ '@' . $post->user->username }}</span>
                    <span class="text-x-muted text-sm shrink-0">·</span>
                    <span class="text-x-muted text-sm shrink-0" title="{{ $post->created_at->format('Y年m月d日 H:i') }}">
                        {{ $post->created_at->diffForHumans() }}
                    </span>
                </div>
                @if(auth()->id() === $post->user_id)
                <div class="flex gap-0.5 text-x-muted shrink-0">
                    <button @click.stop="editing = !editing"
                        class="p-2 rounded-full hover:bg-x-blue/10 hover:text-x-blue transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </button>
                    <form method="POST" action="{{ route('posts.destroy', $post) }}" onclick="event.stopPropagation()">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('この投稿を削除しますか？')"
                            class="p-2 rounded-full hover:bg-x-red/10 hover:text-x-red transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
                @endif
            </div>

            {{-- 本文（通常） --}}
            <div x-show="!editing">
                <a href="{{ route('posts.show', $post) }}" class="block mt-0.5">
                    <p class="text-[15px] leading-relaxed whitespace-pre-wrap break-words text-x-text">{{ $post->content }}</p>
                    @if($post->image)
                    <div class="mt-3 rounded-2xl overflow-hidden border border-x-border">
                        <img src="{{ Storage::url($post->image) }}" alt="投稿画像"
                            class="w-full max-h-96 object-cover hover:opacity-95 transition-opacity">
                    </div>
                    @endif
                </a>
            </div>

            {{-- 編集フォーム --}}
            <div x-show="editing" x-cloak class="mt-2">
                <form method="POST" action="{{ route('posts.update', $post) }}" onclick="event.stopPropagation()">
                    @csrf @method('PATCH')
                    <textarea name="content" maxlength="280" rows="3" x-model="editContent"
                        class="input resize-none text-[15px] leading-relaxed" required></textarea>
                    <div class="flex gap-2 mt-2">
                        <button type="submit" class="btn-primary text-sm px-4 py-1.5">保存</button>
                        <button type="button" @click="editing = false" class="btn-outline text-sm px-4 py-1.5">キャンセル</button>
                    </div>
                </form>
            </div>

            {{-- アクションボタン --}}
            <div class="flex items-center gap-1 mt-3 -ml-2" onclick="event.stopPropagation()">
                {{-- コメント --}}
                <button @click.stop="showComments = !showComments"
                    class="post-action-btn">
                    <span class="icon-wrap">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </span>
                    <span class="text-sm tabular-nums">{{ $post->comments_count }}</span>
                </button>

                {{-- いいね --}}
                <form method="POST" action="{{ route('posts.like', $post) }}">
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

            {{-- コメント欄 --}}
            <div x-show="showComments" x-cloak class="mt-3" onclick="event.stopPropagation()">
                <div class="border-t border-x-border/50 pt-3">
                    <form method="POST" action="{{ route('posts.comments.store', $post) }}" class="flex gap-2 mb-4">
                        @csrf
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-x-blue to-purple-500 flex items-center justify-center text-xs font-bold shrink-0 mt-1">
                            {{ mb_substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="flex-1 flex gap-2">
                            <input type="text" name="content" maxlength="280" placeholder="返信する..."
                                class="input py-2 text-sm rounded-full px-4" required>
                            <button type="submit" class="btn-primary text-sm px-4 py-2 shrink-0">返信</button>
                        </div>
                    </form>
                    <div class="space-y-3">
                        @foreach($post->comments as $comment)
                        <div class="flex gap-2 items-start">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-x-blue to-purple-500 flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">
                                {{ mb_substr($comment->user->name, 0, 1) }}
                            </div>
                            <div class="flex-1 bg-white/[0.03] rounded-2xl px-3 py-2 border border-x-border/50">
                                <div class="flex items-center gap-1.5 mb-0.5">
                                    <span class="font-bold text-sm">{{ $comment->user->name }}</span>
                                    <span class="text-x-muted text-xs">{{ '@' . $comment->user->username }}</span>
                                    <span class="text-x-muted text-xs">· {{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm leading-relaxed">{{ $comment->content }}</p>
                            </div>
                            @if(auth()->id() === $comment->user_id)
                            <form method="POST" action="{{ route('posts.comments.destroy', [$post, $comment]) }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 mt-1 text-x-muted hover:text-x-red hover:bg-x-red/10 rounded-full transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </form>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>
