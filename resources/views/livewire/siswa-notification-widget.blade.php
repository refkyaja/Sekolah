<div class="notification-system-card flex h-full max-h-[42rem] min-h-[32rem] flex-col overflow-hidden rounded-xl border border-slate-100 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
    <style>
        .notification-system-card .notification-scroll {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .notification-system-card .notification-scroll::-webkit-scrollbar {
            width: 0;
            height: 0;
            display: none;
        }
    </style>

    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-bold flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">campaign</span>
            Notification System
            @if($unreadCount > 0)
            <span class="px-2 py-0.5 bg-red-500 text-white text-xs font-bold rounded-full">{{ $unreadCount }}</span>
            @endif
        </h3>
        @if($unreadCount > 0)
        <button
            wire:click="markAllRead"
            class="text-xs text-primary hover:underline font-medium"
        >
            Tandai semua dibaca
        </button>
        @endif
    </div>

    @php
        $primaryNotifications = array_slice($notifications, 0, 3);
        $olderNotifications = array_slice($notifications, 3);
    @endphp

    <div class="notification-scroll flex-1 overflow-y-auto pl-3 pr-2">
        <div class="space-y-5">
            @forelse($primaryNotifications as $notif)
            @php
                $timelineBorder = 'border-l-2 border-primary/20';
                $timelineDot = $loop->first
                    ? 'bg-primary border-4 border-primary/15'
                    : 'bg-white border-2 border-primary/35 dark:bg-slate-900';
                $labelColor = 'text-primary';
            @endphp
            <div
                wire:key="{{ $notif['id'] }}"
                class="relative pl-7 cursor-pointer group transition-opacity hover:opacity-80 {{ $timelineBorder }}"
                wire:click="markRead('{{ $notif['id'] }}')"
            >
                <div class="absolute -left-[11px] top-0 h-4 w-4 rounded-full {{ $timelineDot }}"></div>

                <div class="mb-1 flex items-center justify-between gap-2">
                    <span class="text-xs font-bold uppercase {{ $labelColor }}">
                        Notification System
                    </span>
                    <span class="text-[10px] text-slate-400 whitespace-nowrap">{{ $notif['time_ago'] }}</span>
                </div>
                <p class="text-sm font-semibold mb-1 {{ $notif['is_unread'] ? 'text-slate-800 dark:text-slate-100' : 'text-slate-500 dark:text-slate-400' }}">
                    {{ $notif['title'] }}
                </p>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">{{ $notif['body'] }}</p>

                @if(isset($notif['data']['note']))
                <div class="mt-3 rounded-xl border border-amber-200 bg-amber-50 px-3 py-2 text-xs text-amber-800 dark:border-amber-800 dark:bg-amber-900/20 dark:text-amber-200">
                    {{ $notif['data']['note'] }}
                </div>
                @endif

                @if(isset($notif['data']['url']))
                <a href="{{ $notif['data']['url'] }}" class="inline-block mt-1 text-xs text-primary hover:underline font-medium">
                    Lihat Detail ->
                </a>
                @endif
            </div>
            @empty
            <div class="flex flex-col items-center justify-center py-8 text-center">
                <span class="material-symbols-outlined text-5xl text-slate-200 dark:text-slate-700 mb-3">notifications_off</span>
                <p class="text-sm font-semibold text-slate-800 dark:text-slate-100 mb-1">Belum ada notifikasi sistem</p>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Informasi pendaftaran, dokumen, dan catatan admin akan tampil di sini.
                </p>
            </div>
            @endforelse
        </div>

        @if(count($olderNotifications) > 0)
        <details class="mt-6 rounded-2xl border border-slate-200 bg-slate-50/80 p-4 dark:border-slate-800 dark:bg-slate-800/40">
            <summary class="cursor-pointer list-none text-sm font-bold text-slate-700 dark:text-slate-200">
                Lainnya
                <span class="ml-2 text-xs font-medium text-slate-400">({{ count($olderNotifications) }} notifikasi lama)</span>
            </summary>
            <div class="notification-scroll mt-4 max-h-72 space-y-5 overflow-y-auto pl-3 pr-2">
                @foreach($olderNotifications as $notif)
                @php
                    $timelineBorder = 'border-l-2 border-primary/15';
                    $timelineDot = 'bg-white border-2 border-primary/25 dark:bg-slate-900';
                    $labelColor = 'text-primary';
                @endphp
                <div
                    wire:key="older-{{ $notif['id'] }}"
                    class="relative pl-7 cursor-pointer group transition-opacity hover:opacity-80 {{ $timelineBorder }}"
                    wire:click="markRead('{{ $notif['id'] }}')"
                >
                    <div class="absolute -left-[11px] top-0 h-4 w-4 rounded-full {{ $timelineDot }}"></div>
                    <div class="mb-1 flex items-center justify-between gap-2">
                        <span class="text-xs font-bold uppercase {{ $labelColor }}">Notification System</span>
                        <span class="text-[10px] text-slate-400 whitespace-nowrap">{{ $notif['time_ago'] }}</span>
                    </div>
                    <p class="text-sm font-semibold mb-1 {{ $notif['is_unread'] ? 'text-slate-800 dark:text-slate-100' : 'text-slate-500 dark:text-slate-400' }}">
                        {{ $notif['title'] }}
                    </p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">{{ $notif['body'] }}</p>

                    @if(isset($notif['data']['note']))
                    <div class="mt-3 rounded-xl border border-amber-200 bg-amber-50 px-3 py-2 text-xs text-amber-800 dark:border-amber-800 dark:bg-amber-900/20 dark:text-amber-200">
                        {{ $notif['data']['note'] }}
                    </div>
                    @endif

                    @if(isset($notif['data']['url']))
                    <a href="{{ $notif['data']['url'] }}" class="inline-block mt-1 text-xs text-primary hover:underline font-medium">
                        Lihat Detail ->
                    </a>
                    @endif
                </div>
                @endforeach
            </div>
        </details>
        @endif

        @if(count($notifications) > 0 && $unreadCount > 0)
        <button
            wire:click="markAllRead"
            class="w-full mt-8 py-3 rounded-xl border-2 border-dashed border-slate-200 dark:border-slate-800 text-slate-500 text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors"
        >
            Tandai Semua Dibaca
        </button>
        @endif
    </div>

    @if(Auth::guard('siswa')->check())
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof window.Echo === 'undefined') return;
        const siswaId = {{ Auth::guard('siswa')->id() }};
        window.Echo.private('notifications.' + siswaId)
            .listen('.notification.new', () => {
                @this.dispatch('siswa-notification-received');
            });
    });
    </script>
    @endif
</div>
