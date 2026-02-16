// resources/js/components/ppdb-detail.js

// PPDB status modal
function showStatusModal() {
    const modal = document.getElementById('statusModal');
    if (modal) {
        modal.classList.remove('hidden');
    }
}

// Close status modal
function closeStatusModal() {
    const modal = document.getElementById('statusModal');
    if (modal) {
        modal.classList.add('hidden');
    }
}

// Initialize pada saat DOM siap
document.addEventListener('DOMContentLoaded', function() {
    // Event listener untuk modal close dengan ESC
    document.addEventListener('keydown', function(e) {
        const modal = document.getElementById('statusModal');
        if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
            closeStatusModal();
        }
    });
    
    // Event listener untuk klik di luar modal
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('statusModal');
        if (modal && e.target === modal) {
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
            const message = form.querySelector('button[type="submit"]').textContent.includes('Konversi') 
                ? 'Konversi data PPDB ini ke data siswa?'
                : 'Hapus data PPDB ini?';
                
            if (confirm(message)) {
                form.submit();
            }
        };
    });
});

// Export functions untuk digunakan global
window.showStatusModal = showStatusModal;
window.closeStatusModal = closeStatusModal;