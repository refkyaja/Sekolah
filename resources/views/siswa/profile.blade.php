@extends('layouts.siswa')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8 flex flex-col md:flex-row md:items-end gap-6">
        <div class="relative group">
            <div class="w-32 h-32 rounded-3xl overflow-hidden border-4 border-white dark:border-slate-800 shadow-xl">
                @php
                    $fotoUrl = $siswa->foto_url;
                @endphp
                <img src="{{ $fotoUrl }}" alt="Profile Picture" class="w-full h-full object-cover">
            </div>
            <button class="absolute -bottom-2 -right-2 p-2 bg-primary text-white rounded-xl shadow-lg hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-sm">edit</span>
            </button>
        </div>
        
        <div class="flex-1">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">{{ $siswa->nama_lengkap ?? 'Siswa' }}</h1>
            <div class="flex flex-wrap gap-3">
                <span class="px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-semibold uppercase tracking-wider">
                    TK PGRI Harapan Bangsa 1
                </span>
                <span class="px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-xs font-medium">
                    NIK: {{ $siswa->nik ?? '-' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Personal Info -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-sm border border-slate-100 dark:border-slate-800">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined">person</span>
                </div>
                <h3 class="text-lg font-bold">Informasi Pribadi</h3>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label class="text-xs text-slate-500 uppercase tracking-wider mb-1 block">Nama Lengkap</label>
                    <p class="font-medium">{{ $siswa->nama_lengkap ?? '-' }}</p>
                </div>
                <div>
                    <label class="text-xs text-slate-500 uppercase tracking-wider mb-1 block">Alamat Email</label>
                    <p class="font-medium text-slate-600 dark:text-slate-400">{{ $siswa->email ?? '-' }}</p>
                </div>
                <div>
                    <label class="text-xs text-slate-500 uppercase tracking-wider mb-1 block">Nomor WhatsApp</label>
                    <p class="font-medium">{{ $siswa->whatsapp ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- System Info -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-sm border border-slate-100 dark:border-slate-800">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined">settings_account_box</span>
                </div>
                <h3 class="text-lg font-bold">Status Akun</h3>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label class="text-xs text-slate-500 uppercase tracking-wider mb-1 block">Bergabung Sejak</label>
                    <p class="font-medium">{{ $siswa->created_at->format('d F Y') }}</p>
                </div>
                <div>
                    <label class="text-xs text-slate-500 uppercase tracking-wider mb-1 block">Terakhir Update</label>
                    <p class="font-medium">{{ $siswa->updated_at->diffForHumans() }}</p>
                </div>
                <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800">
                    <button class="w-full py-3 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-semibold hover:bg-slate-200 transition-colors flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-sm">lock</span>
                        Ganti Password
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
