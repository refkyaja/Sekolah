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
<nav aria-label="Breadcrumb" class="flex mb-4 text-xs font-medium text-slate-400 dark:text-slate-500 uppercase tracking-widest">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li><a class="hover:text-primary dark:hover:text-primary transition-colors" href="{{ route('admin.ppdb.index') }}">PPDB</a></li>
        <li><span class="mx-2">/</span></li>
        <li class="text-slate-600 dark:text-slate-400">Export Data</li>
    </ol>
</nav>

<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight">Export Data PPDB</h1>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Eksport data calon siswa berdasarkan tahun ajaran.</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.ppdb.index') }}" class="flex items-center gap-2 px-4 py-2.5 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded-xl font-medium text-sm hover:bg-slate-200 dark:hover:bg-slate-700 transition-all">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            Kembali
        </a>
    </div>
</div>

<div class="bg-white dark:bg-slate-900 rounded-2xl p-6 mb-8 border border-slate-100 dark:border-slate-800 shadow-sm">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h3 class="text-sm font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider mb-1 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-lg">download</span>
                Eksport Seluruh Data
            </h3>
            <p class="text-xs text-slate-500 dark:text-slate-400">Eksport data pendaftar dari seluruh tahun ajaran dalam satu file.</p>
        </div>
        <div class="flex gap-3">
            <button type="button" onclick="doExport('pdf')" class="flex items-center gap-2 px-6 py-2.5 bg-red-600 text-white rounded-xl font-bold text-sm hover:bg-red-700 transition-all shadow-lg shadow-red-200/50">
                <span class="material-symbols-outlined text-lg">picture_as_pdf</span>
                Export All (PDF)
            </button>
            <button type="button" onclick="doExport('excel')" class="flex items-center gap-2 px-6 py-2.5 bg-green-600 text-white rounded-xl font-bold text-sm hover:bg-green-700 transition-all shadow-lg shadow-green-200/50">
                <span class="material-symbols-outlined text-lg">table_chart</span>
                Export All (Excel)
            </button>
        </div>
    </div>
</div>

<div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
    <!-- Search Filter Section -->
    <div class="p-6 border-b border-slate-50 dark:border-slate-800">
        <div class="relative w-full md:w-72">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-lg">search</span>
            <input 
                id="tahunSearch"
                class="w-full pl-11 pr-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-sm transition-all text-slate-900 dark:text-white placeholder:text-slate-400 dark:placeholder:text-slate-500" 
                placeholder="Cari Tahun Ajaran..." 
                type="text"
                onkeyup="filterTahun()"
            />
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 dark:bg-slate-800/50">
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest border-b border-slate-100 dark:border-slate-800">No</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest border-b border-slate-100 dark:border-slate-800">Tahun Ajaran</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest border-b border-slate-100 dark:border-slate-800 text-center">Total Pendaftar</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest border-b border-slate-100 dark:border-slate-800 text-center">Lulus Seleksi</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest border-b border-slate-100 dark:border-slate-800 text-center">Tidak Lulus</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest border-b border-slate-100 dark:border-slate-800 text-center">Menunggu</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest border-b border-slate-100 dark:border-slate-800 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                @forelse($statistikPerTahun as $index => $stat)
                <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/60 transition-colors">
                    <td class="px-6 py-5 text-sm font-medium text-slate-600 dark:text-slate-400">{{ $index + 1 }}</td>
                    <td class="px-6 py-5">
                        <span class="text-sm font-bold text-slate-800 dark:text-slate-100 tahun-text">{{ $stat['tahun_ajaran'] }}</span>
                        @if($stat['is_active'])
                        <span class="ml-2 px-2 py-0.5 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 text-[10px] font-bold rounded-full uppercase">Active</span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-sm text-center font-semibold text-slate-700 dark:text-slate-200">{{ $stat['total'] }}</td>
                    <td class="px-6 py-5 text-sm text-center font-semibold text-green-600">{{ $stat['lulus'] }}</td>
                    <td class="px-6 py-5 text-sm text-center font-semibold text-red-600">{{ $stat['tidak_lulus'] }}</td>
                    <td class="px-6 py-5 text-sm text-center font-semibold text-yellow-600">{{ $stat['menunggu'] }}</td>
                    <td class="px-6 py-5">
                        <div class="flex items-center justify-end gap-3">
                            <button type="button" onclick="doExport('pdf', '{{ $stat['tahun_ajaran_id'] }}')" class="flex items-center gap-2 px-4 py-2 bg-red-50 dark:bg-red-900/10 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/20 rounded-lg text-xs font-bold transition-all border border-red-100 dark:border-red-900/30">
                                <span class="material-symbols-outlined text-lg leading-none">picture_as_pdf</span>
                                Export PDF
                            </button>
                            <button type="button" onclick="doExport('excel', '{{ $stat['tahun_ajaran_id'] }}')" class="flex items-center gap-2 px-4 py-2 bg-green-50 dark:bg-green-900/10 text-green-600 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-900/20 rounded-lg text-xs font-bold transition-all border border-green-100 dark:border-green-900/30">
                                <span class="material-symbols-outlined text-lg leading-none">table_chart</span>
                                Export Excel
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr class="empty-row">
                    <td colspan="7" class="px-6 py-12 text-center text-slate-400 dark:text-slate-600">
                        <span class="material-symbols-outlined text-5xl mb-2">folder_open</span>
                        <p class="text-sm">Tidak ada data tahun ajaran</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 bg-slate-50/50 dark:bg-slate-800/50 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
        <p class="text-xs font-medium text-slate-400 dark:text-slate-500">Showing 1 to {{ count($statistikPerTahun) }} of {{ count($statistikPerTahun) }} academic years</p>
    </div>
</div>
@push('scripts')
<script>
function doExport(format, tahunAjaranId = null) {
    let url = tahunAjaranId ? "{{ route('admin.ppdb.exportData') }}" : "{{ route('admin.ppdb.exportAll') }}";
    const params = new URLSearchParams();
    params.append('format', format);
    
    if (tahunAjaranId) {
        params.append('tahun_ajaran_id', tahunAjaranId);
    }

    window.location.href = url + '?' + params.toString();
}

function filterTahun() {
    const input = document.getElementById('tahunSearch').value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr:not(.empty-row)');
    
    rows.forEach(row => {
        const text = row.querySelector('.tahun-text').textContent.toLowerCase();
        row.style.display = text.includes(input) ? '' : 'none';
    });
}
</script>
@endpush
@endsection
