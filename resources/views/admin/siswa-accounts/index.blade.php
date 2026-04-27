@extends('layouts.admin')

@section('title', 'Manajemen Akun Calon Siswa')
@section('breadcrumb', 'Akun Calon Siswa')

@section('content')
<div class="space-y-6">
    <!-- Stats & Header Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <p class="text-sm text-slate-500 dark:text-slate-400">Total {{ $siswas->total() }} akun terdaftar dalam sistem.</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-sm border border-slate-200 dark:border-slate-800">
        <form action="{{ route('admin.siswa-accounts.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-6 gap-4">
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Cari Akun</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/20 dark:text-slate-100 placeholder:text-slate-400"
                           placeholder="Nama, Email, NIK...">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Status Akun</label>
                <select name="status" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/20 dark:text-slate-100">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Kelulusan</label>
                <select name="status_siswa" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/20 dark:text-slate-100">
                    <option value="">Semua</option>
                    <option value="aktif" {{ request('status_siswa') === 'aktif' ? 'selected' : '' }}>Siswa Aktif</option>
                    <option value="lulus" {{ request('status_siswa') === 'lulus' ? 'selected' : '' }}>Lulus / Alumni</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Login</label>
                <select name="login_method" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/20 dark:text-slate-100">
                    <option value="">Semua</option>
                    <option value="google" {{ request('login_method') === 'google' ? 'selected' : '' }}>Google</option>
                    <option value="manual" {{ request('login_method') === 'manual' ? 'selected' : '' }}>Manual</option>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-primary text-white px-4 py-2.5 rounded-xl font-semibold text-sm hover:bg-primary/90 transition-all shadow-sm shadow-primary/20">
                    Filter
                </button>
                <a href="{{ route('admin.siswa-accounts.index') }}" class="px-4 py-2.5 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded-xl font-semibold text-sm hover:bg-slate-200 dark:hover:bg-slate-700 transition-all text-center">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">No</th>
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Siswa / Akun</th>
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-center">Data PPDB</th>
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-center">Kelulusan & Status</th>
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Dibuat Pada</th>
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($siswas as $siswa)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                        <td class="px-6 py-4 text-sm text-slate-500 font-medium">
                            {{ ($siswas->currentPage()-1) * $siswas->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $siswa->foto_url }}" class="w-10 h-10 rounded-full object-cover border-2 border-white dark:border-slate-700 shadow-sm">
                                <div>
                                    <p class="text-sm font-bold text-slate-800 dark:text-slate-100 leading-tight">{{ $siswa->nama_lengkap }}</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $siswa->email }}</p>
                                        @if($siswa->provider === 'google')
                                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 bg-white border border-slate-200 shadow-sm rounded-md text-[9px] font-bold text-slate-600 uppercase tracking-wider">
                                                <svg class="w-3 h-3" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                                                Google
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 bg-slate-100 border border-slate-200 rounded-md text-[9px] font-bold text-slate-500 uppercase tracking-wider">
                                                Manual
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($siswa->spmb)
                                <span class="px-2.5 py-1 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 text-[10px] font-black uppercase tracking-wider rounded-lg border border-blue-100 dark:border-blue-800/30">
                                    SUDAH DAFTAR
                                </span>
                            @else
                                <span class="px-2.5 py-1 bg-slate-50 dark:bg-slate-800 text-slate-400 dark:text-slate-500 text-[10px] font-black uppercase tracking-wider rounded-lg border border-slate-100 dark:border-slate-700 block mb-1">
                                    BELUM DAFTAR
                                </span>
                                <span class="text-[9px] text-red-500 font-bold uppercase tracking-wider">Tidak terhubung ke data siswa</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col gap-1 items-center">
                                @if($siswa->status_siswa === 'aktif')
                                    <span class="px-2.5 py-1 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 text-[10px] font-black uppercase tracking-wider rounded-lg border border-emerald-100 dark:border-emerald-800/30 w-full">
                                        SISWA AKTIF
                                    </span>
                                @elseif($siswa->status_siswa === 'lulus')
                                    <span class="px-2.5 py-1 bg-sky-50 dark:bg-sky-900/20 text-sky-600 dark:text-sky-400 text-[10px] font-black uppercase tracking-wider rounded-lg border border-sky-100 dark:border-sky-800/30 w-full">
                                        SISWA LULUS
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 bg-slate-50 dark:bg-slate-800 text-slate-500 text-[10px] font-black uppercase tracking-wider rounded-lg border border-slate-200 dark:border-slate-700 w-full">
                                        {{ strtoupper($siswa->status_siswa ?? 'NONAKTIF') }}
                                    </span>
                                @endif

                                @if($siswa->is_active)
                                    <span class="text-[9px] text-green-600 dark:text-green-400 font-bold uppercase tracking-wider mt-1">
                                        ✔ Login Diizinkan
                                    </span>
                                @else
                                    <span class="text-[9px] text-red-600 dark:text-red-400 font-bold uppercase tracking-wider mt-1">
                                        ✖ Akun Dinonaktifkan
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-xs font-medium text-slate-600 dark:text-slate-300">{{ $siswa->created_at->translatedFormat('d M Y') }}</p>
                            <p class="text-[10px] text-slate-400">{{ $siswa->created_at->format('H:i') }}</p>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.siswa-accounts.show', $siswa) }}" 
                                   class="p-2 text-slate-400 hover:text-primary hover:bg-primary/10 rounded-lg transition-all"
                                   title="Lihat Detail">
                                    <span class="material-symbols-outlined text-xl">visibility</span>
                                </a>
                                <a href="{{ route('admin.siswa-accounts.edit', $siswa) }}" 
                                   class="p-2 text-slate-400 hover:text-amber-500 hover:bg-amber-50 dark:hover:bg-amber-900/20 rounded-lg transition-all"
                                   title="Edit Akun">
                                    <span class="material-symbols-outlined text-xl">edit</span>
                                </a>
                                <form action="{{ route('admin.siswa-accounts.toggle-status', $siswa) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="p-2 {{ $siswa->is_active ? 'text-slate-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20' : 'text-slate-400 hover:text-green-500 hover:bg-green-50 dark:hover:bg-green-900/20' }} rounded-lg transition-all"
                                            title="{{ $siswa->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}">
                                        <span class="material-symbols-outlined text-xl">{{ $siswa->is_active ? 'block' : 'check_circle' }}</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center space-y-3">
                                <div class="w-16 h-16 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center">
                                    <span class="material-symbols-outlined text-3xl text-slate-300">person_off</span>
                                </div>
                                <div class="text-slate-500 dark:text-slate-400">
                                    <p class="font-bold">Tidak ada data ditemukan</p>
                                    <p class="text-sm">Silakan sesuaikan filter atau pencarian Anda.</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($siswas->hasPages())
        <div class="px-6 py-4 bg-slate-50/50 dark:bg-slate-800/50 border-t border-slate-100 dark:border-slate-800">
            {{ $siswas->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
