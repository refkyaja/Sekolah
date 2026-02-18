@extends('layouts.admin')

@section('title', 'Data Guru')
@section('breadcrumb', 'Data Guru')

@push('meta')
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
@endpush

@section('content')
    <div class="max-w-full mx-auto">
        
        <!-- Quick Stats -->
        <div id="stats-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 sm:gap-4 mb-4 sm:mb-6">
            @include('admin.guru.partials.stats', ['gurus' => $gurus])
        </div>
        
        <!-- Main Card -->
        <div class="bg-white rounded-lg sm:rounded-xl shadow-sm sm:shadow overflow-hidden">
            <!-- Header dengan tombol tambah -->
            <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-0">
                <div class="flex-1 min-w-0">
                    <h2 class="text-base sm:text-lg font-semibold text-gray-800 truncate">Daftar Guru</h2>
                    <p class="text-xs sm:text-sm text-gray-600 mt-1">
                        <span id="total-guru">{{ $gurus->total() ?? 0 }}</span> guru terdaftar
                        <span id="filtered-count" class="hidden">
                            (<span id="filtered-number">0</span> hasil filter)
                        </span>
                    </p>
                </div>
                <a href="{{ route('admin.guru.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-3 sm:px-4 py-2 rounded-lg flex items-center justify-center whitespace-nowrap text-sm sm:text-base transition-colors duration-150 w-full sm:w-auto">
                    <i class="fas fa-plus mr-2 text-xs sm:text-sm"></i> 
                    <span class="truncate">Tambah Guru</span>
                </a>
            </div>
            
            <!-- Filter & Search Section -->
            <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gray-50 border-b">
                <!-- Search Input -->
                <div class="mb-3 sm:mb-4">
                    <div class="relative">
                        <input type="text" 
                               id="search-input" 
                               placeholder="Cari nama guru, NIP..." 
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
                
                <!-- Filter Group -->
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                    <!-- Jabatan Filter -->
                    <div class="flex-1 min-w-0">
                        <label class="block text-xs text-gray-500 mb-1 sm:hidden">Jabatan</label>
                        <select id="filter-jabatan" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-150">
                            <option value="">Semua Jabatan</option>
                            <option value="guru" {{ request('jabatan') == 'guru' ? 'selected' : '' }}>Guru</option>
                            <option value="staff" {{ request('jabatan') == 'staff' ? 'selected' : '' }}>Staff</option>
                        </select>
                    </div>
                    
                    <!-- Kelompok Filter Container -->
                    <div id="kelompok-filter-container" class="flex-1 min-w-0 hidden">
                        <label class="block text-xs text-gray-500 mb-1 sm:hidden">Kelompok</label>
                        <select id="filter-kelompok" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-150">
                            <option value="">Semua Kelompok</option>
                            <option value="A" {{ request('kelompok') == 'A' ? 'selected' : '' }}>Kelompok A</option>
                            <option value="B" {{ request('kelompok') == 'B' ? 'selected' : '' }}>Kelompok B</option>
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
                    <span class="text-gray-700 text-sm sm:text-base">Memuat data guru...</span>
                </div>
            </div>
            
            <!-- Tabel Container -->
            <div id="guru-table-container" class="overflow-hidden">
                <div class="overflow-x-auto -mx-4 sm:-mx-6">
                    <div class="inline-block min-w-full align-middle">
                        @include('admin.guru.partials.table', ['gurus' => $gurus, 'search' => $search ?? ''])
                    </div>
                </div>
            </div>
            
            <!-- Pagination Container -->
            <div id="pagination-container" class="px-4 sm:px-6 py-3 sm:py-4 border-t border-gray-200">
                @if(isset($gurus) && $gurus->hasPages())
                    <div class="overflow-x-auto">
                        <div class="inline-block min-w-full">
                            {{ $gurus->onEachSide(0)->links('vendor.pagination.tailwind') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Custom styles for responsive table */
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
        
        /* Table responsive hints */
        .overflow-x-auto::after {
            content: "← Geser →";
            display: block;
            text-align: center;
            font-size: 11px;
            color: #6b7280;
            padding: 4px 0;
            background: linear-gradient(90deg, transparent, #f9fafb, transparent);
            margin-top: 8px;
        }
    }
    
    /* Responsive filter show/hide */
    @media (max-width: 768px) {
        .filter-group {
            flex-direction: column;
        }
        
        .filter-group > * {
            width: 100%;
            margin-bottom: 8px;
        }
        
        .filter-group > *:last-child {
            margin-bottom: 0;
        }
    }
</style>
@endpush

@push('scripts')
@vite(['resources/js/guru-search.js'])

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Responsive table handling
        function adjustTableForMobile() {
            const tableContainer = document.querySelector('#guru-table-container .overflow-x-auto');
            const tables = document.querySelectorAll('table');
            
            if (window.innerWidth < 640) {
                // Add horizontal scroll indicators
                if (tableContainer && !tableContainer.querySelector('.scroll-hint')) {
                    const hint = document.createElement('div');
                    hint.className = 'scroll-hint text-center text-xs text-gray-500 py-2 bg-gray-50 sticky left-0 right-0';
                    hint.innerHTML = '<i class="fas fa-arrows-alt-h mr-2"></i>Geser tabel untuk melihat lebih banyak';
                    tableContainer.appendChild(hint);
                }
                
                // Adjust table cell padding for mobile
                tables.forEach(table => {
                    const cells = table.querySelectorAll('td, th');
                    cells.forEach(cell => {
                        cell.classList.add('px-3', 'py-2');
                        cell.classList.remove('px-6', 'py-3');
                    });
                });
            } else {
                // Restore desktop padding
                tables.forEach(table => {
                    const cells = table.querySelectorAll('td, th');
                    cells.forEach(cell => {
                        cell.classList.add('px-4', 'sm:px-6', 'py-3');
                        cell.classList.remove('px-3', 'py-2');
                    });
                });
            }
        }
        
        // Initial adjustment
        adjustTableForMobile();
        
        // Adjust on window resize
        window.addEventListener('resize', adjustTableForMobile);
        
        // Jabatan filter untuk show/hide kelompok filter
        const jabatanFilter = document.getElementById('filter-jabatan');
        const kelompokFilterContainer = document.getElementById('kelompok-filter-container');
        
        if (jabatanFilter && kelompokFilterContainer) {
            function toggleKelompokFilter() {
                if (jabatanFilter.value === 'guru') {
                    kelompokFilterContainer.classList.remove('hidden');
                    
                    // Adjust layout for mobile
                    if (window.innerWidth < 640) {
                        kelompokFilterContainer.classList.add('flex-1', 'min-w-0');
                    }
                } else {
                    kelompokFilterContainer.classList.add('hidden');
                }
            }
            
            jabatanFilter.addEventListener('change', toggleKelompokFilter);
            
            // Initial check
            toggleKelompokFilter();
            
            // Re-check on resize
            window.addEventListener('resize', toggleKelompokFilter);
        }
        
        // Mobile search optimization
        const searchInput = document.getElementById('search-input');
        if (searchInput && window.innerWidth < 640) {
            searchInput.addEventListener('focus', function() {
                // Scroll to top when search is focused on mobile
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
        
        // Filter dropdown optimization for mobile
        const filters = document.querySelectorAll('#filter-jabatan, #filter-kelompok');
        filters.forEach(filter => {
            if (filter) {
                filter.addEventListener('change', function() {
                    if (window.innerWidth < 640) {
                        // Close virtual keyboard on mobile after selection
                        this.blur();
                    }
                });
            }
        });
        
        // Reset filters button handling
        const resetButton = document.getElementById('reset-filters');
        if (resetButton) {
            resetButton.addEventListener('click', function() {
                if (window.innerWidth < 640) {
                    // Show confirmation on mobile
                    if (confirm('Reset semua filter?')) {
                        window.location.href = window.location.pathname;
                    }
                } else {
                    window.location.href = window.location.pathname;
                }
            });
        }
        
        // Handle pagination on mobile
        const paginationLinks = document.querySelectorAll('.pagination a');
        paginationLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                if (window.innerWidth < 768) {
                    // Show loading overlay on mobile
                    const overlay = document.getElementById('loading-overlay');
                    if (overlay) overlay.classList.remove('hidden');
                }
            });
        });
    });
</script>
@endpush