@extends('layouts.siswa')

@section('title', 'Pendaftaran Berhasil')

@section('content')
<main class="flex flex-1 flex-col items-center justify-center p-4 min-h-[70vh]">
    <div class="max-w-[560px] w-full bg-white dark:bg-slate-900 p-8 md:p-12 rounded-3xl shadow-sm border border-primary/5 flex flex-col items-center text-center">
        <div class="mb-8 relative">
            <div class="absolute inset-0 bg-primary/10 rounded-full animate-pulse scale-110"></div>
            <div class="relative bg-primary text-white size-24 md:size-32 rounded-full flex items-center justify-center shadow-lg shadow-primary/30">
                <span class="material-symbols-outlined text-5xl md:text-6xl" style="font-variation-settings: 'FILL' 1">check_circle</span>
            </div>
        </div>
        <h1 class="text-slate-900 dark:text-slate-100 tracking-tight text-3xl md:text-4xl font-bold leading-tight mb-4">
            Formulir Berhasil Dikirim!
        </h1>
        <p class="text-slate-600 dark:text-slate-400 text-base md:text-lg font-normal leading-relaxed mb-10 max-w-[400px]">
            Data Anda telah kami terima. Silakan lanjut ke tahap berikutnya untuk melengkapi berkas pendaftaran.
        </p>
        <div class="flex flex-col w-full gap-4">
            <a href="{{ route('siswa.dokumen') }}" class="flex min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-2xl h-14 px-6 bg-primary hover:bg-primary/90 text-white text-lg font-bold transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-md shadow-primary/20">
                <span class="truncate">Lanjut ke Tambah Dokumen</span>
                <span class="material-symbols-outlined ml-2">arrow_forward</span>
            </a>
            <a href="{{ route('siswa.dashboard') }}" class="flex min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-2xl h-14 px-6 bg-primary/10 dark:bg-primary/20 text-primary hover:bg-primary/15 dark:hover:bg-primary/30 text-base font-bold transition-all">
                <span class="material-symbols-outlined mr-2">dashboard</span>
                <span class="truncate">Kembali ke Dashboard</span>
            </a>
        </div>
        <div class="mt-12 pt-8 border-t border-primary/10 w-full flex items-center justify-center gap-8 text-slate-400 dark:text-slate-500">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">verified_user</span>
                <span class="text-xs uppercase tracking-widest font-semibold">Data Aman</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">bolt</span>
                <span class="text-xs uppercase tracking-widest font-semibold">Proses Cepat</span>
            </div>
        </div>
    </div>
    <div class="mt-8 flex flex-col items-center gap-2">
        <p class="text-sm text-slate-500 dark:text-slate-400">Butuh bantuan pendaftaran?</p>
        <a class="text-primary font-semibold text-sm hover:underline flex items-center gap-1" href="#">
            Hubungi Support Center
            <span class="material-symbols-outlined text-xs">open_in_new</span>
        </a>
    </div>
</main>
@endsection
