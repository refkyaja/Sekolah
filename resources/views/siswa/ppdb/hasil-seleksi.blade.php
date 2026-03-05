@extends('layouts.student')

@section('title', 'Hasil Seleksi PPDB')
@section('header_title', 'Dashboard Siswa')

@section('content')
@php
    $statusPengumuman = $setting ? $setting->getStatusPengumumanHomepage() : null;
    $pengumumanTampil = $setting ? $setting->isPengumumanTampil() : false;

    $status = $spmb?->status_pendaftaran;
    $isLulus = $status === 'Lulus';
    $isTidakLulus = $status === 'Tidak Lulus';

    $statusLabel = match (true) {
        $isLulus => 'SELAMAT! ANDA DINYATAKAN LULUS',
        $isTidakLulus => 'MOHON MAAF, ANDA DINYATAKAN TIDAK LULUS',
        $status === 'Revisi Dokumen' => 'DOKUMEN PERLU DIREVISI',
        $status === 'Dokumen Verified' => 'DOKUMEN TERVERIFIKASI',
        default => 'MENUNGGU VERIFIKASI',
    };

    $statusBoxClass = match (true) {
        $isLulus => 'bg-green-50 border-2 border-green-100',
        $isTidakLulus => 'bg-red-50 border-2 border-red-100',
        default => 'bg-amber-50 border-2 border-amber-100',
    };

    $statusTextClass = match (true) {
        $isLulus => 'text-green-700',
        $isTidakLulus => 'text-red-700',
        default => 'text-amber-700',
    };

    $adminCatatan = $spmb?->catatan_admin;
    $catatanDaftarUlang = $spmb?->catatan_daftar_ulang;

    $tglMulai = $spmb?->tanggal_mulai_daftar_ulang;
    $tglSelesai = $spmb?->tanggal_selesai_daftar_ulang;
@endphp

<div class="relative overflow-hidden bg-primary/10 rounded-[2.5rem] p-10 flex items-center justify-between">
    <div class="relative z-10 max-w-xl">
        <h2 class="text-4xl font-extrabold text-slate-800 dark:text-slate-100 tracking-tight leading-tight">Hasil Seleksi PPDB</h2>
        <p class="text-slate-600 dark:text-slate-300 mt-4 text-lg font-medium">Informasi resmi pengumuman kelulusan calon peserta didik baru.</p>
    </div>
    <div class="hidden lg:block relative z-10">
        <div class="w-48 h-48 bg-primary/10 rounded-full flex items-center justify-center">
            <span class="material-symbols-outlined text-primary text-7xl">workspace_premium</span>
        </div>
    </div>
    <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-primary/5 rounded-full"></div>
    <div class="absolute right-20 top-0 w-32 h-32 bg-white/40 rounded-full blur-2xl"></div>
</div>

@if(!$pengumumanTampil)
    <div class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
        <div class="p-10">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-1.5 h-6 bg-amber-400 rounded-full"></div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100">Pengumuman Belum Dibuka</h3>
            </div>
            <div class="p-6 bg-amber-50/50 dark:bg-amber-900/10 rounded-3xl border border-amber-100 dark:border-amber-800">
                <p class="text-slate-700 dark:text-slate-200 text-sm font-medium leading-relaxed">
                    {{ $statusPengumuman['message'] ?? ($setting?->pesan_tunggu ?? 'Pengumuman belum tersedia.') }}
                </p>
                @if(($statusPengumuman['status'] ?? null) === 'countdown')
                    <div class="mt-4 text-xs text-slate-500 dark:text-slate-400 font-semibold">
                        {{ $statusPengumuman['target_date'] ?? '' }} {{ $statusPengumuman['target_time'] ? ' - ' . $statusPengumuman['target_time'] . ' WIB' : '' }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@elseif(!$spmb)
    <div class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
        <div class="p-10">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-1.5 h-6 bg-amber-400 rounded-full"></div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100">Data PPDB Tidak Ditemukan</h3>
            </div>
            <div class="p-6 bg-amber-50/50 dark:bg-amber-900/10 rounded-3xl border border-amber-100 dark:border-amber-800">
                <p class="text-slate-700 dark:text-slate-200 text-sm font-medium leading-relaxed">Akun kamu belum terhubung dengan data pendaftaran PPDB/SPMB. Silakan hubungi admin sekolah.</p>
            </div>
        </div>
    </div>
@else
    @if($adminCatatan)
        <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-amber-100 dark:border-amber-900 shadow-sm overflow-hidden">
            <div class="p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-1.5 h-6 bg-amber-400 rounded-full"></div>
                    <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100">Informasi &amp; Catatan</h3>
                </div>
                <div class="flex flex-col md:flex-row items-center justify-between gap-6 p-6 bg-amber-50/50 dark:bg-amber-900/10 rounded-3xl border border-amber-100 dark:border-amber-800">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-2xl flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-amber-600">info</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 dark:text-slate-100 mb-1">Catatan Admin</h4>
                            <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed">{{ $adminCatatan }}</p>
                        </div>
                    </div>
                    <button class="flex-shrink-0 flex items-center gap-2 px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white rounded-xl font-bold text-sm transition-all shadow-lg shadow-amber-200" type="button">
                        <span class="material-symbols-outlined text-lg">upload_file</span>
                        Re-upload Dokumen
                    </button>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
        <div class="p-10 flex flex-col md:flex-row items-center gap-10">
            <div class="w-24 h-24 bg-primary/5 rounded-3xl flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-primary text-5xl">person</span>
            </div>
            <div class="flex-1 text-center md:text-left">
                <div class="flex flex-col md:flex-row md:items-center gap-4">
                    <h3 class="text-3xl font-bold text-slate-900 dark:text-slate-100">{{ $spmb->nama_lengkap_anak }}</h3>
                    <span class="inline-flex px-4 py-1.5 rounded-full text-xs font-black bg-primary/10 text-primary tracking-widest">{{ $spmb->no_registrasi ?? '-' }}</span>
                </div>
                <p class="text-slate-500 dark:text-slate-400 font-medium mt-1">Nomor Registrasi: {{ $spmb->no_pendaftaran }}</p>
            </div>
            <div class="w-full md:w-auto">
                <div class="{{ $statusBoxClass }} px-8 py-6 rounded-3xl text-center">
                    <span class="{{ $statusTextClass }} font-black text-xs uppercase tracking-[0.2em] block mb-2">Status Seleksi</span>
                    <h4 class="{{ $statusTextClass }} text-2xl font-black">{{ $statusLabel }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm p-8">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-1.5 h-6 bg-primary rounded-full"></div>
                    <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100">Ringkasan Data Calon Siswa</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="p-6 bg-slate-50/50 dark:bg-slate-800/50 rounded-2xl">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nomor Induk Kependudukan (NIK)</p>
                        <p class="text-base font-bold text-slate-700 dark:text-slate-100">{{ $spmb->nik_anak }}</p>
                    </div>
                    <div class="p-6 bg-slate-50/50 dark:bg-slate-800/50 rounded-2xl">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">NISN</p>
                        <p class="text-base font-bold text-slate-700 dark:text-slate-100">{{ $spmb->nisn ?? '-' }}</p>
                    </div>
                    <div class="p-6 bg-slate-50/50 dark:bg-slate-800/50 rounded-2xl">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nama Lengkap</p>
                        <p class="text-base font-bold text-slate-700 dark:text-slate-100">{{ $spmb->nama_lengkap_anak }}</p>
                    </div>
                    <div class="p-6 bg-slate-50/50 dark:bg-slate-800/50 rounded-2xl">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Jenis Kelamin</p>
                        <p class="text-base font-bold text-slate-700 dark:text-slate-100">{{ $spmb->jenis_kelamin ?? '-' }}</p>
                    </div>
                </div>
            </div>

            @if($catatanDaftarUlang)
                <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="material-symbols-outlined text-primary">feedback</span>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100">Catatan Daftar Ulang</h3>
                    </div>
                    <div class="p-8 bg-primary/5 rounded-3xl border border-primary/10">
                        <p class="text-slate-700 dark:text-slate-200 leading-relaxed font-medium">{{ $catatanDaftarUlang }}</p>
                        @if($tglMulai || $tglSelesai)
                            <div class="mt-4 text-xs text-slate-500 dark:text-slate-400 font-semibold">
                                {{ $tglMulai ? $tglMulai->translatedFormat('d F Y') : '-' }} - {{ $tglSelesai ? $tglSelesai->translatedFormat('d F Y') : '-' }}
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <div class="space-y-8">
            <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm p-8">
                <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-8">Langkah Selanjutnya</h3>
                <div class="space-y-4">
                    @if($isLulus)
                    <a href="{{ route('siswa.ppdb.hasil-seleksi.print', $spmb->id) }}" target="_blank" class="w-full flex items-center justify-center gap-3 px-8 py-5 bg-primary text-white rounded-2xl font-bold text-base hover:shadow-xl hover:shadow-primary/25 transition-all">
                        <span class="material-symbols-outlined">print</span>
                        Cetak Bukti Kelulusan
                    </a>
                    @else
                    <button class="w-full flex items-center justify-center gap-3 px-8 py-5 bg-slate-200 text-slate-400 rounded-2xl font-bold text-base cursor-not-allowed" disabled>
                        <span class="material-symbols-outlined">print</span>
                        Cetak Bukti Kelulusan
                    </button>
                    @endif
                    <button class="w-full flex items-center justify-center gap-3 px-8 py-5 bg-white dark:bg-slate-900 border-2 border-slate-100 dark:border-slate-800 text-slate-600 dark:text-slate-300 rounded-2xl font-bold text-base hover:bg-slate-50 dark:hover:bg-slate-800 transition-all" type="button">
                        <span class="material-symbols-outlined">support_agent</span>
                        Hubungi Admin
                    </button>
                </div>
                <div class="mt-10 pt-8 border-t border-slate-50 dark:border-slate-800">
                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-orange-50/50 dark:bg-orange-900/10 border border-orange-100 dark:border-orange-900">
                        <span class="material-symbols-outlined text-orange-400 text-2xl">warning</span>
                        <p class="text-xs text-orange-800/80 dark:text-orange-200/80 font-medium leading-relaxed">
                            Penting: Bukti kelulusan wajib dibawa saat melakukan proses daftar ulang fisik ke sekolah.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-slate-900 rounded-[2rem] p-8 text-white relative overflow-hidden group">
                <div class="relative z-10">
                    <h4 class="font-bold text-lg mb-2">Butuh Bantuan?</h4>
                    <p class="text-white/60 text-sm mb-6">Tim dukungan kami siap membantu pertanyaan Anda seputar PPDB.</p>
                    <a class="inline-flex items-center gap-2 text-primary font-bold bg-white px-5 py-2.5 rounded-xl hover:bg-primary hover:text-white transition-all" href="#">
                        Buka Tiket
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
                <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-white/5 text-9xl group-hover:scale-110 transition-transform">help_center</span>
            </div>
        </div>
    </div>
@endif
@endsection
