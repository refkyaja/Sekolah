@extends('layouts.student')

@section('title', 'Kalender Akademik')
@section('header_title', 'Tanggal Akademik')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    <!-- Page Title & Actions -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h3 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">Kalender Akademik</h3>
            <p class="text-slate-500 mt-1">Lihat jadwal kegiatan dan libur sekolah periode {{ $currentMonth->translatedFormat('F Y') }}</p>
        </div>
        <a href="{{ route('siswa.kalender.download-pdf', ['month' => $month, 'year' => $year]) }}" class="flex items-center justify-center gap-2 px-6 py-3 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/25 hover:bg-primary/90 transition-all">
            <span class="material-symbols-outlined text-lg">picture_as_pdf</span>
            <span>Download PDF Kalender</span>
        </a>
    </div>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-4">
        <!-- Main Calendar -->
        <div class="space-y-6 lg:col-span-3">
            <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 p-6">
                <!-- Calendar Navigation -->
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-4">
                        <h4 class="text-xl font-bold">{{ $currentMonth->translatedFormat('F Y') }}</h4>
                        <div class="flex gap-1">
                            <a href="{{ route('siswa.kalender.index', ['month' => $prevMonth->month, 'year' => $prevMonth->year]) }}" class="p-1.5 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg text-slate-600 transition-colors border border-slate-200 dark:border-slate-700">
                                <span class="material-symbols-outlined text-sm">chevron_left</span>
                            </a>
                            <a href="{{ route('siswa.kalender.index', ['month' => $nextMonth->month, 'year' => $nextMonth->year]) }}" class="p-1.5 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg text-slate-600 transition-colors border border-slate-200 dark:border-slate-700">
                                <span class="material-symbols-outlined text-sm">chevron_right</span>
                            </a>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('siswa.kalender.index') }}" class="px-4 py-1.5 text-xs font-bold bg-slate-100 dark:bg-slate-800 rounded-lg">Bulan Ini</a>
                    </div>
                </div>

                <!-- Grid Calendar -->
                <div class="grid grid-cols-7 gap-px bg-slate-100 dark:bg-slate-800 border border-slate-100 dark:border-slate-800 rounded-lg overflow-hidden">
                    <!-- Days Header -->
                    @foreach(['MIN', 'SEN', 'SEL', 'RAB', 'KAM', 'JUM', 'SAB'] as $dayName)
                        <div class="bg-slate-50 dark:bg-slate-800 py-3 text-center text-xs font-bold text-slate-400">{{ $dayName }}</div>
                    @endforeach

                    @foreach ($days as $day)
                        @php
                            $isSunday = $day['date']->dayOfWeek == \Carbon\Carbon::SUNDAY;
                            $textColor = $day['isCurrentMonth'] ? ($isSunday ? 'text-red-500' : 'text-slate-900 dark:text-white') : 'text-slate-300';
                        @endphp
                        <div class="bg-white dark:bg-slate-900 min-h-24 p-2 font-medium {{ $textColor }} {{ $day['isToday'] ? 'bg-primary/5' : '' }}">
                            <div class="flex flex-col h-full">
                                @if($day['isToday'])
                                    <span class="bg-primary text-white size-6 flex items-center justify-center rounded-full text-xs">{{ $day['date']->day }}</span>
                                @else
                                    <span class="text-xs">{{ $day['date']->day }}</span>
                                @endif

                                <div class="mt-1 space-y-1">
                                    @foreach ($day['events'] as $event)
                                        @php
                                            $classes = $event->tailwind_classes;
                                        @endphp
                                        <div class="p-1 {{ $classes['bg'] }} {{ $classes['text'] }} text-[10px] rounded border-l-2 {{ str_replace('bg-', 'border-', $classes['dot']) }} font-bold leading-tight truncate" title="{{ $event->judul }}">
                                            {{ $event->judul }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Legend -->
            <div class="flex flex-wrap gap-6 p-4 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800">
                @foreach($daftarKategori as $key => $kat)
                    @php
                        $dotColor = match($key) {
                            'Libur Nasional' => 'bg-red-500',
                            'Ujian' => 'bg-primary',
                            'Kegiatan Sekolah' => 'bg-blue-500',
                            'Rapat Guru' => 'bg-orange-500',
                            default => 'bg-slate-400'
                        };
                    @endphp
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full {{ $dotColor }}"></div>
                        <span class="text-xs font-medium">{{ str_replace(['🔴 ', '🟣 ', '🔵 ', '🟠 ', '⚪ '], '', $kat['label']) }}</span>
                    </div>
                @endforeach
            </div>

            <!-- Detailed Agenda List -->
            @php
                $allEvents = \App\Models\KalenderAkademik::inMonth($year, $month)
                    ->where('is_aktif', true)
                    ->orderBy('tanggal_mulai')
                    ->get();
            @endphp

            @if($allEvents->count() > 0)
            <div class="space-y-4">
                <h4 class="text-lg font-bold text-slate-800 dark:text-slate-200 px-2">Daftar Agenda {{ $currentMonth->translatedFormat('F Y') }}</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($allEvents as $event)
                        @php $classes = $event->tailwind_classes; @endphp
                        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 hover:shadow-md transition-shadow group">
                            <div class="flex items-start justify-between mb-3">
                                <div class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider {{ $classes['bg'] }} {{ $classes['text'] }}">
                                    {{ $event->kategori }}
                                </div>
                            </div>
                            <h4 class="font-bold text-slate-800 dark:text-slate-100 mb-1">{{ $event->judul }}</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 mb-3">{{ $event->deskripsi ?: 'Tidak ada deskripsi.' }}</p>
                            <div class="flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                <span class="material-symbols-outlined text-xs">calendar_month</span>
                                {{ $event->tanggal_mulai->translatedFormat('d M Y') }}
                                @if($event->tanggal_selesai)
                                    - {{ $event->tanggal_selesai->translatedFormat('d M Y') }}
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <div class="bg-primary/20 rounded-2xl p-6 relative overflow-hidden group">
                <div class="relative z-10">
                    <h5 class="text-primary font-black text-xl leading-tight mb-2">Semangat Belajar!</h5>
                    <p class="text-sm text-primary/80 mb-4 font-medium">Selalu cek kalender akademik agar tidak ketinggalan kegiatan seru!</p>
                </div>
                <div class="absolute -right-4 -bottom-4 size-24 bg-primary/30 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            </div>

            <div class="bg-yellow-50 dark:bg-yellow-900/10 border border-yellow-200 dark:border-yellow-900/30 rounded-xl p-5">
                <div class="flex items-center gap-3 mb-2">
                    <span class="material-symbols-outlined text-yellow-600">lightbulb</span>
                    <span class="font-bold text-yellow-800 dark:text-yellow-400">Info Penting</span>
                </div>
                <p class="text-xs text-yellow-700 dark:text-yellow-500/80 leading-relaxed">
                    Pastikan untuk selalu memantau pengumuman terbaru di dashboard terkait perubahan jadwal kegiatan.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
