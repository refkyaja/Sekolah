@extends('layouts.admin')

@section('title', 'Data Pendaftaran SPMB')
@section('breadcrumb', 'SPMB')

@push('meta')
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 p-3 sm:p-4 md:p-6">
    <div class="max-w-full mx-auto">
        <!-- Quick Stats - SESUAIKAN DENGAN FIELD BARU -->
        @if(isset($statistik))
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
            <!-- Total -->
            <div class="bg-white rounded-xl shadow-sm p-4 flex flex-col border border-gray-100" style="min-height: 100px;">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-blue-600 text-sm"></i>
                    </div>
                    <span class="text-xs font-medium text-gray-600">TOTAL</span>
                </div>
                <div class="mt-1">
                    <span class="text-2xl font-bold text-gray-800">{{ $statistik['total'] ?? 0 }}</span>
                </div>
            </div>

            <!-- Diterima -->
            <div class="bg-white rounded-xl shadow-sm p-4 flex flex-col border border-gray-100" style="min-height: 100px;">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-sm"></i>
                    </div>
                    <span class="text-xs font-medium text-gray-600">DITERIMA</span>
                </div>
                <div class="mt-1">
                    <span class="text-2xl font-bold text-green-600">{{ $statistik['diterima'] ?? 0 }}</span>
                </div>
            </div>

            <!-- Menunggu Verifikasi -->
            <div class="bg-white rounded-xl shadow-sm p-4 flex flex-col border border-gray-100" style="min-height: 100px;">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600 text-sm"></i>
                    </div>
                    <span class="text-xs font-medium text-gray-600">MENUNGGU</span>
                </div>
                <div class="mt-1">
                    <span class="text-2xl font-bold text-yellow-600">{{ $statistik['menunggu'] ?? 0 }}</span>
                </div>
            </div>

            <!-- Mundur -->
            <div class="bg-white rounded-xl shadow-sm p-4 flex flex-col border border-gray-100" style="min-height: 100px;">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-times-circle text-red-600 text-sm"></i>
                    </div>
                    <span class="text-xs font-medium text-gray-600">MUNDUR</span>
                </div>
                <div class="mt-1">
                    <span class="text-2xl font-bold text-red-600">{{ $statistik['mundur'] ?? 0 }}</span>
                </div>
            </div>
        </div>
        @endif

        <style>
        /* PENTING: Fix untuk mobile */
        @media (max-width: 768px) {
            .grid.grid-cols-2.md\:grid-cols-4 {
                display: grid !important;
                grid-template-columns: repeat(2, 1fr) !important;
            }
            
            .grid.grid-cols-2.md\:grid-cols-4 > div {
                min-height: 90px !important;
                padding: 12px !important;
            }
            
            .grid.grid-cols-2.md\:grid-cols-4 > div .text-2xl {
                font-size: 22px !important;
            }
            
            .grid.grid-cols-2.md\:grid-cols-4 > div .w-8.h-8 {
                width: 28px !important;
                height: 28px !important;
            }
        }

        /* Landscape mode */
        @media (min-width: 640px) and (max-width: 768px) {
            .grid.grid-cols-2.md\:grid-cols-4 {
                grid-template-columns: repeat(4, 1fr) !important;
            }
        }
        </style>

        <!-- Main Card -->
        <div class="bg-white rounded-lg sm:rounded-xl shadow-sm sm:shadow overflow-hidden">
            <!-- Header -->
            <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-0">
                <div class="flex-1 min-w-0">
                    <h2 class="text-base sm:text-lg font-semibold text-gray-800 truncate">Daftar Pendaftaran SPMB</h2>
                    <p class="text-xs sm:text-sm text-gray-600 mt-1">
                        <span id="total-spmb">{{ $spmb->total() ?? 0 }}</span> pendaftaran
                        <span id="filtered-count" class="hidden">
                            (<span id="filtered-number">0</span> hasil filter)
                        </span>
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                    <a href="{{ route('admin.spmb.create') }}" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 sm:px-4 py-2 rounded-lg flex items-center justify-center whitespace-nowrap text-sm sm:text-base transition-colors duration-150 w-full sm:w-auto">
                        <i class="fas fa-plus mr-2 text-xs sm:text-sm"></i> 
                        <span class="truncate">Tambah Pendaftaran</span>
                    </a>
                    
                    <!-- Tombol Pembagian Kelas -->
                    <button type="button" 
                            onclick="openClassDivisionModal()"
                            class="bg-green-600 hover:bg-green-700 text-white px-3 sm:px-4 py-2 rounded-lg flex items-center justify-center whitespace-nowrap text-sm sm:text-base transition-colors duration-150 w-full sm:w-auto">
                        <i class="fas fa-users-class mr-2 text-xs sm:text-sm"></i> 
                        <span class="truncate">Pembagian Kelas</span>
                    </button>
                </div>
            </div>

            <!-- Filter & Search -->
            <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gray-50 border-b">
                <div class="mb-3 sm:mb-4">
                    <div class="relative">
                        <input type="text" 
                               id="search-input" 
                               placeholder="Cari nama anak, no. pendaftaran, NIK, nama ayah/ibu..." 
                               class="w-full px-4 py-2 pl-10 pr-10 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-150"
                               autocomplete="off"
                               value="{{ request('search', '') }}">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                            <i class="fas fa-search text-gray-400 text-sm"></i>
                        </div>
                        <div id="search-clear" 
                             class="absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer hidden hover:scale-110 transition-transform"
                             title="Clear search">
                            <i class="fas fa-times text-gray-400 hover:text-gray-600 text-sm"></i>
                        </div>
                    </div>
                    <div id="search-loading" class="absolute right-10 top-1/2 transform -translate-y-1/2 hidden">
                        <i class="fas fa-spinner fa-spin text-blue-500 text-sm"></i>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                    <div class="flex-1 min-w-0">
                        <label class="block text-xs text-gray-500 mb-1 sm:hidden">Tahun Ajaran</label>
                        <select id="filter-tahun-ajaran" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-150">
                            <option value="">Semua Tahun Ajaran</option>
                            @foreach($tahunAjaran as $ta)
                                <option value="{{ $ta->id }}" {{ request('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>
                                    {{ $ta->tahun_ajaran }} - {{ $ta->semester }} {{ $ta->is_aktif ? '(Aktif)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex-1 min-w-0">
                        <label class="block text-xs text-gray-500 mb-1 sm:hidden">Status</label>
                        <select id="filter-status" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-150">
                            <option value="">Semua Status</option>
                            <option value="Diterima" {{ request('status_pendaftaran') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="Menunggu Verifikasi" {{ request('status_pendaftaran') == 'Menunggu Verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                            <option value="Mundur" {{ request('status_pendaftaran') == 'Mundur' ? 'selected' : '' }}>Mundur</option>
                        </select>
                    </div>

                    <div class="flex-1 min-w-0">
                        <label class="block text-xs text-gray-500 mb-1 sm:hidden">Jenis Kelamin</label>
                        <select id="filter-jenis-kelamin" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-150">
                            <option value="">Semua Jenis Kelamin</option>
                            <option value="Laki-laki" {{ request('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ request('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="flex-1 sm:flex-none">
                        <button id="reset-filters" 
                                class="w-full sm:w-auto px-3 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 flex items-center justify-center whitespace-nowrap transition-colors duration-150 mt-2 sm:mt-0">
                            <i class="fas fa-redo mr-1 text-xs"></i> 
                            <span>Reset Filter</span>
                        </button>
                    </div>
                </div>

                <div id="search-info" class="mt-3 text-xs sm:text-sm text-gray-600 hidden">
                    <div class="flex items-center flex-wrap gap-1 sm:gap-2">
                        <i class="fas fa-info-circle mr-1 text-blue-500"></i>
                        <span>Menampilkan hasil untuk: <span id="search-term" class="font-medium truncate"></span></span>
                        <button id="clear-search-info" class="ml-1 sm:ml-2 text-blue-600 hover:text-blue-800 text-xs transition-colors duration-150 whitespace-nowrap">
                            <i class="fas fa-times mr-1"></i> Clear
                        </button>
                    </div>
                </div>
            </div>

            <!-- Loading Overlay -->
            <div id="loading-overlay" class="fixed inset-0 bg-black bg-opacity-10 z-50 hidden backdrop-blur-sm flex items-center justify-center">
                <div class="bg-white p-4 sm:p-6 rounded-lg shadow-xl flex items-center">
                    <i class="fas fa-spinner fa-spin text-blue-500 text-xl sm:text-2xl mr-3"></i>
                    <span class="text-gray-700 text-sm sm:text-base">Memuat data pendaftaran...</span>
                </div>
            </div>

            <!-- Table Container -->
            <div id="spmb-table-container" class="w-full">
                <div class="overflow-x-auto">
                    @include('admin.spmb.partials.table', ['spmb' => $spmb])
                </div>
            </div>

            <!-- Pagination Container -->
            <div id="pagination-container" class="px-4 sm:px-6 py-3 sm:py-4 border-t border-gray-200">
                @if(isset($spmb) && $spmb->hasPages())
                    <div class="overflow-x-auto">
                        <div class="inline-block min-w-full">
                            {{ $spmb->onEachSide(0)->appends(request()->query())->links('vendor.pagination.tailwind') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Pembagian Kelas -->
<div id="classDivisionModal" class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-4xl transform transition-all duration-300 scale-95 opacity-0" id="classDivisionModalContent">
        <!-- Header -->
        <div class="px-5 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-users-class text-green-500 mr-2"></i>
                    Pembagian Kelas Otomatis
                </h3>
                <button onclick="closeClassDivisionModal()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 w-8 h-8 rounded-full flex items-center justify-center">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <p class="text-xs text-gray-500 mt-1">
                Kelompok A wajib <strong>25 siswa termuda</strong>, sisanya otomatis ke Kelompok B
            </p>
        </div>
        
        <!-- Body -->
        <div class="px-5 py-4 max-h-[70vh] overflow-y-auto">
            <!-- Filter Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <!-- Pilih Tahun Ajaran -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Ajaran</label>
                    <select id="class-year" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="">-- Pilih Tahun Ajaran --</option>
                        @foreach($tahunAjaran as $ta)
                            <option value="{{ $ta->id }}" {{ $ta->is_aktif ? 'selected' : '' }}>
                                {{ $ta->tahun_ajaran }} - {{ $ta->semester }} {{ $ta->is_aktif ? '(Aktif)' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Urutkan Berdasarkan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
                    <select id="sort-order" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="asc">Termuda ke Tertua (Ascending)</option>
                        <option value="desc">Tertua ke Termuda (Descending)</option>
                    </select>
                </div>
                
                <!-- Cari Siswa -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari Siswa</label>
                    <input type="text" id="search-student" placeholder="Nama / NIK..." 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>
            </div>
            
            <!-- Info Jumlah Siswa -->
            <div id="student-count-info" class="bg-blue-50 p-3 rounded-lg mb-6 hidden">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                        <span id="student-count-text" class="text-sm text-blue-800">Menghitung data...</span>
                    </div>
                    <div class="flex gap-4">
                        <span class="text-sm"><span id="total-siswa" class="font-bold">0</span> Total</span>
                        <span class="text-sm text-blue-600"><span id="kelompok-a-total" class="font-bold">0</span> di A</span>
                        <span class="text-sm text-green-600"><span id="kelompok-b-total" class="font-bold">0</span> di B</span>
                    </div>
                </div>
            </div>
            
            <!-- Preview Hasil Pembagian -->
            <div id="division-preview" class="space-y-4 hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kelompok A -->
                    <div class="border-2 border-blue-200 rounded-lg p-4 bg-blue-50">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h5 class="font-bold text-blue-800 text-lg">
                                    <i class="fas fa-star mr-2"></i> Kelompok A
                                </h5>
                                <p class="text-xs text-blue-600">Maksimal 25 siswa termuda</p>
                            </div>
                            <div class="text-right">
                                <span id="kelompok-a-count" class="text-2xl font-bold text-blue-800">0</span>
                                <span class="text-sm text-blue-600">/25</span>
                            </div>
                        </div>
                        
                        <!-- Search di Kelompok A -->
                        <div class="mb-3">
                            <input type="text" id="search-a" placeholder="Cari di Kelompok A..." 
                                   class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg">
                        </div>
                        
                        <!-- List Siswa Kelompok A -->
                        <div id="kelompok-a-list" class="space-y-2 max-h-60 overflow-y-auto p-2 bg-white rounded-lg">
                            <!-- Akan diisi JavaScript -->
                        </div>
                    </div>
                    
                    <!-- Kelompok B -->
                    <div class="border-2 border-green-200 rounded-lg p-4 bg-green-50">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h5 class="font-bold text-green-800 text-lg">
                                    <i class="fas fa-star-half-alt mr-2"></i> Kelompok B
                                </h5>
                                <p class="text-xs text-green-600">Sisa siswa (lebih tua)</p>
                            </div>
                            <div class="text-right">
                                <span id="kelompok-b-count" class="text-2xl font-bold text-green-800">0</span>
                                <span class="text-sm text-green-600">siswa</span>
                            </div>
                        </div>
                        
                        <!-- Search di Kelompok B -->
                        <div class="mb-3">
                            <input type="text" id="search-b" placeholder="Cari di Kelompok B..." 
                                   class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg">
                        </div>
                        
                        <!-- List Siswa Kelompok B -->
                        <div id="kelompok-b-list" class="space-y-2 max-h-60 overflow-y-auto p-2 bg-white rounded-lg">
                            <!-- Akan diisi JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="px-5 py-3 border-t border-gray-200 bg-gray-50 rounded-b-xl flex justify-end space-x-2">
            <button type="button" 
                    onclick="closeClassDivisionModal()" 
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                Batal
            </button>
            <button type="button" 
                    id="preview-division"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 flex items-center">
                <i class="fas fa-eye mr-1.5"></i> Preview
            </button>
            <button type="button" 
                    id="execute-division"
                    class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 flex items-center disabled:opacity-50 disabled:cursor-not-allowed"
                    disabled>
                <i class="fas fa-check mr-1.5"></i> Simpan Pembagian
            </button>
        </div>
    </div>
</div>
<!-- Tambahkan CSS untuk icon jika belum ada -->
<style>
    .fa-users-class:before {
        content: "\f0c0"; /* Ini adalah icon users, Anda bisa ganti dengan icon yang sesuai */
    }
</style>
@endsection

@push('styles')
<style>
    @media (max-width: 640px) {
        .overflow-x-auto::after {
            content: "← Geser untuk melihat data lengkap →";
            display: block;
            text-align: center;
            font-size: 11px;
            color: #6b7280;
            padding: 4px 0;
            background: linear-gradient(90deg, transparent, #f9fafb, transparent);
            margin-top: 8px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // CSRF Token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
        
        // Fungsi untuk menyesuaikan tabel di mobile
        function adjustTableForMobile() {
            const tableContainer = document.querySelector('#spmb-table-container .overflow-x-auto');
            if (window.innerWidth < 640) {
                if (tableContainer && !tableContainer.querySelector('.scroll-hint')) {
                    const hint = document.createElement('div');
                    hint.className = 'scroll-hint text-center text-xs text-gray-500 py-2 bg-gray-50 sticky left-0 right-0';
                    hint.innerHTML = '<i class="fas fa-arrows-alt-h mr-2"></i>Geser tabel untuk melihat lebih banyak';
                    tableContainer.appendChild(hint);
                }
            }
        }
        
        adjustTableForMobile();
        window.addEventListener('resize', adjustTableForMobile);
        
        // Handle filter changes
        const filterTahun = document.getElementById('filter-tahun-ajaran');
        const filterStatus = document.getElementById('filter-status');
        const filterJenisKelamin = document.getElementById('filter-jenis-kelamin');
        const resetBtn = document.getElementById('reset-filters');
        const searchInput = document.getElementById('search-input');
        
        function applyFilters() {
            const params = new URLSearchParams(window.location.search);
            
            if (filterTahun && filterTahun.value) {
                params.set('tahun_ajaran_id', filterTahun.value);
            } else {
                params.delete('tahun_ajaran_id');
            }
            
            if (filterStatus && filterStatus.value) {
                params.set('status_pendaftaran', filterStatus.value);
            } else {
                params.delete('status_pendaftaran');
            }
            
            if (filterJenisKelamin && filterJenisKelamin.value) {
                params.set('jenis_kelamin', filterJenisKelamin.value);
            } else {
                params.delete('jenis_kelamin');
            }
            
            if (searchInput && searchInput.value) {
                params.set('search', searchInput.value);
            } else {
                params.delete('search');
            }
            
            params.set('page', '1'); // Reset ke halaman pertama
            window.location.href = window.location.pathname + '?' + params.toString();
        }
        
        if (filterTahun) filterTahun.addEventListener('change', applyFilters);
        if (filterStatus) filterStatus.addEventListener('change', applyFilters);
        if (filterJenisKelamin) filterJenisKelamin.addEventListener('change', applyFilters);
        
        // Reset filters
        if (resetBtn) {
            resetBtn.addEventListener('click', function() {
                window.location.href = window.location.pathname;
            });
        }
        
        // Search with debounce
        let searchTimeout;
        if (searchInput) {
            searchInput.addEventListener('keyup', function(e) {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    applyFilters();
                }, 500);
            });
        }
        
        // Clear search
        const searchClear = document.getElementById('search-clear');
        if (searchClear) {
            searchClear.addEventListener('click', function() {
                if (searchInput) searchInput.value = '';
                this.classList.add('hidden');
                applyFilters();
            });
        }
        
        // Show/hide clear button based on search input
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const clearBtn = document.getElementById('search-clear');
                if (clearBtn) {
                    if (this.value.length > 0) {
                        clearBtn.classList.remove('hidden');
                    } else {
                        clearBtn.classList.add('hidden');
                    }
                }
            });
        }
        
        // Show clear button if there's initial search value
        if (searchInput && searchInput.value.length > 0) {
            const searchClear = document.getElementById('search-clear');
            if (searchClear) searchClear.classList.remove('hidden');
        }
        
        // Handle filtered count display
        @if(request()->hasAny(['search', 'tahun_ajaran_id', 'status_pendaftaran', 'jenis_kelamin']))
            const filteredCount = document.getElementById('filtered-count');
            if (filteredCount) filteredCount.classList.remove('hidden');
            
            const filteredNumber = document.getElementById('filtered-number');
            if (filteredNumber) filteredNumber.textContent = '{{ $spmb->total() ?? 0 }}';
            
            @if(request('search'))
                const searchInfo = document.getElementById('search-info');
                if (searchInfo) searchInfo.classList.remove('hidden');
                
                const searchTerm = document.getElementById('search-term');
                if (searchTerm) searchTerm.textContent = '{{ request('search') }}';
            @endif
        @endif
        
        // Clear search info
        const clearSearchInfo = document.getElementById('clear-search-info');
        if (clearSearchInfo) {
            clearSearchInfo.addEventListener('click', function() {
                if (searchInput) searchInput.value = '';
                const searchClear = document.getElementById('search-clear');
                if (searchClear) searchClear.classList.add('hidden');
                const searchInfo = document.getElementById('search-info');
                if (searchInfo) searchInfo.classList.add('hidden');
                applyFilters();
            });
        }
    });

    // === FUNGSI PEMBAGIAN KELAS ===
    let allStudents = [];
    let kelompokA = [];
    let kelompokB = [];

    // Fungsi untuk membuka modal
    window.openClassDivisionModal = function() {
        const modal = document.getElementById('classDivisionModal');
        const modalContent = document.getElementById('classDivisionModalContent');
        
        if (!modal || !modalContent) return;
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            modalContent.style.opacity = '1';
            modalContent.style.transform = 'scale(1)';
        }, 10);
        document.body.style.overflow = 'hidden';
        
        // Reset tampilan
        const studentCountInfo = document.getElementById('student-count-info');
        if (studentCountInfo) studentCountInfo.classList.add('hidden');
        
        const divisionPreview = document.getElementById('division-preview');
        if (divisionPreview) divisionPreview.classList.add('hidden');
        
        const executeBtn = document.getElementById('execute-division');
        if (executeBtn) executeBtn.disabled = true;
        
        // Reset data
        allStudents = [];
        kelompokA = [];
        kelompokB = [];
        
        // Reset input
        ['search-a', 'search-b', 'search-student'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = '';
        });
    };

    window.closeClassDivisionModal = function() {
        const modalContent = document.getElementById('classDivisionModalContent');
        if (!modalContent) return;
        
        modalContent.style.opacity = '0';
        modalContent.style.transform = 'scale(0.95)';
        setTimeout(() => {
            const modal = document.getElementById('classDivisionModal');
            if (modal) modal.classList.add('hidden');
            document.body.style.overflow = '';
        }, 200);
    };

    // Fungsi untuk membagi siswa berdasarkan umur
    function divideStudents(students, sortOrder = 'asc') {
        const studentsCopy = [...students];
        
        const sortedStudents = studentsCopy.sort((a, b) => {
            // Konversi string tanggal "dd/mm/yyyy" ke Date object
            const [dayA, monthA, yearA] = a.tanggal_lahir.split('/');
            const [dayB, monthB, yearB] = b.tanggal_lahir.split('/');
            
            const dateA = new Date(yearA, monthA - 1, dayA);
            const dateB = new Date(yearB, monthB - 1, dayB);
            
            if (sortOrder === 'asc') {
                return dateB - dateA; // Termuda dulu
            } else {
                return dateA - dateB; // Tertua dulu
            }
        });
        
        const newKelompokA = sortedStudents.slice(0, 25);
        const newKelompokB = sortedStudents.slice(25);
        
        return { kelompokA: newKelompokA, kelompokB: newKelompokB };
    }

    // Render list siswa
    function renderStudentList() {
        const kelompokAList = document.getElementById('kelompok-a-list');
        const kelompokBList = document.getElementById('kelompok-b-list');
        const searchA = document.getElementById('search-a')?.value.toLowerCase() || '';
        const searchB = document.getElementById('search-b')?.value.toLowerCase() || '';
        
        if (!kelompokAList || !kelompokBList) return;
        
        // Filter Kelompok A
        const filteredA = kelompokA.filter(s => 
            s.nama.toLowerCase().includes(searchA) || 
            (s.nik && s.nik.toLowerCase().includes(searchA))
        );
        
        // Filter Kelompok B
        const filteredB = kelompokB.filter(s => 
            s.nama.toLowerCase().includes(searchB) || 
            (s.nik && s.nik.toLowerCase().includes(searchB))
        );
        
        // Render Kelompok A
        kelompokAList.innerHTML = '';
        if (filteredA.length === 0) {
            kelompokAList.innerHTML = '<div class="text-center text-gray-400 py-4 text-sm">Tidak ada siswa</div>';
        } else {
            filteredA.forEach((siswa) => {
                const item = document.createElement('div');
                item.className = 'flex items-center justify-between p-2 bg-white border rounded-lg hover:shadow-sm transition-shadow';
                item.innerHTML = `
                    <div class="flex-1 min-w-0">
                        <div class="font-medium text-sm truncate">${siswa.nama}</div>
                        <div class="flex items-center text-xs text-gray-500 mt-1">
                            <span class="mr-3">${siswa.usia}</span>
                            <span class="truncate">${siswa.tanggal_lahir}</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" 
                                onclick="moveToB(${siswa.id})"
                                class="text-red-600 hover:text-red-800 p-1 hover:bg-red-50 rounded-lg transition-colors"
                                title="Pindah ke Kelompok B">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                `;
                kelompokAList.appendChild(item);
            });
        }
        
        // Render Kelompok B
        kelompokBList.innerHTML = '';
        if (filteredB.length === 0) {
            kelompokBList.innerHTML = '<div class="text-center text-gray-400 py-4 text-sm">Tidak ada siswa</div>';
        } else {
            filteredB.forEach((siswa) => {
                const item = document.createElement('div');
                item.className = 'flex items-center justify-between p-2 bg-white border rounded-lg hover:shadow-sm transition-shadow';
                item.innerHTML = `
                    <div class="flex-1 min-w-0">
                        <div class="font-medium text-sm truncate">${siswa.nama}</div>
                        <div class="flex items-center text-xs text-gray-500 mt-1">
                            <span class="mr-3">${siswa.usia}</span>
                            <span class="truncate">${siswa.tanggal_lahir}</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" 
                                onclick="moveToA(${siswa.id})"
                                class="text-green-600 hover:text-green-800 p-1 hover:bg-green-50 rounded-lg transition-colors"
                                title="Pindah ke Kelompok A">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                    </div>
                `;
                kelompokBList.appendChild(item);
            });
        }
        
        // Update count
        const kelompokACount = document.getElementById('kelompok-a-count');
        const kelompokBCount = document.getElementById('kelompok-b-count');
        const kelompokATotal = document.getElementById('kelompok-a-total');
        const kelompokBTotal = document.getElementById('kelompok-b-total');
        const totalSiswa = document.getElementById('total-siswa');
        
        if (kelompokACount) kelompokACount.textContent = kelompokA.length;
        if (kelompokBCount) kelompokBCount.textContent = kelompokB.length;
        if (kelompokATotal) kelompokATotal.textContent = kelompokA.length;
        if (kelompokBTotal) kelompokBTotal.textContent = kelompokB.length;
        if (totalSiswa) totalSiswa.textContent = allStudents.length;
        
        // Enable/disable tombol proses
        const executeBtn = document.getElementById('execute-division');
        if (executeBtn) {
            executeBtn.disabled = (kelompokA.length === 0 && kelompokB.length === 0);
        }
    }

    // Pindah dari A ke B
    window.moveToB = function(studentId) {
        const studentIndex = kelompokA.findIndex(s => s.id === studentId);
        if (studentIndex !== -1) {
            const student = kelompokA.splice(studentIndex, 1)[0];
            kelompokB.push(student);
            renderStudentList();
        }
    };

    // Pindah dari B ke A
    window.moveToA = function(studentId) {
        const studentIndex = kelompokB.findIndex(s => s.id === studentId);
        if (studentIndex !== -1) {
            const student = kelompokB.splice(studentIndex, 1)[0];
            
            if (kelompokA.length < 25) {
                kelompokA.push(student);
                renderStudentList();
            } else {
                alert('Kelompok A sudah mencapai batas maksimal 25 siswa!');
            }
        }
    };

    // Preview pembagian kelas
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
        
        const previewBtn = document.getElementById('preview-division');
        if (previewBtn) {
            previewBtn.addEventListener('click', function() {
                const tahunAjaranId = document.getElementById('class-year')?.value;
                const sortOrder = document.getElementById('sort-order')?.value || 'asc';
                
                if (!tahunAjaranId) {
                    alert('Pilih tahun ajaran terlebih dahulu!');
                    return;
                }
                
                // Tampilkan loading
                this.disabled = true;
                this.innerHTML = '<i class="fas fa-spinner fa-spin mr-1.5"></i> Memproses...';
                
                // Fetch data
                fetch('{{ url("admin/spmb/class-division-preview") }}?tahun_ajaran_id=' + tahunAjaranId, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        allStudents = data.students;
                        
                        const studentCountInfo = document.getElementById('student-count-info');
                        const studentCountText = document.getElementById('student-count-text');
                        if (studentCountInfo) studentCountInfo.classList.remove('hidden');
                        if (studentCountText) {
                            studentCountText.textContent = `Ditemukan ${data.students.length} siswa yang siap dibagi ke kelas.`;
                        }
                        
                        if (data.students.length > 0) {
                            const divided = divideStudents(data.students, sortOrder);
                            kelompokA = divided.kelompokA;
                            kelompokB = divided.kelompokB;
                            
                            const divisionPreview = document.getElementById('division-preview');
                            if (divisionPreview) divisionPreview.classList.remove('hidden');
                            renderStudentList();
                        } else {
                            alert('Tidak ada siswa yang perlu dibagi ke kelas.');
                            const divisionPreview = document.getElementById('division-preview');
                            if (divisionPreview) divisionPreview.classList.add('hidden');
                        }
                    } else {
                        alert('Gagal: ' + (data.message || 'Terjadi kesalahan'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memuat data: ' + error.message);
                })
                .finally(() => {
                    this.disabled = false;
                    this.innerHTML = '<i class="fas fa-eye mr-1.5"></i> Preview';
                });
            });
        }

        const sortOrder = document.getElementById('sort-order');
        if (sortOrder) {
            sortOrder.addEventListener('change', function() {
                if (allStudents.length > 0) {
                    const divided = divideStudents(allStudents, this.value);
                    kelompokA = divided.kelompokA;
                    kelompokB = divided.kelompokB;
                    renderStudentList();
                }
            });
        }

        ['search-a', 'search-b'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener('input', renderStudentList);
            }
        });

        // Eksekusi pembagian kelas
        const executeBtn = document.getElementById('execute-division');
        if (executeBtn) {
            executeBtn.addEventListener('click', function() {
                const tahunAjaranId = document.getElementById('class-year')?.value;
                
                if (!tahunAjaranId) {
                    alert('Pilih tahun ajaran terlebih dahulu!');
                    return;
                }
                
                if (kelompokA.length === 0 && kelompokB.length === 0) {
                    alert('Tidak ada data untuk disimpan!');
                    return;
                }
                
                const dataToSend = {
                    tahun_ajaran_id: tahunAjaranId,
                    kelompok_a: kelompokA.map(s => s.id),
                    kelompok_b: kelompokB.map(s => s.id)
                };
                
                if (!confirm('Apakah Anda yakin ingin menyimpan pembagian kelas ini?')) {
                    return;
                }
                
                // Tampilkan loading
                this.disabled = true;
                this.innerHTML = '<i class="fas fa-spinner fa-spin mr-1.5"></i> Menyimpan...';
                
                fetch('{{ url("admin/spmb/execute-class-division") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(dataToSend)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert(`✅ Berhasil!\n\nKelompok A: ${data.result.kelompok_a} siswa\nKelompok B: ${data.result.kelompok_b} siswa`);
                        closeClassDivisionModal();
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        alert('Gagal: ' + (data.message || 'Terjadi kesalahan'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyimpan: ' + error.message);
                })
                .finally(() => {
                    this.disabled = false;
                    this.innerHTML = '<i class="fas fa-check mr-1.5"></i> Simpan Pembagian';
                });
            });
        }

        // Tutup modal saat klik di luar
        const modal = document.getElementById('classDivisionModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeClassDivisionModal();
                }
            });
        }
    });
</script>
@endpush