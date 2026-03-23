<div class="relative" x-data="{ open: $wire.entangle('isOpen') }" @click.outside="open = false; $wire.closeDropdown()">

    {{-- Bell Button --}}
    <button
        type="button"
        wire:click="toggleDropdown"
        class="p-2.5 text-slate-600 dark:text-slate-400 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-800 dark:hover:bg-slate-800/80 rounded-2xl transition-all shadow-sm relative"
        aria-label="Notifikasi"
    >
        <span class="material-symbols-outlined">notifications</span>

        {{-- Badge count --}}
        @if($unreadCount > 0)
        <span class="absolute top-1.5 right-1.5 min-w-[18px] h-[18px] px-1 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center leading-none">
            {{ $unreadCount > 99 ? '99+' : $unreadCount }}
        </span>
        @else
        <span class="absolute top-2 right-2 w-2 h-2 bg-slate-300 dark:bg-slate-600 rounded-full"></span>
        @endif
    </button>

    {{-- Dropdown --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95 translate-y-1"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-1"
        x-cloak
        class="absolute right-0 mt-2 w-80 bg-white dark:bg-slate-800 dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-700 dark:border-slate-800 z-[60] overflow-hidden"
        style="display: none;"
    >
        {{-- Header Dropdown --}}
        <div class="flex items-center justify-between px-4 py-3 border-b border-slate-100 dark:border-slate-700 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 dark:bg-slate-800/50">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-lg">notifications</span>
                <span class="text-sm font-bold text-slate-800 dark:text-slate-100 dark:text-slate-100">Notifikasi</span>
                @if($unreadCount > 0)
                <span class="px-1.5 py-0.5 bg-red-500 text-white text-[10px] font-bold rounded-full">{{ $unreadCount }}</span>
                @endif
            </div>
            @if($unreadCount > 0)
            <button
                wire:click="markAllRead"
                class="text-xs text-primary hover:text-primary/80 font-medium transition-colors"
            >
                Tandai semua dibaca
            </button>
            @endif
        </div>

        {{-- List Notifikasi --}}
        <div class="max-h-72 overflow-y-auto divide-y divide-slate-50 dark:divide-slate-700/50 dark:divide-slate-800">
            @forelse($notifications as $notif)
            <div
                wire:key="{{ $notif['id'] }}"
                class="flex gap-3 px-4 py-3 hover:bg-slate-50 dark:hover:bg-slate-700 dark:hover:bg-slate-800/50 transition-colors {{ $notif['is_unread'] ? 'bg-primary/5 dark:bg-primary/10' : '' }} cursor-pointer group"
                wire:click="markRead('{{ $notif['id'] }}')"
            >
                {{-- Icon berdasarkan tipe --}}
                <div class="flex-shrink-0 w-8 h-8 rounded-xl flex items-center justify-center
                    @if(str_contains($notif['type'], 'ppdb') || str_contains($notif['type'], 'spmb')) bg-blue-100 dark:bg-blue-900/30 dark:bg-blue-900/30 text-blue-600 dark:text-blue-500
                    @elseif(str_contains($notif['type'], 'lulus')) bg-green-100 dark:bg-green-900/30 dark:bg-green-900/30 text-green-600 dark:text-green-500
                    @elseif(str_contains($notif['type'], 'revisi') || str_contains($notif['type'], 'tolak')) bg-red-100 dark:bg-red-900/30 dark:bg-red-900/30 text-red-600 dark:text-red-500
                    @else bg-primary/10 text-primary @endif">
                    <span class="material-symbols-outlined text-sm">
                        @if(str_contains($notif['type'], 'ppdb') || str_contains($notif['type'], 'spmb')) assignment
                        @elseif(str_contains($notif['type'], 'lulus')) check_circle
                        @elseif(str_contains($notif['type'], 'revisi') || str_contains($notif['type'], 'tolak')) warning
                        @else notifications @endif
                    </span>
                </div>

                {{-- Konten --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-1">
                        <p class="text-xs font-semibold text-slate-800 dark:text-slate-100 dark:text-slate-100 truncate">{{ $notif['title'] }}</p>
                        @if($notif['is_unread'])
                        <span class="flex-shrink-0 w-2 h-2 bg-primary rounded-full mt-1"></span>
                        @endif
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 dark:text-slate-400 mt-0.5 line-clamp-2">{{ $notif['body'] }}</p>
                    <p class="text-[10px] text-slate-400 dark:text-slate-500 dark:text-slate-500 mt-1">{{ $notif['time_ago'] }}</p>
                </div>
            </div>
            @empty
            <div class="flex flex-col items-center justify-center py-10 text-center">
                <span class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-600 dark:text-slate-600 mb-2">notifications_off</span>
                <p class="text-sm text-slate-400 dark:text-slate-500 dark:text-slate-500 font-medium">Belum ada notifikasi</p>
            </div>
            @endforelse
        </div>

        {{-- Footer --}}
        @if(count($notifications) > 0)
        <div class="px-4 py-2.5 border-t border-slate-100 dark:border-slate-700 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 dark:bg-slate-800/50">
            <p class="text-[11px] text-slate-400 dark:text-slate-500 text-center">Menampilkan {{ count($notifications) }} notifikasi terbaru</p>
        </div>
        @endif
    </div>

    {{-- Reverb Real-time Listener --}}
    @auth
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof window.Echo === 'undefined') return;

        const userId = {{ auth()->id() }};
        window.Echo.private('notifications.' + userId)
            .listen('.notification.new', (data) => {
                // Update Livewire component
                @this.dispatch('notification-received');

                // Toast popup
                if (typeof window.showNotifToast === 'function') {
                    window.showNotifToast(data.title, data.body);
                }
            });
    });
    </script>
    @endauth
</div>
