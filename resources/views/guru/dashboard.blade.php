@extends('layouts.teacher')

@section('title', 'Dashboard Guru')
@section('header_title', 'Dashboard Guru')

@section('content')
<!-- Info Guru -->
<div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-slate-800/50 dark:to-slate-700/50 rounded-2xl p-6 mb-8 border border-slate-200 dark:border-slate-800 shadow-sm">
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <img src="{{ auth()->user()->avatar_url }}" 
                 alt="Foto Profil" 
                 class="h-20 w-20 rounded-2xl object-cover border-4 border-white dark:border-slate-700 shadow-md">
        </div>
        <div class="ml-6">
            <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100">{{ auth()->user()->nama_lengkap }}</h3>
            <p class="text-slate-600 dark:text-slate-400">
                <span class="material-symbols-outlined text-sm align-middle mr-1">mail</span>{{ auth()->user()->email }}
            </p>
            @if(auth()->user()->guru)
            <div class="flex flex-wrap gap-2 mt-3">
                <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-semibold rounded-full flex items-center gap-1">
                    <span class="material-symbols-outlined text-xs">badge</span>{{ auth()->user()->guru->nip ?? 'N/A' }}
                </span>
                <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-semibold rounded-full flex items-center gap-1">
                    <span class="material-symbols-outlined text-xs">work</span>{{ auth()->user()->guru->jabatan_formatted }}
                </span>
                <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 text-xs font-semibold rounded-full flex items-center gap-1">
                    <span class="material-symbols-outlined text-xs">groups</span>{{ auth()->user()->guru->kelompok_formatted }}
                </span>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <a href="{{ route('guru.absensi.index') }}" 
       class="group relative overflow-hidden bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md hover:border-primary/30 transition-all">
        <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
            <span class="material-symbols-outlined text-8xl">assignment_turned_in</span>
        </div>
        <div class="relative z-10">
            <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined">assignment_turned_in</span>
            </div>
            <h4 class="text-lg font-bold text-slate-900 dark:text-slate-100">Absensi Siswa</h4>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola kehadiran siswa hari ini</p>
        </div>
    </a>
    
    <a href="{{ route('guru.profile') }}" 
       class="group relative overflow-hidden bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md hover:border-primary/30 transition-all">
        <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
            <span class="material-symbols-outlined text-8xl">person_edit</span>
        </div>
        <div class="relative z-10">
            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined">person_edit</span>
            </div>
            <h4 class="text-lg font-bold text-slate-900 dark:text-slate-100">Profil Saya</h4>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Perbarui data pribadi Anda</p>
        </div>
    </a>
    
    <a href="#" 
       class="group relative overflow-hidden bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md hover:border-primary/30 transition-all">
        <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
            <span class="material-symbols-outlined text-8xl">calendar_month</span>
        </div>
        <div class="relative z-10">
            <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined">calendar_month</span>
            </div>
            <h4 class="text-lg font-bold text-slate-900 dark:text-slate-100">Jadwal</h4>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Lihat jadwal mengajar mingguan</p>
        </div>
    </a>
</div>

<!-- Stats -->
<div class="bg-white dark:bg-slate-900 rounded-2xl p-8 border border-slate-200 dark:border-slate-800 shadow-sm">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-bold text-slate-900 dark:text-slate-100">Statistik Belajar</h3>
        <button class="text-sm text-primary font-medium hover:underline">Lihat Detail</button>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="space-y-1">
            <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">15</div>
            <div class="text-sm text-slate-500 dark:text-slate-400">Siswa Aktif</div>
        </div>
        <div class="space-y-1">
            <div class="text-3xl font-bold text-green-600 dark:text-green-400">98%</div>
            <div class="text-sm text-slate-500 dark:text-slate-400">Kehadiran</div>
        </div>
        <div class="space-y-1">
            <div class="text-3xl font-bold text-orange-500 dark:text-orange-400">24</div>
            <div class="text-sm text-slate-500 dark:text-slate-400">Materi/Bulan</div>
        </div>
        <div class="space-y-1">
            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400">5</div>
            <div class="text-sm text-slate-500 dark:text-slate-400">Tugas Baru</div>
        </div>
    </div>
</div>
@endsection