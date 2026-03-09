@extends('layouts.student')

@section('title', 'Kalender Akademik')
@section('header_title', 'Tanggal Akademik')

@section('content')
<div class="space-y-12">
    <!-- Page Title & Actions -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-12">
        <div>
            <span class="text-[9px] font-extrabold uppercase tracking-[.3em] text-brand-primary mb-2 block">Akademik</span>
            <h1 class="text-4xl font-extrabold text-brand-dark uppercase tracking-tighter leading-none mb-4">Kalender Akademik</h1>
            <p class="text-[10px] font-extrabold text-stone-300 uppercase tracking-widest">{{ $currentMonth->translatedFormat('F Y') }} - Jadwal Kegiatan & Libur</p>
        </div>
        <a href="{{ route('siswa.kalender.download-pdf', ['month' => $month, 'year' => $year]) }}" class="px-8 py-4 flex items-center gap-3 rounded-[2rem] bg-brand-dark text-white font-extrabold text-[10px] uppercase tracking-[0.2em] shadow-xl shadow-brand-dark/10 hover:bg-brand-primary transition-all active:scale-95">
            <span class="material-symbols-outlined text-xl">picture_as_pdf</span>
            <span>Download PDF</span>
        </a>
    </div>

    <div class="grid grid-cols-1 gap-12 lg:grid-cols-4">
        <!-- Main Calendar -->
        <div class="space-y-12 lg:col-span-3">
            <div class="bg-white rounded-[2.5rem] border border-stone-100 shadow-xl shadow-stone-200/30 p-10">
                <!-- Calendar Navigation -->
                <div class="flex items-center justify-between mb-10 pb-6 border-b border-stone-50">
                    <div class="flex items-center gap-6">
                        <h4 class="text-2xl font-extrabold text-brand-dark uppercase tracking-tight">{{ $currentMonth->translatedFormat('F Y') }}</h4>
                        <div class="flex gap-2">
                            <a href="{{ route('siswa.kalender.index', ['month' => $prevMonth->month, 'year' => $prevMonth->year]) }}" class="size-10 flex items-center justify-center bg-stone-50 rounded-xl text-stone-300 hover:text-brand-primary transition-colors">
                                <span class="material-symbols-outlined">chevron_left</span>
                            </a>
                            <a href="{{ route('siswa.kalender.index', ['month' => $nextMonth->month, 'year' => $nextMonth->year]) }}" class="size-10 flex items-center justify-center bg-stone-50 rounded-xl text-stone-300 hover:text-brand-primary transition-colors">
                                <span class="material-symbols-outlined">chevron_right</span>
                            </a>
                        </div>
                    </div>
                    <a href="{{ route('siswa.kalender.index') }}" class="px-6 py-2.5 text-[9px] font-extrabold text-brand-primary uppercase tracking-[0.2em] bg-brand-soft rounded-full">Bulan Ini</a>
                </div>

                <!-- Grid Calendar -->
                <div class="grid grid-cols-7 gap-px bg-stone-50 border border-stone-50 rounded-2xl overflow-hidden">
                    <!-- Days Header -->
                    @foreach(['MIN', 'SEN', 'SEL', 'RAB', 'KAM', 'JUM', 'SAB'] as $dayName)
                        <div class="bg-stone-50/50 py-4 text-center text-[9px] font-extrabold text-stone-300 uppercase tracking-widest">{{ $dayName }}</div>
                    @endforeach

                    @foreach ($days as $day)
                        @php
                            $isSunday = $day['date']->dayOfWeek == \Carbon\Carbon::SUNDAY;
                            $textColor = $day['isCurrentMonth'] ? ($isSunday ? 'text-red-400' : 'text-brand-dark') : 'text-stone-200';
                        @endphp
                        <div class="bg-white min-h-[9rem] p-4 font-medium {{ $textColor }} {{ $day['isToday'] ? 'bg-brand-soft/20' : '' }} group transition-colors hover:bg-stone-50/30">
                            <div class="flex flex-col h-full">
                                <div class="flex items-center justify-between mb-2">
                                    @if($day['isToday'])
                                        <span class="bg-brand-dark text-white size-8 flex items-center justify-center rounded-xl text-[10px] font-extrabold shadow-lg shadow-brand-dark/20">{{ $day['date']->day }}</span>
                                    @else
                                        <span class="text-[10px] font-bold">{{ $day['date']->day }}</span>
                                    @endif
                                    @if($isSunday)
                                        <span class="text-[8px] font-extrabold uppercase tracking-tighter opacity-30">Libur</span>
                                    @endif
                                </div>

                                <div class="space-y-1.5 mt-1">
                                    @foreach ($day['events'] as $event)
                                        @php
                                            $classes = $event->tailwind_classes;
                                            // Handle mapping brand colors to existing categories
                                            $catColor = match($event->kategori) {
                                                'Libur Nasional' => 'bg-red-50 text-red-500 border-red-200',
                                                'Ujian' => 'bg-brand-soft text-brand-primary border-brand-primary/20',
                                                'Kegiatan Sekolah' => 'bg-emerald-50 text-emerald-500 border-emerald-200',
                                                'Rapat Guru' => 'bg-amber-50 text-amber-500 border-amber-200',
                                                default => 'bg-stone-50 text-stone-400 border-stone-200'
                                            };
                                        @endphp
                                        <div class="px-2 py-1.5 {{ $catColor }} text-[8px] rounded-lg border font-extrabold tracking-tight leading-tight truncate uppercase transition-all hover:scale-105 shadow-sm" title="{{ $event->judul }}">
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
            <div class="flex flex-wrap gap-8 p-8 bg-white rounded-[2rem] border border-stone-100 shadow-sm">
                @foreach($daftarKategori as $key => $kat)
                    @php
                        $colorClass = match($key) {
                            'Libur Nasional' => 'bg-red-500 shadow-red-500/20',
                            'Ujian' => 'bg-brand-primary shadow-brand-primary/20',
                            'Kegiatan Sekolah' => 'bg-emerald-500 shadow-emerald-500/20',
                            'Rapat Guru' => 'bg-amber-500 shadow-amber-500/20',
                            default => 'bg-stone-400 shadow-stone-400/20'
                        };
                    @endphp
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full {{ $colorClass }} shadow-lg"></div>
                        <span class="text-[10px] font-extrabold text-stone-400 uppercase tracking-widest">{{ str_replace(['🔴 ', '🟣 ', '🔵 ', '🟠 ', '⚪ '], '', $kat['label']) }}</span>
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
            <div class="space-y-8">
                <div class="flex items-center justify-between border-b border-stone-100 pb-6">
                    <div>
                        <span class="text-[9px] font-extrabold uppercase tracking-[.2em] text-stone-300 block mb-1">Daftar Agenda</span>
                        <h4 class="text-2xl font-extrabold text-brand-dark uppercase tracking-tight">{{ $currentMonth->translatedFormat('F Y') }}</h4>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach($allEvents as $event)
                        @php 
                            $catBadge = match($event->kategori) {
                                'Libur Nasional' => 'bg-red-50 text-red-500 shadow-sm border-red-50',
                                'Ujian' => 'bg-brand-soft text-brand-primary shadow-sm border-brand-soft',
                                'Kegiatan Sekolah' => 'bg-emerald-50 text-emerald-500 shadow-sm border-emerald-50',
                                'Rapat Guru' => 'bg-amber-50 text-amber-500 shadow-sm border-amber-50',
                                default => 'bg-stone-50 text-stone-400 shadow-sm border-stone-50'
                            };
                        @endphp
                        <div class="group bg-white p-8 rounded-[2.5rem] border border-stone-100 hover:border-brand-primary/10 hover:shadow-xl hover:shadow-stone-200/40 transition-all">
                            <div class="flex items-center gap-3 mb-6">
                                <span class="px-4 py-1.5 rounded-full text-[8px] font-extrabold uppercase tracking-widest {{ $catBadge }}">
                                    {{ $event->kategori }}
                                </span>
                            </div>
                            <h4 class="text-lg font-extrabold text-brand-dark uppercase tracking-tight mb-2 group-hover:text-brand-primary transition-colors">{{ $event->judul }}</h4>
                            <p class="text-[10px] font-bold text-stone-400 uppercase leading-relaxed line-clamp-2 mb-6">{{ $event->deskripsi ?: 'Tidak ada deskripsi agenda.' }}</p>
                            
                            <div class="pt-6 border-t border-stone-50 flex items-center gap-3 text-[9px] font-extrabold text-stone-300 uppercase tracking-widest">
                                <span class="material-symbols-outlined text-base">calendar_month</span>
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
        <div class="space-y-12">
            <div class="bg-brand-primary rounded-[2.5rem] p-10 text-white relative overflow-hidden group shadow-xl shadow-brand-primary/20">
                <div class="absolute -top-12 -right-12 w-32 h-32 bg-white/20 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                <div class="relative z-10">
                    <span class="text-[9px] font-extrabold uppercase tracking-[0.4em] opacity-80 mb-6 block">Motivasi</span>
                    <h5 class="text-2xl font-extrabold uppercase tracking-tight leading-tight mb-4">Semangat<br>Belajar!</h5>
                    <p class="text-[10px] font-bold uppercase tracking-widest opacity-70 leading-relaxed">Selalu cek kalender akademik agar tidak ketinggalan kegiatan seru di sekolah!</p>
                </div>
            </div>

            <div class="bg-brand-soft rounded-[2.5rem] p-10 border border-brand-primary/5">
                <div class="flex items-center gap-4 mb-6">
                    <div class="size-10 rounded-xl bg-brand-primary/10 flex items-center justify-center text-brand-primary">
                        <span class="material-symbols-outlined text-xl">lightbulb</span>
                    </div>
                    <span class="text-[10px] font-extrabold text-brand-dark uppercase tracking-widest">Info Penting</span>
                </div>
                <p class="text-[10px] font-bold text-brand-primary uppercase tracking-widest leading-relaxed opacity-70">
                    Pastikan untuk selalu memantau pengumuman terbaru di dashboard terkait perubahan jadwal kegiatan atau libur tambahan.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
