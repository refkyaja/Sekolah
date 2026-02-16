/**
 * resources/js/guru-search.js
 * Live Search untuk Data Guru
 */

// Konfigurasi
const CONFIG = {
    debounceDelay: 300,
    minSearchLength: 1,
    apiEndpoint: '/admin/guru',
    csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
};

// State management
let currentPage = 1;
let isLoading = false;
let abortController = null;
let debounceTimer = null;

// DOM Elements
let searchInput, filterJabatan, filterKelompok, resetButton;
let searchClear, searchInfo, searchTerm, clearSearchInfo;
let tableContainer, paginationContainer, statsContainer;
let loadingOverlay, searchLoading;
let totalGuru, filteredCount, filteredNumber;
let kelompokFilterContainer;

// Debounce function
const debounce = (func, wait) => {
    return (...args) => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            func.apply(this, args);
        }, wait);
    };
};

// Fungsi untuk menampilkan/sembunyikan filter kelompok
const toggleKelompokFilter = () => {
    const jabatanValue = filterJabatan.value;
    
    console.log('Jabatan dipilih:', jabatanValue); // Debug log
    
    if (jabatanValue === 'guru') {
        // Tampilkan filter kelompok
        kelompokFilterContainer.classList.remove('hidden');
        kelompokFilterContainer.classList.add('visible');
        console.log('Menampilkan filter kelompok');
    } else {
        // Sembunyikan filter kelompok dan reset nilainya
        kelompokFilterContainer.classList.add('hidden');
        kelompokFilterContainer.classList.remove('visible');
        filterKelompok.value = '';
        console.log('Menyembunyikan filter kelompok');
    }
};

// Update search info
const updateSearchInfo = (searchTermValue) => {
    if (!searchInfo || !searchTerm) return;
    
    if (searchTermValue.length > 0) {
        searchTerm.textContent = `"${searchTermValue}"`;
        searchInfo.classList.remove('hidden');
    } else {
        searchInfo.classList.add('hidden');
    }
};

// Show/hide loading
const showLoading = (show) => {
    if (loadingOverlay) {
        loadingOverlay.classList.toggle('hidden', !show);
    }
    if (searchLoading) {
        searchLoading.classList.toggle('hidden', !show);
    }
};

// Event Handlers
const handleSearchInput = () => {
    const searchValue = searchInput.value.trim();
    
    // Toggle clear button
    searchClear.classList.toggle('hidden', searchValue.length === 0);
    
    // Update search info
    updateSearchInfo(searchValue);
    
    // Load data
    loadData(1);
};

const handleResetFilters = () => {
    searchInput.value = '';
    filterJabatan.value = '';
    filterKelompok.value = '';
    searchClear.classList.add('hidden');
    searchInfo.classList.add('hidden');
    
    // Reset tampilan filter kelompok
    toggleKelompokFilter();
    
    loadData(1);
};

const handleClearSearch = () => {
    searchInput.value = '';
    searchClear.classList.add('hidden');
    searchInfo.classList.add('hidden');
    searchInput.focus();
    loadData(1);
};

const handleClearSearchInfo = () => {
    searchInput.value = '';
    searchInfo.classList.add('hidden');
    searchClear.classList.add('hidden');
    loadData(1);
};

const handlePaginationClick = (e) => {
    if (e.target.matches('.pagination a, .pagination a *')) {
        e.preventDefault();
        const link = e.target.closest('a');
        if (link && link.href && !link.classList.contains('disabled')) {
            const url = new URL(link.href);
            const page = url.searchParams.get('page') || 1;
            loadData(parseInt(page));
        }
    }
};

// Load data via AJAX
const loadData = async (page = 1) => {
    // Cancel previous request jika masih loading
    if (isLoading && abortController) {
        abortController.abort();
    }
    
    currentPage = page;
    isLoading = true;
    showLoading(true);
    
    const params = new URLSearchParams();
    params.append('page', page);
    
    const searchValue = searchInput.value.trim();
    if (searchValue.length > 0) {
        params.append('search', searchValue);
    }
    
    if (filterJabatan.value) {
        params.append('jabatan', filterJabatan.value);
    }
    
    // Hanya kirim filter kelompok jika jabatan adalah guru
    if (filterKelompok.value && filterJabatan.value === 'guru') {
        params.append('kelompok', filterKelompok.value);
    }
    
    // Tambahkan parameter untuk identifikasi AJAX request
    params.append('ajax', 'true');
    
    // Update URL tanpa reload
    const newUrl = `${window.location.pathname}?${params.toString()}`;
    window.history.replaceState({}, '', newUrl);
    
    try {
        abortController = new AbortController();
        
        const response = await fetch(`${CONFIG.apiEndpoint}?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': CONFIG.csrfToken
            },
            signal: abortController.signal
        });
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        
        const data = await response.json();
        
        // Update UI
        if (data.table_html) {
            tableContainer.innerHTML = data.table_html;
            tableContainer.classList.add('fade-in');
        }
        
        if (data.pagination_html && paginationContainer) {
            paginationContainer.innerHTML = data.pagination_html;
        }
        
        if (data.stats_html && statsContainer) {
            statsContainer.innerHTML = data.stats_html;
        }
        
        if (data.total !== undefined && totalGuru) {
            totalGuru.textContent = data.total;
            
            if (filteredCount && filteredNumber) {
                if (data.filtered_count > 0 && data.filtered_count !== data.total) {
                    filteredCount.classList.remove('hidden');
                    filteredNumber.textContent = data.filtered_count;
                } else {
                    filteredCount.classList.add('hidden');
                }
            }
        }
        
    } catch (error) {
        if (error.name !== 'AbortError') {
            console.error('Error loading data:', error);
            // Tampilkan error sederhana
            const errorDiv = document.createElement('div');
            errorDiv.className = 'p-4 bg-red-50 text-red-800 rounded-lg';
            errorDiv.innerHTML = `
                <p class="font-medium">Gagal memuat data</p>
                <p class="text-sm mt-1">Silakan refresh halaman atau coba lagi.</p>
            `;
            tableContainer.innerHTML = '';
            tableContainer.appendChild(errorDiv);
        }
    } finally {
        isLoading = false;
        abortController = null;
        showLoading(false);
    }
};

// Load state from URL
const loadStateFromURL = () => {
    const urlParams = new URLSearchParams(window.location.search);
    
    if (urlParams.has('search')) {
        const searchValue = urlParams.get('search');
        searchInput.value = searchValue;
        if (searchValue.length > 0) {
            searchClear.classList.remove('hidden');
            updateSearchInfo(searchValue);
        }
    }
    
    if (urlParams.has('jabatan')) {
        filterJabatan.value = urlParams.get('jabatan');
        // Tampilkan/sembunyikan filter kelompok berdasarkan jabatan
        toggleKelompokFilter();
    }
    
    if (urlParams.has('kelompok')) {
        filterKelompok.value = urlParams.get('kelompok');
    }
    
    if (urlParams.has('page')) {
        currentPage = parseInt(urlParams.get('page')) || 1;
    }
};

// Initialize
const initGuruSearch = () => {
    console.log('Initializing Guru Search...'); // Debug log
    
    // Cache DOM elements
    try {
        searchInput = document.getElementById('search-input');
        filterJabatan = document.getElementById('filter-jabatan');
        filterKelompok = document.getElementById('filter-kelompok');
        resetButton = document.getElementById('reset-filters');
        searchClear = document.getElementById('search-clear');
        searchInfo = document.getElementById('search-info');
        searchTerm = document.getElementById('search-term');
        clearSearchInfo = document.getElementById('clear-search-info');
        tableContainer = document.getElementById('guru-table-container');
        paginationContainer = document.getElementById('pagination-container');
        statsContainer = document.getElementById('stats-container');
        loadingOverlay = document.getElementById('loading-overlay');
        searchLoading = document.getElementById('search-loading');
        totalGuru = document.getElementById('total-guru');
        filteredCount = document.getElementById('filtered-count');
        filteredNumber = document.getElementById('filtered-number');
        kelompokFilterContainer = document.getElementById('kelompok-filter-container');
        
        console.log('Elements found:', {
            searchInput: !!searchInput,
            filterJabatan: !!filterJabatan,
            filterKelompok: !!filterKelompok,
            kelompokFilterContainer: !!kelompokFilterContainer
        }); // Debug log
        
        if (!searchInput || !filterJabatan) {
            console.error('Required elements not found!');
            return;
        }
        
        // Setup event listeners
        const debouncedSearch = debounce(handleSearchInput, CONFIG.debounceDelay);
        searchInput.addEventListener('input', debouncedSearch);
        
        // Event listener untuk filter jabatan
        filterJabatan.addEventListener('change', () => {
            console.log('Jabatan changed to:', filterJabatan.value); // Debug log
            toggleKelompokFilter();
            loadData(1);
        });
        
        // Event listener untuk filter kelompok
        if (filterKelompok) {
            filterKelompok.addEventListener('change', () => {
                console.log('Kelompok changed to:', filterKelompok.value); // Debug log
                loadData(1);
            });
        }
        
        resetButton.addEventListener('click', handleResetFilters);
        searchClear.addEventListener('click', handleClearSearch);
        
        if (clearSearchInfo) {
            clearSearchInfo.addEventListener('click', handleClearSearchInfo);
        }
        
        document.addEventListener('click', handlePaginationClick);
        
        // Load initial state
        loadStateFromURL();
        
        // Set initial visibility for kelompok filter
        if (kelompokFilterContainer) {
            console.log('Setting initial kelompok filter visibility'); // Debug log
            toggleKelompokFilter();
        }
        
        console.log('Guru Search initialized successfully');
        
    } catch (error) {
        console.error('Failed to initialize Guru Search:', error);
    }
};

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initGuruSearch);
} else {
    initGuruSearch();
}

// Export for module bundlers
export default initGuruSearch;