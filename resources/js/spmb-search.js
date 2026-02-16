/**
 * Live Search untuk Data SPMB dengan AJAX
 * File: resources/js/spmb-search.js
 */

// Konfigurasi
const CONFIG_SP = {
    debounceDelay: 500,
    minSearchLength: 1,
    apiEndpoint: "/admin/spmb",
    csrfToken:
        document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute("content") || "",
};

let currentPage = 1;
let isLoading = false;
let abortController = null;
let debounceTimer = null;

let searchInput, filterJalur, filterStatus, filterTahun, resetButton;
let searchClear, searchInfo, searchTerm, clearSearchInfo;
let tableContainer, paginationContainer, statsContainer;
let loadingOverlay, searchLoading;
let totalSpmb, filteredCount, filteredNumber;

const debounce = (func, wait) => {
    return (...args) => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            func.apply(this, args);
        }, wait);
    };
};

const showLoading = (show) => {
    if (loadingOverlay) {
        if (show) loadingOverlay.classList.remove("hidden");
        else loadingOverlay.classList.add("hidden");
    }
    if (searchLoading) searchLoading.classList.toggle("hidden", !show);
};

const showError = (message) => {
    const existingError = document.getElementById("ajax-error");
    if (existingError) existingError.remove();
    const errorDiv = document.createElement("div");
    errorDiv.id = "ajax-error";
    errorDiv.className =
        "fixed top-4 right-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg shadow-lg z-50 max-w-md";
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
        if (errorDiv.parentElement) errorDiv.remove();
    }, 5000);
};

const updateSearchInfo = (value) => {
    if (!searchInfo || !searchTerm) return;
    if (value.length > 0) {
        searchTerm.textContent = `"${value}"`;
        searchInfo.classList.remove("hidden");
    } else {
        searchInfo.classList.add("hidden");
    }
};

const updateURL = (params) => {
    const newUrl = `${window.location.pathname}?${params.toString()}`;
    window.history.replaceState({}, "", newUrl);
};

const handleSearchInput = () => {
    const val = searchInput.value.trim();
    searchClear.classList.toggle("hidden", val.length === 0);
    updateSearchInfo(val);
    loadData(1);
};

const handleResetFilters = () => {
    searchInput.value = "";
    if (filterJalur) filterJalur.value = "";
    if (filterStatus) filterStatus.value = "";
    if (filterTahun) filterTahun.value = "";
    searchClear.classList.add("hidden");
    searchInfo.classList.add("hidden");
    loadData(1);
};

const handleClearSearch = () => {
    searchInput.value = "";
    searchClear.classList.add("hidden");
    searchInfo.classList.add("hidden");
    searchInput.focus();
    loadData(1);
};

const handlePaginationClick = (e) => {
    if (e.target.matches(".pagination a, .pagination a *")) {
        e.preventDefault();
        const link = e.target.closest("a");
        if (link && link.href && !link.classList.contains("disabled")) {
            const url = new URL(link.href);
            const page = url.searchParams.get("page") || 1;
            loadData(parseInt(page));
        }
    }
};

const handleKeydown = (e) => {
    if (e.key === "Escape" && searchInput.value.length > 0) handleClearSearch();
    if ((e.ctrlKey || e.metaKey) && e.key === "f") {
        e.preventDefault();
        searchInput.focus();
        searchInput.select();
    }
};

const loadData = async (page = 1) => {
    if (isLoading && abortController) {
        abortController.abort();
    }
    currentPage = page;
    isLoading = true;
    showLoading(true);

    const params = new URLSearchParams();
    params.append("page", page);
    const searchValue = searchInput.value.trim();
    if (searchValue.length > 0) params.append("search", searchValue);
    if (filterJalur && filterJalur.value)
        params.append("jalur", filterJalur.value);
    if (filterStatus && filterStatus.value)
        params.append("status", filterStatus.value);
    if (filterTahun && filterTahun.value)
        params.append("tahun_ajaran", filterTahun.value);
    params.append("ajax", "true");
    updateURL(params);

    try {
        abortController = new AbortController();
        const signal = abortController.signal;
        const timeoutId = setTimeout(() => {
            if (abortController) abortController.abort();
        }, 10000);
        const response = await fetch(
            `${CONFIG_SP.apiEndpoint}?${params.toString()}`,
            {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    Accept: "application/json",
                    "X-CSRF-TOKEN": CONFIG_SP.csrfToken,
                },
                signal: signal,
            },
        );
        clearTimeout(timeoutId);
        if (!response.ok)
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        const data = await response.json();
        if (data.table_html) updateTable(data.table_html);
        if (data.pagination_html) updatePagination(data.pagination_html);
        if (data.stats_html || data.statistik)
            updateStats(data.stats_html || data.statistik);
        if (data.total !== undefined)
            updateCounters(data.total, data.filtered_count || 0);
    } catch (error) {
        if (error.name === "AbortError") {
            console.log("Request aborted");
        } else {
            console.error("Error:", error);
            showError(error.message || "Terjadi kesalahan saat memuat data.");
        }
    } finally {
        isLoading = false;
        abortController = null;
        showLoading(false);
    }
};

const updateTable = (html) => {
    if (!html) {
        tableContainer.innerHTML = `<div class="p-8 text-center text-gray-500"><i class="fas fa-exclamation-triangle text-3xl mb-4 text-yellow-500"></i><p class="text-lg font-medium">Tidak dapat memuat data</p><p class="mt-2">Silakan refresh halaman atau coba lagi nanti.</p></div>`;
        return;
    }
    tableContainer.innerHTML = html;
};

const updatePagination = (html) => {
    if (paginationContainer && html) paginationContainer.innerHTML = html;
};

const updateStats = (data) => {
    if (!statsContainer) return;
    if (typeof data === "string") statsContainer.innerHTML = data;
    else if (typeof data === "object") {
        // If object with keys, re-render minimal stats
        const stat = data.stats || data;
        statsContainer.innerHTML = `
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-4 rounded-lg shadow"><div class="text-sm text-gray-500">Total</div><div class="text-2xl font-bold">${stat.total || 0}</div></div>
                <div class="bg-white p-4 rounded-lg shadow"><div class="text-sm text-gray-500">Diterima</div><div class="text-2xl font-bold text-green-600">${stat.diterima || 0}</div></div>
                <div class="bg-white p-4 rounded-lg shadow"><div class="text-sm text-gray-500">Diproses</div><div class="text-2xl font-bold text-yellow-600">${stat.diproses || 0}</div></div>
                <div class="bg-white p-4 rounded-lg shadow"><div class="text-sm text-gray-500">Ditolak</div><div class="text-2xl font-bold text-red-600">${stat.ditolak || 0}</div></div>
            </div>
        `;
    }
};

const updateCounters = (total, filtered) => {
    if (totalSpmb) totalSpmb.textContent = total;
    if (filteredCount && filteredNumber) {
        if (filtered > 0 && filtered !== total) {
            filteredCount.classList.remove("hidden");
            filteredNumber.textContent = filtered;
        } else {
            filteredCount.classList.add("hidden");
        }
    }
};

const loadStateFromURL = () => {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has("search")) {
        const v = urlParams.get("search");
        searchInput.value = v;
        if (v.length > 0) {
            searchClear.classList.remove("hidden");
            updateSearchInfo(v);
        }
    }
    if (urlParams.has("jalur") && filterJalur)
        filterJalur.value = urlParams.get("jalur");
    if (urlParams.has("status") && filterStatus)
        filterStatus.value = urlParams.get("status");
    if (urlParams.has("tahun_ajaran") && filterTahun)
        filterTahun.value = urlParams.get("tahun_ajaran");
    if (urlParams.has("page"))
        currentPage = parseInt(urlParams.get("page")) || 1;
};

const initSpmbSearch = () => {
    try {
        searchInput = document.getElementById("search-input");
        filterJalur = document.getElementById("filter-jalur");
        filterStatus = document.getElementById("filter-status");
        filterTahun = document.getElementById("filter-tahun");
        resetButton = document.getElementById("reset-filters");
        searchClear = document.getElementById("search-clear");
        searchInfo = document.getElementById("search-info");
        searchTerm = document.getElementById("search-term");
        clearSearchInfo = document.getElementById("clear-search-info");
        tableContainer = document.getElementById("spmb-table-container");
        paginationContainer = document.getElementById("pagination-container");
        statsContainer = document.getElementById("stats-container");
        loadingOverlay = document.getElementById("loading-overlay");
        searchLoading = document.getElementById("search-loading");
        totalSpmb = document.getElementById("total-spmb");
        filteredCount = document.getElementById("filtered-count");
        filteredNumber = document.getElementById("filtered-number");

        if (!searchInput) {
            console.error("Search input not found!");
            return;
        }

        const debounced = debounce(handleSearchInput, CONFIG_SP.debounceDelay);
        searchInput.addEventListener("input", debounced);
        if (filterJalur)
            filterJalur.addEventListener("change", () => loadData(1));
        if (filterStatus)
            filterStatus.addEventListener("change", () => loadData(1));
        if (filterTahun)
            filterTahun.addEventListener("change", () => loadData(1));
        if (resetButton)
            resetButton.addEventListener("click", handleResetFilters);
        if (searchClear)
            searchClear.addEventListener("click", handleClearSearch);
        if (clearSearchInfo)
            clearSearchInfo.addEventListener("click", handleClearSearch);

        document.addEventListener("click", handlePaginationClick);
        document.addEventListener("keydown", handleKeydown);
        loadStateFromURL();

        window.addEventListener("popstate", () => {
            loadStateFromURL();
            loadData(currentPage);
        });
        console.log("SPMB Search initialized");
    } catch (e) {
        console.error("Failed to initialize SPMB search", e);
    }
};

document.addEventListener("DOMContentLoaded", initSpmbSearch);
export default initSpmbSearch;
