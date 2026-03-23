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

@section('title', 'Detail Riwayat PPDB')

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
<nav aria-label="Breadcrumb" class="flex mb-4 text-xs font-medium text-slate-400 uppercase tracking-widest">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li><a class="hover:text-primary" href="{{ route($routePrefix . '.ppdb.index') }}">PPDB</a></li>
        <li><a class="hover:text-primary" href="{{ route($routePrefix . '.ppdb.riwayat') }}">Riwayat PPDB</a></li>
        <li><span class="mx-2">/</span></li>
        <li class="text-slate-600">{{ $tahunAjaran }}</li>
    </ol>
</nav>

<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Riwayat PPDB - {{ $tahunAjaran }}</h1>
        <p class="text-sm text-slate-500 mt-1">Detail pendaftaran siswa tahun ajaran {{ $tahunAjaran }}.</p>
    </div>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-primary">groups</span>
            </div>
            <div>
                <p class="text-sm text-slate-500">Total Pendaftaran</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ number_format($totalPendar) }}</h3>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-green-600">check_circle</span>
            </div>
            <div>
                <p class="text-sm text-slate-500">Lulus</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ number_format($totalLulus) }}</h3>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-red-600">cancel</span>
            </div>
            <div>
                <p class="text-sm text-slate-500">Tidak Lulus</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ number_format($totalDitolak) }}</h3>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-yellow-600">hourglass_empty</span>
            </div>
            <div>
                <p class="text-sm text-slate-500">Menunggu</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ number_format($totalMenunggu) }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl p-6 mb-8 border border-slate-100 shadow-sm flex flex-wrap items-center gap-4">
    <form method="GET" class="flex-1 min-w-[250px] flex items-center gap-4">
        <div class="flex-1 relative">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">search</span>
            <input name="search" value="{{ $search }}" class="w-full pl-12 pr-4 py-3 bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-sm transition-all" placeholder="Cari nama atau no pendaftaran..." type="text"/>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider px-2">Status:</span>
            <select name="status" class="px-4 py-3 bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-sm text-slate-600 transition-all cursor-pointer" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="Menunggu Verifikasi" {{ $status == 'Menunggu Verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                <option value="Revisi Dokumen" {{ $status == 'Revisi Dokumen' ? 'selected' : '' }}>Revisi Dokumen</option>
                <option value="Dokumen Verified" {{ $status == 'Dokumen Verified' ? 'selected' : '' }}>Dokumen Verified</option>
                <option value="Lulus" {{ $status == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                <option value="Tidak Lulus" {{ $status == 'Tidak Lulus' ? 'selected' : '' }}>Tidak Lulus</option>
            </select>
        </div>
        <a href="{{ route($routePrefix . '.ppdb.riwayat.show', $tahunAjaran) }}" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-200 transition-all">
            Reset
        </a>
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-8">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-wider w-16 text-center">No</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-wider">No. Pendaftaran</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-wider">Nama Siswa</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-wider">Jalur</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($siswa as $index => $item)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-5 text-sm font-medium text-slate-400 text-center">{{ $siswa->firstItem() + $index }}</td>
                    <td class="px-6 py-5">
                        <span class="text-sm font-bold text-slate-800">{{ $item->no_pendaftaran }}</span>
                    </td>
                    <td class="px-6 py-5">
                        <span class="text-sm font-medium text-slate-700">{{ $item->nama_lengkap_anak }}</span>
                    </td>
                    <td class="px-6 py-5">
                        <span class="text-sm text-slate-600">{{ $item->jalur_pendaftaran ?? '-' }}</span>
                    </td>
                    <td class="px-6 py-5">
                        @php
                        $statusColors = [
                            'Menunggu Verifikasi' => 'bg-yellow-100 text-yellow-700',
                            'Revisi Dokumen' => 'bg-amber-100 text-amber-700',
                            'Dokumen Verified' => 'bg-blue-100 text-blue-700',
                            'Lulus' => 'bg-green-100 text-green-700',
                            'Tidak Lulus' => 'bg-red-100 text-red-700',
                        ];
                        @endphp
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $statusColors[$item->status_pendaftaran] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ $item->status_pendaftaran }}
                        </span>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center justify-center">
                            <a href="{{ route($routePrefix . '.ppdb.show', $item->id) }}" class="flex items-center gap-2 px-4 py-2 bg-primary/5 hover:bg-primary text-primary hover:text-white rounded-xl transition-all font-bold text-xs">
                                <span class="material-symbols-outlined text-base">visibility</span>
                                Detail
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-slate-400">
                        Tidak ada data siswa.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($siswa->hasPages())
<div class="flex justify-center">
    {{ $siswa->appends(request()->query())->links() }}
</div>
@endif
@endsection
