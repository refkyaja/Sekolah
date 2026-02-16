/**
 * Live Search untuk Data Guru dengan AJAX
 * File: resources/js/guru-search.js
 */

// Konfigurasi
const CONFIG = {
    debounceDelay: 500,
    minSearchLength: 1,
    apiEndpoint: '/admin/guru',
    csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
};

// State management
let currentPage = 1;
let isLoading = false;
let abortController = null;
let debounceTimer = null;

// DOM Elements - cache dengan null check
let searchInput, filterJabatan, filterStatus, resetButton;
let searchClear, searchInfo, searchTerm, clearSearchInfo;
let tableContainer, paginationContainer, statsContainer;
let loadingOverlay, searchLoading;
let totalGuru, filteredCount, filteredNumber;

// Helper function untuk debounce
const debounce = (func, wait) => {
    return (...args) => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            func.apply(this, args);
        }, wait);
    };
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

// Update URL tanpa reload
const updateURL = (params) => {
    const newUrl = `${window.location.pathname}?${params.toString()}`;
    window.history.replaceState({}, '', newUrl);
};

// Show/hide loading
const showLoading = (show) => {
    if (loadingOverlay) {
        if (show) {
            loadingOverlay.classList.remove('hidden');
        } else {
            loadingOverlay.classList.add('hidden');
        }
    }
    if (searchLoading) {
        searchLoading.classList.toggle('hidden', !show);
    }
};

// Show error message
const showError = (message) => {
    const existingError = document.getElementById('ajax-error');
    if (existingError) {
        existingError.remove();
    }
    
    const errorDiv = document.createElement('div');
    errorDiv.id = 'ajax-error';
    errorDiv.className = 'fixed top-4 right-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg shadow-lg z-50 max-w-md';
    errorDiv.innerHTML = `
        <div class="flex items-start">
            <i class="fas fa-exclamation-triangle text-red-500 mt-0.5 mr-2"></i>
            <div class="flex-1">
                <p class="font-medium">Gagal Memuat Data</p>
                <p class="text-sm mt-1">${message}</p>
            </div>
            <button class="ml-3 text-red-500 hover:text-red-700" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    document.body.appendChild(errorDiv);
    
    setTimeout(() => {
        if (errorDiv.parentElement) {
            errorDiv.remove();
        }
    }, 5000);
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
    // filterStatus.value = '';
    searchClear.classList.add('hidden');
    searchInfo.classList.add('hidden');
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

const handleKeydown = (e) => {
    if (e.key === 'Escape' && searchInput.value.length > 0) {
        handleClearSearch();
    }
    
    if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
        e.preventDefault();
        searchInput.focus();
        searchInput.select();
    }
};

// Load data via AJAX
const loadData = async (page = 1) => {
    // Cancel previous request jika masih loading
    if (isLoading && abortController) {
        abortController.abort();
        console.log('Previous request cancelled');
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
    
    // if (filterStatus.value) {
    //     params.append('status', filterStatus.value);
    // }
    
    // Tambahkan parameter untuk identifikasi AJAX request
    params.append('ajax', 'true');
    
    updateURL(params);
    
    try {
        abortController = new AbortController();
        const signal = abortController.signal;
        
        // Timeout untuk request
        const timeoutId = setTimeout(() => {
            if (abortController) {
                abortController.abort();
            }
        }, 10000);
        
        console.log('Fetching:', `${CONFIG.apiEndpoint}?${params.toString()}`);
        
        const response = await fetch(`${CONFIG.apiEndpoint}?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': CONFIG.csrfToken
            },
            signal: signal
        });
        
        clearTimeout(timeoutId);
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        
        const data = await response.json();
        console.log('Response data:', data);
        
        // Update UI
        if (data.table_html) {
            updateTable(data.table_html);
        }
        
        if (data.pagination_html) {
            updatePagination(data.pagination_html);
        }
        
        if (data.stats_html || data.stats) {
            updateStats(data.stats_html || data);
        }
        
        if (data.total !== undefined) {
            updateCounters(data.total, data.filtered_count || 0);
        }
        
    } catch (error) {
        if (error.name === 'AbortError') {
            console.log('Request was aborted');
        } else {
            console.error('Error loading data:', error);
            showError(error.message || 'Terjadi kesalahan saat memuat data. Silakan coba lagi.');
        }
    } finally {
        isLoading = false;
        abortController = null;
        showLoading(false);
    }
};

// Update UI components
const updateTable = (html) => {
    if (!html) {
        tableContainer.innerHTML = `
            <div class="p-8 text-center text-gray-500">
                <i class="fas fa-exclamation-triangle text-3xl mb-4 text-yellow-500"></i>
                <p class="text-lg font-medium">Tidak dapat memuat data</p>
                <p class="mt-2">Silakan refresh halaman atau coba lagi nanti.</p>
            </div>
        `;
        return;
    }
    
    tableContainer.innerHTML = html;
};

const updatePagination = (html) => {
    if (paginationContainer && html) {
        paginationContainer.innerHTML = html;
    }
};

const updateStats = (data) => {
    if (!statsContainer) return;
    
    if (typeof data === 'string') {
        statsContainer.innerHTML = data;
    } else if (typeof data === 'object') {
        const stats = data.stats || data;
        updateStatsCounters(stats);
    }
};

const updateStatsCounters = (stats) => {
    const elements = {
        'stat-total': stats.total || 0,
        'stat-aktif': stats.aktif || 0,
        'stat-nonaktif': stats.nonaktif || 0
    };
    
    Object.entries(elements).forEach(([id, value]) => {
        const element = document.getElementById(id);
        if (element) {
            element.textContent = value;
        }
    });
};

const updateCounters = (total, filtered) => {
    if (totalGuru) {
        totalGuru.textContent = total;
    }
    
    if (filteredCount && filteredNumber) {
        if (filtered > 0 && filtered !== total) {
            filteredCount.classList.remove('hidden');
            filteredNumber.textContent = filtered;
        } else {
            filteredCount.classList.add('hidden');
        }
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
    }
    
    // if (urlParams.has('status')) {
    //     filterStatus.value = urlParams.get('status');
    // }
    
    if (urlParams.has('page')) {
        currentPage = parseInt(urlParams.get('page')) || 1;
    }
};

// Initialize
const initGuruSearch = () => {
    // Cache DOM elements dengan safety check
    try {
        searchInput = document.getElementById('search-input');
        filterJabatan = document.getElementById('filter-jabatan');
        // filterStatus = document.getElementById('filter-status');
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
        
        if (!searchInput) {
            console.error('Search input not found!');
            return;
        }
        
        // Setup event listeners
        const debouncedSearch = debounce(handleSearchInput, CONFIG.debounceDelay);
        searchInput.addEventListener('input', debouncedSearch);
        
        filterJabatan.addEventListener('change', () => loadData(1));
        // filterStatus.addEventListener('change', () => loadData(1));
        resetButton.addEventListener('click', handleResetFilters);
        searchClear.addEventListener('click', handleClearSearch);
        
        if (clearSearchInfo) {
            clearSearchInfo.addEventListener('click', handleClearSearchInfo);
        }
        
        document.addEventListener('click', handlePaginationClick);
        document.addEventListener('keydown', handleKeydown);
        
        // Load initial state
        loadStateFromURL();
        
        // Handle browser back/forward
        window.addEventListener('popstate', () => {
            loadStateFromURL();
            loadData(currentPage);
        });
        
        console.log('Guru Search initialized successfully');
        
    } catch (error) {
        console.error('Failed to initialize Guru Search:', error);
    }
};

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', initGuruSearch);

// Export for module bundlers
export default initGuruSearch;