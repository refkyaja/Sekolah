@extends('layouts.admin')

@push('styles')
<style>
    .sidebar-scroll::-webkit-scrollbar { width: 4px; }
    .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
    .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.2); border-radius: 10px; }
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    #sidebar-toggle:checked ~ aside { width: 80px; }
    #sidebar-toggle:checked ~ aside .logo-text,
    #sidebar-toggle:checked ~ aside .nav-text,
    #sidebar-toggle:checked ~ aside .nav-section-title,
    #sidebar-toggle:checked ~ aside .system-status { display: none; }
    #sidebar-toggle:checked ~ aside .nav-item { justify-content: center; padding-left: 0; padding-right: 0; }
    #sidebar-toggle:checked ~ aside .nav-section-divider { display: block; border-top: 1px solid rgba(255, 255, 255, 0.1); margin: 1rem 0.5rem; }
    .nav-section-divider { display: none; }
    aside { transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .export-dropdown:hover .export-menu { display: block; }
</style>
@endpush

@section('content')
<nav aria-label="Breadcrumb" class="flex mb-4 text-xs font-medium text-slate-400 uppercase tracking-widest">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <a href="{{ route('admin.spmb.index') }}">PPDB</a>
        <li><span class="mx-2">/</span></li>
        <li class="text-slate-600">Export Data</li>
    </ol>
</nav>

<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Export Data PPDB</h1>
        <p class="text-sm text-slate-500 mt-1">Eksport data calon siswa berdasarkan tahun ajaran.</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.spmb.index') }}" class="flex items-center gap-2 px-4 py-2.5 bg-slate-100 text-slate-600 rounded-xl font-medium text-sm hover:bg-slate-200 transition-all">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            Kembali
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl p-6 mb-8 border border-slate-100 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div class="flex flex-wrap items-center gap-4">
        <div class="relative w-full md:w-72">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
            <input 
                name="search" 
                value="{{ request('search') }}"
                class="w-full pl-11 pr-4 py-2.5 bg-background-light border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-sm transition-all" 
                placeholder="Cari Tahun Ajaran..." 
                type="text"
            />
        </div>
        <div class="relative">
            <select name="tahun_ajaran_id" class="appearance-none pl-4 pr-10 py-2.5 bg-background-light border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-sm font-medium text-slate-600 cursor-pointer">
                <option value="">Semua Tahun Ajaran</option>
                @foreach($tahunAjaran as $ta)
                    <option value="{{ $ta->id }}" {{ request('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>
                        {{ $ta->tahun_ajaran }}
                    </option>
                @endforeach
            </select>
            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-lg">expand_more</span>
        </div>
    </div>
    <div class="relative group export-dropdown">
        <button type="button" class="flex items-center gap-2 px-6 py-2.5 bg-primary text-white rounded-xl font-bold text-sm hover:bg-purple-700 transition-all shadow-lg shadow-primary/20">
            <span class="material-symbols-outlined text-lg">download</span>
            Export All Data
            <span class="material-symbols-outlined text-lg">arrow_drop_down</span>
        </button>
        <div class="absolute right-0 mt-2 w-48 bg-white border border-slate-100 rounded-xl shadow-xl overflow-hidden z-30 hidden group-hover:block">
            <a href="{{ route('admin.spmb.exportAll', ['format' => 'pdf']) }}" class="w-full text-left px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 flex items-center gap-2 border-b border-slate-50">
                <span class="material-symbols-outlined text-red-500 text-lg">picture_as_pdf</span>
                Export as PDF
            </a>
            <a href="{{ route('admin.spmb.exportAll', ['format' => 'excel']) }}" class="w-full text-left px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 flex items-center gap-2">
                <span class="material-symbols-outlined text-green-600 text-lg">table_chart</span>
                Export as Excel
            </a>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">No</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Tahun Ajaran</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">Total Pendaftar</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">Lulus Seleksi</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">Tidak Lulus</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">Menunggu</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($statistikPerTahun as $index => $stat)
                <tr class="hover:bg-slate-50/80 transition-colors">
                    <td class="px-6 py-5 text-sm font-medium text-slate-600">{{ $index + 1 }}</td>
                    <td class="px-6 py-5">
                        <span class="text-sm font-bold text-slate-800">{{ $stat['tahun_ajaran'] }}</span>
                        @if($stat['is_active'])
                        <span class="ml-2 px-2 py-0.5 bg-green-100 text-green-600 text-[10px] font-bold rounded-full uppercase">Active</span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-sm text-center font-semibold text-slate-700">{{ $stat['total'] }}</td>
                    <td class="px-6 py-5 text-sm text-center font-semibold text-green-600">{{ $stat['lulus'] }}</td>
                    <td class="px-6 py-5 text-sm text-center font-semibold text-red-600">{{ $stat['tidak_lulus'] }}</td>
                    <td class="px-6 py-5 text-sm text-center font-semibold text-yellow-600">{{ $stat['menunggu'] }}</td>
                    <td class="px-6 py-5">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.spmb.exportData', ['tahun_ajaran_id' => $stat['tahun_ajaran_id'], 'format' => 'pdf']) }}" class="flex items-center gap-2 px-4 py-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-xs font-bold transition-all border border-red-100">
                                <span class="material-symbols-outlined text-lg leading-none">picture_as_pdf</span>
                                Export PDF
                            </a>
                            <a href="{{ route('admin.spmb.exportData', ['tahun_ajaran_id' => $stat['tahun_ajaran_id'], 'format' => 'excel']) }}" class="flex items-center gap-2 px-4 py-2 bg-green-50 text-green-600 hover:bg-green-100 rounded-lg text-xs font-bold transition-all border border-green-100">
                                <span class="material-symbols-outlined text-lg leading-none">table_chart</span>
                                Export Excel
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                        <span class="material-symbols-outlined text-5xl mb-2">folder_open</span>
                        <p class="text-sm">Tidak ada data tahun ajaran</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
        <p class="text-xs font-medium text-slate-400">Showing 1 to {{ count($statistikPerTahun) }} of {{ count($statistikPerTahun) }} academic years</p>
    </div>
</div>
@endsection
