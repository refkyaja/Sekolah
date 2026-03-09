@extends('layouts.student')

@section('title', 'Dashboard Siswa')
@section('header_title', 'Dashboard Siswa')

@section('content')
<!-- Welcome Hero -->
<div class="relative overflow-hidden bg-primary/10 rounded-xl p-8 flex flex-col md:flex-row items-center gap-8">
    <div class="absolute top-0 right-0 w-64 h-64 bg-primary/20 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl"></div>
    <div class="relative z-10 flex-1">
        <h2 class="text-3xl font-bold text-slate-900 dark:text-slate-100 mb-2">Halo, Selamat Datang di TK Harapan Bangsa 1!</h2>
        <p class="text-slate-600 dark:text-slate-400 text-lg mb-6">Senang melihatmu kembali hari ini, <strong>{{ $siswa->nama_lengkap }}</strong>!</p>
        
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-xl text-sm border border-green-100 flex items-center gap-3">
                <span class="material-symbols-outlined">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif
    </div>
    <div class="relative z-10 w-48 h-48 bg-cover bg-center rounded-2xl shadow-xl border-4 border-white" style="background-image: url('{{ $siswa->foto ?? 'https://ui-avatars.com/api/?name=' . urlencode($siswa->nama_lengkap) . '&size=200' }}');"></div>
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

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">
    <!-- Latest Announcements -->
    <div class="lg:col-span-2 space-y-8">
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold">Pengumuman Terbaru</h3>
                <a class="text-primary text-sm font-semibold hover:underline" href="#">Lihat Semua</a>
            </div>
            <div class="space-y-4">
                @forelse($pengumuman as $item)
                    <div class="bg-white dark:bg-slate-900 p-5 rounded-xl border border-slate-200 dark:border-slate-800 hover:shadow-md transition-shadow cursor-pointer flex gap-4">
                        <div class="size-12 bg-primary/10 text-primary rounded-xl flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-3xl">campaign</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 dark:text-slate-100">{{ $item->judul }}</h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1 line-clamp-2">{{ strip_tags($item->isi_berita) }}</p>
                            <div class="flex items-center gap-3 mt-3">
                                <span class="text-[10px] bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded font-bold text-slate-500 uppercase">{{ $item->tanggal_publish->diffForHumans() }}</span>
                                <span class="text-[10px] bg-primary/10 text-primary px-2 py-1 rounded font-bold uppercase">BERITA</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-slate-900 p-8 rounded-xl border border-slate-200 dark:border-slate-800 text-center text-slate-500">
                        Belum ada pengumuman terbaru.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- New: Latest Materials -->
        @if($siswa->status_siswa == 'aktif')
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold">Materi KBM Terbaru</h3>
                <a class="text-primary text-sm font-semibold hover:underline" href="{{ route('siswa.materi.index') }}">Lihat Semua</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @forelse($materiTerbaru as $materi)
                    <a href="{{ route('siswa.materi.download', $materi) }}" class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 hover:shadow-md transition-shadow flex items-center gap-4 group">
                        @php
                            $icon = match($materi->file_type) {
                                'PDF Document' => 'picture_as_pdf',
                                'PowerPoint' => 'present_to_all',
                                'Word Document' => 'description',
                                'Video' => 'videocam',
                                'Gambar' => 'image',
                                default => 'attach_file'
                            };
                            $iconColor = match($materi->file_type) {
                                'PDF Document' => 'text-red-500',
                                'PowerPoint' => 'text-orange-500',
                                'Word Document' => 'text-blue-500',
                                'Video' => 'text-purple-500',
                                'Gambar' => 'text-emerald-500',
                                default => 'text-slate-500'
                            };
                        @endphp
                        <div class="size-10 rounded-lg bg-slate-50 dark:bg-slate-800 flex items-center justify-center {{ $iconColor }}">
                            <span class="material-symbols-outlined text-2xl">{{ $icon }}</span>
                        </div>
                        <div class="overflow-hidden">
                            <h4 class="font-bold text-sm text-slate-900 dark:text-slate-100 truncate">{{ $materi->judul_materi }}</h4>
                            <p class="text-[10px] text-slate-500 uppercase font-bold tracking-wider">{{ $materi->mata_pelajaran }}</p>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full bg-slate-50 dark:bg-slate-800/50 p-6 rounded-xl border border-dashed border-slate-200 dark:border-slate-800 text-center text-slate-500 text-sm">
                        Belum ada materi pembelajaran baru.
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
    @if($siswa->status_siswa == 'aktif')
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
                    @endif
                </div>
            @empty
                <div class="p-8 text-center text-slate-500 text-sm italic">
                    Tidak ada jadwal untuk hari ini.
                </div>
            @endforelse
        </div>
        <a href="{{ route('siswa.jadwal.index') }}" class="w-full py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-50 transition-colors flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-lg">calendar_month</span>
            <span>Lihat Jadwal Lengkap</span>
        </a>
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

<!-- Quick Access / Categories -->

@endsection
