@extends($layout)

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h2 class="text-3xl font-black text-slate-900 dark:text-white mb-2">Pusat Notifikasi</h2>
        <p class="text-slate-500 dark:text-slate-400">Pantau seluruh aktivitas dan pembaruan sistem di sini.</p>
    </div>
    
    <a href="{{ route(str_replace('_', '-', auth()->user()->role) . '.dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm">
        <span class="material-symbols-outlined text-sm">arrow_back</span>
        Kembali ke Dashboard
    </a>
</div>

<div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
    <div class="p-8 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
        <h3 class="text-xl font-bold flex items-center gap-3">
            <span class="material-symbols-outlined text-primary">history</span>
            Riwayat Notifikasi
        </h3>
        <span class="px-4 py-1.5 bg-primary/10 text-primary text-xs font-bold rounded-full">
            {{ $notifications->total() }} Notifikasi
        </span>
    </div>

    <div class="divide-y divide-slate-50 dark:divide-slate-800/50">
        @forelse($notifications as $notif)
            @php
                $icon = 'notifications';
                $colorClass = 'bg-primary/10 text-primary';
                
                if (str_contains($notif->type, 'ppdb') || str_contains($notif->type, 'spmb')) {
                    $icon = 'assignment';
                    $colorClass = 'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-500';
                } elseif (str_contains($notif->type, 'lulus')) {
                    $icon = 'check_circle';
                    $colorClass = 'bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-500';
                } elseif (str_contains($notif->type, 'revisi') || str_contains($notif->type, 'tolak')) {
                    $icon = 'warning';
                    $colorClass = 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-500';
                } elseif (str_contains($notif->type, 'system')) {
                    $icon = 'settings_suggest';
                    $colorClass = 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400';
                }
            @endphp
            
            <div class="p-6 md:p-8 hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors group relative">
                @if($notif->isUnread())
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-primary"></div>
                @endif
                
                <div class="flex items-start gap-4 md:gap-6">
                    <div class="w-12 h-12 md:w-14 md:h-14 shrink-0 rounded-2xl {{ $colorClass }} flex items-center justify-center">
                        <span class="material-symbols-outlined text-2xl md:text-3xl">{{ $icon }}</span>
                    </div>
                    
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-1 mb-2">
                            <h4 class="text-base md:text-lg font-bold {{ $notif->isUnread() ? 'text-slate-900 dark:text-white' : 'text-slate-700 dark:text-slate-300' }}">
                                {{ $notif->title }}
                            </h4>
                            <span class="text-xs font-medium text-slate-400 dark:text-slate-500 whitespace-nowrap">
                                {{ $notif->created_at->diffForHumans() }}
                            </span>
                        </div>
                        
                        <p class="text-sm md:text-base text-slate-500 dark:text-slate-400 leading-relaxed {{ isset($notif->data['url']) ? 'mb-4' : '' }}">
                            {{ $notif->body }}
                        </p>

                    </div>
                    
                    @if($notif->isUnread())
                        <div class="shrink-0 pt-1">
                            <span class="flex h-3 w-3 rounded-full bg-primary ring-4 ring-primary/20"></span>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="p-20 text-center">
                <div class="w-24 h-24 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-5xl text-slate-300 dark:text-slate-600">notifications_off</span>
                </div>
                <h4 class="text-xl font-bold text-slate-800 dark:text-white mb-2">Belum ada notifikasi</h4>
                <p class="text-slate-500 dark:text-slate-400 max-w-sm mx-auto">Seluruh aktivitas dan informasi penting akan muncul di sini.</p>
            </div>
        @endforelse
    </div>
    
    @if($notifications->hasPages())
        <div class="p-8 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-100 dark:border-slate-800">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
@endsection
