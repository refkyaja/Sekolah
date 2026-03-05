@extends('layouts.admin')

@push('styles')
<style>
    .sidebar-scroll::-webkit-scrollbar {
        width: 4px;
    }
    .sidebar-scroll::-webkit-scrollbar-track {
        background: transparent;
    }
    .sidebar-scroll::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
    }
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    #sidebar-toggle:checked ~ aside {
        width: 80px;
    }
    #sidebar-toggle:checked ~ aside .logo-text,
    #sidebar-toggle:checked ~ aside .nav-text,
    #sidebar-toggle:checked ~ aside .nav-section-title,
    #sidebar-toggle:checked ~ aside .system-status {
        display: none;
    }
    #sidebar-toggle:checked ~ aside .nav-item {
        justify-content: center;
        padding-left: 0;
        padding-right: 0;
    }
    #sidebar-toggle:checked ~ aside .nav-section-divider {
        display: block;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        margin: 1rem 0.5rem;
    }
    .nav-section-divider {
        display: none;
    }
    aside {
        transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .data-table th {
        white-space: nowrap;
    }
    .data-table td {
        vertical-align: middle;
    }
</style>
@endpush

@section('content')
<nav aria-label="Breadcrumb" class="flex mb-4 text-xs font-medium text-slate-400 uppercase tracking-widest">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li><a class="hover:text-primary" href="#">PPDB</a></li>
        <li><span class="mx-2">/</span></li>
        <li class="text-slate-600">Pendaftaran</li>
    </ol>
</nav>

<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Pendaftaran PPDB</h1>
        <p class="text-sm text-slate-500 mt-1">Manajemen pendaftaran calon siswa baru dengan fitur filter dan aksi massal.</p>
    </div>
    <a href="{{ route('admin.ppdb.create') }}" class="flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-2xl font-bold text-sm hover:bg-primary/90 transition-all shadow-lg shadow-primary/25">
        <span class="material-symbols-outlined text-lg">add</span>
        Tambah Data PPDB
    </a>
</div>

<form action="{{ route('admin.ppdb.index') }}" method="GET">
    <div class="bg-white rounded-2xl p-6 mb-8 border border-slate-100 shadow-sm flex flex-wrap items-center gap-4">
        <div class="flex-1 min-w-[250px] relative">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">search</span>
            <input 
                name="search" 
                value="{{ request('search') }}"
                class="w-full pl-12 pr-4 py-3 bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-sm transition-all" 
                placeholder="Cari Kode Pendaftaran atau Nama..." 
                type="text"
            />
        </div>
        <div class="w-full md:w-48">
            <select name="status" class="w-full px-4 py-3 bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-sm text-slate-600 transition-all cursor-pointer">
                <option value="">Semua Status</option>
                <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                <option value="cadangan" {{ request('status') == 'cadangan' ? 'selected' : '' }}>Cadangan</option>
            </select>
        </div>
        <div class="w-full md:w-56">
            <select class="w-full px-4 py-3 bg-primary/10 border-2 border-primary/20 rounded-xl focus:ring-2 focus:ring-primary/20 text-sm text-primary font-bold transition-all cursor-pointer outline-none">
                <option disabled selected value="">Aksi Massal</option>
                <option value="verify">Verifikasi Terpilih</option>
                <option value="update_status">Update Status Terpilih</option>
                <option value="delete">Hapus Terpilih</option>
            </select>
        </div>
        <a href="{{ route('admin.ppdb.index') }}" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-200 transition-all">
            Reset Filter
        </a>
        <button type="submit" class="px-6 py-3 bg-primary text-white rounded-xl font-bold text-sm hover:bg-primary/90 transition-all">
            Filter
        </button>
    </div>
</form>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-8">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse data-table">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th class="pl-6 py-4 w-12">
                        <input class="w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary transition-all cursor-pointer" type="checkbox" id="selectAll"/>
                    </th>
                    <th class="px-4 py-4 text-[11px] font-black text-slate-400 uppercase tracking-wider w-16">No</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-wider">Kode Pendaftaran</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-wider">Nama Lengkap</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-wider">Jenis Kelamin</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-wider">Tanggal & Waktu Pendaftaran</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($spmb as $index => $item)
                <tr class="hover:bg-slate-50/50 transition-colors group" data-id="{{ $item->id }}">
                    <td class="pl-6 py-4">
                        <input class="w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary transition-all cursor-pointer item-checkbox" type="checkbox" value="{{ $item->id }}"/>
                    </td>
                    <td class="px-4 py-4 text-sm font-medium text-slate-400">{{ $spmb->firstItem() + $index }}</td>
                    <td class="px-6 py-4 text-sm font-bold text-primary">{{ $item->no_pendaftaran ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="text-sm font-bold text-slate-800">{{ $item->nama_lengkap_anak ?? '-' }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600">
                        @if($item->jenis_kelamin == 'Laki-laki')
                            Laki-laki
                        @elseif($item->jenis_kelamin == 'Perempuan')
                            Perempuan
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-500">
                        {{ $item->created_at ? $item->created_at->format('d M Y, H:i') : '-' }}
                    </td>
                    <td class="px-6 py-4">
                        @switch($item->status_pendaftaran)
                            @case('Menunggu Verifikasi')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-orange-100 text-orange-700 uppercase tracking-wider">Menunggu Verifikasi</span>
                                @break
                            @case('Diterima')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-700 uppercase tracking-wider">Lulus</span>
                                @break
                            @case('Mundur')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-700 uppercase tracking-wider">Tidak Lulus</span>
                                @break
                            @case('Diproses')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700 uppercase tracking-wider">Dokumen Verified</span>
                                @break
                            @default
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-yellow-100 text-yellow-700 uppercase tracking-wider">{{ $item->status_pendaftaran ?? 'Menunggu' }}</span>
                        @endswitch
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.ppdb.show', $item->id) }}" class="p-2 bg-slate-50 hover:bg-primary/10 text-slate-400 hover:text-primary rounded-lg transition-all" title="Show">
                                <span class="material-symbols-outlined text-lg">visibility</span>
                            </a>
                            <a href="{{ route('admin.ppdb.edit', $item->id) }}" class="p-2 bg-slate-50 hover:bg-primary/10 text-slate-400 hover:text-primary rounded-lg transition-all" title="Edit">
                                <span class="material-symbols-outlined text-lg">edit</span>
                            </a>
                            <button onclick="updateStatus({{ $item->id }}, '{{ $item->nama_lengkap_anak }}')" class="p-2 bg-slate-50 hover:bg-green-50 text-slate-400 hover:text-green-500 rounded-lg transition-all" title="Update Status">
                                <span class="material-symbols-outlined text-lg">refresh</span>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <span class="material-symbols-outlined text-5xl text-slate-300 mb-3">folder_off</span>
                            <p class="text-slate-500 font-medium">Tidak ada data pendaftaran</p>
                            <a href="{{ route('admin.ppdb.create') }}" class="text-primary hover:underline text-sm mt-2">Tambah data baru</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($spmb->hasPages())
    <div class="px-6 py-4 border-t border-slate-50 flex items-center justify-between">
        <p class="text-xs text-slate-400 font-medium">Showing <span class="text-slate-900">{{ $spmb->firstItem() ?? 0 }}</span> to <span class="text-slate-900">{{ $spmb->lastItem() ?? 0 }}</span> of <span class="text-slate-900">{{ $spmb->total() }}</span> pendaftar</p>
        <div class="flex gap-2">
            @if($spmb->onFirstPage())
                <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-400 cursor-not-allowed">
                    <span class="material-symbols-outlined text-lg">chevron_left</span>
                </button>
            @else
                <a href="{{ $spmb->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-400 hover:bg-slate-50 transition-colors">
                    <span class="material-symbols-outlined text-lg">chevron_left</span>
                </a>
            @endif
            
            @foreach($spmb->getUrlRange(1, $spmb->lastPage()) as $page => $url)
                @if($page == $spmb->currentPage())
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-primary text-white text-xs font-bold">{{ $page }}</button>
                @else
                    <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-600 text-xs font-bold hover:bg-slate-50">{{ $page }}</a>
                @endif
            @endforeach
            
            @if($spmb->hasMorePages())
                <a href="{{ $spmb->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-400 hover:bg-slate-50 transition-colors">
                    <span class="material-symbols-outlined text-lg">chevron_right</span>
                </a>
            @else
                <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 text-slate-400 cursor-not-allowed">
                    <span class="material-symbols-outlined text-lg">chevron_right</span>
                </button>
            @endif
        </div>
    </div>
    @endif
</div>

<div class="bg-white rounded-2xl p-8 border border-slate-100 shadow-sm">
    <div class="flex items-center gap-2 mb-8">
        <span class="material-symbols-outlined text-primary">info</span>
        <h3 class="text-lg font-bold text-slate-800 tracking-tight">Status Information</h3>
    </div>
    <div class="space-y-6 max-w-4xl">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 mt-1">
                <span class="inline-flex items-center justify-center px-2 py-1 rounded-md text-[10px] font-black bg-orange-100 text-orange-700 uppercase tracking-widest min-w-[130px]">Menunggu Verifikasi</span>
            </div>
            <div class="flex-1">
                <h4 class="text-sm font-bold text-slate-800 tracking-tight">Menunggu Verifikasi</h4>
                <p class="text-[13px] text-slate-500 mt-0.5">Pendaftaran baru masuk dan perlu diperiksa.</p>
            </div>
        </div>
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 mt-1">
                <span class="inline-flex items-center justify-center px-2 py-1 rounded-md text-[10px] font-black bg-yellow-100 text-yellow-700 uppercase tracking-widest min-w-[130px]">Revisi Dokumen</span>
            </div>
            <div class="flex-1">
                <h4 class="text-sm font-bold text-slate-800 tracking-tight">Revisi Dokumen</h4>
                <p class="text-[13px] text-slate-500 mt-0.5">Menunggu perbaikan berkas dari orang tua.</p>
            </div>
        </div>
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 mt-1">
                <span class="inline-flex items-center justify-center px-2 py-1 rounded-md text-[10px] font-black bg-blue-100 text-blue-700 uppercase tracking-widest min-w-[130px]">Dokumen Verified</span>
            </div>
            <div class="flex-1">
                <h4 class="text-sm font-bold text-slate-800 tracking-tight">Dokumen Verified</h4>
                <p class="text-[13px] text-slate-500 mt-0.5">Berkas lengkap dan valid.</p>
            </div>
        </div>
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 mt-1">
                <span class="inline-flex items-center justify-center px-2 py-1 rounded-md text-[10px] font-black bg-green-100 text-green-700 uppercase tracking-widest min-w-[130px]">Lulus</span>
            </div>
            <div class="flex-1">
                <h4 class="text-sm font-bold text-slate-800 tracking-tight">Lulus</h4>
                <p class="text-[13px] text-slate-500 mt-0.5">Calon siswa diterima.</p>
            </div>
        </div>
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 mt-1">
                <span class="inline-flex items-center justify-center px-2 py-1 rounded-md text-[10px] font-black bg-red-100 text-red-700 uppercase tracking-widest min-w-[130px]">Tidak Lulus</span>
            </div>
            <div class="flex-1">
                <h4 class="text-sm font-bold text-slate-800 tracking-tight">Tidak Lulus</h4>
                <p class="text-[13px] text-slate-500 mt-0.5">Calon siswa tidak diterima.</p>
            </div>
        </div>
    </div>
</div>

<!-- Update Status Modal -->
<div id="statusModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md mx-4 shadow-2xl">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-slate-800">Update Status</h3>
            <button onclick="closeStatusModal()" class="text-slate-400 hover:text-slate-600">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <form id="statusForm" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" id="ppdbId" name="ppdb_id">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-2">Nama Siswa</label>
                <p id="siswaName" class="text-slate-800 font-medium">-</p>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-2">Status Baru</label>
                <select name="status" class="w-full px-4 py-3 bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-sm">
                    <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
                    <option value="Diproses">Diproses</option>
                    <option value="Diterima">Diterima</option>
                    <option value="Mundur">Mundur</option>
                </select>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-2">Catatan (Opsional)</label>
                <textarea name="catatan" rows="3" class="w-full px-4 py-3 bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-sm" placeholder="Tambahkan catatan..."></textarea>
            </div>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeStatusModal()" class="flex-1 px-6 py-3 border border-slate-200 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-50 transition-all">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-6 py-3 bg-primary text-white rounded-xl font-bold text-sm hover:bg-primary/90 transition-all">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Select All Checkbox
    document.getElementById('selectAll')?.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.item-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Update Status Modal
    function updateStatus(id, name) {
        document.getElementById('ppdbId').value = id;
        document.getElementById('siswaName').textContent = name;
        document.getElementById('statusForm').action = `/admin/ppdb/${id}/update-status`;
        document.getElementById('statusModal').classList.remove('hidden');
        document.getElementById('statusModal').classList.add('flex');
    }

    function closeStatusModal() {
        document.getElementById('statusModal').classList.add('hidden');
        document.getElementById('statusModal').classList.remove('flex');
    }

    // Close modal on outside click
    document.getElementById('statusModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeStatusModal();
        }
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeStatusModal();
        }
    });
</script>
@endpush
@endsection
