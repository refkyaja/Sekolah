@extends('layouts.siswa')

@section('title', 'Kehadiran Siswa')

@section('content')
<div class="p-6" x-data="{ mode: '{{ $viewMode }}' }">
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Kehadiran Siswa @if($siswa->status_siswa === 'lulus') <span class="text-[10px] uppercase tracking-widest font-bold text-slate-400 bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded ml-2 align-middle border border-slate-200 dark:border-slate-700">(ARSIP)</span> @endif</h1>
            <p class="text-slate-500 dark:text-slate-400">Pantau riwayat kehadiran Anda di sekolah.</p>
        </div>
        
        <div class="flex items-center p-1 bg-slate-100 dark:bg-slate-800 rounded-xl w-fit">
            <button @click="mode = 'calendar'" 
                    :class="mode === 'calendar' ? 'bg-white dark:bg-slate-700 shadow-sm text-primary font-medium' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'"
                    class="px-4 py-2 rounded-lg transition-all text-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">calendar_month</span>
                Mode Kalender
            </button>
            <button @click="mode = 'table'" 
                    :class="mode === 'table' ? 'bg-white dark:bg-slate-700 shadow-sm text-primary font-medium' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'"
                    class="px-4 py-2 rounded-lg transition-all text-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">list_alt</span>
                Mode Tabel
            </button>
        </div>
    </div>

    <!-- Statistik Singkat -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        @php
            $stats = [
                'hadir' => $absensi->where('status', 'hadir')->count(),
                'izin' => $absensi->where('status', 'izin')->count(),
                'sakit' => $absensi->where('status', 'sakit')->count(),
                'alpa' => $absensi->where('status', 'alpa')->count(),
            ];
        @endphp
        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-green-100 dark:bg-green-900/30 text-green-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-sm">check_circle</span>
            </div>
            <div>
                <p class="text-[10px] text-slate-500 uppercase tracking-wider font-bold">Hadir</p>
                <p class="text-xl font-bold dark:text-white">{{ $stats['hadir'] }}</p>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 text-blue-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-sm">info</span>
            </div>
            <div>
                <p class="text-[10px] text-slate-500 uppercase tracking-wider font-bold">Izin</p>
                <p class="text-xl font-bold dark:text-white">{{ $stats['izin'] }}</p>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-sm">medical_services</span>
            </div>
            <div>
                <p class="text-[10px] text-slate-500 uppercase tracking-wider font-bold">Sakit</p>
                <p class="text-xl font-bold dark:text-white">{{ $stats['sakit'] }}</p>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-red-100 dark:bg-red-900/30 text-red-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-sm">cancel</span>
            </div>
            <div>
                <p class="text-[10px] text-slate-500 uppercase tracking-wider font-bold">Alpa</p>
                <p class="text-xl font-bold dark:text-white">{{ $stats['alpa'] }}</p>
            </div>
        </div>
    </div>

    <!-- Tab Content: Calendar -->
    <div x-show="mode === 'calendar'" x-cloak class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
        <div class="p-6 border-b border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50">
             <div class="flex items-center justify-between">
                <h2 class="font-bold text-slate-800 dark:text-white">Kalender Kehadiran - {{ now()->translatedFormat('F Y') }}</h2>
             </div>
        </div>
        <div class="p-4 overflow-x-auto">
            <div class="grid grid-cols-7 gap-px bg-slate-200 dark:bg-slate-800 border border-slate-200 dark:border-slate-800 min-w-[700px]">
                @php
                    $startOfMonth = now()->startOfMonth();
                    $endOfMonth = now()->endOfMonth();
                    $daysInMonth = $endOfMonth->day;
                    $startDay = $startOfMonth->dayOfWeekIso; // 1 (Mon) to 7 (Sun)
                    
                    // Month name array for labeling
                    $dayLabels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
                @endphp
                
                @foreach($dayLabels as $label)
                    <div class="bg-slate-50 dark:bg-slate-800 p-2 text-center text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ $label }}</div>
                @endforeach

                @for($i = 1; $i < $startDay; $i++)
                    <div class="bg-white dark:bg-slate-900 p-4 min-h-[100px]"></div>
                @endfor

                @for($day = 1; $day <= $daysInMonth; $day++)
                    @php
                        $date = now()->setDay($day);
                        $dateStr = $date->format('Y-m-d');
                        $absent = $absensi->where('tanggal', $dateStr)->first();
                        
                        $bgColor = 'bg-white dark:bg-slate-900';
                        $indicator = '';
                        
                        if ($absent) {
                            $indicator = match($absent->status) {
                                'hadir' => '<div class="absolute inset-0 bg-green-500/10 flex items-center justify-center text-green-600 font-bold text-xs ring-1 ring-green-500/20">H</div>',
                                'sakit' => '<div class="absolute inset-0 bg-yellow-500/10 flex items-center justify-center text-yellow-600 font-bold text-xs ring-1 ring-yellow-500/20">S</div>',
                                'izin' => '<div class="absolute inset-0 bg-blue-500/10 flex items-center justify-center text-blue-600 font-bold text-xs ring-1 ring-blue-500/20">I</div>',
                                'alpa' => '<div class="absolute inset-0 bg-red-500/10 flex items-center justify-center text-red-600 font-bold text-xs ring-1 ring-red-500/20">A</div>',
                                default => ''
                            };
                        }
                    @endphp
                    <div class="bg-white dark:bg-slate-900 p-2 min-h-[80px] relative border-slate-100 dark:border-slate-800 border-t border-l">
                        <span class="relative z-10 text-xs text-slate-400 font-medium">{{ $day }}</span>
                        {!! $indicator !!}
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <!-- Tab Content: Table -->
    <div x-show="mode === 'table'" x-cloak class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 dark:border-slate-800">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 dark:border-slate-800">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 dark:border-slate-800">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($absensi as $item)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="px-6 py-4 text-sm font-medium text-slate-700 dark:text-slate-300">
                                {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $badgeClass = match($item->status) {
                                        'hadir' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                        'sakit' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                        'izin' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                        'alpa' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                        default => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-400'
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $badgeClass }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">
                                {{ $item->keterangan ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                                <span class="material-symbols-outlined text-4xl mb-2 opacity-20">event_busy</span>
                                <p>Belum ada riwayat kehadiran.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection
