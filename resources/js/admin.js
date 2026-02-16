// resources/js/admin.js

// Admin JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Mobile Menu Toggle
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const sidebar = document.getElementById('sidebar');
    
    if (mobileMenuButton && sidebar) {
        mobileMenuButton.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            if (window.innerWidth < 768 && 
                !sidebar.contains(event.target) && 
                !mobileMenuButton.contains(event.target)) {
                sidebar.classList.remove('active');
            }
        });
    }
    
    // Confirm Delete Dialogs
    const deleteForms = document.querySelectorAll('form[data-confirm-delete]');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                e.preventDefault();
            }
        });
    });
    
    // Image Preview for File Inputs
    const imageInputs = document.querySelectorAll('input[type="file"][data-preview]');
    imageInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const previewId = this.dataset.preview;
            const previewElement = document.getElementById(previewId);
            
            if (previewElement && this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    if (previewElement.tagName === 'IMG') {
                        previewElement.src = e.target.result;
                    } else {
                        previewElement.style.backgroundImage = `url(${e.target.result})`;
                    }
                    previewElement.classList.remove('hidden');
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
    
    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert-success, .alert-error');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.parentNode.removeChild(alert);
                }
            }, 500);
        }, 5000);
    });
    
    // Form Validation Feedback
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        const requiredInputs = form.querySelectorAll('[required]');
        
        requiredInputs.forEach(input => {
            input.addEventListener('invalid', function(e) {
                e.preventDefault();
                this.classList.add('border-red-500');
                
                // Show error message
                let errorElement = this.nextElementSibling;
                if (!errorElement || !errorElement.classList.contains('error-message')) {
                    errorElement = document.createElement('p');
                    errorElement.className = 'error-message text-red-500 text-sm mt-1';
                    this.parentNode.appendChild(errorElement);
                }
                
                errorElement.textContent = this.validationMessage;
            });
            
            input.addEventListener('input', function() {
                this.classList.remove('border-red-500');
                const errorElement = this.nextElementSibling;
                if (errorElement && errorElement.classList.contains('error-message')) {
                    errorElement.remove();
                }
            });
        });
    });
});