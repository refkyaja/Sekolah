// resources/js/components/siswa-detail.js

// Update status siswa modal
function updateStatus() {
    const statusSelect = document.querySelector('#statusForm select[name="status_siswa"]');
    const nonAktifFields = document.getElementById('nonAktifFields');
    
    // Tampilkan field tambahan jika status bukan aktif
    statusSelect.addEventListener('change', function() {
        if (this.value !== 'aktif') {
            nonAktifFields.classList.remove('hidden');
        } else {
            nonAktifFields.classList.add('hidden');
        }
    });
    
    // Set tanggal default untuk hari ini
    const tanggalInput = document.querySelector('input[name="tanggal_status"]');
    if (tanggalInput) {
        const today = new Date().toISOString().split('T')[0];
        tanggalInput.value = today;
    }
    
    document.getElementById('statusModal').classList.remove('hidden');
}

// Close status modal
function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
}

// Initialize pada saat DOM siap
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.querySelector('#statusForm select[name="status_siswa"]');
    const nonAktifFields = document.getElementById('nonAktifFields');
    
    if (statusSelect && statusSelect.value !== 'aktif') {
        nonAktifFields.classList.remove('hidden');
    }
    
    // Event listener untuk modal close dengan ESC
    document.addEventListener('keydown', function(e) {
        const modal = document.getElementById('statusModal');
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeStatusModal();
        }
    });
    
    // Event listener untuk klik di luar modal
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('statusModal');
        if (e.target === modal) {
            closeStatusModal();
        }
    });
    
    // Confirm delete dengan sweetalert2 atau alert biasa
    const deleteForms = document.querySelectorAll('form[onsubmit*="confirm"]');
    deleteForms.forEach(form => {
        const originalOnsubmit = form.onsubmit;
        form.onsubmit = function(e) {
            e.preventDefault();
            
            // Anda bisa menggunakan sweetalert2 jika sudah diinstall
            // Atau menggunakan confirm bawaan
            if (confirm('Apakah Anda yakin ingin menghapus data siswa ini?')) {
                form.submit();
            }
        };
    });
});

// Export functions untuk digunakan global
window.updateStatus = updateStatus;
window.closeStatusModal = closeStatusModal;