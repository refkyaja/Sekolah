@extends('layouts.student')

@section('title', 'Student Dashboard')
@section('header_title', 'Dashboard')

@section('content')
<!-- Welcome Hero -->
<div class="relative overflow-hidden bg-brand-soft rounded-[2.5rem] p-12 flex flex-col md:flex-row items-center gap-12 border border-brand-primary/5 shadow-sm">
    <div class="absolute -top-24 -right-24 w-64 h-64 bg-brand-primary/10 rounded-full blur-3xl opacity-50"></div>
    <div class="absolute -bottom-12 -left-12 w-48 h-48 bg-brand-primary/5 rounded-full blur-2xl opacity-50"></div>
    
    <div class="relative z-10 flex-1">
        <span class="text-[10px] font-extrabold uppercase tracking-[.3em] text-brand-primary mb-4 block">Selamat Datang</span>
        <h2 class="text-4xl lg:text-5xl font-extrabold text-brand-dark uppercase tracking-tighter leading-none mb-4">
            Halo, <br> {{ explode(' ', $siswa->nama_lengkap)[0] }}!
        </h2>
        <p class="text-stone-400 text-xs font-bold uppercase tracking-widest leading-relaxed max-w-md">
            Senang melihatmu kembali hari ini di TK Harapan Bangsa 1. Mari kita belajar hal baru bersama-sama!
        </p>
        
        @if(session('success'))
            <div class="mt-8 p-4 bg-white/80 backdrop-blur-md rounded-2xl border border-brand-primary/10 flex items-center gap-3 animate-fade-in shadow-sm">
                <div class="size-8 bg-brand-primary/10 rounded-full flex items-center justify-center text-brand-primary">
                    <span class="material-symbols-outlined text-sm">check_circle</span>
                </div>
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-brand-dark">{{ session('success') }}</span>
            </div>
        @endif
    </div>
    
    <div class="relative z-10 group">
        <div class="absolute -inset-4 bg-brand-primary/10 rounded-[3rem] blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        <div class="relative w-56 h-56 bg-stone-100 rounded-[2.5rem] shadow-2xl border-8 border-white overflow-hidden transform group-hover:scale-105 transition-transform duration-700">
            <img src="{{ $siswa->foto ?? 'https://ui-avatars.com/api/?name=' . urlencode($siswa->nama_lengkap) . '&size=400' }}" 
                 class="w-full h-full object-cover" 
                 alt="{{ $siswa->nama_lengkap }}">
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-12 mt-12">
    <!-- Main Content (Announcements & Materials) -->
    <div class="lg:col-span-2 space-y-12">
        <!-- Announcements -->
        <div class="space-y-8">
            <div class="flex items-center justify-between border-b border-stone-100 pb-6">
                <div>
                    <span class="text-[9px] font-extrabold uppercase tracking-[.2em] text-stone-300 block mb-1">Penting</span>
                    <h3 class="text-2xl font-extrabold text-brand-dark uppercase tracking-tight">Pengumuman</h3>
                </div>
                <a class="text-[10px] font-extrabold text-brand-primary uppercase tracking-widest hover:underline" href="#">Lihat Semua</a>
            </div>
            
            <div class="space-y-6">
                @forelse($pengumuman as $item)
                    <div class="group bg-white rounded-[2rem] p-8 border border-stone-100 hover:border-brand-primary/10 hover:shadow-xl hover:shadow-stone-200/50 transition-all cursor-pointer flex gap-8">
                        <div class="size-16 bg-brand-soft text-brand-primary rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-3xl">campaign</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="text-[9px] font-extrabold uppercase tracking-widest text-brand-primary bg-brand-soft px-3 py-1 rounded-full">Berita</span>
                                <span class="text-[9px] font-bold text-stone-300 uppercase tracking-widest">{{ $item->tanggal_publish->diffForHumans() }}</span>
                            </div>
                            <h4 class="text-xl font-extrabold text-brand-dark uppercase tracking-tight mb-2 group-hover:text-brand-primary transition-colors">{{ $item->judul }}</h4>
                            <p class="text-[11px] font-bold text-stone-400 uppercase leading-relaxed line-clamp-2">{{ strip_tags($item->isi_berita) }}</p>
                        </div>
                    </div>
                @empty
                    <div class="bg-stone-50 rounded-[2rem] p-12 text-center border-2 border-dashed border-stone-100">
                        <span class="material-symbols-outlined text-4xl text-stone-200 mb-4 block">inbox</span>
                        <p class="text-[10px] font-bold text-stone-300 uppercase tracking-widest">Belum ada pengumuman terbaru</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Materials -->
        <div class="space-y-8">
            <div class="flex items-center justify-between border-b border-stone-100 pb-6">
                <div>
                    <span class="text-[9px] font-extrabold uppercase tracking-[.2em] text-stone-300 block mb-1">Pembelajaran</span>
                    <h3 class="text-2xl font-extrabold text-brand-dark uppercase tracking-tight">Materi KBM</h3>
                </div>
                <a class="text-[10px] font-extrabold text-brand-primary uppercase tracking-widest hover:underline" href="{{ route('siswa.materi.index') }}">Lihat Semua</a>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @forelse($materiTerbaru as $materi)
                    <a href="{{ route('siswa.materi.download', $materi) }}" class="group bg-white p-6 rounded-[2rem] border border-stone-100 hover:border-brand-primary/10 hover:shadow-xl hover:shadow-stone-200/40 transition-all flex items-center gap-6">
                        @php
                            $icon = match($materi->file_type) {
                                'PDF Document' => 'picture_as_pdf',
                                'PowerPoint' => 'present_to_all',
                                'Word Document' => 'description',
                                'Video' => 'videocam',
                                'Gambar' => 'image',
                                default => 'attach_file'
                            };
                        @endphp
                        <div class="size-14 rounded-2xl bg-stone-50 group-hover:bg-brand-soft flex items-center justify-center text-stone-400 group-hover:text-brand-primary transition-colors">
                            <span class="material-symbols-outlined text-3xl">{{ $icon }}</span>
                        </div>
                        <div class="overflow-hidden">
                            <span class="text-[8px] font-extrabold text-stone-300 uppercase tracking-[.3em] block mb-1">{{ $materi->mata_pelajaran }}</span>
                            <h4 class="text-sm font-extrabold text-brand-dark uppercase tracking-tight truncate">{{ $materi->judul_materi }}</h4>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full bg-stone-50 rounded-[2rem] p-12 text-center border-2 border-dashed border-stone-100">
                        <p class="text-[10px] font-bold text-stone-300 uppercase tracking-widest">Belum ada materi pembelajaran baru</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Sidebar (Today's Schedule) -->
    <div class="space-y-8">
        <div class="bg-white rounded-[2.5rem] p-8 border border-stone-100 shadow-xl shadow-stone-200/30">
            <div class="flex items-center justify-between mb-10">
                <h3 class="text-xl font-extrabold text-brand-dark uppercase tracking-tight">Jadwal<br>Hari Ini</h3>
                <div class="text-right">
                    <p class="text-[9px] font-extrabold text-brand-primary uppercase tracking-widest">{{ \Carbon\Carbon::now()->isoFormat('dddd') }}</p>
                    <p class="text-[8px] font-bold text-stone-300 uppercase tracking-widest mt-1">{{ \Carbon\Carbon::now()->isoFormat('D MMMM') }}</p>
                </div>
            </div>
            
            <div class="space-y-8">
                @forelse($todaySchedule as $item)
                    <div class="flex items-start gap-6 relative group">
                        @if(!$loop->last)
                            <div class="absolute left-[1.15rem] top-10 bottom-[-2rem] w-[2px] bg-stone-50"></div>
                        @endif
                        <div class="size-10 rounded-xl bg-brand-soft flex items-center justify-center text-brand-primary flex-shrink-0 z-10 border border-brand-primary/10">
                            <span class="text-[10px] font-extrabold">{{ date('H:i', strtotime($item->jam_mulai)) }}</span>
                        </div>
                        <div class="flex-1 pt-1">
                            <h4 class="text-sm font-extrabold text-brand-dark uppercase tracking-tight">{{ $item->mata_pelajaran }}</h4>
                            <p class="text-[9px] font-bold text-stone-400 uppercase tracking-widest mt-1">{{ $item->guru ?? 'Guru belum ditentukan' }}</p>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center">
                        <span class="material-symbols-outlined text-stone-100 text-5xl mb-4 block">event_note</span>
                        <p class="text-[9px] font-bold text-stone-300 uppercase tracking-[.2em] leading-relaxed">Tidak ada jadwal<br>untuk hari ini</p>
                    </div>
                @endforelse
            </div>
            
            <a href="{{ route('siswa.jadwal.index') }}" class="mt-12 w-full py-5 bg-brand-dark text-white rounded-2xl text-[10px] font-extrabold uppercase tracking-[.3em] hover:bg-brand-primary transition-all flex items-center justify-center gap-3 shadow-xl shadow-brand-dark/10">
                <span class="material-symbols-outlined text-lg">calendar_month</span>
                <span>Lihat Kalender</span>
            </a>
        </div>

        <!-- Quick Info Card -->
        <div class="bg-brand-primary rounded-[2.5rem] p-8 text-white relative overflow-hidden group">
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-white/20 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
            <div class="relative z-10">
                <span class="text-[10px] font-extrabold uppercase tracking-[.4em] opacity-80 mb-4 block">Pengingat</span>
                <h4 class="text-xl font-extrabold uppercase tracking-tight leading-tight mb-4">Jangan lupa jaga kesehatan ya!</h4>
                <p class="text-[9px] font-bold uppercase tracking-widest opacity-70 leading-relaxed">Istirahat cukup dan makan makanan bergizi agar selalu ceria saat belajar.</p>
            </div>
        </div>
    </div>
</div>
@endsection
