@extends('layouts.student')

@section('title', 'Student Dashboard')
@section('header_title', 'Dashboard')

@section('content')
<!-- Welcome Hero -->
<div class="relative overflow-hidden bg-brand-soft rounded-[2.5rem] p-12 flex flex-col md:flex-row items-center gap-12 border border-brand-primary/5 shadow-sm">
    <div class="absolute -top-24 -right-24 w-64 h-64 bg-brand-primary/10 rounded-full blur-3xl opacity-50"></div>
    <div class="absolute -bottom-12 -left-12 w-48 h-48 bg-brand-primary/5 rounded-full blur-2xl opacity-50"></div>
    
    <div class="relative z-10 flex-1">
        <h2 class="text-3xl font-bold text-slate-900 dark:text-slate-100 mb-2">Halo, Selamat Datang di TK Harapan Bangsa 2!</h2>
        <p class="text-slate-600 dark:text-slate-400 text-lg mb-6">Senang melihatmu kembali hari ini, <strong>{{ $siswa->nama_lengkap }}</strong>!</p>
        
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

<!-- Notifikasi Lulus (Setelah Pengumuman Selesai) -->
@if($showPengumumanLulus && $isLulus)
<div class="mt-8 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl p-6 text-white shadow-lg">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-3xl">celebration</span>
            </div>
            <div>
                <h3 class="text-xl font-bold">Selamat! Kamu Lulus!</h3>
                <p class="text-white/80 text-sm">Pengumuman kelulusan sudah selesai. Selamat menjadi bagian dari TK Harapan Bangsa 1!</p>
            </div>
        </div>
        <a href="{{ route('pengumuman') }}" class="px-6 py-3 bg-white text-green-600 rounded-xl font-bold hover:bg-white/90 transition-colors flex items-center gap-2">
            <span class="material-symbols-outlined">visibility</span>
            <span>Lihat Pengumuman</span>
        </a>
    </div>
</div>
@endif

<!-- Notifikasi Tidak Lulus -->
@if($showPengumumanLulus && !$isLulus && $spmb)
<div class="mt-8 bg-gradient-to-r from-slate-500 to-slate-600 rounded-xl p-6 text-white shadow-lg">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-3xl">info</span>
            </div>
            <div>
                <h3 class="text-xl font-bold">Pengumuman Selesai</h3>
                <p class="text-white/80 text-sm">Mohon maaf, kamu belum lulus pada tahun ini. Sampai jumpa di tahun depan!</p>
            </div>
        </div>
        <a href="{{ route('pengumuman') }}" class="px-6 py-3 bg-white text-slate-600 rounded-xl font-bold hover:bg-white/90 transition-colors flex items-center gap-2">
            <span class="material-symbols-outlined">visibility</span>
            <span>Lihat Pengumuman</span>
        </a>
    </div>
</div>
@endif

<!-- PPDB Status Card -->
@if(!$siswa->spmb_id)
<div class="mt-8 bg-gradient-to-r from-amber-500 to-orange-500 rounded-xl p-6 text-white">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-3xl">assignment</span>
            </div>
            <div>
                <h3 class="text-xl font-bold">Belum Melakukan PPDB</h3>
                <p class="text-white/80 text-sm">Daftarkan diri kamu untuk tahun ajaran yang akan datang</p>
            </div>
        </div>
        <a href="{{ route('ppdb.index') }}" class="px-8 py-3 bg-white text-amber-600 rounded-xl font-bold hover:bg-white/90 transition-colors flex items-center gap-2">
            <span>Daftar PPDB</span>
            <span class="material-symbols-outlined">arrow_forward</span>
        </a>
    </div>
</div>
@else
@php
    $spmb = $siswa->spmb;
@endphp
<div class="mt-8 bg-white dark:bg-slate-900 rounded-xl p-6 border border-slate-200 dark:border-slate-800">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold">Status PPDB</h3>
        <span class="px-3 py-1 rounded-full text-xs font-bold @if($spmb->status_pendaftaran == 'Lulus') bg-green-100 text-green-700 @elseif($spmb->status_pendaftaran == 'Tidak Lulus') bg-red-100 text-red-700 @elseif($spmb->status_pendaftaran == 'Dokumen Verified') bg-blue-100 text-blue-700 @else bg-yellow-100 text-yellow-700 @endif">
            {{ $spmb->status_pendaftaran }}
        </span>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="p-4 bg-slate-50 dark:bg-slate-800 rounded-lg">
            <p class="text-xs text-slate-500 font-medium">No. Pendaftaran</p>
            <p class="font-bold text-slate-900 dark:text-slate-100">{{ $spmb->no_pendaftaran ?? '-' }}</p>
        </div>
        <div class="p-4 bg-slate-50 dark:bg-slate-800 rounded-lg">
            <p class="text-xs text-slate-500 font-medium">Nama Lengkap</p>
            <p class="font-bold text-slate-900 dark:text-slate-100">{{ $spmb->nama_lengkap_anak ?? '-' }}</p>
        </div>
        <div class="p-4 bg-slate-50 dark:bg-slate-800 rounded-lg">
            <p class="text-xs text-slate-500 font-medium">Tahun Ajaran</p>
            <p class="font-bold text-slate-900 dark:text-slate-100">{{ $spmb->tahunAjaran->tahun_ajaran ?? '-' }}</p>
        </div>
    </div>
    <div class="mt-4 flex gap-3">
        <a href="{{ route('siswa.ppdb.hasil-seleksi') }}" class="flex-1 py-2.5 bg-primary text-white rounded-lg font-medium text-center hover:bg-primary/90 transition-colors">
            Lihat Detail PPDB
        </a>
    </div>
</div>
@endif

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

        <!-- New: Latest Materials -->
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold">Materi KBM Terbaru</h3>
                <a class="text-primary text-sm font-semibold hover:underline" href="{{ route('siswa.materi.index') }}">Lihat Semua</a>
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
        @else
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold">Materi KBM Terbaru</h3>
            </div>
            <div class="bg-amber-50 dark:bg-amber-900/20 p-6 rounded-xl border border-amber-200 dark:border-amber-800 text-center text-amber-700 dark:text-amber-400">
                <span class="material-symbols-outlined text-4xl mb-2">lock</span>
                <p class="font-medium">Materi Pelajaran Belum Tersedia</p>
                <p class="text-sm mt-1">Materi pembelajaran akan ditampilkan setelah pendaftaran kamu diverifikasi dan dinyatakan lulus.</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Today's Schedule -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="text-xl font-bold">Jadwal Hari Ini</h3>
            <span class="text-sm font-medium text-slate-500">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM') }}</span>
        </div>
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 divide-y divide-slate-100 dark:divide-slate-800">
            @forelse($todaySchedule as $item)
                <div class="p-4 flex items-center gap-4 {{ $loop->index % 2 != 0 ? 'bg-primary/5' : '' }}">
                    <div class="text-center w-14">
                        <p class="text-sm font-bold text-primary">{{ date('H:i', strtotime($item->jam_mulai)) }}</p>
                        <p class="text-[10px] text-slate-400 uppercase">Pagi</p>
                    </div>
                    <div class="h-10 w-[2px] bg-slate-100 dark:bg-slate-800"></div>
                    <div class="flex-1">
                        <p class="text-sm font-bold">{{ $item->mata_pelajaran }}</p>
                        <p class="text-xs text-slate-500">{{ $item->guru ?? 'Guru belum ditentukan' }}</p>
                    </div>
                    @if($item->lokasi)
                        <div class="hidden sm:flex items-center gap-1 text-[10px] text-slate-400">
                            <span class="material-symbols-outlined text-[14px]">location_on</span>
                            {{ $item->lokasi }}
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
    @else
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="text-xl font-bold">Jadwal Hari Ini</h3>
            <span class="text-sm font-medium text-slate-500">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM') }}</span>
        </div>
        <div class="bg-amber-50 dark:bg-amber-900/20 p-6 rounded-xl border border-amber-200 dark:border-amber-800 text-center text-amber-700 dark:text-amber-400">
            <span class="material-symbols-outlined text-4xl mb-2">event_busy</span>
            <p class="font-medium">Jadwal Belum Tersedia</p>
            <p class="text-sm mt-1">Jadwal pelajaran akan muncul setelah pendaftaran kamu diverifikasi dan kamu dimasukkan ke dalam kelas.</p>
        </div>
    </div>
    @endif
</div>
@endsection
