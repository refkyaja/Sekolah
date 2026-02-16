// resources/js/components/ppdb-edit.js

// Tab switching functionality
function switchTab(tabName) {
    // Hide all tab panes
    const tabPanes = document.querySelectorAll('.tab-pane');
    tabPanes.forEach(pane => {
        pane.classList.remove('active');
        pane.classList.add('hidden');
    });

    // Remove active class from all tab buttons
    const tabButtons = document.querySelectorAll('.tab-btn');
    tabButtons.forEach(button => {
        button.classList.remove('active');
        button.classList.remove('border-blue-500', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });

    // Show selected tab pane
    const activePane = document.getElementById(tabName);
    if (activePane) {
        activePane.classList.remove('hidden');
        activePane.classList.add('active');
    }

    // Activate selected tab button
    const activeButton = document.querySelector(`.tab-btn[data-tab="${tabName}"]`);
    if (activeButton) {
        activeButton.classList.remove('border-transparent', 'text-gray-500');
        activeButton.classList.add('border-blue-500', 'text-blue-600', 'active');
    }
}

// Date input handling
function setupDateInputs() {
    const dateInputs = document.querySelectorAll('input[type="date"]');
    dateInputs.forEach(input => {
        // Format tanggal untuk tampilan
        if (input.value) {
            const date = new Date(input.value);
            if (!isNaN(date)) {
                // Format bisa disesuaikan jika perlu
            }
        }
    });
}

// File input preview (optional)
function setupFileInputs() {
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                // Bisa ditambahkan preview file jika diperlukan
                console.log('File selected:', fileName);
            }
        });
    });
}

// Form validation
function setupFormValidation() {
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('border-red-500');
                    
                    // Scroll ke field yang error
                    if (isValid === false) {
                        field.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        field.focus();
                    }
                } else {
                    field.classList.remove('border-red-500');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Harap isi semua field yang wajib diisi!');
            }
        });
    }
}

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', function() {
    // Set default active tab
    const defaultTab = document.querySelector('.tab-btn[data-tab="data-siswa"]');
    if (defaultTab) {
        defaultTab.click();
    }
    
    // Setup functionalities
    setupDateInputs();
    setupFileInputs();
    setupFormValidation();
    
    // Set tanggal lahir maksimal hari ini
    const tanggalLahirInput = document.getElementById('tanggal_lahir');
    if (tanggalLahirInput) {
        const today = new Date().toISOString().split('T')[0];
        tanggalLahirInput.max = today;
    }
    
    // Auto format no HP
    const noHpInput = document.getElementById('no_hp_ortu');
    if (noHpInput) {
        noHpInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.startsWith('0')) {
                value = value.substring(1);
            }
            if (value.length > 0) {
                value = '0' + value;
            }
            e.target.value = value;
        });
    }
});

// Export functions for global use
window.switchTab = switchTab;