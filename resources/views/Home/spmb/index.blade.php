@extends('layouts.nav-spmb')

@section('title', 'PPDB Vidya Mandir')

@section('content')
@php
    $isPendaftaranOpen = $setting && 
                        $setting->pendaftaran_mulai && 
                        $setting->pendaftaran_selesai && 
                        $now->between($setting->pendaftaran_mulai, $setting->pendaftaran_selesai);

    $isPengumumanOpen = $setting && 
                        $setting->pengumuman_mulai && 
                        $setting->pengumuman_selesai && 
                        $now->between($setting->pengumuman_mulai, $setting->pengumuman_selesai);

    $isPublished = $setting && $setting->is_published;
@endphp

<!-- Hero Section -->
<section class="relative px-4 py-12 md:py-24 overflow-hidden">
<div class="blob w-96 h-96 bg-primary top-0 -left-20 rounded-full"></div>
<div class="blob w-96 h-96 bg-secondary bottom-0 -right-20 rounded-full"></div>
<div class="max-w-5xl mx-auto text-center">
<div class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-2 rounded-full mb-6">
<span class="material-symbols-outlined text-sm">campaign</span>
<span class="text-xs font-bold uppercase tracking-wider">Tahun Ajaran {{ $tahunAjaranAktif->nama_tahun_ajaran ?? '2026/2027' }}</span>
</div>
<h1 class="text-5xl md:text-7xl font-black text-slate-900 dark:text-slate-100 mb-6 leading-tight">
                        PPDB <span class="text-primary italic">Vidya Mandir</span>
</h1>
<p class="text-lg md:text-xl text-slate-600 dark:text-slate-400 max-w-2xl mx-auto mb-10 leading-relaxed">
                        Selamat datang di Penerimaan Peserta Didik Baru. Mari bergabung dan tumbuh bersama lingkungan belajar yang kreatif dan inovatif!
                    </p><div class="flex flex-wrap items-center justify-center gap-4 mb-10">
<div class="bg-white dark:bg-dark-card px-6 py-3 rounded-2xl shadow-md border-l-4 {{ $isPendaftaranOpen ? 'border-emerald-500' : 'border-gray-500' }} flex items-center gap-3 border border-white/5">
<span class="material-symbols-outlined {{ $isPendaftaranOpen ? 'text-emerald-500' : 'text-gray-500' }}">event_available</span>
<div class="text-left">
<p class="text-[10px] uppercase font-bold text-slate-400 leading-none">Pendaftaran Dibuka</p>
<p class="text-sm md:text-base font-black text-slate-900 dark:text-white">{{ $setting && $setting->pendaftaran_mulai ? $setting->pendaftaran_mulai->translatedFormat('d F Y') : 'Menunggu' }}</p>
</div>
</div>
<div class="bg-white dark:bg-dark-card px-6 py-3 rounded-2xl shadow-md border-l-4 {{ ($setting && $setting->pendaftaran_selesai && $now->gt($setting->pendaftaran_selesai)) ? 'border-rose-500' : 'border-emerald-500' }} flex items-center gap-3 border border-white/5">
<span class="material-symbols-outlined {{ ($setting && $setting->pendaftaran_selesai && $now->gt($setting->pendaftaran_selesai)) ? 'text-rose-500' : 'text-emerald-500' }}">event_busy</span>
<div class="text-left">
<p class="text-[10px] uppercase font-bold text-slate-400 leading-none">Pendaftaran Ditutup</p>
<p class="text-sm md:text-base font-black text-slate-900 dark:text-white">{{ $setting && $setting->pendaftaran_selesai ? $setting->pendaftaran_selesai->translatedFormat('d F Y') : 'Menunggu' }}</p>
</div>
</div>
</div>
<div class="flex flex-col sm:flex-row items-center justify-center gap-4">
@if($isPendaftaranOpen)
    @guest('siswa')
    <button onclick="showLoginModal(event)" class="w-full sm:w-auto bg-primary text-white px-10 py-4 rounded-xl font-extrabold text-lg shadow-xl shadow-primary/30 hover:scale-105 transition-transform flex items-center justify-center gap-2">
                                Daftar Sekarang
                                <span class="material-symbols-outlined">arrow_forward</span>
    </button>
    @else
    <a href="{{ route('spmb.pendaftaran') }}" class="w-full sm:w-auto bg-primary text-white px-10 py-4 rounded-xl font-extrabold text-lg shadow-xl shadow-primary/30 hover:scale-105 transition-transform flex items-center justify-center gap-2">
                                Daftar Sekarang
                                <span class="material-symbols-outlined">arrow_forward</span>
    </a>
    @endguest
@elseif($setting && $now->lt($setting->pendaftaran_mulai))
<button class="w-full sm:w-auto bg-gray-400 text-white px-10 py-4 rounded-xl font-extrabold text-lg cursor-not-allowed flex items-center justify-center gap-2">
                            Belum Buka
</button>
@else
<button class="w-full sm:w-auto bg-gray-400 text-white px-10 py-4 rounded-xl font-extrabold text-lg cursor-not-allowed flex items-center justify-center gap-2">
                            Pendaftaran Tutup
</button>
@endif

@if($isPengumumanOpen && $isPublished)
<a href="{{ route('spmb.pengumuman') }}" class="w-full sm:w-auto border-2 border-secondary text-secondary px-10 py-4 rounded-xl font-extrabold text-lg hover:bg-secondary/5 transition-colors">
                            Lihat Pengumuman
</a>
@elseif($isPengumumanOpen && !$isPublished)
<a href="{{ route('spmb.countdown') }}" class="w-full sm:w-auto border-2 border-purple-500 text-purple-500 px-10 py-4 rounded-xl font-extrabold text-lg hover:bg-purple-50 transition-colors">
                            Menunggu Pengumuman
</a>
@else
<button class="w-full sm:w-auto border-2 border-secondary text-secondary px-10 py-4 rounded-xl font-extrabold text-lg hover:bg-secondary/5 transition-colors">
                            Lihat Brosur
</button>
@endif
</div>
</div>
<!-- Decorative elements -->
<div class="mt-16 relative max-w-4xl mx-auto">
<div class="aspect-[16/9] rounded-xl overflow-hidden shadow-2xl border-4 border-white dark:border-dark-card">
<img class="w-full h-full object-cover" data-alt="School building exterior with students" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAQBq0MFvC5-D4pxIoIQRXjWvtzjmEJFxuibvJNyGVWySmo8WHb3VwY50bMIhSgm519QOZfr2LthL-rGQeWulV6gRbFC96WQ_d6nKBX_7cj2k7XlL8R5lpYaxhSl2LzFQA3uP0psLsUSKLD80Y99SDsUGCWi6znmO80WywiDRTOnE7crAueNJ2WOtaUGsePB8IWij7ZpRheLX-dYnPCsCcp2OUFqE4czRV-3Dq2hO4ZlwvkKHRCXZnISjhKEfwHVs6moZk6nLinz38"/>
</div>
<div class="absolute -bottom-6 -right-6 bg-secondary text-white p-6 rounded-xl shadow-xl hidden md:block">
<p class="font-bold text-2xl">A+</p>
<p class="text-xs opacity-90">Akreditasi Sekolah</p>
</div>
</div>
</section>

<!-- Kriteria Section -->
<section class="px-4 py-20 bg-white dark:bg-slate-900/50">
<div class="max-w-7xl mx-auto">
<div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
<div>
<h2 class="text-3xl font-black text-slate-900 dark:text-slate-100 mb-2">Kriteria Pendaftaran</h2>
<p class="text-slate-500">Hal yang perlu diperhatikan sebelum mendaftar ke Vidya Mandir.</p>
</div>
<div class="flex gap-2">
<div class="w-12 h-2 rounded-full bg-primary"></div>
<div class="w-4 h-2 rounded-full bg-primary/30"></div>
</div>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
<!-- Card 1 -->
<div class="group p-8 rounded-xl bg-orange-50 dark:bg-dark-card border border-white/5 hover:border-primary/50 transition-all shadow-lg">
<div class="w-14 h-14 rounded-xl bg-primary flex items-center justify-center text-white mb-6 group-hover:rotate-6 transition-transform">
<span class="material-symbols-outlined text-3xl">child_care</span>
</div>
<h3 class="text-xl font-bold mb-3">Kriteria Usia</h3>
<p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">
                                Calon siswa minimal berusia 6 tahun pada bulan Juli tahun ajaran berjalan untuk tingkat SD.
                            </p>
</div>
<!-- Card 2 -->
<div class="group p-8 rounded-xl bg-blue-50 dark:bg-dark-card border border-white/5 hover:border-secondary/50 transition-all shadow-lg">
<div class="w-14 h-14 rounded-xl bg-secondary flex items-center justify-center text-white mb-6 group-hover:-rotate-6 transition-transform">
<span class="material-symbols-outlined text-3xl">location_on</span>
</div>
<h3 class="text-xl font-bold mb-3">Kriteria Domisili</h3>
<p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">
                                Memprioritaskan calon siswa yang berdomisili di wilayah zonasi sekitar lingkungan Vidya Mandir.
                            </p>
</div>
<!-- Card 3 -->
<div class="group p-8 rounded-xl bg-emerald-50 dark:bg-dark-card border border-white/5 hover:border-emerald-500/50 transition-all shadow-lg">
<div class="w-14 h-14 rounded-xl bg-emerald-500 flex items-center justify-center text-white mb-6 group-hover:rotate-6 transition-transform">
<span class="material-symbols-outlined text-3xl">military_tech</span>
</div>
<h3 class="text-xl font-bold mb-3">Kriteria Akademik</h3>
<p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">
                                Memiliki nilai rata-rata rapor minimal 80 untuk mata pelajaran utama di jenjang sebelumnya.
                            </p>
</div>
</div>
</div>
</section>

<!-- Syarat Section -->
<section class="px-4 py-20">
<div class="max-w-7xl mx-auto bg-primary/5 rounded-xl p-8 md:p-16 border-2 border-dashed border-primary/20">
<div class="text-center mb-16">
<h2 class="text-3xl font-black mb-4">Syarat &amp; Dokumen</h2>
<p class="text-slate-500">Persiapkan dokumen berikut dalam bentuk scan/digital</p>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
<div class="space-y-6">
<div class="flex gap-4 items-start bg-white dark:bg-slate-800 p-6 rounded-xl shadow-sm">
<div class="bg-primary/20 text-primary p-2 rounded-lg">
<span class="material-symbols-outlined">contact_page</span>
</div>
<div>
<h4 class="font-bold text-lg mb-1">Kartu Keluarga</h4>
<p class="text-sm text-slate-500">Fotokopi kartu keluarga terbaru (minimal terbit 1 tahun).</p>
</div>
</div>
<div class="flex gap-4 items-start bg-white dark:bg-dark-card p-6 rounded-xl shadow-lg border border-white/5">
<div class="bg-primary/20 text-primary p-2 rounded-lg">
<span class="material-symbols-outlined">cake</span>
</div>
<div>
<h4 class="font-bold text-lg mb-1">Akta Kelahiran</h4>
<p class="text-sm text-slate-500">Scan asli akta kelahiran calon peserta didik.</p>
</div>
</div>
<div class="flex gap-4 items-start bg-white dark:bg-dark-card p-6 rounded-xl shadow-lg border border-white/5">
<div class="bg-primary/20 text-primary p-2 rounded-lg">
<span class="material-symbols-outlined">description</span>
</div>
<div>
<h4 class="font-bold text-lg mb-1">Rapor Terakhir</h4>
<p class="text-sm text-slate-500">Halaman biodata dan nilai rapor 2 semester terakhir.</p>
</div>
</div>
</div>
<div class="space-y-6">
<div class="flex gap-4 items-start bg-white dark:bg-dark-card p-6 rounded-xl shadow-lg border border-white/5">
<div class="bg-secondary/20 text-secondary p-2 rounded-lg">
<span class="material-symbols-outlined">add_a_photo</span>
</div>
<div>
<h4 class="font-bold text-lg mb-1">Pas Foto</h4>
<p class="text-sm text-slate-500">Foto terbaru ukuran 3x4 dengan latar belakang merah.</p>
</div>
</div>
<div class="flex gap-4 items-start bg-white dark:bg-dark-card p-6 rounded-xl shadow-lg border border-white/5">
<div class="bg-secondary/20 text-secondary p-2 rounded-lg">
<span class="material-symbols-outlined">verified_user</span>
</div>
<div>
<h4 class="font-bold text-lg mb-1">Surat Kesehatan</h4>
<p class="text-sm text-slate-500">Surat keterangan sehat dari dokter atau puskesmas.</p>
</div>
</div>
<div class="flex gap-4 items-start bg-white dark:bg-slate-800 p-6 rounded-xl shadow-sm">
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

<!-- Bottom CTA -->
<section class="relative py-24 px-4 overflow-hidden">
<div class="max-w-4xl mx-auto bg-slate-900 dark:bg-primary rounded-xl p-10 md:p-20 text-center relative z-10 overflow-hidden">
<h2 class="text-3xl md:text-5xl font-black text-white mb-6">Sudah Siap Bergabung?</h2>
<p class="text-white/80 text-lg mb-10 max-w-lg mx-auto">
                        Jangan lewatkan kesempatan untuk menjadi bagian dari generasi emas Vidya Mandir. Pendaftaran dibuka hingga Juli 2024.
                    </p>
@if($isPendaftaranOpen)
    @guest('siswa')
    <button onclick="showLoginModal(event)" class="inline-block bg-white text-slate-900 dark:text-primary px-12 py-5 rounded-full font-black text-xl shadow-2xl hover:scale-105 transition-transform">
                            Daftar Sekarang
    </button>
    @else
    <a href="{{ route('spmb.pendaftaran') }}" class="inline-block bg-white text-slate-900 dark:text-primary px-12 py-5 rounded-full font-black text-xl shadow-2xl hover:scale-105 transition-transform">
                            Daftar Sekarang
    </a>
    @endguest
@else
<button class="bg-gray-300 text-gray-500 px-12 py-5 rounded-full font-black text-xl shadow-2xl cursor-not-allowed">
                        Pendaftaran Tutup
</button>
@endif
<!-- Decorative Icon -->
<div class="absolute -top-10 -left-10 text-white/10">
<span class="material-symbols-outlined text-[150px]">rocket_launch</span>
</div>
</div>
</section>

@endsection