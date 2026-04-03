@extends('layouts.siswa')

@section('title', 'Notifikasi - ' . config('app.name'))

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h2 class="text-3xl font-black text-slate-900 dark:text-white mb-2">Pusat Notifikasi</h2>
        <p class="text-slate-500 dark:text-slate-400">Pantau seluruh aktivitas dan pembaruan pendaftaran Anda di sini.</p>
    </div>
    
    <a href="{{ route('siswa.dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm">
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
            {{ count($allNotifications) }} Notifikasi
        </span>
    </div>

    <div class="divide-y divide-slate-50 dark:divide-slate-800/50">
        @forelse($allNotifications as $notif)
            @php
                $isSystem = str_starts_with($notif['id'], 'system-');
                $icon = 'notifications';
                $colorClass = 'bg-primary/10 text-primary';
                
                if ($notif['type'] === 'system_welcome') {
                    $icon = 'celebration';
                    $colorClass = 'bg-amber-100 text-amber-600';
                } elseif ($notif['type'] === 'system_start_registration') {
                    $icon = 'edit_note';
                    $colorClass = 'bg-blue-100 text-blue-600';
                } elseif ($notif['type'] === 'system_formulir') {
                    $icon = 'description';
                    $colorClass = 'bg-emerald-100 text-emerald-600';
                } elseif ($notif['type'] === 'system_documents') {
                    $icon = 'inventory_2';
                    $colorClass = 'bg-indigo-100 text-indigo-600';
                } elseif ($notif['type'] === 'system_announcement') {
                    $icon = 'campaign';
                    $colorClass = 'bg-primary text-white shadow-lg shadow-primary/20';
                }
            @endphp
            
            <div class="p-6 md:p-8 hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors group relative">
                @if($notif['is_unread'])
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-primary"></div>
                @endif
                
                <div class="flex items-start gap-4 md:gap-6">
                    <div class="w-12 h-12 md:w-14 md:h-14 shrink-0 rounded-2xl {{ $colorClass }} flex items-center justify-center">
                        <span class="material-symbols-outlined text-2xl md:text-3xl">{{ $icon }}</span>
                    </div>
                    
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-1 mb-2">
                            <h4 class="text-base md:text-lg font-bold {{ $notif['is_unread'] ? 'text-slate-900 dark:text-white' : 'text-slate-700 dark:text-slate-300' }}">
                                {{ $notif['title'] }}
                            </h4>
                            <span class="text-xs font-medium text-slate-400 dark:text-slate-500 whitespace-nowrap">
                                {{ $notif['time_ago'] }}
                            </span>
                        </div>
                        
                        <p class="text-sm md:text-base text-slate-500 dark:text-slate-400 leading-relaxed mb-4">
                            {{ $notif['body'] }}
                        </p>

                        @if(isset($notif['data']['url']))
                            <a href="{{ $notif['data']['url'] }}" class="inline-flex items-center gap-2 text-sm font-bold text-primary hover:underline">
                                Lihat Detail
                                <span class="material-symbols-outlined text-xs">arrow_forward</span>
                            </a>
                        @endif
                    </div>
                    
                    @if($notif['is_unread'])
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
                <p class="text-slate-500 dark:text-slate-400 max-w-sm mx-auto">Seluruh aktivitas pendaftaran Anda akan muncul di sini secara berurutan.</p>
            </div>
        @endforelse
    </div>
    
    <div class="p-8 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-100 dark:border-slate-800 text-center">
        <p class="text-sm text-slate-400 dark:text-slate-500">
            Menampilkan {{ count($allNotifications) }} notifikasi terbaru.
        </p>
    </div>
</div>
@endsection
