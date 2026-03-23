@extends('layouts.home')

@section('title', 'Kurikulum - TK PGRI Harapan Bangsa 1')

@section('content')
<main class="flex flex-col items-center">
<!-- Hero Section -->
<div class="w-full max-w-[1200px] px-6 mt-4 md:mt-8">
    <section data-kurikulum-animate="zoom-in" class="hero-section relative h-[300px] md:h-[400px] w-full overflow-hidden rounded-xl md:rounded-3xl shadow-lg">
        <div class="absolute inset-0 bg-cover bg-center" data-alt="Children playing happily in a colorful classroom" style="background-image: url('{{ asset('images/kurikulum.jpeg') }}');"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex flex-col justify-end p-8 md:p-12">
            <nav data-kurikulum-animate="fade-up" class="hero-breadcrumb flex gap-2 text-white/80 text-sm mb-4">
                <span><a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a></span> <span>/</span> <span class="text-white font-medium">Kurikulum Sekolah</span>
            </nav>
            <h1 data-kurikulum-animate="fade-up" class="hero-title text-white text-4xl md:text-5xl font-bold tracking-tight">Kurikulum Sekolah</h1>
            <p data-kurikulum-animate="fade-up" class="mt-4 text-white/85 text-base md:text-lg leading-relaxed max-w-2xl">
                Kurikulum kami dirancang untuk menumbuhkan karakter, kemandirian, kreativitas, dan kecintaan anak terhadap proses belajar sejak dini.
            </p>
        </div>
    </section>
</div>
<!-- Kurikulum Merdeka Section -->
    <section data-kurikulum-animate="fade-up" class="kurikulum-section w-full max-w-[1200px] px-6 py-12 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <div class="order-2 md:order-1">
            <div data-kurikulum-animate="fade-right" class="kurikulum-badge inline-flex items-center gap-2 text-primary font-bold mb-4">
                <span class="material-symbols-outlined">auto_awesome</span>
                <span>Sesuai Kebijakan Kemendikdasmen RI</span>
            </div>
            <h2 data-kurikulum-animate="fade-right" class="kurikulum-title text-3xl font-bold text-slate-900 dark:text-white mb-6">Kurikulum Merdeka</h2>
            <div data-kurikulum-animate="fade-right" class="kurikulum-content space-y-4 text-slate-600 dark:text-slate-400 leading-relaxed">
                <p>
                    Sekolah kami menerapkan Kurikulum Merdeka sebagai acuan utama dalam proses pembelajaran. Kurikulum ini memberikan ruang belajar yang lebih fleksibel, berpusat pada anak, serta mendorong pengembangan kompetensi dan karakter secara seimbang.
                </p>
                <p>
                    Anak tidak hanya diajak untuk mengenal pengetahuan dasar, tetapi juga dilatih untuk berpikir kritis, kreatif, mandiri, serta memiliki rasa percaya diri sejak usia dini. Pendekatan ini memungkinkan guru merancang pembelajaran yang menyenangkan dan kontekstual.
                </p>
            </div>
            <div data-kurikulum-animate="fade-up" class="kurikulum-features mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="flex items-center gap-3 transition-all duration-300 hover:translate-x-2 cursor-pointer">
                    <span class="material-symbols-outlined text-green-500">check_circle</span>
                    <span class="text-slate-700 dark:text-slate-300 font-medium">Berpusat pada Anak</span>
                </div>
                <div class="flex items-center gap-3 transition-all duration-300 hover:translate-x-2 cursor-pointer">
                    <span class="material-symbols-outlined text-green-500">check_circle</span>
                    <span class="text-slate-700 dark:text-slate-300 font-medium">Kreatif &amp; Mandiri</span>
                </div>
                <div class="flex items-center gap-3 transition-all duration-300 hover:translate-x-2 cursor-pointer">
                    <span class="material-symbols-outlined text-green-500">check_circle</span>
                    <span class="text-slate-700 dark:text-slate-300 font-medium">Berpikir Kritis</span>
                </div>
                <div class="flex items-center gap-3 transition-all duration-300 hover:translate-x-2 cursor-pointer">
                    <span class="material-symbols-outlined text-green-500">check_circle</span>
                    <span class="text-slate-700 dark:text-slate-300 font-medium">Belajar Menyenangkan</span>
                </div>
            </div>
        </div>
        <div data-kurikulum-animate="slide-rotate" class="kurikulum-image order-1 md:order-2 rounded-xl overflow-hidden shadow-xl bg-slate-200 aspect-video transition-all duration-500 hover:shadow-2xl">
            <img alt="Anak-anak belajar dengan gembira" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110" data-alt="Children playing and learning in a colorful classroom environment" src="{{ asset('images/kurikulum-1.jpeg') }}"/>
        </div>
    </section>
    <!-- Pendidikan Holistik Section -->
    <section data-kurikulum-animate="fade-up" class="holistic-section w-full bg-white dark:bg-slate-900/50 py-16">
        <div class="max-w-[1200px] mx-auto px-6">
            <div data-kurikulum-animate="fade-up" class="holistic-header text-center mb-12">
                <h2 class="text-3xl font-bold text-slate-900 dark:text-white">Penguatan Pendidikan Holistik Berbasis Karakter</h2>
                <p class="text-slate-600 dark:text-slate-400 mt-4 max-w-3xl mx-auto">Kami meyakini bahwa pendidikan bukan hanya tentang kemampuan akademik, tetapi juga pembentukan karakter dan nilai kehidupan.</p>
            </div>
            <div data-kurikulum-stagger class="grid grid-cols-2 md:grid-cols-5 gap-6">
                <div class="holistic-item p-6 rounded-xl bg-primary/5 border border-primary/10 flex flex-col items-center text-center transition-all duration-300 hover:-translate-y-2 hover:shadow-xl cursor-pointer">
                    <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center text-primary mb-4 transition-all duration-300 group-hover:scale-110">
                        <span class="material-symbols-outlined text-2xl">church</span>
                    </div>
                    <h3 class="font-bold text-sm">Spiritual</h3>
                </div>
                <div class="holistic-item p-6 rounded-xl bg-secondary/5 border border-secondary/10 flex flex-col items-center text-center transition-all duration-300 hover:-translate-y-2 hover:shadow-xl cursor-pointer">
                    <div class="w-12 h-12 rounded-full bg-secondary/20 flex items-center justify-center text-secondary mb-4">
                        <span class="material-symbols-outlined text-2xl">favorite</span>
                    </div>
                    <h3 class="font-bold text-sm">Emosional</h3>
                </div>
                <div class="holistic-item p-6 rounded-xl bg-accent/5 border border-accent/10 flex flex-col items-center text-center transition-all duration-300 hover:-translate-y-2 hover:shadow-xl cursor-pointer">
                    <div class="w-12 h-12 rounded-full bg-accent/20 flex items-center justify-center text-accent mb-4">
                        <span class="material-symbols-outlined text-2xl">groups</span>
                    </div>
                    <h3 class="font-bold text-sm">Sosial</h3>
                </div>
                <div class="holistic-item p-6 rounded-xl bg-green-500/5 border border-green-500/10 flex flex-col items-center text-center transition-all duration-300 hover:-translate-y-2 hover:shadow-xl cursor-pointer">
                    <div class="w-12 h-12 rounded-full bg-green-500/20 flex items-center justify-center text-green-600 mb-4">
                        <span class="material-symbols-outlined text-2xl">psychology</span>
                    </div>
                    <h3 class="font-bold text-sm">Intelektual</h3>
                </div>
                <div class="holistic-item p-6 rounded-xl bg-orange-500/5 border border-orange-500/10 flex flex-col items-center text-center transition-all duration-300 hover:-translate-y-2 hover:shadow-xl cursor-pointer">
                    <div class="w-12 h-12 rounded-full bg-orange-500/20 flex items-center justify-center text-orange-600 mb-4">
                        <span class="material-symbols-outlined text-2xl">fitness_center</span>
                    </div>
                    <h3 class="font-bold text-sm">Fisik</h3>
                </div>
            </div>
            <div data-kurikulum-animate="blur-in" class="holistic-quote mt-12 p-8 bg-slate-50 dark:bg-slate-800/50 rounded-2xl text-center transition-all duration-500 hover:shadow-xl">
                <p class="text-slate-700 dark:text-slate-300 italic leading-relaxed">"Anak dibimbing untuk mengenal nilai tanggung jawab, disiplin, empati, kemandirian, serta kebiasaan baik yang menjadi fondasi kuat dalam perjalanan pendidikan mereka selanjutnya."</p>
            </div>
        </div>
    </section>
<!-- Layanan PAUD HIBER Section -->
<section data-kurikulum-animate="fade-up" class="paud-section w-full max-w-[1200px] px-6 py-20">
        <div data-kurikulum-animate="fade-up" class="paud-header mb-12">
            <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-6">Layanan PAUD HIBER</h2>
            <p class="text-slate-600 dark:text-slate-400 max-w-3xl">Sekolah kami menerapkan layanan PAUD Holistik integratif berdimensi sosial, budaya, dan ekonomi (PAUD HIBER), yaitu layanan terpadu yang mencakup:</p>
        </div>
        <div data-kurikulum-stagger class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="paud-item flex flex-col items-center p-6 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-xl cursor-pointer">
                <span class="material-symbols-outlined text-primary text-3xl mb-3 transition-all duration-300 group-hover:scale-110">school</span>
                <span class="text-sm font-semibold text-center">Layanan Pendidikan</span>
            </div>
            <div class="paud-item flex flex-col items-center p-6 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-xl cursor-pointer">
                <span class="material-symbols-outlined text-primary text-3xl mb-3 transition-all duration-300 group-hover:scale-110">nutrition</span>
                <span class="text-sm font-semibold text-center">Gizi &amp; Kesehatan</span>
            </div>
            <div class="paud-item flex flex-col items-center p-6 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-xl cursor-pointer">
                <span class="material-symbols-outlined text-primary text-3xl mb-3 transition-all duration-300 group-hover:scale-110">family_restroom</span>
                <span class="text-sm font-semibold text-center">Layanan Pengasuhan</span>
            </div>
            <div class="paud-item flex flex-col items-center p-6 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-xl cursor-pointer">
                <span class="material-symbols-outlined text-primary text-3xl mb-3 transition-all duration-300 group-hover:scale-110">shield</span>
                <span class="text-sm font-semibold text-center">Layanan Perlindungan</span>
            </div>
            <div class="paud-item flex flex-col items-center p-6 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-xl cursor-pointer">
                <span class="material-symbols-outlined text-primary text-3xl mb-3 transition-all duration-300 group-hover:scale-110">volunteer_activism</span>
                <span class="text-sm font-semibold text-center">Kesejahteraan</span>
            </div>
            <div class="paud-item flex flex-col items-center p-6 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-xl cursor-pointer">
                <span class="material-symbols-outlined text-primary text-3xl mb-3 transition-all duration-300 group-hover:scale-110">public</span>
                <span class="text-sm font-semibold text-center">Layanan Sosial</span>
            </div>
            <div class="paud-item flex flex-col items-center p-6 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-xl cursor-pointer">
                <span class="material-symbols-outlined text-primary text-3xl mb-3 transition-all duration-300 group-hover:scale-110">theater_comedy</span>
                <span class="text-sm font-semibold text-center">Layanan Budaya</span>
            </div>
            <div class="paud-item flex flex-col items-center p-6 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-xl cursor-pointer">
                <span class="material-symbols-outlined text-primary text-3xl mb-3 transition-all duration-300 group-hover:scale-110">payments</span>
                <span class="text-sm font-semibold text-center">Layanan Ekonomi</span>
            </div>
        </div>
    </section>
<!-- PAUD Percontohan & Rujukan -->
<section data-kurikulum-animate="fade-up" class="percontohan-section w-full max-w-[1200px] px-6 mb-20">
        <div class="bg-slate-900 text-white p-8 md:p-12 rounded-2xl relative overflow-hidden transition-all duration-500 hover:shadow-2xl">
            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                <div data-kurikulum-animate="fade-right" class="percontohan-content">
                    <h2 class="text-3xl font-bold mb-6">PAUD Percontohan &amp; Rujukan Dinas Pendidikan</h2>
                    <p class="text-slate-300 leading-relaxed mb-6">Kami bersyukur dipersiapkan sebagai PAUD Percontohan dan Rujukan Dinas Pendidikan, yang menjadi model praktik baik dalam pengelolaan pembelajaran dan penanaman karakter.</p>
                    <div class="flex items-center gap-4 text-secondary">
                        <span class="material-symbols-outlined text-4xl animate-pulse">verified</span>
                        <span class="text-lg font-bold">Bukti Komitmen Mutu &amp; Inovasi</span>
                    </div>
                </div>
                <div class="hidden lg:block">
                    <div class="grid grid-cols-2 gap-4">
                        <div data-kurikulum-animate="zoom-in" class="percontohan-card p-6 bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 transition-all duration-300 hover:bg-white/20 hover:scale-105">
                            <h4 class="text-xl font-bold mb-2">Model Praktik</h4>
                            <p class="text-xs text-slate-300">Pengelolaan pembelajaran standar nasional</p>
                        </div>
                        <div data-kurikulum-animate="zoom-in" class="percontohan-card p-6 bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 transition-all duration-300 hover:bg-white/20 hover:scale-105">
                            <h4 class="text-xl font-bold mb-2">Mutu Terjaga</h4>
                            <p class="text-xs text-slate-300">Kualitas layanan pendidikan anak usia dini</p>
                        </div>
                    </div>
                </div>
            </div>
            <span class="material-symbols-outlined absolute -bottom-10 -right-10 text-[240px] opacity-10 rotate-12 animate-pulse">verified_user</span>
        </div>
    </section>
<!-- Why Choose Us Section -->
<section data-kurikulum-animate="fade-up" class="why-section w-full max-w-[1200px] px-6 py-16 mb-20 bg-primary/5 rounded-xl transition-all duration-500 hover:shadow-xl">
        <div data-kurikulum-animate="fade-up" class="why-header text-center mb-12">
            <h2 class="text-3xl font-bold text-slate-900 dark:text-white">Mengapa Memilih Sekolah Kami?</h2>
            <p class="text-slate-600 dark:text-slate-400 mt-4 max-w-3xl mx-auto">Karena kami tidak hanya mengajar, tetapi membentuk fondasi kehidupan. Kami tidak sekadar mengenalkan huruf dan angka, tetapi menanamkan nilai, membangun kepercayaan diri, serta menumbuhkan kecintaan anak terhadap proses belajar.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="why-card bg-white dark:bg-slate-800 p-8 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl cursor-pointer">
                <span class="material-symbols-outlined text-primary text-4xl mb-4 transition-all duration-300 group-hover:scale-110">foundation</span>
                <h4 class="font-bold text-lg mb-2">Fondasi Kehidupan</h4>
                <p class="text-sm text-slate-600 dark:text-slate-400">Fokus pada pembentukan karakter dan nilai-nilai luhur yang bertahan seumur hidup.</p>
            </div>
            <div class="why-card bg-white dark:bg-slate-800 p-8 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl cursor-pointer">
                <span class="material-symbols-outlined text-secondary text-4xl mb-4">psychology_alt</span>
                <h4 class="font-bold text-lg mb-2">Pilar Karakter</h4>
                <p class="text-sm text-slate-600 dark:text-slate-400">Integrasi pendidikan holistik untuk menghasilkan individu cerdas dan berakhlak mulia.</p>
            </div>
            <div class="why-card bg-white dark:bg-slate-800 p-8 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 md:col-span-2 lg:col-span-1 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl cursor-pointer">
                <span class="material-symbols-outlined text-accent text-4xl mb-4">auto_awesome</span>
                <h4 class="font-bold text-lg mb-2">Siap Masa Depan</h4>
                <p class="text-sm text-slate-600 dark:text-slate-400">Menanamkan generasi yang cerdas dan berkarakter untuk melangkah menuju masa depan.</p>
            </div>
        </div>
        <div data-kurikulum-animate="scale-up" class="why-cta mt-12 text-center">
            <p class="text-primary font-bold text-xl px-6 py-4 bg-white dark:bg-slate-800 inline-block rounded-full shadow-sm transition-all duration-300 hover:scale-105 hover:shadow-xl cursor-pointer">Mari bersama kami, menanamkan generasi yang cerdas dan berkarakter!</p>
        </div>
    </section>
</main>
@endsection
