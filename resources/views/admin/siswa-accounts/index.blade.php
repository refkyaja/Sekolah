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
        <form action="{{ route('admin.siswa-accounts.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-1">
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
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Data PPDB</label>
                <select name="registration" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/20 dark:text-slate-100">
                    <option value="">Semua</option>
                    <option value="yes" {{ request('registration') === 'yes' ? 'selected' : '' }}>Sudah Daftar PPDB</option>
                    <option value="no" {{ request('registration') === 'no' ? 'selected' : '' }}>Belum Daftar PPDB</option>
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
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Kontak</th>
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-center">Status PPDB</th>
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-center">Status Akun</th>
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
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $siswa->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 text-sm text-slate-600 dark:text-slate-300">
                                <span class="material-symbols-outlined text-base">phone_iphone</span>
                                {{ $siswa->no_hp_ortu ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($siswa->spmb)
                                <span class="px-2.5 py-1 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 text-[10px] font-black uppercase tracking-wider rounded-lg border border-blue-100 dark:border-blue-800/30">
                                    SUDAH DAFTAR
                                </span>
                            @else
                                <span class="px-2.5 py-1 bg-slate-50 dark:bg-slate-800 text-slate-400 dark:text-slate-500 text-[10px] font-black uppercase tracking-wider rounded-lg border border-slate-100 dark:border-slate-700">
                                    BELUM DAFTAR
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($siswa->is_active)
                                <span class="px-2.5 py-1 bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 text-[10px] font-black uppercase tracking-wider rounded-lg border border-green-100 dark:border-green-800/30">
                                    AKTIF
                                </span>
                            @else
                                <span class="px-2.5 py-1 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 text-[10px] font-black uppercase tracking-wider rounded-lg border border-red-100 dark:border-red-800/30">
                                    NONAKTIF
                                </span>
                            @endif
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
