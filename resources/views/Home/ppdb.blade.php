@extends('layouts.home')

@section('title', 'PPDB - TK PGRI Harapan Bangsa 1 Bandung')

@section('content')
    <section class="px-4 md:px-10 py-6">
        <div data-home-animate="zoom-in" class="relative min-h-[400px] md:h-[400px] h-auto w-full overflow-hidden rounded-xl md:rounded-3xl shadow-lg mt-4 md:mt-8">
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/ppdb.jpeg') }}');"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent flex flex-col justify-center p-6 md:p-12 py-14 md:py-12">
                <nav data-home-animate="fade-up" class="flex gap-2 text-white/80 text-sm mb-3 md:mb-4">
                    <span><a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a></span>
                    <span>/</span>
                    <span class="text-white font-medium">PPDB</span>
                </nav>
                <div data-home-animate="fade-up" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/15 border border-white/20 text-white text-[10px] md:text-xs font-bold uppercase tracking-widest mb-4 md:mb-5 w-fit">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                    </span>
                    Tahun Ajaran {{ $tahunAjaranAktif ? $tahunAjaranAktif->tahun_ajaran : '2026/2027' }}
                </div>
                <h1 data-home-animate="fade-up" class="text-white text-3xl md:text-5xl font-bold tracking-tight max-w-3xl">Penerimaan Peserta Didik Baru</h1>
                <p data-home-animate="fade-up" class="mt-3 md:mt-4 text-white/85 text-sm md:text-lg leading-relaxed max-w-2xl">
                    Kami membuka kesempatan bagi putra-putri terbaik untuk bergabung dan bertumbuh bersama sekolah dalam lingkungan yang aman, menyenangkan, dan berkualitas.
                </p>

                @if (session('error'))
                    <div class="mt-4 p-3 rounded-xl bg-red-50/95 border border-red-200 text-red-600 flex items-start gap-2 text-left max-w-2xl">
                        <span class="material-symbols-outlined text-sm">error</span>
                        <p class="text-xs font-medium">{{ session('error') }}</p>
                    </div>
                @endif

                <div data-home-animate="fade-up" class="mt-5 md:mt-6 flex flex-row flex-wrap gap-3 md:gap-4">
                    @guest('siswa')
                        <button onclick="showLoginModal(event)" class="inline-flex items-center justify-center gap-2 bg-white text-primary px-5 md:px-8 py-2.5 md:py-4 rounded-full font-bold text-sm md:text-lg shadow-xl hover:scale-105 transition-all">
                            Daftar Sekarang
                        </button>
                    @else
                        <a href="{{ route('siswa.dashboard') }}" class="inline-flex items-center justify-center gap-2 bg-white text-primary px-5 md:px-8 py-2.5 md:py-4 rounded-full font-bold text-sm md:text-lg shadow-xl hover:scale-105 transition-all">
                            Dashboard
                        </a>
                    @endguest
                    <a href="{{ route('pendaftar.index') }}" class="inline-flex items-center justify-center gap-2 bg-white/15 text-white border border-white/20 px-5 md:px-8 py-2.5 md:py-4 rounded-full font-bold text-sm md:text-lg hover:bg-white/20 transition-all">
                        Lihat Pendaftar
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Jadwal Pelaksanaan -->
    <section class="py-20 bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800" data-home-animate="fade-up">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-home-animate="fade-up">
                <h2 class="text-3xl font-extrabold mb-4">Jadwal Pelaksanaan</h2>
                <p class="text-slate-600 dark:text-slate-400">Pastikan Ayah &amp; Bunda mencatat tanggal-tanggal penting
                    berikut</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6" data-home-stagger>
                <div class="p-6 rounded-2xl border border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50">
                    <span
                        class="text-primary font-bold text-xs block mb-2">{{ $spmbSetting && $spmbSetting->tanggal_mulai_pendaftaran ? \Carbon\Carbon::parse($spmbSetting->tanggal_mulai_pendaftaran)->translatedFormat('d F Y') : '1 MARET 2026' }}</span>
                    <h4 class="font-bold mb-2">Pembukaan</h4>
                    <p class="text-xs text-slate-500">Pendaftaran Online Dibuka secara resmi melalui website.</p>
                </div>
                <div class="p-6 rounded-2xl border-2 border-primary/20 bg-primary/5">
                    <span
                        class="text-primary font-bold text-xs block mb-2">{{ $spmbSetting && $spmbSetting->tanggal_mulai_pendaftaran ? \Carbon\Carbon::parse($spmbSetting->tanggal_mulai_pendaftaran)->translatedFormat('F') : 'MARET' }}
                        -
                        {{ $spmbSetting && $spmbSetting->tanggal_selesai_pendaftaran ? \Carbon\Carbon::parse($spmbSetting->tanggal_selesai_pendaftaran)->translatedFormat('F Y') : 'JUNI 2026' }}</span>
                    <h4 class="font-bold mb-2">Verifikasi</h4>
                    <p class="text-xs text-slate-500">Verifikasi berkas dan penyelesaian pembayaran administrasi.</p>
                </div>
                <div class="p-6 rounded-2xl border border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50">
                    <span
                        class="text-primary font-bold text-xs block mb-2">{{ $spmbSetting && $spmbSetting->tanggal_selesai_pendaftaran ? \Carbon\Carbon::parse($spmbSetting->tanggal_selesai_pendaftaran)->translatedFormat('d F Y') : '30 JUNI 2026' }}</span>
                    <h4 class="font-bold mb-2">Penutupan</h4>
                    <p class="text-xs text-slate-500">Batas akhir pendaftaran online bagi calon peserta didik.</p>
                </div>
                <div class="p-6 rounded-2xl border border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50">
                    <span
                        class="text-primary font-bold text-xs block mb-2">{{ $spmbSetting && $spmbSetting->tanggal_pengumuman ? \Carbon\Carbon::parse($spmbSetting->tanggal_pengumuman)->translatedFormat('d F Y') : '1 JULI 2026' }}</span>
                    <h4 class="font-bold mb-2">Pengumuman</h4>
                    <p class="text-xs text-slate-500">Pengumuman resmi hasil seleksi melalui sistem PPDB.</p>
                </div>
            </div>
            <p class="mt-8 text-center text-sm font-medium text-slate-500 italic">
                *Catatan: Pendaftaran dapat ditutup lebih awal apabila kuota telah terpenuhi.
            </p>
        </div>
    </section>

    <!-- Persyaratan Section -->
    <section class="py-24" data-home-animate="fade-up">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold mb-12 flex items-center justify-center gap-3" data-home-animate="fade-up">
                <span class="material-symbols-outlined text-primary bg-primary/10 p-3 rounded-xl">assignment_turned_in</span>
                Persyaratan Pendaftaran
            </h2>
            <div class="space-y-10">
                <div>
                    <h3 class="font-bold text-xl mb-6 text-slate-800 dark:text-slate-200 border-l-4 border-primary pl-4">A.
                        Usia Calon Peserta Didik</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6" data-home-stagger>
                        <div
                            class="p-6 rounded-2xl bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 shadow-sm">
                            <p class="text-xs text-slate-500 uppercase font-bold mb-2 tracking-wider">Usia Minimal</p>
                            <p class="text-2xl font-bold text-primary">4 Tahun 4 Bulan</p>
                        </div>
                        <div
                            class="p-6 rounded-2xl bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 shadow-sm">
                            <p class="text-xs text-slate-500 uppercase font-bold mb-2 tracking-wider">Usia Maksimal</p>
                            <p class="text-2xl font-bold text-primary">5 Tahun 10 Bulan</p>
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="font-bold text-xl mb-6 text-slate-800 dark:text-slate-200 border-l-4 border-primary pl-4">B.
                        Dokumen Wajib Unggah</h3>
                    <div class="grid gap-4" data-home-stagger>
                        <div
                            class="flex items-center gap-5 p-5 rounded-2xl bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-700 hover:border-primary/30 transition-colors">
                            <span class="material-symbols-outlined text-primary bg-primary/5 p-2 rounded-lg">groups</span>
                            <p class="font-semibold text-lg">Scan / foto Kartu Keluarga (KK)</p>
                        </div>
                        <div
                            class="flex items-center gap-5 p-5 rounded-2xl bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-700 hover:border-primary/30 transition-colors">
                            <span
                                class="material-symbols-outlined text-primary bg-primary/5 p-2 rounded-lg">child_care</span>
                            <p class="font-semibold text-lg">Scan / foto Akta Kelahiran</p>
                        </div>
                        <div
                            class="flex items-center gap-5 p-5 rounded-2xl bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-700 hover:border-primary/30 transition-colors">
                            <span class="material-symbols-outlined text-primary bg-primary/5 p-2 rounded-lg">badge</span>
                            <p class="font-semibold text-lg">Scan / foto KTP orang tua / wali</p>
                        </div>
                        <div
                            class="flex items-center gap-5 p-5 rounded-2xl bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-700 hover:border-primary/30 transition-colors">
                            <span class="material-symbols-outlined text-primary bg-primary/5 p-2 rounded-lg">receipt_long</span>
                            <p class="font-semibold text-lg">Scan / foto Bukti Pembayaran</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Alur Pendaftaran Section -->
    <section id="alur-ppdb" class="py-24 bg-white dark:bg-slate-900 border-y border-slate-100 dark:border-slate-800" data-home-animate="fade-up">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold mb-16 flex items-center justify-center gap-3" data-home-animate="fade-up">
            <span class="material-symbols-outlined text-primary bg-primary/10 p-3 rounded-xl">account_tree</span>
                Alur Pendaftaran
            </h2>
            <div
                data-home-stagger
                class="relative space-y-12 before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-primary before:to-transparent">
                <!-- Step 1 -->
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                    <div
                        class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white dark:border-slate-900 bg-primary text-white shadow-lg shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                        <span class="text-sm font-bold">1</span>
                    </div>
                    <div
                        class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-6 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 shadow-sm hover:shadow-md transition-shadow">
                        <h4 class="font-bold text-lg mb-1">Mengisi Formulir</h4>
                        <p class="text-sm text-slate-500 leading-relaxed">Pengisian data pendaftaran secara online melalui
                            sistem PPDB resmi kami.</p>
                    </div>
                </div>
                <!-- Step 2 -->
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                    <div
                        class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white dark:border-slate-900 bg-primary text-white shadow-lg shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                        <span class="text-sm font-bold">2</span>
                    </div>
                    <div
                        class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-6 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 shadow-sm hover:shadow-md transition-shadow">
                        <h4 class="font-bold text-lg mb-1">Unggah Dokumen</h4>
                        <p class="text-sm text-slate-500 leading-relaxed">Mengunggah semua dokumen persyaratan digital yang
                            diwajibkan oleh sekolah.</p>
                    </div>
                </div>
                <!-- Step 3 -->
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                    <div
                        class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white dark:border-slate-900 bg-primary text-white shadow-lg shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                        <span class="text-sm font-bold">3</span>
                    </div>
                    <div
                        class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-6 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 shadow-sm hover:shadow-md transition-shadow">
                        <h4 class="font-bold text-lg mb-1">Verifikasi Berkas</h4>
                        <p class="text-sm text-slate-500 leading-relaxed">Menunggu proses pengecekan keabsahan data oleh
                            panitia PPDB sekolah.</p>
                    </div>
                </div>
                <!-- Step 4 -->
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                    <div
                        class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white dark:border-slate-900 bg-primary text-white shadow-lg shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                        <span class="text-sm font-bold">4</span>
                    </div>
                    <div
                        class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-6 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 shadow-sm hover:shadow-md transition-shadow">
                        <h4 class="font-bold text-lg mb-1">Pembayaran Administrasi</h4>
                        <p class="text-sm text-slate-500 leading-relaxed">Penyelesaian kewajiban biaya administrasi sekolah
                            sesuai ketentuan.</p>
                    </div>
                </div>
                <!-- Step 5 -->
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                    <div
                        class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white dark:border-slate-900 bg-primary text-white shadow-lg shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                        <span class="text-sm font-bold">5</span>
                    </div>
                    <div
                        class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-6 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 shadow-sm hover:shadow-md transition-shadow">
                        <h4 class="font-bold text-lg mb-1">Hasil Seleksi</h4>
                        <p class="text-sm text-slate-500 leading-relaxed">Melihat pengumuman kelulusan dan daftar ulang
                            melalui dashboard pendaftaran.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Kuota & Biaya -->
    <section class="py-20 bg-slate-50 dark:bg-slate-900/50" data-home-animate="fade-up">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-3 gap-8" data-home-stagger>
                <!-- Kuota -->
                <div class="lg:col-span-1 bg-primary p-8 rounded-3xl text-white flex flex-col justify-center">
                    <h3 class="text-2xl font-bold mb-8">Kuota Penerimaan</h3>
                    <div class="space-y-6">
                        <div class="flex items-center justify-between border-b border-white/20 pb-4">
                            <span class="font-medium">Kelas A</span>
                            <div class="text-right">
                                <span class="text-3xl font-black block">25</span>
                                <span class="text-xs uppercase font-bold text-white/70">Siswa</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between border-b border-white/20 pb-4">
                            <span class="font-medium">Kelas B</span>
                            <div class="text-right">
                                <span class="text-3xl font-black block">25</span>
                                <span class="text-xs uppercase font-bold text-white/70">Siswa</span>
                            </div>
                        </div>
                    </div>
                    <p class="mt-8 text-sm text-white/60 text-center font-medium uppercase tracking-widest">Total: 50
                        Peserta Didik</p>
                </div>
                <!-- Informasi Biaya -->
                <div
                    class="lg:col-span-2 bg-white dark:bg-slate-800 p-8 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700">
                    <h3 class="text-2xl font-bold mb-8">Informasi Biaya</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="border-b border-slate-100 dark:border-slate-700">
                                <tr>
                                    <th class="pb-4 font-bold text-slate-500">Komponen Biaya</th>
                                    <th class="pb-4 font-bold text-slate-500 text-right">Estimasi Biaya</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                                <tr>
                                    <td class="py-6">
                                        <p class="font-bold">Uang Pangkal (IPP)</p>
                                        <p class="text-xs text-slate-400">Biaya pengembangan dan pembangunan sekolah</p>
                                    </td>
                                    <td class="py-6 text-right font-medium text-primary">
                                        [Disediakan saat pendaftaran]
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-6">
                                        <p class="font-bold">SPP Bulanan</p>
                                        <p class="text-xs text-slate-400">Biaya operasional pendidikan rutin bulanan</p>
                                    </td>
                                    <td class="py-6 text-right font-medium text-primary">
                                        [Disediakan saat pendaftaran]
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div
                        class="mt-8 p-4 rounded-xl bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-900/30 flex gap-3">
                        <span class="material-symbols-outlined text-blue-600">info</span>
                        <p class="text-sm text-blue-700 dark:text-blue-400">Detail rincian biaya resmi akan terlampir pada
                            dashboard pendaftaran setelah formulir diisi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Ketentuan Penting -->
    <section class="py-20" data-home-animate="fade-up">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                data-home-animate="zoom-in"
                class="bg-white dark:bg-slate-800 rounded-3xl p-8 md:p-12 shadow-sm border border-slate-100 dark:border-slate-700">
                <h2 class="text-2xl font-bold mb-8 flex items-center gap-3">
                    <span class="material-symbols-outlined text-red-500">priority_high</span>
                    Ketentuan Penting
                </h2>
                <ul class="space-y-6">
                    <li class="flex gap-4">
                        <div class="size-6 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center shrink-0">
                            <span class="text-xs font-bold text-slate-500">1</span>
                        </div>
                        <p class="text-slate-600 dark:text-slate-400">Seluruh data yang diisi harus sesuai dengan dokumen
                            resmi kependudukan dan kesehatan.</p>
                    </li>
                    <li class="flex gap-4">
                        <div class="size-6 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center shrink-0">
                            <span class="text-xs font-bold text-slate-500">2</span>
                        </div>
                        <p class="text-slate-600 dark:text-slate-400">Sekolah berhak menolak pendaftaran apabila ditemukan
                            ketidaksesuaian data atau dokumen yang dipalsukan.</p>
                    </li>
                    <li class="flex gap-4">
                        <div class="size-6 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center shrink-0">
                            <span class="text-xs font-bold text-slate-500">3</span>
                        </div>
                        <p class="text-slate-600 dark:text-slate-400">Keterlambatan pemenuhan dokumen dan administrasi sesuai
                            jadwal bisa menyebabkan calon peserta didik di diskualifikasi.</p>
                    </li>
                    <li class="flex gap-4">
                        <div class="size-6 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center shrink-0">
                            <span class="text-xs font-bold text-slate-500">4</span>
                        </div>
                        <p class="text-slate-600 dark:text-slate-400">Keputusan hasil seleksi bersifat final dan tidak dapat
                            diganggu gugat oleh pihak manapun.</p>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-24 bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800" data-home-animate="fade-up">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <p class="text-xs font-bold text-primary tracking-widest uppercase mb-4">Informasi Tambahan</p>
                <h2 class="text-3xl md:text-5xl font-extrabold text-slate-900 leading-tight">Pertanyaan Sering Diajukan</h2>
            </div>
            
            <div class="space-y-4" data-home-stagger>
                {{-- FAQ 1 --}}
                <details class="group bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800 overflow-hidden transition-all duration-300 [&[open]]:bg-white [&[open]]:shadow-xl [&[open]]:border-primary/20">
                    <summary class="flex items-center justify-between p-6 cursor-pointer list-none font-bold text-slate-900 dark:text-slate-100 group-hover:text-primary transition-colors">
                        <span class="flex items-center gap-4">
                            <span class="size-8 bg-primary/10 rounded-lg flex items-center justify-center text-primary text-sm">01</span>
                            Berapa usia minimal untuk mendaftar di sekolah ini?
                        </span>
                        <span class="material-symbols-outlined transition-transform duration-300 group-open:rotate-180 text-slate-400">expand_more</span>
                    </summary>
                    <div class="px-6 pb-6 pt-0 ml-12 text-slate-600 dark:text-slate-400 leading-relaxed">
                        Usia minimal untuk masuk Kelompok A adalah 4 tahun 4 bulan, sedangkan untuk Kelompok B adalah 5 tahun 4 bulan pada bulan Juli tahun ajaran berjalan.
                    </div>
                </details>

                {{-- FAQ 2 --}}
                <details class="group bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800 overflow-hidden transition-all duration-300 [&[open]]:bg-white [&[open]]:shadow-xl [&[open]]:border-primary/20">
                    <summary class="flex items-center justify-between p-6 cursor-pointer list-none font-bold text-slate-900 dark:text-slate-100 group-hover:text-primary transition-colors">
                        <span class="flex items-center gap-4">
                            <span class="size-8 bg-primary/10 rounded-lg flex items-center justify-center text-primary text-sm">02</span>
                            Bagaimana cara melakukan pendaftaran online?
                        </span>
                        <span class="material-symbols-outlined transition-transform duration-300 group-open:rotate-180 text-slate-400">expand_more</span>
                    </summary>
                    <div class="px-6 pb-6 pt-0 ml-12 text-slate-600 dark:text-slate-400 leading-relaxed">
                        Ayah & Bunda cukup menekan tombol "Daftar Sekarang", lalu membuat akun pendaftar. Setelah itu, silakan lengkapi formulir biodata anak dan orang tua melalui dashboard masing-masing.
                    </div>
                </details>

                {{-- FAQ 3 --}}
                <details class="group bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800 overflow-hidden transition-all duration-300 [&[open]]:bg-white [&[open]]:shadow-xl [&[open]]:border-primary/20">
                    <summary class="flex items-center justify-between p-6 cursor-pointer list-none font-bold text-slate-900 dark:text-slate-100 group-hover:text-primary transition-colors">
                        <span class="flex items-center gap-4">
                            <span class="size-8 bg-primary/10 rounded-lg flex items-center justify-center text-primary text-sm">03</span>
                            Apa saja dokumen yang perlu disiapkan?
                        </span>
                        <span class="material-symbols-outlined transition-transform duration-300 group-open:rotate-180 text-slate-400">expand_more</span>
                    </summary>
                    <div class="px-6 pb-6 pt-0 ml-12 text-slate-600 dark:text-slate-400 leading-relaxed">
                        Dokumen yang wajib diunggah adalah Scan/Foto Kartu Keluarga (KK), Akta Kelahiran, KTP Orang Tua/Wali, dan Bukti Pembayaran dalam format gambar atau PDF yang jelas terbaca.
                    </div>
                </details>

                {{-- FAQ 4 --}}
                <details class="group bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800 overflow-hidden transition-all duration-300 [&[open]]:bg-white [&[open]]:shadow-xl [&[open]]:border-primary/20">
                    <summary class="flex items-center justify-between p-6 cursor-pointer list-none font-bold text-slate-900 dark:text-slate-100 group-hover:text-primary transition-colors">
                        <span class="flex items-center gap-4">
                            <span class="size-8 bg-primary/10 rounded-lg flex items-center justify-center text-primary text-sm">04</span>
                            Apakah ada seleksi tes masuk untuk calon siswa?
                        </span>
                        <span class="material-symbols-outlined transition-transform duration-300 group-open:rotate-180 text-slate-400">expand_more</span>
                    </summary>
                    <div class="px-6 pb-6 pt-0 ml-12 text-slate-600 dark:text-slate-400 leading-relaxed">
                        Kami tidak menerapkan tes akademik (membaca/menulis/hitung) sebagai syarat mutlak. Seleksi dilakukan berdasarkan kesiapan usia dan observasi tingkat kemandirian dasar anak.
                    </div>
                </details>

                {{-- FAQ 5 --}}
                <details class="group bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800 overflow-hidden transition-all duration-300 [&[open]]:bg-white [&[open]]:shadow-xl [&[open]]:border-primary/20">
                    <summary class="flex items-center justify-between p-6 cursor-pointer list-none font-bold text-slate-900 dark:text-slate-100 group-hover:text-primary transition-colors">
                        <span class="flex items-center gap-4">
                            <span class="size-8 bg-primary/10 rounded-lg flex items-center justify-center text-primary text-sm">05</span>
                            Kapan hasil seleksi diumumkan?
                        </span>
                        <span class="material-symbols-outlined transition-transform duration-300 group-open:rotate-180 text-slate-400">expand_more</span>
                    </summary>
                    <div class="px-6 pb-6 pt-0 ml-12 text-slate-600 dark:text-slate-400 leading-relaxed">
                        Hasil seleksi akan diumumkan sesuai jadwal (biasanya awal Juli) melalui dashboard akun pendaftar. Ayah & Bunda juga akan mendapatkan notifikasi resmi dari pihak sekolah.
                    </div>
                </details>
            </div>
        </div>
    </section>

    <!-- CTA Final -->
    <section class="py-20 bg-primary" data-home-animate="zoom-in">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-5xl font-black text-white mb-6 uppercase">Siap Bergabung Bersama Kami?</h2>
            <p class="text-white/80 text-lg mb-10 max-w-2xl mx-auto">Ayo Ayah &amp; Bunda, berikan awal terbaik untuk masa
                depan si kecil di lingkungan belajar yang aman dan menyenangkan.</p>
            <div class="flex flex-wrap justify-center gap-4">
                @guest('siswa')
                    <button onclick="showLoginModal(event)"
                        class="bg-white text-primary px-10 py-4 rounded-full font-bold text-lg hover:bg-slate-50 transition-colors shadow-xl">
                        Daftar Online Sekarang
                    </button>
                @else
                    <a href="{{ route('siswa.dashboard') }}"
                        class="bg-white text-primary px-10 py-4 rounded-full font-bold text-lg hover:bg-slate-50 transition-colors shadow-xl flex items-center">
                        Ke Dashboard Pendaftaran
                    </a>
                @endguest
                <button
                    class="bg-transparent border-2 border-white/40 text-white px-10 py-4 rounded-full font-bold text-lg hover:bg-white/10 transition-colors">
                    Hubungi WhatsApp
                </button>
            </div>
        </div>
    </section>
@endsection
