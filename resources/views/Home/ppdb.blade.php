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
    </style>
</head>
<body class="bg-background-light font-display text-slate-900 wavy-bg pt-[60px] md:pt-[72px]">
<div class="relative flex min-h-screen flex-col overflow-x-hidden">
<header id="navbar" class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-md border-b border-primary/10 px-4 md:px-10 py-3 md:py-4">
<div class="max-w-7xl mx-auto flex items-center justify-between">
<div class="flex items-center gap-3">
<div class="bg-primary p-1.5 md:p-2 rounded-lg text-white">
<span class="material-symbols-outlined block text-[20px] md:text-[24px]">school</span>
</div>
<h2 class="text-sm md:text-xl font-extrabold tracking-tight text-slate-900">TK PGRI HARAPAN BANGSA 1</h2>
</div>

<!-- Mobile Menu Button -->
<button id="mobile-menu-btn" class="md:hidden w-10 h-10 flex items-center justify-center text-slate-700" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
<span class="material-symbols-outlined text-[28px]">menu</span>
</button>

<!-- Desktop Nav -->
<nav class="hidden md:flex items-center gap-8">
<a class="text-sm font-semibold hover:text-primary transition-colors" href="{{ route('home') }}">Beranda</a>
<a class="text-sm font-semibold hover:text-primary transition-colors" href="#">Profil</a>
<a class="text-sm font-semibold hover:text-primary transition-colors" href="#">Kurikulum</a>
<a class="text-sm font-semibold text-primary" href="{{ route('ppdb.index') }}">PPDB</a>
<a class="text-sm font-semibold hover:text-primary transition-colors" href="#">Informasi</a>
</nav>

<!-- Desktop Right Side -->
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
                        {{ strtoupper(substr($user->nama ?? $user->name ?? 'U', 0, 1)) }}
                    </span>
                @endif
            </div>
            <span class="text-sm font-bold text-slate-700">{{ $user->nama ?? $user->name ?? 'User' }}</span>
        </button>

        <div id="profile-backdrop" class="hidden fixed inset-0 z-40 bg-slate-900/20 backdrop-blur-[2px]"></div>

        <div id="profile-dropdown" class="hidden absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-2xl border border-slate-100 py-2 z-50 transform origin-top-right transition-all">
            <div class="px-5 py-4 border-b border-slate-50 flex items-center gap-3">
                <div class="w-12 h-12 rounded-full overflow-hidden border border-slate-100 bg-slate-200 flex items-center justify-center">
                    @if(!empty($user->foto))
                        <img src="{{ $user->foto }}" alt="Foto Profil" class="w-full h-full object-cover" />
                    @else
                        <span class="text-base font-black text-slate-600">
                            {{ strtoupper(substr($user->nama ?? $user->name ?? 'U', 0, 1)) }}
                        </span>
                    @endif
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-extrabold text-slate-800 leading-tight">{{ $user->nama ?? $user->name ?? 'User' }}</span>
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
                <a class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 rounded-xl transition-colors group" href="#">
                    <span class="material-symbols-outlined text-[20px] group-hover:text-primary">settings</span>
                    <span class="text-sm font-semibold">Pengaturan</span>
                </a>
            </div>

            <div class="border-t border-slate-50 mt-2 pt-2 px-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 text-rose-600 hover:bg-rose-50 rounded-xl transition-colors group">
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
                <span class="text-sm font-bold">Dashboard</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 rounded-xl transition-colors group" href="{{ route('siswa.dashboard') }}">
                <div class="w-8 h-8 rounded-lg bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-secondary group-hover:text-white transition-all">
                    <span class="material-symbols-outlined text-xl">person</span>
                </div>
                <span class="text-sm font-bold">Profil Saya</span>
            </a>
        </div>

        <div class="p-2 border-t border-slate-50 mt-1">
            <form method="POST" action="{{ route('siswa.logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-rose-500 hover:bg-rose-50 rounded-xl transition-colors group">
                    <div class="w-8 h-8 rounded-lg bg-rose-50 flex items-center justify-center group-hover:bg-rose-500 group-hover:text-white transition-all">
                        <span class="material-symbols-outlined text-xl font-bold">logout</span>
                    </div>
                    <span class="text-sm font-bold">Keluar</span>
                </button>
            </form>
        </div>
    </div>
</div>
@else
<a href="#register" class="bg-primary hover:bg-primary/90 text-white px-6 py-2.5 rounded-full font-bold text-sm transition-all shadow-lg shadow-primary/20">
Daftar
</a>
@endif
</div>
</div>

<!-- Mobile Menu Dropdown -->
<div id="mobile-menu" class="hidden md:hidden absolute top-full left-0 right-0 bg-white border-b border-primary/10 shadow-lg">
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
                    {{ strtoupper(substr($user->nama ?? $user->name ?? 'U', 0, 1)) }}
                </span>
            @endif
        </div>
        <div class="flex flex-col">
            <span class="text-sm font-bold text-slate-800">{{ $user->nama ?? $user->name ?? 'User' }}</span>
            <span class="text-[10px] text-primary uppercase">{{ $guard === 'siswa' ? 'Calon Siswa' : ($guard === 'admin' ? 'Admin' : 'Guru') }}</span>
        </div>
    </div>
    @if($guard === 'siswa')
    <a class="block text-sm font-semibold text-slate-700 hover:text-primary py-2" href="{{ route('siswa.dashboard') }}">Dashboard</a>
    @endif
    <a class="block text-sm font-semibold text-slate-700 hover:text-primary py-2" href="#">Profil Saya</a>
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
<div class="bg-white px-6 py-3 rounded-2xl shadow-md border-l-4 border-emerald-500 flex items-center gap-3">
<span class="material-symbols-outlined text-emerald-500">event_available</span>
<div class="text-left">
<p class="text-[10px] uppercase font-bold text-slate-400 leading-none">Pendaftaran Dibuka</p>
<p class="text-sm md:text-base font-black text-slate-900">1 Maret 2025</p>
</div>
</div>
<div class="bg-white px-6 py-3 rounded-2xl shadow-md border-l-4 border-rose-500 flex items-center gap-3">
<span class="material-symbols-outlined text-rose-500">event_busy</span>
<div class="text-left">
<p class="text-[10px] uppercase font-bold text-slate-400 leading-none">Pendaftaran Ditutup</p>
<p class="text-sm md:text-base font-black text-slate-900">30 Juni 2025</p>
</div>
</div>
</div>
<div class="flex flex-col sm:flex-row items-center justify-center gap-4">
@if(auth('siswa')->check())
<a href="#register" class="w-full sm:w-auto bg-primary text-white px-10 py-4 rounded-xl font-extrabold text-lg shadow-xl shadow-primary/30 hover:scale-105 transition-transform flex items-center justify-center gap-2">
    Daftar Sekarang
    <span class="material-symbols-outlined">arrow_forward</span>
</a>
@else
<a href="{{ route('siswa.login', ['redirect' => route('ppdb.index')]) }}" class="w-full sm:w-auto bg-primary text-white px-10 py-4 rounded-xl font-extrabold text-lg shadow-xl shadow-primary/30 hover:scale-105 transition-transform flex items-center justify-center gap-2">
    Daftar Sekarang
    <span class="material-symbols-outlined">arrow_forward</span>
</a>
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
<div class="max-w-4xl mx-auto bg-primary rounded-xl p-10 md:p-20 text-center relative z-10">
<h2 class="text-3xl md:text-5xl font-black text-white mb-6">Sudah Siap Bergabung?</h2>
<p class="text-white/80 text-lg mb-10 max-w-lg mx-auto">
                    Jangan lewatkan kesempatan untuk menjadi bagian dari keluarga besar TK PGRI HARAPAN BANGSA 1. Pendaftaran dibuka hingga 30 Juni 2025.
                </p>
@if(auth('siswa')->check())
<a href="#register" class="bg-white text-primary px-12 py-5 rounded-full font-black text-xl shadow-2xl hover:scale-105 transition-transform inline-block">Daftar Sekarang</a>
@else
<a href="{{ route('siswa.register', ['redirect' => route('ppdb.index') . '#register']) }}" class="bg-white text-primary px-12 py-5 rounded-full font-black text-xl shadow-2xl hover:scale-105 transition-transform inline-block">Daftar Sekarang</a>
@endif
<div class="absolute -top-10 -left-10 text-white/10">
<span class="material-symbols-outlined text-[150px]">rocket_launch</span>
</div>
</div>
</section>

<section id="register" class="px-4 pb-24">
    <div class="max-w-4xl mx-auto">
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl">
                {{ session('success') }}
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
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-8 md:p-10 border-b border-slate-100">
                    <h3 class="text-2xl font-black text-slate-900">Form Pendaftaran PPDB</h3>
                    <p class="text-slate-500 mt-2">Setelah dikirim, data tidak dapat diubah (read-only).</p>
                </div>

                <form action="{{ route('ppdb.store') }}" method="POST" class="p-8 md:p-10 grid grid-cols-1 md:grid-cols-2 gap-6">
                    @csrf

                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap Anak</label>
                        <input name="nama_lengkap_anak" value="{{ old('nama_lengkap_anak') }}" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200" required />
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">NIK Anak</label>
                        <input name="nik_anak" value="{{ old('nik_anak') }}" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200" maxlength="16" required />
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200" required>
                            <option value="">Pilih</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tempat Lahir</label>
                        <input name="tempat_lahir_anak" value="{{ old('tempat_lahir_anak') }}" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200" required />
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir_anak" value="{{ old('tanggal_lahir_anak') }}" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200" required />
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Agama</label>
                        <input name="agama" value="{{ old('agama', 'Islam') }}" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200" required />
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Anak Ke</label>
                        <input type="number" name="anak_ke" value="{{ old('anak_ke', 1) }}" min="1" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200" required />
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tinggal Bersama</label>
                        <input name="tinggal_bersama" value="{{ old('tinggal_bersama', 'Ayah dan Ibu') }}" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200" required />
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Status Tempat Tinggal</label>
                        <select name="status_tempat_tinggal" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200" required>
                            <option value="">Pilih</option>
                            <option value="Milik Sendiri" {{ old('status_tempat_tinggal') == 'Milik Sendiri' ? 'selected' : '' }}>Milik Sendiri</option>
                            <option value="Milik Keluarga" {{ old('status_tempat_tinggal') == 'Milik Keluarga' ? 'selected' : '' }}>Milik Keluarga</option>
                            <option value="Kontrakan" {{ old('status_tempat_tinggal') == 'Kontrakan' ? 'selected' : '' }}>Kontrakan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Bahasa Sehari-hari</label>
                        <input name="bahasa_sehari_hari" value="{{ old('bahasa_sehari_hari', 'Indonesia') }}" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200" required />
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Provinsi</label>
                        <input name="provinsi_rumah" value="{{ old('provinsi_rumah') }}" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200" required />
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Kota/Kabupaten</label>
                        <input name="kota_kabupaten_rumah" value="{{ old('kota_kabupaten_rumah') }}" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200" required />
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Kecamatan</label>
                        <input name="kecamatan_rumah" value="{{ old('kecamatan_rumah') }}" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200" required />
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Kelurahan</label>
                        <input name="kelurahan_rumah" value="{{ old('kelurahan_rumah') }}" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200" required />
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Alamat (Nama Jalan)</label>
                        <input name="nama_jalan_rumah" value="{{ old('nama_jalan_rumah') }}" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200" required />
                    </div>

                    <div class="md:col-span-2 pt-4">
                        <button type="submit" class="w-full bg-primary text-white px-8 py-4 rounded-2xl font-extrabold text-lg shadow-xl shadow-primary/30 hover:bg-primary/90 transition-colors">
                            Kirim Pendaftaran
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-10 text-center">
                <h3 class="text-xl font-black text-slate-900">Login/Register Dulu</h3>
                <p class="text-slate-500 mt-2">Untuk mengisi form PPDB kamu harus login sebagai siswa.</p>
                <div class="mt-6 flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('siswa.login', ['redirect' => route('ppdb.index') . '#register']) }}" class="bg-primary text-white px-8 py-3 rounded-full font-bold">Login</a>
                    <a href="{{ route('siswa.register', ['redirect' => route('ppdb.index') . '#register']) }}" class="border-2 border-primary text-primary px-8 py-3 rounded-full font-bold">Register</a>
                </div>
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
<div class="flex gap-4">
<a class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-primary hover:text-white transition-all" href="#">
<span class="material-symbols-outlined text-sm">social_leaderboard</span>
</a>
<a class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-primary hover:text-white transition-all" href="#">
<span class="material-symbols-outlined text-sm">camera</span>
</a>
<a class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-primary hover:text-white transition-all" href="#">
<span class="material-symbols-outlined text-sm">alternate_email</span>
</a>
</div>
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
window.addEventListener('scroll', () => {
    const mobileMenu = document.getElementById('mobile-menu');
    if (!mobileMenu.classList.contains('hidden')) {
        mobileMenu.classList.add('hidden');
    }

    const profileDropdown = document.getElementById('profile-dropdown');
    const profileBackdrop = document.getElementById('profile-backdrop');
    if (profileDropdown && !profileDropdown.classList.contains('hidden')) {
        profileDropdown.classList.add('hidden');
    }
    if (profileBackdrop && !profileBackdrop.classList.contains('hidden')) {
        profileBackdrop.classList.add('hidden');
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
</script>

</body></html>
