<!DOCTYPE html>
<html lang="id"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: {
                    "primary": "#f49d25",
                    "secondary": "#3b82f6",
                    "background-light": "#f8f7f5",
                    "background-dark": "#221a10",
                },
                fontFamily: {
                    "display": ["Plus Jakarta Sans"]
                },
                borderRadius: {"DEFAULT": "1rem", "lg": "2rem", "xl": "3rem", "full": "9999px"},
            },
        },
    }
</script>
<style type="text/tailwindcss">
    .wavy-bg {
        background-color: #f8f7f5;
        background-image: radial-gradient(circle at 2px 2px, rgba(244, 157, 37, 0.05) 1px, transparent 0);
        background-size: 24px 24px;
    }
    .blob {
        position: absolute;
        z-index: -1;
        filter: blur(40px);
        opacity: 0.2;
    }
    .step-content { display: none; }
    .step-content.active { display: block; position: relative; z-index: 100; pointer-events: auto; background: white; }
    .step-content button[type="submit"] { position: relative; z-index: 200; pointer-events: auto; }
    .step-indicator.active { border-color: #f49d25; color: #f49d25; }
    .step-indicator.completed { border-color: #22c55e; background-color: #22c55e; color: white; }
</style>
</head>
<body class="bg-background-light font-display text-slate-900 wavy-bg pt-[60px] md:pt-[72px]">
<div class="relative flex min-h-screen flex-col overflow-x-hidden">
<header id="navbar" class="fixed top-0 left-0 right-0 z-[60] bg-white/80 backdrop-blur-md border-b border-primary/10 px-4 md:px-10 py-3 md:py-4">
<div class="max-w-7xl mx-auto flex items-center justify-between">
<div class="flex items-center gap-3">
<div class="bg-primary p-1.5 md:p-2 rounded-lg text-white">
<span class="material-symbols-outlined block text-[20px] md:text-[24px]">school</span>
</div>
<h2 class="text-sm md:text-xl font-extrabold tracking-tight text-slate-900">TK PGRI HARAPAN BANGSA 1</h2>
</div>

<button id="mobile-menu-btn" type="button" class="md:hidden w-10 h-10 flex items-center justify-center text-slate-700" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
<span class="material-symbols-outlined text-[28px]">menu</span>
</button>

<nav class="hidden md:flex items-center gap-8">
<a class="text-sm font-semibold hover:text-primary transition-colors" href="{{ route('home') }}">Beranda</a>
<a class="text-sm font-semibold hover:text-primary transition-colors" href="#">Profil</a>
<a class="text-sm font-semibold hover:text-primary transition-colors" href="#">Kurikulum</a>
<a class="text-sm font-semibold text-primary" href="{{ route('ppdb.index') }}">PPDB</a>
<a class="text-sm font-semibold hover:text-primary transition-colors" href="#">Informasi</a>
</nav>

<div class="hidden md:flex items-center gap-4">
@if(auth('siswa')->check() || auth('admin')->check() || auth('guru')->check())
    @php
        if (auth('siswa')->check()) {
            $user = auth('siswa')->user();
            $guard = 'siswa';
            $role = 'Calon Siswa';
        } elseif (auth('admin')->check()) {
            $user = auth('admin')->user();
            $guard = 'admin';
            $role = 'Administrator';
        } elseif (auth('guru')->check()) {
            $user = auth('guru')->user();
            $guard = 'guru';
            $role = 'Guru';
        }
    @endphp
    <div class="relative">
        <button type="button" id="profile-trigger" class="inline-flex items-center gap-3 px-2 py-1.5 rounded-full hover:bg-slate-100 transition-all">
            <div class="w-10 h-10 rounded-full bg-slate-200 overflow-hidden border-2 border-primary/20 flex items-center justify-center">
                @if(!empty($user->foto))
                    <img src="{{ $user->foto }}" alt="Foto Profil" class="w-full h-full object-cover" />
                @else
                    <span class="text-sm font-black text-slate-600">
                        {{ strtoupper(substr($user->nama_lengkap ?? $user->name ?? 'U', 0, 1)) }}
                    </span>
                @endif
            </div>
            <span class="text-sm font-bold text-slate-700">{{ $user->nama_lengkap ?? $user->name ?? 'User' }}</span>
        </button>

        <div id="profile-backdrop" class="hidden fixed inset-0 z-[45] bg-slate-900/20 backdrop-blur-[2px]"></div>

        <div id="profile-dropdown" class="hidden absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-2xl border border-slate-100 py-2 z-[80] transform origin-top-right transition-all">
            <div class="px-5 py-4 border-b border-slate-50 flex items-center gap-3">
                <div class="w-12 h-12 rounded-full overflow-hidden border border-slate-100 bg-slate-200 flex items-center justify-center">
                    @if(!empty($user->foto))
                        <img src="{{ $user->foto }}" alt="Foto Profil" class="w-full h-full object-cover" />
                    @else
                        <span class="text-base font-black text-slate-600">
                            {{ strtoupper(substr($user->nama_lengkap ?? $user->name ?? 'U', 0, 1)) }}
                        </span>
                    @endif
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-extrabold text-slate-800 leading-tight">{{ $user->nama_lengkap ?? $user->name ?? 'User' }}</span>
                    <span class="text-[10px] font-bold text-primary uppercase tracking-wider">{{ $role }}</span>
                </div>
            </div>

            <div class="p-2">
                @if($guard === 'siswa')
                <a class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 rounded-xl transition-colors group" href="{{ route('siswa.dashboard') }}">
                    <span class="material-symbols-outlined text-[20px] group-hover:text-primary">dashboard</span>
                    <span class="text-sm font-semibold">Dashboard</span>
                </a>
                @endif
                <a class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 rounded-xl transition-colors group" href="#">
                    <span class="material-symbols-outlined text-[20px] group-hover:text-primary">person</span>
                    <span class="text-sm font-semibold">Profil Saya</span>
                </a>
            </div>

            <div class="border-t border-slate-50 mt-2 pt-2 px-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 text-rose-600 hover:bg-rose-50 rounded-xl transition-colors group cursor-pointer">
                        <span class="material-symbols-outlined text-[20px]">logout</span>
                        <span class="text-sm font-semibold">Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
@else
    <div class="flex items-center gap-3">
        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-primary transition-colors">Masuk</a>
        <a href="#register" class="bg-primary hover:bg-primary/90 text-white px-6 py-2.5 rounded-full font-bold text-sm transition-all shadow-lg shadow-primary/20">
            Daftar
        </a>
    </div>
@endif
</div>
</header>

<div id="mobile-menu" class="hidden md:hidden fixed top-[60px] left-0 right-0 bg-white border-b border-primary/10 shadow-lg z-40">
<div class="px-4 py-4 space-y-3">
<a class="block text-sm font-semibold text-slate-700 hover:text-primary py-2" href="{{ route('home') }}">Beranda</a>
<a class="block text-sm font-semibold text-slate-700 hover:text-primary py-2" href="#">Profil</a>
<a class="block text-sm font-semibold text-slate-700 hover:text-primary py-2" href="#">Kurikulum</a>
<a class="block text-sm font-semibold text-primary font-bold py-2" href="{{ route('ppdb.index') }}">PPDB</a>
<a class="block text-sm font-semibold text-slate-700 hover:text-primary py-2" href="#">Informasi</a>
<hr class="border-slate-200">
@if(auth('siswa')->check() || auth('admin')->check() || auth('guru')->check())
    @php
        if (auth('siswa')->check()) {
            $user = auth('siswa')->user();
            $guard = 'siswa';
        } elseif (auth('admin')->check()) {
            $user = auth('admin')->user();
            $guard = 'admin';
        } elseif (auth('guru')->check()) {
            $user = auth('guru')->user();
            $guard = 'guru';
        }
    @endphp
    <div class="flex items-center gap-3 py-2">
        <div class="w-10 h-10 rounded-full bg-slate-200 overflow-hidden border border-slate-100 flex items-center justify-center">
            @if(!empty($user->foto))
                <img src="{{ $user->foto }}" alt="Foto Profil" class="w-full h-full object-cover" />
            @else
                <span class="text-sm font-black text-slate-600">
                    {{ strtoupper(substr($user->nama_lengkap ?? $user->name ?? 'U', 0, 1)) }}
                </span>
            @endif
        </div>
        <div class="flex flex-col">
            <span class="text-sm font-bold text-slate-800">{{ $user->nama_lengkap ?? $user->name ?? 'User' }}</span>
            <span class="text-[10px] text-primary uppercase">{{ $guard === 'siswa' ? 'Calon Siswa' : ($guard === 'admin' ? 'Admin' : 'Guru') }}</span>
        </div>
    </div>
    @if($guard === 'siswa')
    <a class="block text-sm font-semibold text-slate-700 hover:text-primary py-2" href="{{ route('siswa.dashboard') }}">Dashboard</a>
    @endif
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="block w-full text-left text-sm font-semibold text-rose-600 py-2">Keluar</button>
    </form>
@else
    <div class="flex gap-3">
        <a href="{{ route('login') }}" class="flex-1 text-center border-2 border-slate-200 text-slate-600 px-4 py-2.5 rounded-full font-bold text-sm">Masuk</a>
        <a href="#register" class="flex-1 text-center bg-primary text-white px-4 py-2.5 rounded-full font-bold text-sm">Daftar</a>
    </div>
@endif
</div>
</div>
</header>

<main class="flex-1">
<section class="relative px-4 pt-16 pb-12 md:pt-24 md:pb-20 overflow-hidden">
<div class="blob w-96 h-96 bg-primary top-0 -left-20 rounded-full"></div>
<div class="blob w-96 h-96 bg-secondary bottom-0 -right-20 rounded-full"></div>
<div class="max-w-5xl mx-auto text-center">
<div class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-2 rounded-full mb-6">
<span class="material-symbols-outlined text-sm">campaign</span>
<span class="text-xs font-bold uppercase tracking-wider">Tahun Ajaran {{ $tahunAjaranAktif?->tahun_ajaran ?? '-' }}</span>
</div>
<h1 class="text-4xl md:text-6xl font-black text-slate-900 mb-6 leading-tight">
                    PPDB <span class="text-primary italic">TK PGRI HARAPAN BANGSA 1</span>
</h1>
<p class="text-lg md:text-xl text-slate-600 max-w-2xl mx-auto mb-10 leading-relaxed">
                    Selamat datang di Penerimaan Peserta Didik Baru TK PGRI HARAPAN BANGSA 1. Mari bergabung dan tumbuh bersama lingkungan belajar yang kreatif dan inovatif!
                </p>
<div class="flex flex-wrap items-center justify-center gap-4 mb-10">
<div class="bg-white px-6 py-3 rounded-2xl shadow-md border-l-4 border-{{ $statusPendaftaran['status_class'] }}-500 flex items-center gap-3">
<span class="material-symbols-outlined text-{{ $statusPendaftaran['status_class'] }}-500">{{ $statusPendaftaran['icon'] }}</span>
<div class="text-left">
<p class="text-[10px] uppercase font-bold text-slate-400 leading-none">{{ $statusPendaftaran['pesan_status'] }}</p>
@if($statusPendaftaran['tanggal_mulai'] && $statusPendaftaran['tanggal_selesai'])
<p class="text-sm md:text-base font-black text-slate-900">
    {{ $statusPendaftaran['tanggal_mulai']->format('d M Y') }} - {{ $statusPendaftaran['tanggal_selesai']->format('d M Y') }}
</p>
@elseif($statusPendaftaran['tanggal_mulai'])
<p class="text-sm md:text-base font-black text-slate-900">
    {{ $statusPendaftaran['tanggal_mulai']->format('d M Y') }}
</p>
@else
<p class="text-sm md:text-base font-black text-slate-900">Menunggu Jadwal</p>
@endif
</div>
</div>
@if($statusPendaftaran['is_dibuka'])
<div class="bg-white px-6 py-3 rounded-2xl shadow-md border-l-4 border-emerald-500 flex items-center gap-3">
<span class="material-symbols-outlined text-emerald-500">access_time</span>
<div class="text-left">
<p class="text-[10px] uppercase font-bold text-slate-400 leading-none">Sisa Waktu</p>
<p class="text-sm md:text-base font-black text-slate-900" id="countdown-timer">
    {{ $statusPendaftaran['tanggal_selesai'] ? $statusPendaftaran['tanggal_selesai']->diffForHumans() : 'Hitung Mundur' }}
</p>
</div>
@endif
</div>
<div class="flex flex-col sm:flex-row items-center justify-center gap-4">
@if($statusPendaftaran['is_dibuka'])
    @if(auth('siswa')->check())
    <a href="#register" class="w-full sm:w-auto bg-primary text-white px-10 py-4 rounded-xl font-extrabold text-lg shadow-xl shadow-primary/30 hover:scale-105 transition-transform flex items-center justify-center gap-2">
        Daftar Sekarang
        <span class="material-symbols-outlined">arrow_forward</span>
    </a>
    @else
    <a href="{{ route('siswa.login', ['redirect' => route('ppdb.index') . '#register']) }}" class="w-full sm:w-auto bg-primary text-white px-10 py-4 rounded-xl font-extrabold text-lg shadow-xl shadow-primary/30 hover:scale-105 transition-transform flex items-center justify-center gap-2">
        Daftar Sekarang
        <span class="material-symbols-outlined">arrow_forward</span>
    </a>
    @endif
@else
    <button disabled class="w-full sm:w-auto bg-gray-400 text-white px-10 py-4 rounded-xl font-extrabold text-lg shadow-xl opacity-60 cursor-not-allowed flex items-center justify-center gap-2">
        <span class="material-symbols-outlined">lock</span>
        Pendaftaran {{ $statusPendaftaran['is_dibuka'] ? 'Dibuka' : 'Ditutup' }}
    </button>
@endif
<button class="w-full sm:w-auto border-2 border-secondary text-secondary px-10 py-4 rounded-xl font-extrabold text-lg hover:bg-secondary/5 transition-colors">
                    Lihat Brosur
                </button>
</div>
</div>
</section>

<section class="px-4 py-20 bg-white">
<div class="max-w-7xl mx-auto">
<div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
<div>
<h2 class="text-3xl font-black text-slate-900 mb-2">Kriteria Pendaftaran</h2>
<p class="text-slate-500">Hal yang perlu diperhatikan sebelum mendaftar ke TK PGRI HARAPAN BANGSA 1.</p>
</div>
<div class="flex gap-2">
<div class="w-12 h-2 rounded-full bg-primary"></div>
<div class="w-4 h-2 rounded-full bg-primary/30"></div>
</div>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
<div class="group p-8 rounded-xl bg-orange-50 border-2 border-transparent hover:border-primary transition-all">
<div class="w-14 h-14 rounded-xl bg-primary flex items-center justify-center text-white mb-6 group-hover:rotate-6 transition-transform">
<span class="material-symbols-outlined text-3xl">child_care</span>
</div>
<h3 class="text-xl font-bold mb-3">Kriteria Usia</h3>
<p class="text-slate-600 text-sm leading-relaxed">
                            Calon siswa minimal berusia 4 tahun untuk Kelompok A dan 5 tahun untuk Kelompok B pada bulan Juli.
                        </p>
</div>
<div class="group p-8 rounded-xl bg-blue-50 border-2 border-transparent hover:border-secondary transition-all">
<div class="w-14 h-14 rounded-xl bg-secondary flex items-center justify-center text-white mb-6 group-hover:-rotate-6 transition-transform">
<span class="material-symbols-outlined text-3xl">location_on</span>
</div>
<h3 class="text-xl font-bold mb-3">Kriteria Domisili</h3>
<p class="text-slate-600 text-sm leading-relaxed">
                            Memprioritaskan calon siswa yang berdomisili di wilayah sekitar lingkungan TK PGRI HARAPAN BANGSA 1.
                        </p>
</div>
<div class="group p-8 rounded-xl bg-emerald-50 border-2 border-transparent hover:border-emerald-500 transition-all">
<div class="w-14 h-14 rounded-xl bg-emerald-500 flex items-center justify-center text-white mb-6 group-hover:rotate-6 transition-transform">
<span class="material-symbols-outlined text-3xl">military_tech</span>
</div>
<h3 class="text-xl font-bold mb-3">Kesiapan Belajar</h3>
<p class="text-slate-600 text-sm leading-relaxed">
                            Melakukan observasi kesiapan belajar dan kemandirian dasar anak oleh tim pengajar kami.
                        </p>
</div>
</div>
</div>
</section>
<section class="px-4 py-20">
<div class="max-w-7xl mx-auto bg-primary/5 rounded-xl p-8 md:p-16 border-2 border-dashed border-primary/20">
<div class="text-center mb-16">
<h2 class="text-3xl font-black mb-4">Syarat &amp; Dokumen</h2>
<p class="text-slate-500">Persiapkan dokumen berikut dalam bentuk scan/digital</p>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
<div class="space-y-6">
<div class="flex gap-4 items-start bg-white p-6 rounded-xl shadow-sm">
<div class="bg-primary/20 text-primary p-2 rounded-lg">
<span class="material-symbols-outlined">contact_page</span>
</div>
<div>
<h4 class="font-bold text-lg mb-1">Kartu Keluarga</h4>
<p class="text-sm text-slate-500">Fotokopi kartu keluarga terbaru (domisili orang tua/wali).</p>
</div>
</div>
<div class="flex gap-4 items-start bg-white p-6 rounded-xl shadow-sm">
<div class="bg-primary/20 text-primary p-2 rounded-lg">
<span class="material-symbols-outlined">cake</span>
</div>
<div>
<h4 class="font-bold text-lg mb-1">Akta Kelahiran</h4>
<p class="text-sm text-slate-500">Scan asli akta kelahiran calon peserta didik.</p>
</div>
</div>
<div class="flex gap-4 items-start bg-white p-6 rounded-xl shadow-sm">
<div class="bg-primary/20 text-primary p-2 rounded-lg">
<span class="material-symbols-outlined">badge</span>
</div>
<div>
<h4 class="font-bold text-lg mb-1">KTP Orang Tua</h4>
<p class="text-sm text-slate-500">Identitas resmi orang tua atau wali murid yang sah.</p>
</div>
</div>
</div>
<div class="space-y-6">
<div class="flex gap-4 items-start bg-white p-6 rounded-xl shadow-sm">
<div class="bg-secondary/20 text-secondary p-2 rounded-lg">
<span class="material-symbols-outlined">add_a_photo</span>
</div>
<div>
<h4 class="font-bold text-lg mb-1">Pas Foto</h4>
<p class="text-sm text-slate-500">Foto berwarna terbaru calon peserta didik (3x4).</p>
</div>
</div>
<div class="flex gap-4 items-start bg-white p-6 rounded-xl shadow-sm">
<div class="bg-secondary/20 text-secondary p-2 rounded-lg">
<span class="material-symbols-outlined">verified_user</span>
</div>
<div>
<h4 class="font-bold text-lg mb-1">Buku KIA/Kesehatan</h4>
<p class="text-sm text-slate-500">Fotokopi riwayat imunisasi dasar pada buku KIA.</p>
</div>
</div>
<div class="flex gap-4 items-start bg-white p-6 rounded-xl shadow-sm">
<div class="bg-secondary/20 text-secondary p-2 rounded-lg">
<span class="material-symbols-outlined">payments</span>
</div>
<div>
<h4 class="font-bold text-lg mb-1">Bukti Bayar</h4>
<p class="text-sm text-slate-500">Bukti transfer biaya pendaftaran administrasi.</p>
</div>
</div>
</div>
</div>
</div>
</section>
<section class="relative py-24 px-4 overflow-hidden">
<div class="max-w-4xl mx-auto bg-primary rounded-xl p-10 md:p-20 text-center relative z-20">
<h2 class="text-3xl md:text-5xl font-black text-white mb-6">Sudah Siap Bergabung?</h2>
<p class="text-white/80 text-lg mb-10 max-w-lg mx-auto">
                    Jangan lewatkan kesempatan untuk menjadi bagian dari keluarga besar TK PGRI HARAPAN BANGSA 1.
                    @if($statusPendaftaran['is_dibuka'])
                        Pendaftaran dibuka hingga {{ $statusPendaftaran['tanggal_selesai'] ? $statusPendaftaran['tanggal_selesai']->format('d M Y') : 'selesai' }}.
                    @else
                        Pendaftaran saat ini {{ strtolower($statusPendaftaran['pesan_status']) }}.
                    @endif
                </p>
@if($statusPendaftaran['is_dibuka'])
    @if(auth('siswa')->check())
    <a href="#register" class="bg-white text-primary px-12 py-5 rounded-full font-black text-xl shadow-2xl hover:scale-105 transition-transform inline-block">Daftar Sekarang</a>
    @else
    <a href="{{ route('siswa.register', ['redirect' => route('ppdb.index') . '#register']) }}" class="bg-white text-primary px-12 py-5 rounded-full font-black text-xl shadow-2xl hover:scale-105 transition-transform inline-block">Daftar Sekarang</a>
    @endif
@else
    <button disabled class="bg-gray-400 text-white px-12 py-5 rounded-full font-black text-xl shadow-2xl opacity-60 cursor-not-allowed inline-block">
        <span class="material-symbols-outlined align-middle mr-2">lock</span>
        Pendaftaran Ditutup
    </button>
@endif
<div class="absolute -top-10 -left-10 text-white/10">
<span class="material-symbols-outlined text-[150px]">rocket_launch</span>
</div>
</div>
</section>

<section id="register" class="px-4 pb-24 relative z-50">
    <div class="max-w-4xl mx-auto relative z-50">
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-2xl">
                <div class="font-bold mb-2">Perhatian:</div>
                <div class="text-sm">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-2xl">
                <div class="font-bold mb-2">Terjadi kesalahan:</div>
                <div class="text-sm">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        @if(auth('siswa')->check())
            @if(Auth::guard('siswa')->user()->spmb_id)
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-10 text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-green-600 text-3xl">check_circle</span>
                </div>
                <h3 class="text-xl font-black text-slate-900">Anda Sudah Terdaftar</h3>
                <p class="text-slate-500 mt-2">Anda sudah melakukan pendaftaran PPDB. Silakan lihat hasil seleksi.</p>
                <div class="mt-6">
                    <a href="{{ route('siswa.ppdb.hasil-seleksi') }}" class="bg-primary text-white px-8 py-3 rounded-full font-bold">Lihat Hasil Seleksi</a>
                </div>
            </div>
            @elseif($statusPendaftaran['is_dibuka'])
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 md:p-8">
                <header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-primary/10 pb-6 mb-6">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center justify-center size-10 rounded bg-primary text-white">
                            <span class="material-symbols-outlined">school</span>
                        </div>
                        <div>
                            <h2 class="text-slate-900 text-lg font-bold leading-tight tracking-tight">TK PGRI HARAPAN BANGSA 1</h2>
                            <p class="text-xs text-slate-500 font-medium">Formulir PPDB Online</p>
                        </div>
                    </div>
                    <a href="{{ route('ppdb.index') }}" class="hidden md:flex min-w-[84px] cursor-pointer items-center justify-center rounded-full h-10 px-6 bg-slate-100 text-slate-600 text-sm font-bold transition-all hover:bg-slate-200">
                        <span>Batal</span>
                    </a>
                </header>
            @else
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-10 text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-red-600 text-3xl">lock</span>
                </div>
                <h3 class="text-xl font-black text-slate-900">Pendaftaran Ditutup</h3>
                <p class="text-slate-500 mt-2">{{ $statusPendaftaran['pesan_status'] }}. Silakan kembali lagi saat pendaftaran dibuka.</p>
                <div class="mt-6">
                    <a href="{{ route('ppdb.index') }}" class="bg-primary text-white px-8 py-3 rounded-full font-bold">Kembali ke PPDB</a>
                </div>
            </div>
            @endif
        @else
            @if($statusPendaftaran['is_dibuka'])
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 md:p-8">
                <header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-primary/10 pb-6 mb-6">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center justify-center size-10 rounded bg-primary text-white">
                            <span class="material-symbols-outlined">school</span>
                        </div>
                        <div>
                            <h2 class="text-slate-900 text-lg font-bold leading-tight tracking-tight">TK PGRI HARAPAN BANGSA 1</h2>
                            <p class="text-xs text-slate-500 font-medium">Formulir PPDB Online</p>
                        </div>
                    </div>
                    <a href="{{ route('ppdb.index') }}" class="hidden md:flex min-w-[84px] cursor-pointer items-center justify-center rounded-full h-10 px-6 bg-slate-100 text-slate-600 text-sm font-bold transition-all hover:bg-slate-200">
                        <span>Batal</span>
                    </a>
                </header>
            @else
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-10 text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-red-600 text-3xl">lock</span>
                </div>
                <h3 class="text-xl font-black text-slate-900">Pendaftaran Ditutup</h3>
                <p class="text-slate-500 mt-2">{{ $statusPendaftaran['pesan_status'] }}. Silakan login terlebih dahulu untuk mendaftar saat pendaftaran dibuka.</p>
                <div class="mt-6">
                    <a href="{{ route('siswa.login', ['redirect' => route('ppdb.index') . '#register']) }}" class="bg-primary text-white px-8 py-3 rounded-full font-bold">Login untuk Mendaftar</a>
                </div>
            </div>
            @endif
        @endif

        @if($statusPendaftaran['is_dibuka'] && auth('siswa')->check() && !Auth::guard('siswa')->user()->spmb_id)
                <header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-primary/10 pb-6 mb-6">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center justify-center size-10 rounded bg-primary text-white">
                            <span class="material-symbols-outlined">school</span>
                        </div>
                        <div>
                            <h2 class="text-slate-900 text-lg font-bold leading-tight tracking-tight">TK PGRI HARAPAN BANGSA 1</h2>
                            <p class="text-xs text-slate-500 font-medium">Formulir PPDB Online</p>
                        </div>
                    </div>
                    <a href="{{ route('ppdb.index') }}" class="hidden md:flex min-w-[84px] cursor-pointer items-center justify-center rounded-full h-10 px-6 bg-slate-100 text-slate-600 text-sm font-bold transition-all hover:bg-slate-200">
                        <span>Batal</span>
                    </a>
                </header>

                <form action="{{ route('ppdb.store') }}" method="POST" enctype="multipart/form-data" id="ppdbForm">
                    @csrf

                    <div class="flex items-center justify-between mb-8">
                        <div class="flex gap-2">
                            <button type="button" class="step-indicator active w-10 h-10 rounded-full border-2 border-primary flex items-center justify-center font-bold text-primary" data-step="1">1</button>
                            <button type="button" class="step-indicator w-10 h-10 rounded-full border-2 border-slate-300 flex items-center justify-center font-bold text-slate-400" data-step="2">2</button>
                            <button type="button" class="step-indicator w-10 h-10 rounded-full border-2 border-slate-300 flex items-center justify-center font-bold text-slate-400" data-step="3">3</button>
                            <button type="button" class="step-indicator w-10 h-10 rounded-full border-2 border-slate-300 flex items-center justify-center font-bold text-slate-400" data-step="4">4</button>
                            <button type="button" class="step-indicator w-10 h-10 rounded-full border-2 border-slate-300 flex items-center justify-center font-bold text-slate-400" data-step="5">5</button>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-slate-500">Langkah</p>
                            <p class="text-sm font-bold text-primary" id="stepLabel">Data Pribadi</p>
                        </div>
                    </div>

                    <div class="w-full bg-slate-100 h-2 rounded-full mb-8">
                        <div class="h-full bg-primary rounded-full transition-all duration-300" id="progressBar" style="width: 20%;"></div>
                    </div>

                    <!-- STEP 1: DATA PRIBADI -->
                    <div class="step-content active" data-step="1">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined">person</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-800 tracking-tight">Identitas Calon Siswa</h3>
                                <p class="text-xs text-slate-400">Data pribadi utama calon siswa</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="nama_lengkap_anak">
                                    Nama Lengkap Anak <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="nama_lengkap_anak" name="nama_lengkap_anak" value="{{ old('nama_lengkap_anak') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Nama sesuai akta kelahiran">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="nama_panggilan_anak">
                                    Nama Panggilan
                                </label>
                                <input type="text" id="nama_panggilan_anak" name="nama_panggilan_anak" value="{{ old('nama_panggilan_anak') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Nama panggilan sehari-hari">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="nik_anak">
                                    NIK Anak <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="nik_anak" name="nik_anak" value="{{ old('nik_anak') }}" required maxlength="16" pattern="[0-9]{16}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="16 digit NIK">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="tempat_lahir_anak">
                                    Tempat Lahir <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="tempat_lahir_anak" name="tempat_lahir_anak" value="{{ old('tempat_lahir_anak') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Kota/kabupaten">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="tanggal_lahir_anak">
                                    Tanggal Lahir <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="tanggal_lahir_anak" name="tanggal_lahir_anak" value="{{ old('tanggal_lahir_anak') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="jenis_kelamin">
                                    Jenis Kelamin <span class="text-red-500">*</span>
                                </label>
                                <select id="jenis_kelamin" name="jenis_kelamin" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="agama">
                                    Agama <span class="text-red-500">*</span>
                                </label>
                                <select id="agama" name="agama" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Kristen Protestan" {{ old('agama') == 'Kristen Protestan' ? 'selected' : '' }}>Kristen Protestan</option>
                                    <option value="Kristen Katolik" {{ old('agama') == 'Kristen Katolik' ? 'selected' : '' }}>Kristen Katolik</option>
                                    <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                    <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                    <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                    <option value="Lainnya" {{ old('agama') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="anak_ke">
                                    Anak Ke <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="anak_ke" name="anak_ke" value="{{ old('anak_ke', 1) }}" required min="1" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Contoh: 1, 2, 3">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="tinggal_bersama">
                                    Tinggal Bersama <span class="text-red-500">*</span>
                                </label>
                                <select id="tinggal_bersama" name="tinggal_bersama" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                    <option value="">Pilih</option>
                                    <option value="Ayah dan Ibu" {{ old('tinggal_bersama') == 'Ayah dan Ibu' ? 'selected' : '' }}>Ayah dan Ibu</option>
                                    <option value="Ayah" {{ old('tinggal_bersama') == 'Ayah' ? 'selected' : '' }}>Ayah</option>
                                    <option value="Ibu" {{ old('tinggal_bersama') == 'Ibu' ? 'selected' : '' }}>Ibu</option>
                                    <option value="Keluarga Ayah" {{ old('tinggal_bersama') == 'Keluarga Ayah' ? 'selected' : '' }}>Keluarga Ayah</option>
                                    <option value="Keluarga Ibu" {{ old('tinggal_bersama') == 'Keluarga Ibu' ? 'selected' : '' }}>Keluarga Ibu</option>
                                    <option value="Lainnya" {{ old('tinggal_bersama') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="status_tempat_tinggal">
                                    Status Tempat Tinggal <span class="text-red-500">*</span>
                                </label>
                                <select id="status_tempat_tinggal" name="status_tempat_tinggal" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                    <option value="">Pilih</option>
                                    <option value="Milik Sendiri" {{ old('status_tempat_tinggal') == 'Milik Sendiri' ? 'selected' : '' }}>Milik Sendiri</option>
                                    <option value="Milik Keluarga" {{ old('status_tempat_tinggal') == 'Milik Keluarga' ? 'selected' : '' }}>Milik Keluarga</option>
                                    <option value="Kontrakan" {{ old('status_tempat_tinggal') == 'Kontrakan' ? 'selected' : '' }}>Kontrakan</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="bahasa_sehari_hari">
                                    Bahasa Sehari-hari <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="bahasa_sehari_hari" name="bahasa_sehari_hari" value="{{ old('bahasa_sehari_hari', 'Indonesia') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Contoh: Indonesia, Sunda, Jawa">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="jarak_rumah_ke_sekolah">
                                    Jarak Rumah ke Sekolah (meter)
                                </label>
                                <input type="number" id="jarak_rumah_ke_sekolah" name="jarak_rumah_ke_sekolah" value="{{ old('jarak_rumah_ke_sekolah') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Contoh: 500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="waktu_tempuh_ke_sekolah">
                                    Waktu Tempuh (menit)
                                </label>
                                <input type="number" id="waktu_tempuh_ke_sekolah" name="waktu_tempuh_ke_sekolah" value="{{ old('waktu_tempuh_ke_sekolah') }}" class="w py-3 border border-gray-300-full px-4 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Contoh: 15">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="berat_badan">
                                    Berat Badan (kg)
                                </label>
                                <input type="number" id="berat_badan" name="berat_badan" value="{{ old('berat_badan') }}" step="0.1" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Contoh: 15.5">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="tinggi_badan">
                                    Tinggi Badan (cm)
                                </label>
                                <input type="number" id="tinggi_badan" name="tinggi_badan" value="{{ old('tinggi_badan') }}" step="0.1" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Contoh: 95.5">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="golongan_darah">
                                    Golongan Darah
                                </label>
                                <select id="golongan_darah" name="golongan_darah" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                    <option value="">Pilih Golongan Darah</option>
                                    <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                                    <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O</option>
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="penyakit_pernah_diderita">
                                    Penyakit yang Pernah Diderita
                                </label>
                                <textarea id="penyakit_pernah_diderita" name="penyakit_pernah_diderita" rows="2" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Contoh: Demam berdarah, cacar, asma, dll">{{ old('penyakit_pernah_diderita') }}</textarea>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="imunisasi_pernah_diterima">
                                    Imunisasi yang Pernah Diterima
                                </label>
                                <textarea id="imunisasi_pernah_diterima" name="imunisasi_pernah_diterima" rows="2" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Contoh: BCG, Polio, Campak, Hepatitis, DPT">{{ old('imunisasi_pernah_diterima') }}</textarea>
                            </div>
                        </div>

                        <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-slate-100">
                            <a href="{{ route('ppdb.index') }}" class="px-8 py-3 rounded-full border border-slate-200 text-slate-600 font-bold hover:bg-slate-50 transition-colors">
                                Batal
                            </a>
                            <button type="button" class="next-step px-10 py-3 rounded-full bg-primary text-white font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all flex items-center gap-2">
                                <span>Selanjutnya</span>
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 2: DATA ORANG TUA -->
                    <div class="step-content" data-step="2">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center text-green-600">
                                <span class="material-symbols-outlined">people</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-800 tracking-tight">Data Orang Tua & Wali</h3>
                                <p class="text-xs text-slate-400">Informasi ayah, ibu, dan wali calon siswa</p>
                            </div>
                        </div>

                        <!-- Data Ayah -->
                        <div class="mb-8">
                            <h4 class="font-bold text-slate-700 mb-4 flex items-center gap-2">
                                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                Data Ayah
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="nama_lengkap_ayah">
                                        Nama Lengkap Ayah <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="nama_lengkap_ayah" name="nama_lengkap_ayah" value="{{ old('nama_lengkap_ayah') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="nik_ayah">
                                        NIK Ayah <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="nik_ayah" name="nik_ayah" value="{{ old('nik_ayah') }}" required maxlength="16" pattern="[0-9]{16}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="16 digit NIK">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="tempat_lahir_ayah">
                                        Tempat Lahir Ayah <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="tempat_lahir_ayah" name="tempat_lahir_ayah" value="{{ old('tempat_lahir_ayah') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="tanggal_lahir_ayah">
                                        Tanggal Lahir Ayah <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" id="tanggal_lahir_ayah" name="tanggal_lahir_ayah" value="{{ old('tanggal_lahir_ayah') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="pendidikan_ayah">
                                        Pendidikan Ayah
                                    </label>
                                    <select id="pendidikan_ayah" name="pendidikan_ayah" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                        <option value="">Pilih Pendidikan</option>
                                        <option value="Tidak Sekolah" {{ old('pendidikan_ayah') == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                                        <option value="SD" {{ old('pendidikan_ayah') == 'SD' ? 'selected' : '' }}>SD</option>
                                        <option value="SMP" {{ old('pendidikan_ayah') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                        <option value="SMA" {{ old('pendidikan_ayah') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                        <option value="D1" {{ old('pendidikan_ayah') == 'D1' ? 'selected' : '' }}>D1</option>
                                        <option value="D2" {{ old('pendidikan_ayah') == 'D2' ? 'selected' : '' }}>D2</option>
                                        <option value="D3" {{ old('pendidikan_ayah') == 'D3' ? 'selected' : '' }}>D3</option>
                                        <option value="S1" {{ old('pendidikan_ayah') == 'S1' ? 'selected' : '' }}>S1</option>
                                        <option value="S2" {{ old('pendidikan_ayah') == 'S2' ? 'selected' : '' }}>S2</option>
                                        <option value="S3" {{ old('pendidikan_ayah') == 'S3' ? 'selected' : '' }}>S3</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="pekerjaan_ayah">
                                        Pekerjaan Ayah
                                    </label>
                                    <select id="pekerjaan_ayah" name="pekerjaan_ayah" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                        <option value="">Pilih Pekerjaan</option>
                                        <option value="Pekerja Informal" {{ old('pekerjaan_ayah') == 'Pekerja Informal' ? 'selected' : '' }}>Pekerja Informal</option>
                                        <option value="Wirausaha" {{ old('pekerjaan_ayah') == 'Wirausaha' ? 'selected' : '' }}>Wirausaha</option>
                                        <option value="Pegawai Swasta" {{ old('pekerjaan_ayah') == 'Pegawai Swasta' ? 'selected' : '' }}>Pegawai Swasta</option>
                                        <option value="PNS" {{ old('pekerjaan_ayah') == 'PNS' ? 'selected' : '' }}>Pegawai Negeri Sipil (PNS)</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="bidang_pekerjaan_ayah">
                                        Bidang Pekerjaan
                                    </label>
                                    <input type="text" id="bidang_pekerjaan_ayah" name="bidang_pekerjaan_ayah" value="{{ old('bidang_pekerjaan_ayah') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Contoh: Teknologi Informasi, Pendidikan">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="penghasilan_per_bulan_ayah">
                                        Penghasilan per Bulan
                                    </label>
                                    <select id="penghasilan_per_bulan_ayah" name="penghasilan_per_bulan_ayah" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                        <option value="">Pilih Penghasilan</option>
                                        <option value="< 1 juta" {{ old('penghasilan_per_bulan_ayah') == '< 1 juta' ? 'selected' : '' }}>< Rp 1.000.000</option>
                                        <option value="1-3 juta" {{ old('penghasilan_per_bulan_ayah') == '1-3 juta' ? 'selected' : '' }}>Rp 1.000.000 - 3.000.000</option>
                                        <option value="3-5 juta" {{ old('penghasilan_per_bulan_ayah') == '3-5 juta' ? 'selected' : '' }}>Rp 3.000.000 - 5.000.000</option>
                                        <option value="5-10 juta" {{ old('penghasilan_per_bulan_ayah') == '5-10 juta' ? 'selected' : '' }}>Rp 5.000.000 - 10.000.000</option>
                                        <option value="> 10 juta" {{ old('penghasilan_per_bulan_ayah') == '> 10 juta' ? 'selected' : '' }}>> Rp 10.000.000</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="nomor_telepon_ayah">
                                        Nomor Telepon/WA Ayah <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" id="nomor_telepon_ayah" name="nomor_telepon_ayah" value="{{ old('nomor_telepon_ayah') }}" required maxlength="16" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="081234567890">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="email_ayah">
                                        Email Ayah
                                    </label>
                                    <input type="email" id="email_ayah" name="email_ayah" value="{{ old('email_ayah') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="ayah@email.com">
                                </div>
                            </div>
                        </div>

                        <!-- Data Ibu -->
                        <div class="mb-8">
                            <h4 class="font-bold text-slate-700 mb-4 flex items-center gap-2">
                                <span class="w-2 h-2 bg-pink-500 rounded-full"></span>
                                Data Ibu
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="nama_lengkap_ibu">
                                        Nama Lengkap Ibu <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="nama_lengkap_ibu" name="nama_lengkap_ibu" value="{{ old('nama_lengkap_ibu') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="nik_ibu">
                                        NIK Ibu <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="nik_ibu" name="nik_ibu" value="{{ old('nik_ibu') }}" required maxlength="16" pattern="[0-9]{16}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="16 digit NIK">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="tempat_lahir_ibu">
                                        Tempat Lahir Ibu <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="tempat_lahir_ibu" name="tempat_lahir_ibu" value="{{ old('tempat_lahir_ibu') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="tanggal_lahir_ibu">
                                        Tanggal Lahir Ibu <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" id="tanggal_lahir_ibu" name="tanggal_lahir_ibu" value="{{ old('tanggal_lahir_ibu') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="pendidikan_ibu">
                                        Pendidikan Ibu
                                    </label>
                                    <select id="pendidikan_ibu" name="pendidikan_ibu" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                        <option value="">Pilih Pendidikan</option>
                                        <option value="Tidak Sekolah" {{ old('pendidikan_ibu') == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                                        <option value="SD" {{ old('pendidikan_ibu') == 'SD' ? 'selected' : '' }}>SD</option>
                                        <option value="SMP" {{ old('pendidikan_ibu') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                        <option value="SMA" {{ old('pendidikan_ibu') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                        <option value="D1" {{ old('pendidikan_ibu') == 'D1' ? 'selected' : '' }}>D1</option>
                                        <option value="D2" {{ old('pendidikan_ibu') == 'D2' ? 'selected' : '' }}>D2</option>
                                        <option value="D3" {{ old('pendidikan_ibu') == 'D3' ? 'selected' : '' }}>D3</option>
                                        <option value="S1" {{ old('pendidikan_ibu') == 'S1' ? 'selected' : '' }}>S1</option>
                                        <option value="S2" {{ old('pendidikan_ibu') == 'S2' ? 'selected' : '' }}>S2</option>
                                        <option value="S3" {{ old('pendidikan_ibu') == 'S3' ? 'selected' : '' }}>S3</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="pekerjaan_ibu">
                                        Pekerjaan Ibu
                                    </label>
                                    <select id="pekerjaan_ibu" name="pekerjaan_ibu" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                        <option value="">Pilih Pekerjaan</option>
                                        <option value="Ibu Rumah Tangga" {{ old('pekerjaan_ibu') == 'Ibu Rumah Tangga' ? 'selected' : '' }}>Ibu Rumah Tangga</option>
                                        <option value="Pekerja Informal" {{ old('pekerjaan_ibu') == 'Pekerja Informal' ? 'selected' : '' }}>Pekerja Informal</option>
                                        <option value="Wirausaha" {{ old('pekerjaan_ibu') == 'Wirausaha' ? 'selected' : '' }}>Wirausaha</option>
                                        <option value="Pegawai Swasta" {{ old('pekerjaan_ibu') == 'Pegawai Swasta' ? 'selected' : '' }}>Pegawai Swasta</option>
                                        <option value="PNS" {{ old('pekerjaan_ibu') == 'PNS' ? 'selected' : '' }}>Pegawai Negeri Sipil (PNS)</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="bidang_pekerjaan_ibu">
                                        Bidang Pekerjaan
                                    </label>
                                    <input type="text" id="bidang_pekerjaan_ibu" name="bidang_pekerjaan_ibu" value="{{ old('bidang_pekerjaan_ibu') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Contoh: Kesehatan, Pendidikan">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="penghasilan_per_bulan_ibu">
                                        Penghasilan per Bulan
                                    </label>
                                    <select id="penghasilan_per_bulan_ibu" name="penghasilan_per_bulan_ibu" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                        <option value="">Pilih Penghasilan</option>
                                        <option value="< 1 juta" {{ old('penghasilan_per_bulan_ibu') == '< 1 juta' ? 'selected' : '' }}>< Rp 1.000.000</option>
                                        <option value="1-3 juta" {{ old('penghasilan_per_bulan_ibu') == '1-3 juta' ? 'selected' : '' }}>Rp 1.000.000 - 3.000.000</option>
                                        <option value="3-5 juta" {{ old('penghasilan_per_bulan_ibu') == '3-5 juta' ? 'selected' : '' }}>Rp 3.000.000 - 5.000.000</option>
                                        <option value="5-10 juta" {{ old('penghasilan_per_bulan_ibu') == '5-10 juta' ? 'selected' : '' }}>Rp 5.000.000 - 10.000.000</option>
                                        <option value="> 10 juta" {{ old('penghasilan_per_bulan_ibu') == '> 10 juta' ? 'selected' : '' }}>> Rp 10.000.000</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="nomor_telepon_ibu">
                                        Nomor Telepon/WA Ibu <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" id="nomor_telepon_ibu" name="nomor_telepon_ibu" value="{{ old('nomor_telepon_ibu') }}" required maxlength="16" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="081234567890">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="email_ibu">
                                        Email Ibu
                                    </label>
                                    <input type="email" id="email_ibu" name="email_ibu" value="{{ old('email_ibu') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="ibu@email.com">
                                </div>
                            </div>
                        </div>

                        <!-- Data Wali -->
                        <div class="mb-6">
                            <div class="flex items-center mb-4">
                                <input type="checkbox" id="punya_wali" name="punya_wali" value="1" {{ old('punya_wali') ? 'checked' : '' }} class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary">
                                <label for="punya_wali" class="ml-2 text-sm text-gray-700 font-medium">
                                    Centang jika memiliki wali (berbeda dari ayah/ibu)
                                </label>
                            </div>

                            <div id="dataWaliContainer" class="{{ old('punya_wali') ? '' : 'hidden' }}">
                                <h4 class="font-bold text-slate-700 mb-4 flex items-center gap-2">
                                    <span class="w-2 h-2 bg-purple-500 rounded-full"></span>
                                    Data Wali
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2" for="nama_lengkap_wali">
                                            Nama Lengkap Wali
                                        </label>
                                        <input type="text" id="nama_lengkap_wali" name="nama_lengkap_wali" value="{{ old('nama_lengkap_wali') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2" for="hubungan_dengan_anak">
                                            Hubungan dengan Anak
                                        </label>
                                        <select id="hubungan_dengan_anak" name="hubungan_dengan_anak" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                            <option value="">Pilih Hubungan</option>
                                            <option value="Kakek" {{ old('hubungan_dengan_anak') == 'Kakek' ? 'selected' : '' }}>Kakek</option>
                                            <option value="Nenek" {{ old('hubungan_dengan_anak') == 'Nenek' ? 'selected' : '' }}>Nenek</option>
                                            <option value="Paman" {{ old('hubungan_dengan_anak') == 'Paman' ? 'selected' : '' }}>Paman</option>
                                            <option value="Bibi" {{ old('hubungan_dengan_anak') == 'Bibi' ? 'selected' : '' }}>Bibi</option>
                                            <option value="Kakak" {{ old('hubungan_dengan_anak') == 'Kakak' ? 'selected' : '' }}>Kakak</option>
                                            <option value="Lainnya" {{ old('hubungan_dengan_anak') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2" for="nik_wali">
                                            NIK Wali
                                        </label>
                                        <input type="text" id="nik_wali" name="nik_wali" value="{{ old('nik_wali') }}" maxlength="16" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="16 digit NIK">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2" for="tempat_lahir_wali">
                                            Tempat Lahir Wali
                                        </label>
                                        <input type="text" id="tempat_lahir_wali" name="tempat_lahir_wali" value="{{ old('tempat_lahir_wali') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2" for="tanggal_lahir_wali">
                                            Tanggal Lahir Wali
                                        </label>
                                        <input type="date" id="tanggal_lahir_wali" name="tanggal_lahir_wali" value="{{ old('tanggal_lahir_wali') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2" for="pendidikan_wali">
                                            Pendidikan Wali
                                        </label>
                                        <select id="pendidikan_wali" name="pendidikan_wali" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                            <option value="">Pilih Pendidikan</option>
                                            <option value="Tidak Sekolah" {{ old('pendidikan_wali') == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                                            <option value="SD" {{ old('pendidikan_wali') == 'SD' ? 'selected' : '' }}>SD</option>
                                            <option value="SMP" {{ old('pendidikan_wali') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                            <option value="SMA" {{ old('pendidikan_wali') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                            <option value="D1" {{ old('pendidikan_wali') == 'D1' ? 'selected' : '' }}>D1</option>
                                            <option value="D2" {{ old('pendidikan_wali') == 'D2' ? 'selected' : '' }}>D2</option>
                                            <option value="D3" {{ old('pendidikan_wali') == 'D3' ? 'selected' : '' }}>D3</option>
                                            <option value="S1" {{ old('pendidikan_wali') == 'S1' ? 'selected' : '' }}>S1</option>
                                            <option value="S2" {{ old('pendidikan_wali') == 'S2' ? 'selected' : '' }}>S2</option>
                                            <option value="S3" {{ old('pendidikan_wali') == 'S3' ? 'selected' : '' }}>S3</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2" for="pekerjaan_wali">
                                            Pekerjaan Wali
                                        </label>
                                        <select id="pekerjaan_wali" name="pekerjaan_wali" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                            <option value="">Pilih Pekerjaan</option>
                                            <option value="Pekerja Informal" {{ old('pekerjaan_wali') == 'Pekerja Informal' ? 'selected' : '' }}>Pekerja Informal</option>
                                            <option value="Wirausaha" {{ old('pekerjaan_wali') == 'Wirausaha' ? 'selected' : '' }}>Wirausaha</option>
                                            <option value="Pegawai Swasta" {{ old('pekerjaan_wali') == 'Pegawai Swasta' ? 'selected' : '' }}>Pegawai Swasta</option>
                                            <option value="PNS" {{ old('pekerjaan_wali') == 'PNS' ? 'selected' : '' }}>Pegawai Negeri Sipil (PNS)</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2" for="nomor_telepon_wali">
                                            Nomor Telepon/WA Wali
                                        </label>
                                        <input type="tel" id="nomor_telepon_wali" name="nomor_telepon_wali" value="{{ old('nomor_telepon_wali') }}" maxlength="16" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="081234567890">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2" for="email_wali">
                                            Email Wali
                                        </label>
                                        <input type="email" id="email_wali" name="email_wali" value="{{ old('email_wali') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="wali@email.com">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between gap-4 mt-8 pt-6 border-t border-slate-100">
                            <button type="button" class="prev-step px-8 py-3 rounded-full border border-slate-200 text-slate-600 font-bold hover:bg-slate-50 transition-colors flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">arrow_back</span>
                                <span>Kembali</span>
                            </button>
                            <button type="button" class="next-step px-10 py-3 rounded-full bg-primary text-white font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all flex items-center gap-2">
                                <span>Selanjutnya</span>
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 3: ALAMAT & INFORMASI TAMBAHAN -->
                    <div class="step-content" data-step="3">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600">
                                <span class="material-symbols-outlined">location_on</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-800 tracking-tight">Alamat & Informasi Tambahan</h3>
                                <p class="text-xs text-slate-400">Alamat lengkap dan informasi tambahan</p>
                            </div>
                        </div>

                        <!-- Alamat Rumah -->
                        <div class="mb-8">
                            <h4 class="font-bold text-slate-700 mb-4">Alamat Rumah</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="provinsi_rumah">
                                        Provinsi <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="provinsi_rumah" name="provinsi_rumah" value="{{ old('provinsi_rumah', 'Jawa Barat') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="kota_kabupaten_rumah">
                                        Kota/Kabupaten <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="kota_kabupaten_rumah" name="kota_kabupaten_rumah" value="{{ old('kota_kabupaten_rumah', 'Kota Bandung') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="kecamatan_rumah">
                                        Kecamatan <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="kecamatan_rumah" name="kecamatan_rumah" value="{{ old('kecamatan_rumah') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="kelurahan_rumah">
                                        Kelurahan <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="kelurahan_rumah" name="kelurahan_rumah" value="{{ old('kelurahan_rumah') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="nama_jalan_rumah">
                                        Nama Jalan <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="nama_jalan_rumah" name="nama_jalan_rumah" value="{{ old('nama_jalan_rumah') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Jl. Terusan PSM No. 1A, RT 01 RW 02">
                                </div>

                                <div class="md:col-span-2 flex items-center">
                                    <input type="checkbox" id="alamat_kk_sama" name="alamat_kk_sama" value="1" {{ old('alamat_kk_sama') ? 'checked' : '' }} class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary">
                                    <label for="alamat_kk_sama" class="ml-2 text-sm text-gray-700">
                                        Alamat di Kartu Keluarga (KK) sama dengan alamat di atas
                                    </label>
                                </div>
                            </div>

                            <div id="alamatKKContainer" class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 {{ old('alamat_kk_sama') ? 'hidden' : '' }}">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="provinsi_kk">
                                        Provinsi (KK)
                                    </label>
                                    <input type="text" id="provinsi_kk" name="provinsi_kk" value="{{ old('provinsi_kk') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="kota_kabupaten_kk">
                                        Kota/Kabupaten (KK)
                                    </label>
                                    <input type="text" id="kota_kabupaten_kk" name="kota_kabupaten_kk" value="{{ old('kota_kabupaten_kk') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="kecamatan_kk">
                                        Kecamatan (KK)
                                    </label>
                                    <input type="text" id="kecamatan_kk" name="kecamatan_kk" value="{{ old('kecamatan_kk') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="kelurahan_kk">
                                        Kelurahan (KK)
                                    </label>
                                    <input type="text" id="kelurahan_kk" name="kelurahan_kk" value="{{ old('kelurahan_kk') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="nama_jalan_kk">
                                        Nama Jalan (KK)
                                    </label>
                                    <input type="text" id="nama_jalan_kk" name="nama_jalan_kk" value="{{ old('nama_jalan_kk') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="alamat_kk">
                                        Alamat KK Lengkap
                                    </label>
                                    <textarea id="alamat_kk" name="alamat_kk" rows="2" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">{{ old('alamat_kk') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Tambahan -->
                        <div>
                            <h4 class="font-bold text-slate-700 mb-4">Informasi Tambahan</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="tahun_ajaran_id">
                                        Tahun Ajaran <span class="text-red-500">*</span>
                                    </label>
                                    <select id="tahun_ajaran_id" name="tahun_ajaran_id" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                        <option value="">Pilih Tahun Ajaran</option>
                                        @if($tahunAjaranAktif)
                                        <option value="{{ $tahunAjaranAktif->id }}" selected>{{ $tahunAjaranAktif->tahun_ajaran }} (Aktif)</option>
                                        @endif
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="jenis_daftar">
                                        Jenis Pendaftaran <span class="text-red-500">*</span>
                                    </label>
                                    <select id="jenis_daftar" name="jenis_daftar" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                        <option value="">Pilih Jenis</option>
                                        <option value="Siswa Baru" {{ old('jenis_daftar', 'Siswa Baru') == 'Siswa Baru' ? 'selected' : '' }}>Siswa Baru</option>
                                        <option value="Pindahan" {{ old('jenis_daftar') == 'Pindahan' ? 'selected' : '' }}>Pindahan</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="sumber_informasi_ppdb">
                                        Sumber Informasi PPDB
                                    </label>
                                    <select id="sumber_informasi_ppdb" name="sumber_informasi_ppdb" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                        <option value="">Pilih Sumber</option>
                                        <option value="Media Sosial" {{ old('sumber_informasi_ppdb') == 'Media Sosial' ? 'selected' : '' }}>Media Sosial</option>
                                        <option value="Website Sekolah" {{ old('sumber_informasi_ppdb') == 'Website Sekolah' ? 'selected' : '' }}>Website Sekolah</option>
                                        <option value="Spanduk/Baliho" {{ old('sumber_informasi_ppdb') == 'Spanduk/Baliho' ? 'selected' : '' }}>Spanduk/Baliho</option>
                                        <option value="Teman/Keluarga" {{ old('sumber_informasi_ppdb') == 'Teman/Keluarga' ? 'selected' : '' }}>Teman/Keluarga</option>
                                        <option value="Guru" {{ old('sumber_informasi_ppdb') == 'Guru' ? 'selected' : '' }}>Guru</option>
                                        <option value="Lainnya" {{ old('sumber_informasi_ppdb') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="punya_saudara_sekolah_tk">
                                        Apakah anak memiliki saudara yang bersekolah di TK ini?
                                    </label>
                                    <select id="punya_saudara_sekolah_tk" name="punya_saudara_sekolah_tk" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                        <option value="">Pilih</option>
                                        <option value="Ya" {{ old('punya_saudara_sekolah_tk') == 'Ya' ? 'selected' : '' }}>Ya</option>
                                        <option value="Tidak" {{ old('punya_saudara_sekolah_tk', 'Tidak') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between gap-4 mt-8 pt-6 border-t border-slate-100">
                            <button type="button" class="prev-step px-8 py-3 rounded-full border border-slate-200 text-slate-600 font-bold hover:bg-slate-50 transition-colors flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">arrow_back</span>
                                <span>Kembali</span>
                            </button>
                            <button type="button" class="next-step px-10 py-3 rounded-full bg-primary text-white font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all flex items-center gap-2">
                                <span>Selanjutnya</span>
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 4: UPLOAD BERKAS -->
                    <div class="step-content" data-step="4">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center text-yellow-600">
                                <span class="material-symbols-outlined">description</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-800 tracking-tight">Upload Dokumen</h3>
                                <p class="text-xs text-slate-400">Upload dokumen yang diperlukan (PDF/JPG/PNG, maks. 2MB)</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="akte_kelahiran">
                                    Akta Kelahiran <span class="text-red-500">*</span>
                                </label>
                                <input type="file" id="akte_kelahiran" name="akte_kelahiran" accept=".pdf,.jpg,.jpeg,.png" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                <p class="text-xs text-gray-500 mt-1">Format: PDF, JPG, PNG (maks. 2MB)</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="kartu_keluarga">
                                    Kartu Keluarga <span class="text-red-500">*</span>
                                </label>
                                <input type="file" id="kartu_keluarga" name="kartu_keluarga" accept=".pdf,.jpg,.jpeg,.png" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                <p class="text-xs text-gray-500 mt-1">Format: PDF, JPG, PNG (maks. 2MB)</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="ktp_orang_tua">
                                    KTP Orang Tua/Wali <span class="text-red-500">*</span>
                                </label>
                                <input type="file" id="ktp_orang_tua" name="ktp_orang_tua" accept=".pdf,.jpg,.jpeg,.png" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                <p class="text-xs text-gray-500 mt-1">Format: PDF, JPG, PNG (maks. 2MB)</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-4 bg-primary/5 rounded-xl border border-primary/10 mt-6">
                            <span class="material-symbols-outlined text-primary">info</span>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Pastikan semua dokumen yang diupload jelas dan dapat dibaca. File yang blur atau tidak jelas akan mempengaruhi proses verifikasi.
                            </p>
                        </div>

                        <div class="flex justify-between gap-4 mt-8 pt-6 border-t border-slate-100">
                            <button type="button" class="prev-step px-8 py-3 rounded-full border border-slate-200 text-slate-600 font-bold hover:bg-slate-50 transition-colors flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">arrow_back</span>
                                <span>Kembali</span>
                            </button>
                            <button type="button" class="next-step px-10 py-3 rounded-full bg-primary text-white font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all flex items-center gap-2">
                                <span>Selanjutnya</span>
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 5: KONFIRMASI -->
                    <div class="step-content" data-step="5">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center text-green-600">
                                <span class="material-symbols-outlined">check_circle</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-800 tracking-tight">Konfirmasi Pendaftaran</h3>
                                <p class="text-xs text-slate-400">Periksa kembali data sebelum提交</p>
                            </div>
                        </div>

                        <div class="bg-slate-50 rounded-xl p-6 mb-6">
                            <p class="text-sm text-slate-600 mb-4">Dengan ini saya menyatakan bahwa data yang填写 adalah benar dan sesuai dengan dokumen resmi. Saya memahami bahwa:</p>
                            <ul class="text-sm text-slate-600 space-y-2">
                                <li class="flex items-start gap-2">
                                    <span class="material-symbols-outlined text-green-600 text-sm mt-0.5">check</span>
                                    <span>Data yang sudah dikirim tidak dapat diubah secara mandiri</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="material-symbols-outlined text-green-600 text-sm mt-0.5">check</span>
                                    <span>Admin sekolah akan memverifikasi data dan dokumen</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="material-symbols-outlined text-green-600 text-sm mt-0.5">check</span>
                                    <span>Hasil seleksi akan diinformasikan melalui dashboard</span>
                                </li>
                            </ul>
                        </div>

                        <div class="flex items-center mb-6">
                            <input type="checkbox" id="konfirmasi_data" name="konfirmasi_data" value="1" required class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary">
                            <label for="konfirmasi_data" class="ml-2 text-sm text-gray-700 font-medium">
                                Saya确认 semua data dan dokumen yang diupload adalah benar <span class="text-red-500">*</span>
                            </label>
                        </div>

                        <div class="flex justify-between gap-4 mt-8 pt-6 border-t border-slate-100">
                            <button type="button" class="prev-step px-8 py-3 rounded-full border border-slate-200 text-slate-600 font-bold hover:bg-slate-50 transition-colors flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">arrow_back</span>
                                <span>Kembali</span>
                            </button>
                            <button type="button" id="submitPpdbBtn" class="px-10 py-3 rounded-full bg-green-600 text-white font-bold shadow-lg shadow-green-600/20 hover:scale-[1.02] active:scale-95 transition-all flex items-center gap-2 relative z-[200] cursor-pointer pointer-events-auto">
                                <span class="material-symbols-outlined text-sm">send</span>
                                <span>Kirim Pendaftaran</span>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
            @endif
    </div>
</section>
</main>

<footer class="bg-white border-t border-slate-200 pt-16 pb-8 px-4 md:px-10">
<div class="max-w-7xl mx-auto">
<div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
<div class="col-span-1 md:col-span-2">
<div class="flex items-center gap-3 mb-6">
<div class="bg-primary p-2 rounded-lg text-white">
<span class="material-symbols-outlined block text-[24px]">school</span>
</div>
<h2 class="text-2xl font-black tracking-tight">TK PGRI HARAPAN BANGSA 1</h2>
</div>
<p class="text-slate-500 max-w-sm leading-relaxed mb-6">
                        Menyiapkan generasi unggul yang berkarakter, kreatif, dan mandiri melalui pendidikan berkualitas yang berfokus pada potensi anak sejak usia dini.
                    </p>
</div>
<div>
<h4 class="font-bold mb-6">Link Cepat</h4>
<ul class="space-y-4 text-slate-500 text-sm">
<li><a class="hover:text-primary transition-colors" href="#">Visi &amp; Misi</a></li>
<li><a class="hover:text-primary transition-colors" href="#">Program Belajar</a></li>
<li><a class="hover:text-primary transition-colors" href="#">Fasilitas</a></li>
<li><a class="hover:text-primary transition-colors" href="#">Ekstrakurikuler</a></li>
</ul>
</div>
<div>
<h4 class="font-bold mb-6">Kontak</h4>
<ul class="space-y-4 text-slate-500 text-sm">
<li class="flex items-start gap-3">
<span class="material-symbols-outlined text-primary text-lg">location_on</span>
<span>Jl. Pendidikan No. 123, Indonesia</span>
</li>
<li class="flex items-center gap-3">
<span class="material-symbols-outlined text-primary text-lg">call</span>
<span>(021) 555-0123</span>
</li>
<li class="flex items-center gap-3">
<span class="material-symbols-outlined text-primary text-lg">mail</span>
<span>info@tkpgrihb1.sch.id</span>
</li>
</ul>
</div>
</div>
<div class="border-t border-slate-100 pt-8 text-center text-sm text-slate-400">
<p>&copy; 2025 TK PGRI HARAPAN BANGSA 1. All rights reserved.</p>
</div>
</div>
</footer>
</div>

<script>
let currentStep = 1;
const totalSteps = 5;

const stepLabels = ['Data Pribadi', 'Data Orang Tua', 'Alamat & Info', 'Upload Berkas', 'Konfirmasi'];

function updateStep() {
    document.querySelectorAll('.step-content').forEach(el => el.classList.remove('active'));
    document.querySelector(`.step-content[data-step="${currentStep}"]`).classList.add('active');
    
    document.querySelectorAll('.step-indicator').forEach((el, idx) => {
        el.classList.remove('active', 'completed');
        if (idx + 1 < currentStep) {
            el.classList.add('completed');
            el.innerHTML = '<span class="material-symbols-outlined text-sm">check</span>';
        } else if (idx + 1 === currentStep) {
            el.classList.add('active');
            el.innerHTML = idx + 1;
        } else {
            el.innerHTML = idx + 1;
        }
    });
    
    document.getElementById('progressBar').style.width = (currentStep * 20) + '%';
    document.getElementById('stepLabel').textContent = stepLabels[currentStep - 1];
    
    const form = document.getElementById('ppdbForm');
    if (form) {
        form.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

document.querySelectorAll('.next-step').forEach(btn => {
    btn.addEventListener('click', () => {
        if (currentStep < totalSteps) {
            currentStep++;
            updateStep();
        }
    });
});

// Countdown Timer untuk PPDB
@if($statusPendaftaran['is_dibuka'] && $statusPendaftaran['tanggal_selesai'])
const countdownTimer = document.getElementById('countdown-timer');
if (countdownTimer) {
    const targetDate = new Date('{{ $statusPendaftaran['tanggal_selesai']->toIso8601String() }}');
    
    function updateCountdown() {
        const now = new Date();
        const difference = targetDate - now;
        
        if (difference > 0) {
            const days = Math.floor(difference / (1000 * 60 * 60 * 24));
            const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((difference % (1000 * 60)) / 1000);
            
            let timeString = '';
            if (days > 0) {
                timeString = `${days} hari ${hours} jam`;
            } else if (hours > 0) {
                timeString = `${hours} jam ${minutes} menit`;
            } else if (minutes > 0) {
                timeString = `${minutes} menit ${seconds} detik`;
            } else {
                timeString = `${seconds} detik`;
            }
            
            countdownTimer.textContent = timeString;
        } else {
            countdownTimer.textContent = 'Selesai';
            // Refresh page untuk update status
            setTimeout(() => {
                window.location.reload();
            }, 5000);
        }
    }
    
    updateCountdown();
    setInterval(updateCountdown, 1000);
}
@endif

document.querySelectorAll('.prev-step').forEach(btn => {
    btn.addEventListener('click', () => {
        if (currentStep > 1) {
            currentStep--;
            updateStep();
        }
    });
});

document.querySelectorAll('.step-indicator').forEach(indicator => {
    indicator.addEventListener('click', () => {
        const step = parseInt(indicator.dataset.step);
        if (step < currentStep) {
            currentStep = step;
            updateStep();
        }
    });
});

document.getElementById('punya_wali').addEventListener('change', function() {
    const container = document.getElementById('dataWaliContainer');
    container.classList.toggle('hidden', !this.checked);
});

document.getElementById('alamat_kk_sama').addEventListener('change', function() {
    const container = document.getElementById('alamatKKContainer');
    container.classList.toggle('hidden', this.checked);
    if (this.checked) {
        document.getElementById('provinsi_kk').value = '';
        document.getElementById('kota_kabupaten_kk').value = '';
        document.getElementById('kecamatan_kk').value = '';
        document.getElementById('kelurahan_kk').value = '';
        document.getElementById('nama_jalan_kk').value = '';
        document.getElementById('alamat_kk').value = '';
    }
});

['nik_anak', 'nik_ayah', 'nik_ibu', 'nik_wali'].forEach(id => {
    const el = document.getElementById(id);
    if (el) {
        el.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 16) {
                this.value = this.value.substring(0, 16);
            }
        });
    }
});

['nomor_telepon_ayah', 'nomor_telepon_ibu', 'nomor_telepon_wali'].forEach(id => {
    const el = document.getElementById(id);
    if (el) {
        el.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 16) {
                this.value = this.value.substring(0, 16);
            }
        });
    }
});

(() => {
    const trigger = document.getElementById('profile-trigger');
    const dropdown = document.getElementById('profile-dropdown');
    const backdrop = document.getElementById('profile-backdrop');

    if (!trigger || !dropdown || !backdrop) return;

    const close = () => {
        dropdown.classList.add('hidden');
        backdrop.classList.add('hidden');
    };

    const toggle = () => {
        dropdown.classList.toggle('hidden');
        backdrop.classList.toggle('hidden');
    };

    trigger.addEventListener('click', (e) => {
        e.preventDefault();
        toggle();
    });

    backdrop.addEventListener('click', close);

    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') close();
    });
})();

document.getElementById('submitPpdbBtn').addEventListener('click', function() {
    var konfirmasi = document.getElementById('konfirmasi_data');
    if (!konfirmasi.checked) {
        alert('Mohon centang konfirmasi bahwa data yang diinput benar');
        return;
    }
    var form = document.getElementById('ppdbForm');
    if (form) {
        form.submit();
    }
});
</script>

</body></html>
