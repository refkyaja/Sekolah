// resources/js/pages/ppdb-admin.js
// JavaScript untuk halaman admin PPDB

class PPDBAdmin {
    constructor() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        this.baseUrl = window.location.origin;
        this.init();
    }

    init() {
        this.bindEvents();
        this.initModals();
        this.setupGlobalFunctions();
        console.log('PPDB Admin initialized');
    }

    bindEvents() {
        // Export button
        const exportBtn = document.getElementById('exportBtn');
        if (exportBtn) {
            exportBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.openExportModal();
            });
        }

        // Quick status update buttons
        document.querySelectorAll('.quick-status-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const ppdbId = btn.dataset.id;
                const currentStatus = btn.dataset.status;
                this.openStatusModal(ppdbId, currentStatus);
            });
        });

        // Quick payment update buttons
        document.querySelectorAll('.quick-payment-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const ppdbId = btn.dataset.id;
                const currentPayment = btn.dataset.payment;
                this.openPaymentModal(ppdbId, currentPayment);
            });
        });

        // Filter select changes
        document.querySelectorAll('.filter-select').forEach(select => {
            select.addEventListener('change', () => {
                this.submitFilterForm();
            });
        });

        // Per page select
        const perPageSelect = document.getElementById('perPageSelect');
        if (perPageSelect) {
            perPageSelect.addEventListener('change', () => {
                this.changePerPage(perPageSelect.value);
            });
        }

        // Search form submit
        const searchForm = document.getElementById('searchForm');
        if (searchForm) {
            searchForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.submitFilterForm();
            });
        }

        // Form submissions
        const statusForm = document.getElementById('statusForm');
        if (statusForm) {
            statusForm.addEventListener('submit', (e) => this.handleFormSubmit(e, statusForm));
        }

        const paymentForm = document.getElementById('paymentForm');
        if (paymentForm) {
            paymentForm.addEventListener('submit', (e) => this.handleFormSubmit(e, paymentForm));
        }
    }

    initModals() {
        // Setup modal close buttons
        document.querySelectorAll('[data-modal-close]').forEach(btn => {
            btn.addEventListener('click', () => {
                const modalId = btn.dataset.modalClose;
                this.closeModal(modalId);
            });
        });

        // Close modal on outside click
        document.querySelectorAll('.ppdb-modal').forEach(modal => {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    this.closeModal(modal.id);
                }
            });
        });

        // ESC key to close modals
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeAllModals();
            }
        });
    }

    setupGlobalFunctions() {
        // Setup global functions untuk dipanggil dari inline onclick
        window.konversiKeSiswa = (ppdbId) => this.konversiKeSiswa(ppdbId);
    }

    getCurrentFilters() {
        const filters = {};
        
        // Get select filters
        document.querySelectorAll('.filter-select').forEach(select => {
            if (select.value) {
                filters[select.name] = select.value;
            }
        });
        
        // Get search input
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput && searchInput.value) {
            filters.search = searchInput.value;
        }
        
        // Get per page
        const perPageSelect = document.getElementById('perPageSelect');
        if (perPageSelect && perPageSelect.value) {
            filters.per_page = perPageSelect.value;
        }
        
        return filters;
    }

    submitFilterForm() {
        const filters = this.getCurrentFilters();
        const url = new URL(window.location.href);
        
        // Clear existing params
        url.search = '';
        
        // Add filters as params
        Object.entries(filters).forEach(([key, value]) => {
            url.searchParams.set(key, value);
        });
        
        // Show loading state
        this.showLoading();
        
        // Submit via AJAX
        fetch(url.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
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
                this.updateTable(data.table_html);
                this.updatePagination(data.pagination_html);
                this.updateStats(data.statistik);
                this.showNotification('Filter diterapkan', 'success');
            } else {
                this.showNotification('Gagal memfilter data', 'error');
            }
        })
        .catch(error => {
            console.error('Filter error:', error);
            this.showNotification('Terjadi kesalahan saat memfilter', 'error');
            // Fallback to page reload
            window.location.href = url.toString();
        })
        .finally(() => {
            this.hideLoading();
        });
    }

    updateTable(tableHtml) {
        const tableContainer = document.getElementById('tableContainer');
        if (tableContainer) {
            tableContainer.innerHTML = tableHtml;
            this.bindEvents(); // Re-bind events for new elements
        }
    }

    updatePagination(paginationHtml) {
        const paginationContainer = document.getElementById('paginationContainer');
        if (paginationContainer) {
            paginationContainer.innerHTML = paginationHtml;
        }
    }

    updateStats(statistik) {
        if (!statistik) return;
        
        // Update statistik cards
        const stats = {
            'total': document.querySelector('.border-blue-500 .text-3xl'),
            'diterima': document.querySelector('.border-green-500 .text-3xl'),
            'diproses': document.querySelector('.border-yellow-500 .text-3xl'),
            'ditolak': document.querySelector('.border-red-500 .text-3xl'),
        };
        
        if (stats.total && statistik.total !== undefined) {
            this.animateCounter(stats.total, statistik.total);
        }
        
        if (stats.diterima && statistik.diterima !== undefined) {
            this.animateCounter(stats.diterima, statistik.diterima);
        }
        
        if (stats.diproses && statistik.diproses !== undefined) {
            this.animateCounter(stats.diproses, statistik.diproses);
        }
        
        if (stats.ditolak && statistik.ditolak !== undefined) {
            this.animateCounter(stats.ditolak, statistik.ditolak);
        }
    }

    animateCounter(element, targetValue, duration = 500) {
        const startValue = parseInt(element.textContent) || 0;
        const increment = targetValue > startValue ? 1 : -1;
        const steps = Math.abs(targetValue - startValue);
        const stepDuration = duration / steps;
        
        let currentStep = 0;
        
        const updateCounter = () => {
            if (currentStep >= steps) {
                element.textContent = targetValue;
                return;
            }
            
            currentStep++;
            element.textContent = startValue + (increment * currentStep);
            setTimeout(updateCounter, stepDuration);
        };
        
        updateCounter();
    }

    openExportModal() {
        const filters = this.getCurrentFilters();
        this.updateExportForm(filters);
        this.showModal('exportModal');
    }

    openStatusModal(ppdbId, currentStatus) {
        const ppdbIdInput = document.getElementById('ppdbId');
        const statusSelect = document.querySelector('#statusForm select[name="status"]');
        const statusForm = document.getElementById('statusForm');
        
        if (ppdbIdInput && statusSelect && statusForm) {
            ppdbIdInput.value = ppdbId;
            statusSelect.value = currentStatus;
            statusForm.action = `${this.baseUrl}/admin/ppdb/${ppdbId}/status`;
            this.showModal('statusModal');
        }
    }

    openPaymentModal(ppdbId, currentPayment) {
        const paymentPpdbId = document.getElementById('paymentPpdbId');
        const paymentSelect = document.querySelector('#paymentForm select[name="status_pembayaran"]');
        const paymentForm = document.getElementById('paymentForm');
        
        if (paymentPpdbId && paymentSelect && paymentForm) {
            paymentPpdbId.value = ppdbId;
            paymentSelect.value = currentPayment;
            paymentForm.action = `${this.baseUrl}/admin/ppdb/${ppdbId}/pembayaran`;
            this.showModal('paymentModal');
        }
    }

    updateExportForm(filters) {
        const form = document.querySelector('#exportModal form');
        if (!form) return;
        
        // Remove old filter inputs
        form.querySelectorAll('input[name]:not([name="format"])').forEach(input => {
            if (input.name !== 'format') {
                input.remove();
            }
        });
        
        // Add current filters as hidden inputs
        Object.entries(filters).forEach(([key, value]) => {
            if (key !== 'per_page') { // Exclude per_page from export
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = value;
                form.appendChild(input);
            }
        });
    }

    showModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }

    closeAllModals() {
        document.querySelectorAll('.ppdb-modal').forEach(modal => {
            modal.classList.add('hidden');
        });
        document.body.style.overflow = '';
    }

    changePerPage(value) {
        const url = new URL(window.location.href);
        url.searchParams.set('per_page', value);
        window.location.href = url.toString();
    }

    showLoading() {
        // Create loading overlay
        let loadingOverlay = document.getElementById('ppdbLoadingOverlay');
        
        if (!loadingOverlay) {
            loadingOverlay = document.createElement('div');
            loadingOverlay.id = 'ppdbLoadingOverlay';
            loadingOverlay.className = 'fixed inset-0 bg-white/70 flex items-center justify-center z-50';
            loadingOverlay.innerHTML = `
                <div class="text-center">
                    <div class="ppdb-spinner mx-auto mb-4"></div>
                    <p class="text-gray-600">Memuat data...</p>
                </div>
            `;
            document.body.appendChild(loadingOverlay);
        }
    }

    hideLoading() {
        const loadingOverlay = document.getElementById('ppdbLoadingOverlay');
        if (loadingOverlay) {
            loadingOverlay.remove();
        }
    }

    async konversiKeSiswa(ppdbId) {
        if (!confirm('Konversi pendaftaran ini menjadi data siswa? Setelah dikonversi, data akan masuk ke master data siswa.')) {
            return;
        }

        try {
            this.showLoading();
            
            const response = await fetch(`${this.baseUrl}/admin/ppdb/${ppdbId}/konversi`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success) {
                this.showNotification('Berhasil dikonversi menjadi data siswa!', 'success');
                // Reload after 2 seconds
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                this.showNotification('Gagal mengkonversi: ' + (data.message || 'Unknown error'), 'error');
            }
        } catch (error) {
            console.error('Konversi error:', error);
            this.showNotification('Terjadi kesalahan saat mengkonversi!', 'error');
        } finally {
            this.hideLoading();
        }
    }

    async handleFormSubmit(e, form) {
        e.preventDefault();
        
        try {
            this.showLoading();
            
            const formData = new FormData(form);
            const url = form.action;
            const method = form.method;
            
            const response = await fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                this.showNotification(data.message || 'Berhasil diperbarui!', 'success');
                this.closeAllModals();
                // Refresh data
                this.submitFilterForm();
            } else {
                this.showNotification(data.message || 'Gagal memperbarui!', 'error');
            }
        } catch (error) {
            console.error('Form submit error:', error);
            this.showNotification('Terjadi kesalahan!', 'error');
        } finally {
            this.hideLoading();
        }
    }

    showNotification(message, type = 'info') {
        // Remove existing notification
        const existingNotification = document.getElementById('ppdbNotification');
        if (existingNotification) {
            existingNotification.remove();
        }

        // Create notification
        const notification = document.createElement('div');
        notification.id = 'ppdbNotification';
        notification.className = `ppdb-notification ${type}`;
        notification.textContent = message;

        document.body.appendChild(notification);

        // Show notification
        setTimeout(() => {
            notification.classList.add('show');
        }, 10);

        // Auto hide after 5 seconds
        setTimeout(() => {
            this.hideNotification();
        }, 5000);
    }

    hideNotification() {
        const notification = document.getElementById('ppdbNotification');
        if (notification) {
            notification.classList.remove('show');
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 300);
        }
    }
}

// Initialize when DOM is loaded
if (document.querySelector('[data-page="ppdb-admin"]')) {
    document.addEventListener('DOMContentLoaded', () => {
        window.ppdbAdmin = new PPDBAdmin();
    });
}

// Export for module system
export default PPDBAdmin;