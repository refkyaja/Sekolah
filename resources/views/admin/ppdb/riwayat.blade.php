@php
    $role = auth()->user()->role;
    $layout = match ($role) {
        'admin' => 'layouts.admin',
        'operator' => 'layouts.operator',
        'kepala_sekolah' => 'layouts.kepala-sekolah',
        'guru' => 'layouts.guru',
        default => 'layouts.app',
    };
    $routePrefix = match ($role) {
        'admin' => 'admin',
        'operator' => 'operator',
        'kepala_sekolah' => 'kepala-sekolah',
        'guru' => 'guru',
        default => 'admin',
    };
@endphp

@extends($layout)

@push('styles')
<style>
    .sidebar-scroll::-webkit-scrollbar { width: 4px; }
    .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
    .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.2); border-radius: 10px; }
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    #sidebar-toggle:checked ~ aside { width: 80px; }
    #sidebar-toggle:checked ~ aside .logo-text, #sidebar-toggle:checked ~ aside .nav-text, #sidebar-toggle:checked ~ aside .nav-section-title, #sidebar-toggle:checked ~ aside .system-status { display: none; }
    #sidebar-toggle:checked ~ aside .nav-item { justify-content: center; padding-left: 0; padding-right: 0; }
    #sidebar-toggle:checked ~ aside .nav-section-divider { display: block; border-top: 1px solid rgba(255, 255, 255, 0.1); margin: 1rem 0.5rem; }
    .nav-section-divider { display: none; }
    aside { transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
</style>
@endpush

@section('content')
<nav aria-label="Breadcrumb" class="flex mb-4 text-xs font-medium text-slate-400 dark:text-slate-500 uppercase tracking-widest">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li><a class="hover:text-primary" href="{{ route($routePrefix . '.ppdb.index') }}">PPDB</a></li>
        <li><span class="mx-2">/</span></li>
        <li class="text-slate-600 dark:text-slate-400">Riwayat PPDB</li>
    </ol>
</nav>

<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100 tracking-tight">Riwayat PPDB</h1>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Ikhtisar data penerimaan siswa baru dari tahun-tahun sebelumnya.</p>
    </div>
</div>

<div class="bg-white dark:bg-slate-800 rounded-2xl p-6 mb-8 border border-slate-100 dark:border-slate-700 shadow-sm flex flex-wrap items-center gap-4">
    <form method="GET" class="flex-1 min-w-[250px] flex items-center gap-4">
        <div class="flex-1 relative">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500">search</span>
            <input name="search" value="{{ $search }}" class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-900 border-none dark:text-slate-100 rounded-xl focus:ring-2 focus:ring-primary/20 text-sm transition-all" placeholder="Cari Tahun Ajaran..." type="text"/>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider px-2">Filter Range:</span>
            <select name="range" class="px-4 py-3 bg-slate-50 dark:bg-slate-900 border-none dark:text-slate-100 rounded-xl focus:ring-2 focus:ring-primary/20 text-sm text-slate-600 dark:text-slate-400 transition-all cursor-pointer" onchange="this.form.submit()">
                <option value="">Semua Tahun</option>
                <option value="3" {{ $range == '3' ? 'selected' : '' }}>3 Tahun Terakhir</option>
                <option value="5" {{ $range == '5' ? 'selected' : '' }}>5 Tahun Terakhir</option>
            </select>
        </div>
        <a href="{{ route($routePrefix . '.ppdb.riwayat') }}" class="px-6 py-3 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400 rounded-xl font-bold text-sm hover:bg-slate-200 dark:hover:bg-slate-600 transition-all">
            Reset
        </a>
    </form>
</div>

<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden mb-8">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-700">
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider w-16 text-center">No</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider">Tahun Ajaran</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider">Total Pendaftar</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider">Jumlah Siswa Lulus</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
                @forelse($riwayat as $index => $item)
                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/50 transition-colors">
                    <td class="px-6 py-5 text-sm font-medium text-slate-400 dark:text-slate-500 text-center">{{ $riwayat->firstItem() + $index }}</td>
                    <td class="px-6 py-5">
                        <span class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ $item->tahun_ajaran }}</span>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ number_format($item->total_pendaftar) }}</span>
                            @if($item->persentase_kenaikan > 0)
                            <span class="text-[10px] text-green-500 dark:text-green-400 font-bold bg-green-50 dark:bg-green-900/10 px-1.5 py-0.5 rounded-md">+{{ $item->persentase_kenaikan }}%</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-5 text-sm text-slate-600 dark:text-slate-400">
                        <span class="font-bold text-primary">{{ number_format($item->total_diterima) }}</span>
                        <span class="text-xs text-slate-400 dark:text-slate-500 ml-1">({{ number_format($item->persentase_kelulusan, 1) }}%)</span>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center justify-center">
                            <a href="{{ route($routePrefix . '.ppdb.riwayat.show', $item->tahun_ajaran) }}" class="flex items-center gap-2 px-4 py-2 bg-primary/5 hover:bg-primary text-primary hover:text-white rounded-xl transition-all font-bold text-xs" title="Lihat Detail">
                                <span class="material-symbols-outlined text-base">visibility</span>
                                Show List
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-slate-400 dark:text-slate-500">
                        Tidak ada data riwayat PPDB.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($riwayat->hasPages())
<div class="flex justify-center">
    {{ $riwayat->appends(request()->query())->links() }}
</div>
@endif

<div class="bg-white dark:bg-slate-800 rounded-2xl p-8 border border-slate-100 dark:border-slate-700 shadow-sm">
    <div class="flex items-center gap-2 mb-8">
        <span class="material-symbols-outlined text-primary">info</span>
        <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 tracking-tight">Status Definitions</h3>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-12 gap-y-8">
        <div class="flex gap-4">
            <div class="w-2 h-10 bg-yellow-500 rounded-full mt-1"></div>
            <div>
                <h4 class="text-sm font-bold text-slate-800 dark:text-slate-100 uppercase tracking-tight">Menunggu Verifikasi</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">Pendaftaran baru menunggu verifikasi dokumen.</p>
            </div>
        </div>
        <div class="flex gap-4">
            <div class="w-2 h-10 bg-amber-500 rounded-full mt-1"></div>
            <div>
                <h4 class="text-sm font-bold text-slate-800 dark:text-slate-100 uppercase tracking-tight">Revisi Dokumen</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">Dokumen perlu diperbaiki/diunggah ulang.</p>
            </div>
        </div>
        <div class="flex gap-4">
            <div class="w-2 h-10 bg-blue-500 rounded-full mt-1"></div>
            <div>
                <h4 class="text-sm font-bold text-slate-800 dark:text-slate-100 uppercase tracking-tight">Dokumen Verified</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">Dokumen lengkap dan valid.</p>
            </div>
        </div>
        <div class="flex gap-4">
            <div class="w-2 h-10 bg-green-500 rounded-full mt-1"></div>
            <div>
                <h4 class="text-sm font-bold text-slate-800 dark:text-slate-100 uppercase tracking-tight">Lulus</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">Calon siswa diterima.</p>
            </div>
        </div>
        <div class="flex gap-4">
            <div class="w-2 h-10 bg-red-500 rounded-full mt-1"></div>
            <div>
                <h4 class="text-sm font-bold text-slate-800 dark:text-slate-100 uppercase tracking-tight">Tidak Lulus</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">Calon siswa tidak diterima.</p>
            </div>
        </div>
    </div>
</div>
@endsection
