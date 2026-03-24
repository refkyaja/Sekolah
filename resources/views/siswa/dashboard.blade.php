@extends('layouts.siswa')

@section('title', 'Dashboard')

@section('content')
@php
    $currentStep  = $currentStep  ?? 1;
    $spmb         = $spmb         ?? null;
    $isLulus      = $isLulus      ?? false;
    $dokumenStatus = $dokumenStatus ?? ['akte' => 'pending', 'kk' => 'pending', 'ktp' => 'pending', 'bukti_pembayaran' => 'pending'];

    // Hitung label tahun ajaran
    $tahunAjaran = ($spmb && $spmb->tahunAjaran)
        ? $spmb->tahunAjaran->tahun_ajaran
        : (date('Y') . '/' . (date('Y') + 1));
    
    $hasCatatan = $spmb && $spmb->catatan_admin;
    $heroTitle = 'Selamat datang di Dashboard Siswa';
    $heroBody = 'Silakan lengkapi formulir pendaftaran terlebih dahulu untuk memulai proses PPDB Anda di TK PGRI Harapan Bangsa 1.';
    $heroActionLabel = 'Isi Formulir';
    $heroActionUrl = route('siswa.formulir');
    $heroTone = 'from-primary via-fuchsia-600 to-violet-700';

    if ($spmb && !$spmb->dokumen_terunggah) {
        $heroTitle = 'Terima kasih telah mendaftar';
        $heroBody = 'Formulir Anda sudah kami terima. Sekarang silakan lanjutkan dengan mengunggah dokumen pendukung agar proses verifikasi dapat segera berjalan.';
        $heroActionLabel = 'Upload Dokumen';
        $heroActionUrl = route('siswa.dokumen');
        $heroTone = 'from-sky-600 via-primary to-indigo-700';
    } elseif ($spmb && $spmb->dokumen_terunggah) {
        $heroTitle = 'Terima kasih telah mendaftar di TK PGRI Harapan Bangsa 1';
        $heroBody = 'Formulir dan dokumen Anda sudah kami terima. Data Anda akan kami verifikasi, dan setiap perkembangan akan ditampilkan pada panel pembaruan.';
        $heroActionLabel = 'Lihat Pembaruan';
        $heroActionUrl = '#notification-system';
        $heroTone = 'from-emerald-600 via-teal-600 to-cyan-700';
    }

    if ($currentStep > 4) {
        $heroTitle = 'Pengumuman sudah tersedia';
        $heroBody = 'Terima kasih Bapak/Ibu telah mendampingi proses pendaftaran sampai tahap ini. Hasil seleksi sudah dapat dilihat pada halaman pengumuman. Apa pun hasilnya, kami menghargai kepercayaan dan partisipasi Bapak/Ibu dalam proses PPDB TK PGRI Harapan Bangsa 1.';
        $heroActionLabel = 'Lihat Pengumuman';
        $heroActionUrl = route('siswa.pengumuman');
        $heroTone = 'from-slate-700 via-slate-800 to-slate-900';
    }
@endphp

{{-- Header --}}
<header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h2 class="text-3xl font-bold tracking-tight">Dashboard</h2>
        <div class="flex items-center gap-2 mt-1">
            @if ($spmb)
                <span class="px-2 py-1 rounded bg-primary/10 text-primary text-xs font-bold">
                    {{ $spmb->no_pendaftaran }}
                </span>
            @endif
            <span class="text-sm text-slate-500">Tahun Ajaran {{ $tahunAjaran }}</span>
        </div>
    </div>
    
    <div class="flex items-center gap-3">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm group">
            <span class="material-symbols-outlined text-lg group-hover:-translate-x-0.5 transition-transform">arrow_back</span>
            Kembali ke Beranda
        </a>
    </div>
</header>

{{-- Notification Dropdown --}}
@if($hasCatatan)
<div id="notificationDropdown" class="hidden absolute right-8 top-20 w-80 bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-slate-200 dark:border-slate-700 z-50 overflow-hidden">
    <div class="p-4 bg-orange-50 dark:bg-orange-900/20 border-b border-orange-100 dark:border-orange-800">
        <h4 class="font-bold text-orange-800 dark:text-orange-200 flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">info</span>
            Catatan dari Admin
        </h4>
    </div>
    <div class="p-4">
        <p class="text-sm text-slate-600 dark:text-slate-300 mb-3">{{ $spmb->catatan_admin }}</p>
        @if($spmb->catatan_admin_at)
            <p class="text-xs text-slate-400">{{ $spmb->catatan_admin_at->format('d M Y, H:i') }}</p>
        @endif
    </div>
    <div class="p-3 bg-slate-50 dark:bg-slate-700/50 border-t border-slate-100 dark:border-slate-600">
        <a href="{{ route('siswa.dokumen') }}" class="text-sm text-primary font-bold hover:underline">
            Lihat Dokumen →
        </a>
    </div>
</div>
@endif

<script>
function toggleNotifications() {
    const dropdown = document.getElementById('notificationDropdown');
    if (dropdown) {
        dropdown.classList.toggle('hidden');
    }
}

document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('notificationDropdown');
    const button = document.querySelector('button[onclick="toggleNotifications()"]');
    if (dropdown && (!button || (!dropdown.contains(e.target) && !button.contains(e.target)))) {
        dropdown.classList.add('hidden');
    }
});
</script>

@if($isLulus)
{{-- Active Student Dashboard Content --}}
<section class="mb-8 overflow-hidden rounded-[2rem] bg-gradient-to-br from-indigo-600 via-primary to-violet-700 text-white shadow-2xl shadow-primary/20">
    <div class="flex flex-col gap-6 p-8 md:flex-row md:items-center md:justify-between">
        <div class="max-w-3xl">
            <p class="mb-3 text-xs font-black uppercase tracking-[0.35em] text-white/75">Portal Siswa Aktif</p>
            <h3 class="text-2xl font-black tracking-tight md:text-3xl">Selamat Belajar, {{ $siswa->nama_lengkap }}!</h3>
            <p class="mt-3 max-w-2xl text-sm leading-7 text-white/85 md:text-base">
                Anda terdaftar di {{ $siswa->kelas ?? 'Kelompok ' . ($siswa->kelompok ?? 'A') }}. 
                Gunakan dashboard ini untuk memantau kehadiran, materi KBM, dan jadwal pelajaran Anda.
            </p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('siswa.kehadiran') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-6 py-3 text-sm font-black uppercase tracking-widest text-slate-900 transition-all hover:-translate-y-0.5 hover:bg-slate-100">
                <span class="material-symbols-outlined text-lg">calendar_month</span>
                Absensi
            </a>
        </div>
    </div>
</section>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    {{-- Left Column: Schedule & Materials --}}
    <div class="lg:col-span-2 space-y-8">
        {{-- Today's Schedule --}}
        <section class="bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-sm border border-slate-200 dark:border-slate-800">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">schedule</span>
                    Jadwal Hari Ini
                </h3>
                <a href="{{ route('siswa.jadwal') }}" class="text-xs font-bold text-primary hover:underline uppercase tracking-wider">Lihat Semua</a>
            </div>
            
            <div class="space-y-4">
                @forelse($todaySchedule as $item)
                    <div class="flex items-center justify-between p-4 rounded-2xl border border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50 hover:border-primary/20 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-bold text-xs">
                                {{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800 dark:text-white">{{ $item->mata_pelajaran }}</p>
                                <p class="text-xs text-slate-500">{{ $item->guru ?? 'Guru Pengajar' }} • {{ $item->lokasi ?? 'Ruang Kelas' }}</p>
                            </div>
                        </div>
                        <span class="material-symbols-outlined text-slate-300">chevron_right</span>
                    </div>
                @empty
                    <div class="p-8 text-center bg-slate-50 dark:bg-slate-800/30 rounded-2xl border border-dashed border-slate-200 dark:border-slate-700">
                        <span class="material-symbols-outlined text-4xl text-slate-200 mb-2">event_busy</span>
                        <p class="text-sm text-slate-500">Tidak ada jadwal pelajaran hari ini.</p>
                    </div>
                @endforelse
            </div>
        </section>

        {{-- Latest Materials --}}
        <section class="bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-sm border border-slate-200 dark:border-slate-800">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">library_books</span>
                    Materi Terbaru
                </h3>
                <a href="{{ route('siswa.materi') }}" class="text-xs font-bold text-primary hover:underline uppercase tracking-wider">Semua Materi</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($materiTerbaru as $item)
                    <div class="p-4 rounded-2xl border border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-800/20 hover:shadow-md transition-shadow relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-2 opacity-10 group-hover:opacity-20 transition-opacity">
                            <span class="material-symbols-outlined text-4xl">description</span>
                        </div>
                        <span class="px-2 py-0.5 rounded-full bg-slate-100 dark:bg-slate-800 text-[9px] font-black text-slate-500 uppercase tracking-widest">{{ $item->mata_pelajaran }}</span>
                        <h4 class="font-bold text-sm text-slate-800 dark:text-white mt-2 mb-1 line-clamp-1">{{ $item->judul_materi }}</h4>
                        <p class="text-[10px] text-slate-400 mb-4">{{ $item->tanggal_publish->translatedFormat('d F Y') }}</p>
                        <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="text-xs font-bold text-primary flex items-center gap-1 hover:underline">
                            Download <span class="material-symbols-outlined text-xs">download</span>
                        </a>
                    </div>
                @empty
                    <div class="col-span-full p-8 text-center bg-slate-50 dark:bg-slate-800/30 rounded-2xl border border-dashed border-slate-200 dark:border-slate-700">
                        <p class="text-sm text-slate-500">Belum ada materi terbaru.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>

    {{-- Right Column: Notifications & Profile Summary --}}
    <div class="space-y-8">
        @livewire('siswa-notification-widget')
        
        <section class="bg-primary/5 dark:bg-primary/10 rounded-3xl p-6 border border-primary/10">
            <h4 class="text-xs font-black uppercase tracking-widest text-primary mb-4">Ringkasan Profil</h4>
            <div class="space-y-3">
                <div class="flex justify-between items-center text-sm">
                    <span class="text-slate-500">Kelompok</span>
                    <span class="font-bold text-slate-800 dark:text-white">{{ $siswa->kelompok ?? 'A' }}</span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-slate-500">NIS</span>
                    <span class="font-bold text-slate-800 dark:text-white">{{ $siswa->nis ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-slate-500">Wali Kelas</span>
                    <span class="font-bold text-slate-800 dark:text-white">{{ $siswa->guru_kelas ?? '-' }}</span>
                </div>
            </div>
        </section>
    </div>
</div>

@else
{{-- Existing PPDB Content --}}

<section class="mb-8 overflow-hidden rounded-[2rem] bg-gradient-to-br {{ $heroTone }} text-white shadow-2xl shadow-primary/20">
    <div class="flex flex-col gap-6 p-8 md:flex-row md:items-center md:justify-between">
        <div class="max-w-3xl">
            <p class="mb-3 text-xs font-black uppercase tracking-[0.35em] text-white/75">Portal PPDB</p>
            <h3 class="text-2xl font-black tracking-tight md:text-3xl">{{ $heroTitle }}</h3>
            <p class="mt-3 max-w-2xl text-sm leading-7 text-white/85 md:text-base">{{ $heroBody }}</p>
        </div>
        <a href="{{ $heroActionUrl }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-6 py-3 text-sm font-black uppercase tracking-widest text-slate-900 transition-all hover:-translate-y-0.5 hover:bg-slate-100">
            <span class="material-symbols-outlined text-lg">north_east</span>
            {{ $heroActionLabel }}
        </a>
    </div>
</section>

@if($hasCatatan)
<section class="mb-8 rounded-2xl border border-amber-200 bg-amber-50 p-5 shadow-sm dark:border-amber-800 dark:bg-amber-900/20">
    <div class="flex items-start gap-4">
        <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-2xl bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-200">
            <span class="material-symbols-outlined">rate_review</span>
        </div>
        <div class="flex-1">
            <p class="text-xs font-black uppercase tracking-[0.3em] text-amber-700 dark:text-amber-300">Catatan Admin</p>
            <h4 class="mt-1 text-lg font-bold text-amber-900 dark:text-amber-100">Ada catatan baru untuk dokumen Anda</h4>
            <p class="mt-2 text-sm leading-6 text-amber-800 dark:text-amber-200">{{ $spmb->catatan_admin }}</p>
            <div class="mt-4 flex flex-wrap items-center gap-3">
                <a href="{{ route('siswa.dokumen') }}" class="inline-flex items-center gap-2 rounded-xl bg-amber-600 px-4 py-2 text-xs font-bold uppercase tracking-widest text-white hover:bg-amber-700">
                    <span class="material-symbols-outlined text-sm">visibility</span>
                    Cek Dokumen
                </a>
                @if($spmb->catatan_admin_at)
                <span class="text-xs font-medium text-amber-700/80 dark:text-amber-300/80">Dikirim {{ $spmb->catatan_admin_at->format('d M Y, H:i') }}</span>
                @endif
            </div>
        </div>
    </div>
</section>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- ==================== KOLOM KIRI ==================== --}}
    <div class="lg:col-span-2 space-y-8">
        
        @if (!$spmb)
            {{-- CTA Daftar Sekarang --}}
            <section class="bg-primary rounded-xl p-8 text-white relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32 blur-3xl group-hover:bg-white/20 transition-all"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row items-center gap-6">
                    <div class="size-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-md">
                        <span class="material-symbols-outlined text-3xl">assignment_add</span>
                    </div>
                    <div class="flex-1 text-center md:text-left">
                        <h3 class="text-2xl font-bold mb-1">Ayo Lengkapi Pendaftaran!</h3>
                        <p class="text-white/80">Silakan isi formulir pendaftaran untuk memulai proses seleksi PPDB.</p>
                    </div>
                    <a href="{{ route('siswa.formulir') }}" class="px-8 py-3 bg-white text-primary font-bold rounded-xl hover:bg-slate-50 transition-all hover:scale-105 shadow-xl">
                        Daftar Sekarang
                    </a>
                </div>
            </section>
        @endif

        {{-- Status Pendaftaran --}}
        <section class="bg-white dark:bg-slate-900 rounded-xl p-6 shadow-sm border border-slate-100 dark:border-slate-800">
            <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">analytics</span>
                Status Pendaftaran
            </h3>

            <div class="relative flex justify-between items-start">
                {{-- Garis penghubung antara step --}}
                <div class="absolute top-5 left-0 w-full h-0.5 bg-slate-100 dark:bg-slate-800 -z-0"></div>

                {{-- Step 1: Isi Formulir --}}
                <div class="group relative z-10 flex w-1/4 flex-col items-center text-center transition-transform hover:scale-105">
                    @if ($currentStep > 1)
                        <div class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center mb-3">
                            <span class="material-symbols-outlined">check</span>
                        </div>
                        <p class="text-sm font-semibold">Isi Formulir</p>
                        <p class="text-xs text-green-600 font-medium">Selesai</p>
                    @elseif ($currentStep == 1)
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center mb-3 ring-4 ring-primary/20">
                            <span class="material-symbols-outlined">edit</span>
                        </div>
                        <p class="text-sm font-semibold text-primary">Isi Formulir</p>
                        <p class="text-xs text-primary font-medium italic">Sedang Berjalan</p>
                    @else
                        <div class="w-10 h-10 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-500 flex items-center justify-center mb-3">
                            <span class="material-symbols-outlined">edit</span>
                        </div>
                        <p class="text-sm font-semibold text-slate-500">Isi Formulir</p>
                        <p class="text-xs text-slate-400 font-medium">Menunggu</p>
                    @endif
                </div>

                {{-- Step 2: Upload Dokumen --}}
                <a href="{{ route('siswa.dokumen') }}" class="group relative z-10 flex w-1/4 flex-col items-center text-center transition-transform hover:scale-105">
                    @if ($currentStep > 2)
                        <div class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center mb-3">
                            <span class="material-symbols-outlined">check</span>
                        </div>
                        <p class="text-sm font-semibold">Upload Dokumen</p>
                        <p class="text-xs text-green-600 font-medium">Selesai</p>
                    @elseif ($currentStep == 2)
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center mb-3 ring-4 ring-primary/20">
                            <span class="material-symbols-outlined">upload_file</span>
                        </div>
                        <p class="text-sm font-semibold text-primary">Upload Dokumen</p>
                        <p class="text-xs text-primary font-medium italic">Sedang Berjalan</p>
                    @else
                        <div class="w-10 h-10 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-500 flex items-center justify-center mb-3 group-hover:bg-primary/20 group-hover:text-primary transition-colors">
                            <span class="material-symbols-outlined">upload_file</span>
                        </div>
                        <p class="text-sm font-semibold text-slate-500 group-hover:text-primary transition-colors">Upload Dokumen</p>
                        <p class="text-xs text-slate-400 font-medium">Menunggu</p>
                    @endif
                </a>

                {{-- Step 3: Verifikasi Admin --}}
                <div class="group relative z-10 flex w-1/4 flex-col items-center text-center transition-transform hover:scale-105">
                    @if ($currentStep > 3)
                        <div class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center mb-3">
                            <span class="material-symbols-outlined">check</span>
                        </div>
                        <p class="text-sm font-semibold">Verifikasi Admin</p>
                        <p class="text-xs text-green-600 font-medium">Selesai</p>
                    @elseif ($currentStep == 3)
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center mb-3 ring-4 ring-primary/20">
                            <span class="material-symbols-outlined">sync</span>
                        </div>
                        <p class="text-sm font-semibold text-primary">Verifikasi Admin</p>
                        <p class="text-xs text-primary font-medium">Sedang Berjalan</p>
                    @else
                        <div class="w-10 h-10 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-500 flex items-center justify-center mb-3">
                            <span class="material-symbols-outlined">schedule</span>
                        </div>
                        <p class="text-sm font-semibold text-slate-500">Verifikasi Admin</p>
                        <p class="text-xs text-slate-400 font-medium">Menunggu</p>
                    @endif
                </div>

                {{-- Step 4: Pengumuman --}}
                <div class="group relative z-10 flex w-1/4 flex-col items-center text-center transition-transform hover:scale-105">
                    @if ($currentStep > 4)
                        <div class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center mb-3">
                            <span class="material-symbols-outlined">check</span>
                        </div>
                        <p class="text-sm font-semibold text-green-600">Pengumuman</p>
                        <p class="text-xs text-green-600 font-medium">Tersedia</p>
                    @elseif ($currentStep == 4)
                        <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center mb-3 ring-4 ring-primary/20">
                            <span class="material-symbols-outlined">campaign</span>
                        </div>
                        <p class="text-sm font-semibold text-primary">Pengumuman</p>
                        <p class="text-xs text-primary font-medium italic">Menunggu Hasil</p>
                    @else
                        <div class="w-10 h-10 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-500 flex items-center justify-center mb-3">
                            <span class="material-symbols-outlined">schedule</span>
                        </div>
                        <p class="text-sm font-semibold text-slate-500">Pengumuman</p>
                        <p class="text-xs text-slate-400 font-medium">Menunggu</p>
                    @endif
                </div>
            </div>
        </section>

        {{-- Status Dokumen --}}
        <section class="bg-white dark:bg-slate-900 rounded-xl p-6 shadow-sm border border-slate-100 dark:border-slate-800">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">folder_shared</span>
                    Status Dokumen
                </h3>
                <a href="{{ route('siswa.dokumen') }}" class="text-xs font-medium text-primary hover:underline">Lihat Semua</a>
            </div>

            <div class="space-y-4">

                {{-- KTP / Kartu Identitas Orang Tua --}}
                <div class="flex items-center justify-between p-4 rounded-xl border border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 flex items-center justify-center">
                            <span class="material-symbols-outlined">badge</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold">KTP Orang Tua</p>
                            @if ($spmb && $spmb->tanggal_verifikasi_ktp)
                                <p class="text-xs text-slate-500">Diverifikasi {{ $spmb->tanggal_verifikasi_ktp->format('d M Y') }}</p>
                            @else
                                <p class="text-xs text-slate-500">Menunggu verifikasi admin</p>
                            @endif
                        </div>
                    </div>
                    @if ($spmb && $spmb->verifikasi_ktp)
                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 text-xs font-bold uppercase tracking-wider">Verified</span>
                    @else
                        <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 text-xs font-bold uppercase tracking-wider">Pending</span>
                    @endif
                </div>

                {{-- Akte Kelahiran --}}
                <div class="flex items-center justify-between p-4 rounded-xl border border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 text-purple-600 flex items-center justify-center">
                            <span class="material-symbols-outlined">history_edu</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold">Akte Kelahiran</p>
                            @if ($spmb && $spmb->tanggal_verifikasi_akte)
                                <p class="text-xs text-slate-500">Diverifikasi {{ $spmb->tanggal_verifikasi_akte->format('d M Y') }}</p>
                            @else
                                <p class="text-xs text-slate-500">Menunggu verifikasi admin</p>
                            @endif
                        </div>
                    </div>
                    @if ($spmb && $spmb->verifikasi_akte)
                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 text-xs font-bold uppercase tracking-wider">Verified</span>
                    @else
                        <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 text-xs font-bold uppercase tracking-wider">Pending</span>
                    @endif
                </div>

                {{-- Kartu Keluarga --}}
                <div class="flex items-center justify-between p-4 rounded-xl border border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg bg-teal-100 dark:bg-teal-900/30 text-teal-600 flex items-center justify-center">
                            <span class="material-symbols-outlined">group</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold">Kartu Keluarga (KK)</p>
                            @if ($spmb && $spmb->tanggal_verifikasi_kk)
                                <p class="text-xs text-slate-500">Diverifikasi {{ $spmb->tanggal_verifikasi_kk->format('d M Y') }}</p>
                            @else
                                <p class="text-xs text-slate-500">Menunggu verifikasi admin</p>
                            @endif
                        </div>
                    </div>
                    @if ($spmb && $spmb->verifikasi_kk)
                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 text-xs font-bold uppercase tracking-wider">Verified</span>
                    @else
                        <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 text-xs font-bold uppercase tracking-wider">Pending</span>
                    @endif
                </div>

                {{-- Bukti Pembayaran --}}
                <div class="flex items-center justify-between p-4 rounded-xl border border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg bg-orange-100 dark:bg-orange-900/30 text-orange-600 flex items-center justify-center">
                            <span class="material-symbols-outlined">receipt_long</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold">Bukti Pembayaran</p>
                            @if ($spmb && $spmb->tanggal_verifikasi_bukti_transfer)
                                <p class="text-xs text-slate-500">Diverifikasi {{ $spmb->tanggal_verifikasi_bukti_transfer->format('d M Y') }}</p>
                            @else
                                <p class="text-xs text-slate-500">Menunggu verifikasi admin</p>
                            @endif
                        </div>
                    </div>
                    @if ($spmb && $spmb->verifikasi_bukti_transfer)
                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 text-xs font-bold uppercase tracking-wider">Verified</span>
                    @else
                        <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 text-xs font-bold uppercase tracking-wider">Pending</span>
                    @endif
                </div>
            </div>
        </section>

    </div>{{-- end kolom kiri --}}

    <div class="lg:col-span-1" id="notification-system">
        @livewire('siswa-notification-widget')
    </div>{{-- end kolom kanan --}}

</div>{{-- end grid --}}

{{-- Banner Bantuan --}}
<div class="mt-8 p-6 rounded-2xl bg-gradient-to-r from-primary to-purple-600 text-white flex flex-col md:flex-row items-center justify-between gap-6 shadow-lg shadow-primary/20">
    <div class="flex items-center gap-6">
        <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center backdrop-blur-sm">
            <span class="material-symbols-outlined text-3xl">help_outline</span>
        </div>
        <div>
            <h4 class="text-xl font-bold">Butuh bantuan pendaftaran?</h4>
            <p class="text-white/80 text-sm">Tim support kami siap membantu Anda 24/7 melalui WhatsApp atau Email.</p>
        </div>
    </div>
    <div class="flex gap-3 w-full md:w-auto">
        <button class="flex-1 md:flex-none px-6 py-3 bg-white text-primary font-bold rounded-xl hover:bg-slate-50 transition-colors">
            Hubungi Admin
        </button>
        <button class="flex-1 md:flex-none px-6 py-3 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl backdrop-blur-sm transition-colors border border-white/20">
            FAQ
        </button>
    </div>
</div>

@endif
@endsection
