@extends('layouts.admin')

@section('title', 'Data Siswa')
@section('breadcrumb', 'Siswa')

@push('meta')
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 p-3 sm:p-4 md:p-6">
    <div class="max-w-full mx-auto">
        <!-- Main Card -->
        <div class="bg-white rounded-lg sm:rounded-xl shadow-sm sm:shadow overflow-hidden">
            <!-- Header dengan tombol tambah -->
            <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-0">
                <div class="flex-1 min-w-0">
                    <h2 class="text-base sm:text-lg font-semibold text-gray-800 truncate">Daftar Siswa</h2>
                    <p class="text-xs sm:text-sm text-gray-600 mt-1">
                        <span id="total-siswa">{{ $siswas->total() ?? 0 }}</span> siswa terdaftar
                        <span id="filtered-count" class="hidden">
                            (<span id="filtered-number">0</span> hasil filter)
                        </span>
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                    <a href="{{ route('admin.siswa.siswa-aktif.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-3 sm:px-4 py-2 rounded-lg flex items-center justify-center whitespace-nowrap text-sm sm:text-base transition-colors duration-150 w-full sm:w-auto">
                        <i class="fas fa-plus mr-2 text-xs sm:text-sm"></i> 
                        <span class="truncate">Tambah Siswa</span>
                    </a>
                    
                    <!-- Tombol Export -->
                    <a href="{{ route('admin.siswa.export') }}" 
                       class="bg-green-600 hover:bg-green-700 text-white px-3 sm:px-4 py-2 rounded-lg flex items-center justify-center whitespace-nowrap text-sm sm:text-base transition-colors duration-150 w-full sm:w-auto">
                        <i class="fas fa-download mr-2 text-xs sm:text-sm"></i> 
                        <span class="truncate">Export Excel</span>
                    </a>
                </div>
            </div>
            
            <!-- Filter & Search Section -->
            <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gray-50 border-b">
                <!-- Search Input -->
                <div class="mb-3 sm:mb-4">
                    <div class="relative">
                        <input type="text" 
                               id="search-input" 
                               placeholder="Cari nama siswa, NIK, nama orang tua..." 
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
                </div>
                
                <!-- Filter Group -->
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                    <!-- Kelompok Filter -->
                    <div class="flex-1 min-w-0">
                        <label class="block text-xs text-gray-500 mb-1 sm:hidden">Kelompok</label>
                        <select id="filter-kelompok" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-150">
                            <option value="">Semua Kelompok</option>
                            <option value="A" {{ request('kelompok') == 'A' ? 'selected' : '' }}>Kelompok A</option>
                            <option value="B" {{ request('kelompok') == 'B' ? 'selected' : '' }}>Kelompok B</option>
                        </select>
                    </div>
                    
                    <!-- Status Filter -->
                    <div class="flex-1 min-w-0">
                        <label class="block text-xs text-gray-500 mb-1 sm:hidden">Status</label>
                        <select id="filter-status" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-150">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="lulus" {{ request('status') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                            <option value="pindah" {{ request('status') == 'pindah' ? 'selected' : '' }}>Pindah</option>
                            <option value="cuti" {{ request('status') == 'cuti' ? 'selected' : '' }}>Cuti</option>
                        </select>
                    </div>

                    <!-- Tahun Ajaran Filter -->
                    <div class="flex-1 min-w-0">
                        <label class="block text-xs text-gray-500 mb-1 sm:hidden">Tahun Ajaran</label>
                        <select id="filter-tahun-ajaran" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-150">
                            <option value="">Semua Tahun Ajaran</option>
                            @if(isset($tahunAjarans) && $tahunAjarans->count() > 0)
                                @foreach($tahunAjarans as $ta)
                                    <option value="{{ $ta->id }}" {{ request('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>
                                        {{ $ta->tahun_ajaran }} - {{ $ta->semester }} {{ $ta->is_aktif ? '(Aktif)' : '' }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    
                    <!-- Reset Button -->
                    <div class="flex-1 sm:flex-none">
                        <button id="reset-filters" 
                                class="w-full sm:w-auto px-3 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 flex items-center justify-center whitespace-nowrap transition-colors duration-150 mt-2 sm:mt-0">
                            <i class="fas fa-redo mr-1 text-xs"></i> 
                            <span>Reset Filter</span>
                        </button>
                    </div>
                </div>
                
                <!-- Search Info -->
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
                    <span class="text-gray-700 text-sm sm:text-base">Memuat data siswa...</span>
                </div>
            </div>
            
            <!-- Tabel Container -->
            <div id="siswa-table-container" class="overflow-hidden">
                <div class="overflow-x-auto">
                    @include('admin.siswa.siswa-aktif.partials.table', ['siswas' => $siswas])
                </div>
            </div>
            
            <!-- Pagination Container -->
            <div id="pagination-container" class="px-4 sm:px-6 py-3 sm:py-4 border-t border-gray-200">
                @if(isset($siswas) && $siswas->hasPages())
                    <div class="overflow-x-auto">
                        <div class="inline-block min-w-full">
                            {{ $siswas->onEachSide(1)->appends(request()->query())->links('vendor.pagination.tailwind') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    @media (max-width: 640px) {
        .overflow-x-auto {
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
        }
        
        .overflow-x-auto::-webkit-scrollbar {
            height: 4px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        
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
        // === ELEMENTS ===
        const searchInput = document.getElementById('search-input');
        const filterKelompok = document.getElementById('filter-kelompok');
        const filterStatus = document.getElementById('filter-status');
        const filterTahunAjaran = document.getElementById('filter-tahun-ajaran');
        const resetBtn = document.getElementById('reset-filters');
        const searchClear = document.getElementById('search-clear');
        const clearSearchInfo = document.getElementById('clear-search-info');
        const searchInfo = document.getElementById('search-info');
        const searchTerm = document.getElementById('search-term');
        const loadingOverlay = document.getElementById('loading-overlay');
        
        // === APPLY FILTERS FUNCTION ===
        function applyFilters() {
            const params = new URLSearchParams(window.location.search);
            
            // Search
            if (searchInput.value.trim()) {
                params.set('search', searchInput.value.trim());
            } else {
                params.delete('search');
            }
            
            // Kelompok
            if (filterKelompok.value) {
                params.set('kelompok', filterKelompok.value);
            } else {
                params.delete('kelompok');
            }
            
            // Status
            if (filterStatus.value) {
                params.set('status', filterStatus.value);
            } else {
                params.delete('status');
            }
            
            // Tahun Ajaran
            if (filterTahunAjaran.value) {
                params.set('tahun_ajaran_id', filterTahunAjaran.value);
            } else {
                params.delete('tahun_ajaran_id');
            }
            
            // Reset to first page
            params.set('page', '1');
            
            // Show loading
            if (loadingOverlay) loadingOverlay.classList.remove('hidden');
            
            // Redirect
            window.location.href = window.location.pathname + '?' + params.toString();
        }
        
        // === EVENT LISTENERS ===
        filterKelompok?.addEventListener('change', applyFilters);
        filterStatus?.addEventListener('change', applyFilters);
        filterTahunAjaran?.addEventListener('change', applyFilters);
        
        // Search with debounce
        let searchTimeout;
        searchInput?.addEventListener('input', function() {
            // Show/hide clear button
            if (this.value.length > 0) {
                searchClear?.classList.remove('hidden');
            } else {
                searchClear?.classList.add('hidden');
            }
        });
        
        searchInput?.addEventListener('keyup', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (this.value.length >= 3 || this.value.length === 0) {
                    applyFilters();
                }
            }, 800);
        });
        
        // Search on enter
        searchInput?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                applyFilters();
            }
        });
        
        // Clear search
        searchClear?.addEventListener('click', function() {
            searchInput.value = '';
            this.classList.add('hidden');
            applyFilters();
        });
        
        // Reset all filters
        resetBtn?.addEventListener('click', function() {
            if (window.innerWidth < 640) {
                if (confirm('Reset semua filter?')) {
                    window.location.href = window.location.pathname;
                }
            } else {
                window.location.href = window.location.pathname;
            }
        });
        
        // Clear search info
        clearSearchInfo?.addEventListener('click', function() {
            searchInput.value = '';
            searchClear?.classList.add('hidden');
            applyFilters();
        });
        
        // === INITIAL STATE ===
        // Show clear button if search has value
        if (searchInput && searchInput.value.length > 0) {
            searchClear?.classList.remove('hidden');
        }
        
        // Show search info
        @if(request('search'))
            searchInfo?.classList.remove('hidden');
            if (searchTerm) searchTerm.textContent = '{{ request('search') }}';
        @endif
        
        // Show filtered count
        @if(request()->hasAny(['search', 'kelompok', 'status', 'tahun_ajaran_id']))
            document.getElementById('filtered-count')?.classList.remove('hidden');
            document.getElementById('filtered-number').textContent = '{{ $siswas->total() ?? 0 }}';
        @endif
        
        // Hide loading overlay on page load
        window.addEventListener('load', function() {
            if (loadingOverlay) loadingOverlay.classList.add('hidden');
        });
    });
</script>
@endpush