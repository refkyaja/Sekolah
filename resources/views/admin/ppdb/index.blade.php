{{-- resources/views/admin/ppdb/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Kelola PPDB')

@section('content')
{{-- Tambahkan Vite directive untuk load CSS dan JS khusus --}}
@vite(['resources/css/pages/ppdb-admin.css', 'resources/js/pages/ppdb-admin.js'])

<div class="p-6 bg-gray-50 min-h-screen" data-page="ppdb-admin">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
            <i class="fas fa-user-graduate mr-2"></i>Kelola Pendaftaran PPDB
        </h1>
        <p class="text-gray-600 mt-2">Kelola seluruh pendaftaran PPDB TK Ceria Bangsa</p>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Pendaftar</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $statistik['total'] ?? 0 }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium text-gray-500">Diterima</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $statistik['diterima'] ?? 0 }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium text-gray-500">Diproses</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $statistik['diproses'] ?? 0 }}</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-red-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium text-gray-500">Ditolak</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $statistik['ditolak'] ?? 0 }}</p>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Card -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
            <div class="flex-1">
                <form id="searchForm" method="GET" class="flex gap-4">
                    <div class="flex-1">
                        <input type="text" 
                               name="search" 
                               placeholder="Cari nama calon siswa, orang tua, atau no pendaftaran..."
                               value="{{ request('search') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                        <i class="fas fa-search mr-2"></i>Cari
                    </button>
                </form>
            </div>
            <div class="flex gap-4">
                <button id="exportBtn" class="border border-green-600 text-green-600 hover:bg-green-50 px-4 py-2 rounded-lg font-medium">
                    <i class="fas fa-file-export mr-2"></i>Export
                </button>
                <a href="{{ route('admin.ppdb.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
                    <i class="fas fa-plus mr-2"></i>Tambah Baru
                </a>
            </div>
        </div>

        <!-- Quick Filters -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="filter-select w-full px-3 py-2 border border-gray-300 rounded-lg">
                    <option value="">Semua Status</option>
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    <option value="cadangan" {{ request('status') == 'cadangan' ? 'selected' : '' }}>Cadangan</option>
                </select>
            </div>

            <!-- Kelompok Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kelompok</label>
                <select name="kelompok" class="filter-select w-full px-3 py-2 border border-gray-300 rounded-lg">
                    <option value="">Semua Kelompok</option>
                    <option value="A" {{ request('kelompok') == 'A' ? 'selected' : '' }}>Kelompok A</option>
                    <option value="B" {{ request('kelompok') == 'B' ? 'selected' : '' }}>Kelompok B</option>
                </select>
            </div>

            <!-- Jalur Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jalur</label>
                <select name="jalur" class="filter-select w-full px-3 py-2 border border-gray-300 rounded-lg">
                    <option value="">Semua Jalur</option>
                    <option value="reguler" {{ request('jalur') == 'reguler' ? 'selected' : '' }}>Reguler</option>
                    <option value="prestasi" {{ request('jalur') == 'prestasi' ? 'selected' : '' }}>Prestasi</option>
                    <option value="afirmasi" {{ request('jalur') == 'afirmasi' ? 'selected' : '' }}>Afirmasi</option>
                </select>
            </div>

            <!-- Pembayaran Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pembayaran</label>
                <select name="status_pembayaran" class="filter-select w-full px-3 py-2 border border-gray-300 rounded-lg">
                    <option value="">Semua Status</option>
                    <option value="belum" {{ request('status_pembayaran') == 'belum' ? 'selected' : '' }}>Belum Bayar</option>
                    <option value="pending" {{ request('status_pembayaran') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="lunas" {{ request('status_pembayaran') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-medium text-gray-900">Daftar Pendaftaran</h3>
                <p class="text-sm text-gray-600">{{ $ppdb->total() }} data ditemukan</p>
            </div>
            <div class="flex items-center gap-4">
                <select id="perPageSelect" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    <option value="10" {{ request('per_page', 15) == 10 ? 'selected' : '' }}>10 per halaman</option>
                    <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15 per halaman</option>
                    <option value="25" {{ request('per_page', 15) == 25 ? 'selected' : '' }}>25 per halaman</option>
                    <option value="50" {{ request('per_page', 15) == 50 ? 'selected' : '' }}>50 per halaman</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto" id="tableContainer">
            @include('admin.ppdb.partials.table')
        </div>

        <!-- Pagination -->
        @if($ppdb->hasPages())
        <div class="px-6 py-4 border-t border-gray-200" id="paginationContainer">
            {{ $ppdb->onEachSide(1)->links('vendor.pagination.tailwind') }}
        </div>
        @endif
    </div>
</div>

<!-- Export Modal -->
<div id="exportModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 ppdb-modal">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-xl bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Export Data PPDB</h3>
            <button type="button" data-modal-close="exportModal" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form action="{{ route('admin.ppdb.export') }}" method="GET" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Format File</label>
                <select name="format" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    <option value="csv">CSV (Excel)</option>
                </select>
            </div>
            
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" data-modal-close="exportModal" 
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    <i class="fas fa-download mr-2"></i>Export
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Quick Status Update Modal -->
<div id="statusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 ppdb-modal">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-xl bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Update Status</h3>
            <button type="button" data-modal-close="statusModal" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="statusForm" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')
            <input type="hidden" name="ppdb_id" id="ppdbId">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status Baru</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    <option value="menunggu">Menunggu</option>
                    <option value="diproses">Diproses</option>
                    <option value="diterima">Diterima</option>
                    <option value="ditolak">Ditolak</option>
                    <option value="cadangan">Cadangan</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                <textarea name="catatan" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                          placeholder="Tambahkan catatan jika diperlukan..."></textarea>
            </div>
            
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" data-modal-close="statusModal" 
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Quick Payment Update Modal -->
<div id="paymentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 ppdb-modal">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-xl bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Update Status Pembayaran</h3>
            <button type="button" data-modal-close="paymentModal" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="paymentForm" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="ppdb_id" id="paymentPpdbId">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status Pembayaran</label>
                <select name="status_pembayaran" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    <option value="belum">Belum Bayar</option>
                    <option value="pending">Pending</option>
                    <option value="lunas">Lunas</option>
                </select>
            </div>
            
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" data-modal-close="paymentModal" 
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
