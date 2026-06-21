@php $isSelf = auth()->user()->username === $user->username; @endphp

<div class="border-b border-x-border">
    {{-- カバー --}}
    <div class="h-[150px] bg-gradient-to-r from-x-blue/80 via-purple-600/70 to-x-blue/50 relative overflow-hidden">
        @if($user->header_image)
            <img src="{{ Storage::url($user->header_image) }}" alt="" class="w-full h-full object-cover">
        @endif
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/20"></div>
    </div>

    <div class="px-4">
        {{-- アバター & ボタン --}}
        <div class="flex justify-between items-end -mt-[40px] mb-3">
            <div class="w-[80px] h-[80px] rounded-full bg-gradient-to-br from-x-blue to-purple-500 border-4 border-x-bg flex items-center justify-center text-2xl font-bold shadow-xl z-10 overflow-hidden">
                @if($user->avatar)
                    <img src="{{ Storage::url($user->avatar) }}" alt="" class="w-full h-full object-cover">
                @else
                    {{ mb_substr($user->name, 0, 1) }}
                @endif
            </div>
            @if($isSelf)
            <button onclick="openModal('edit-profile-modal')" class="btn-outline px-4 py-1.5 text-sm">
                プロフィールを編集
            </button>
            @else
            <form method="POST" action="{{ route('profile.follow', $user->username) }}">
                @csrf
                <button type="submit" class="{{ $isFollowing ? 'btn-outline' : 'btn-white' }} px-5 py-2 text-sm">
                    {{ $isFollowing ? 'フォロー中' : 'フォローする' }}
                </button>
            </form>
            @endif
        </div>

        <h1 class="text-xl font-bold leading-tight">{{ $user->name }}</h1>
        <p class="text-x-muted text-sm mb-3">{{ '@' . $user->username }}</p>

        @if($user->bio)
        <p class="text-[15px] mb-3 leading-relaxed">{{ $user->bio }}</p>
        @endif

        <div class="flex gap-5 text-sm mb-1">
            <a href="{{ route('profile.following', $user->username) }}" class="hover:underline">
                <span class="font-bold text-x-text">{{ number_format($user->following_count) }}</span>
                <span class="text-x-muted ml-1">フォロー中</span>
            </a>
            <a href="{{ route('profile.followers', $user->username) }}" class="hover:underline">
                <span class="font-bold text-x-text">{{ number_format($user->followers_count) }}</span>
                <span class="text-x-muted ml-1">フォロワー</span>
            </a>
        </div>
    </div>

    {{-- タブ --}}
    <div class="flex mt-1">
        <a href="{{ route('profile.show', $user->username) }}"
            class="flex-1 text-center py-4 text-sm font-medium transition-colors relative {{ request()->routeIs('profile.show') ? 'text-x-text' : 'text-x-muted hover:text-x-text hover:bg-white/[0.03]' }}">
            投稿
            @if(request()->routeIs('profile.show'))
            <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-12 h-1 bg-x-blue rounded-full"></span>
            @endif
        </a>
        <a href="{{ route('profile.likes', $user->username) }}"
            class="flex-1 text-center py-4 text-sm font-medium transition-colors relative {{ request()->routeIs('profile.likes') ? 'text-x-text' : 'text-x-muted hover:text-x-text hover:bg-white/[0.03]' }}">
            いいね
            @if(request()->routeIs('profile.likes'))
            <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-12 h-1 bg-x-blue rounded-full"></span>
            @endif
        </a>
    </div>
</div>

@if($isSelf)
{{-- プロフィール編集モーダル --}}
<div id="edit-profile-modal"
    class="hidden fixed inset-0 z-50 flex items-start justify-center"
    style="background:rgba(0,0,0,0.6);backdrop-filter:blur(4px);"
    onclick="if(event.target===this)closeModal('edit-profile-modal')">

    <div class="relative w-full max-w-[600px] mx-4 my-8 bg-x-surface border border-x-border rounded-2xl shadow-2xl overflow-hidden">

        {{-- モーダルヘッダー --}}
        <div class="flex items-center justify-between px-4 py-3 border-b border-x-border">
            <div class="flex items-center gap-4">
                <button onclick="closeModal('edit-profile-modal')"
                    class="p-2 -ml-1 rounded-full hover:bg-white/10 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                <span class="font-bold text-[19px]">プロフィールを編集</span>
            </div>
            <button type="submit" form="edit-profile-form" class="btn-white px-4 py-1.5 text-sm font-bold">保存</button>
        </div>

        {{-- スクロール可能なボディ --}}
        <div class="overflow-y-auto max-h-[80vh]">
            <form id="edit-profile-form" method="POST" action="{{ route('settings.profile.update') }}"
                enctype="multipart/form-data">
                @csrf @method('PATCH')

                {{-- ヘッダー画像 --}}
                <div class="relative h-[150px] bg-gradient-to-r from-x-blue/80 via-purple-600/70 to-x-blue/50">
                    @if($user->header_image)
                        <img id="modal-header-preview" src="{{ Storage::url($user->header_image) }}" alt="" class="w-full h-full object-cover">
                    @else
                        <img id="modal-header-preview" src="" alt="" class="w-full h-full object-cover hidden">
                    @endif
                    <label class="absolute inset-0 flex items-center justify-center bg-black/40 cursor-pointer hover:bg-black/50 transition-colors">
                        <div class="w-10 h-10 rounded-full bg-black/50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <input type="file" name="header_image" accept="image/jpeg,image/png,image/gif,image/webp" class="hidden"
                            onchange="previewEditImage(this,'modal-header-preview')">
                    </label>
                </div>

                <div class="px-4 pt-3 pb-6">
                    {{-- アバター --}}
                    <div class="-mt-[36px] mb-5 relative inline-block">
                        <div class="w-[72px] h-[72px] rounded-full bg-gradient-to-br from-x-blue to-purple-500 border-4 border-x-surface flex items-center justify-center text-xl font-bold overflow-hidden">
                            @if($user->avatar)
                                <img id="modal-avatar-preview" src="{{ Storage::url($user->avatar) }}" alt="" class="w-full h-full object-cover">
                            @else
                                <img id="modal-avatar-preview" src="" alt="" class="w-full h-full object-cover hidden">
                                <span id="modal-avatar-initial">{{ mb_substr($user->name, 0, 1) }}</span>
                            @endif
                        </div>
                        <label class="absolute inset-0 rounded-full flex items-center justify-center bg-black/50 cursor-pointer hover:bg-black/60 transition-colors">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <input type="file" name="avatar" accept="image/jpeg,image/png,image/gif,image/webp" class="hidden"
                                onchange="previewEditImage(this,'modal-avatar-preview','modal-avatar-initial')">
                        </label>
                    </div>

                    @if($errors->any())
                    <div class="bg-x-red/10 border border-x-red/30 text-x-red rounded-xl px-4 py-3 text-sm mb-4 space-y-1">
                        @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
                    </div>
                    @endif

                    <div class="space-y-4">
                        <div class="relative border border-x-border rounded-md focus-within:border-x-blue transition-colors">
                            <label class="absolute top-2 left-3 text-xs text-x-muted pointer-events-none">名前</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="w-full bg-transparent pt-7 pb-2 px-3 text-x-text focus:outline-none text-[15px]"
                                required maxlength="50">
                        </div>

                        <div class="relative border border-x-border rounded-md focus-within:border-x-blue transition-colors">
                            <label class="absolute top-2 left-3 text-xs text-x-muted pointer-events-none">ユーザー名</label>
                            <div class="flex items-center pt-7 pb-2 px-3">
                                <span class="text-x-muted text-[15px] shrink-0">@</span>
                                <input type="text" name="username" value="{{ old('username', $user->username) }}"
                                    class="flex-1 bg-transparent text-x-text focus:outline-none text-[15px] pl-0.5"
                                    required maxlength="20" pattern="[a-zA-Z0-9_]+">
                            </div>
                        </div>

                        <div class="relative border border-x-border rounded-md focus-within:border-x-blue transition-colors">
                            <label class="absolute top-2 left-3 text-xs text-x-muted pointer-events-none">自己紹介</label>
                            <textarea name="bio" maxlength="160" rows="3"
                                class="w-full bg-transparent pt-7 pb-2 px-3 text-x-text focus:outline-none text-[15px] resize-none"
                                placeholder="自己紹介を追加">{{ old('bio', $user->bio) }}</textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewEditImage(input, previewId, initialId) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById(previewId);
        img.src = e.target.result;
        img.classList.remove('hidden');
        if (initialId) {
            const el = document.getElementById(initialId);
            if (el) el.classList.add('hidden');
        }
    };
    reader.readAsDataURL(input.files[0]);
}
</script>
@endif
