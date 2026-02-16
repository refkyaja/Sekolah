@extends('layouts.admin')

@section('title', 'Tambah Akun Baru')
@section('breadcrumb', 'Tambah Akun')

@push('styles')
<style>
    .form-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 10px 40px -15px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .form-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }
    
    .form-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        pointer-events: none;
    }
    
    .form-header::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        pointer-events: none;
    }
    
    .form-section {
        padding: 2rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .form-section:last-child {
        border-bottom: none;
    }
    
    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }
    
    .section-title i {
        color: #667eea;
        margin-right: 0.75rem;
        font-size: 1.25rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.5rem;
    }
    
    .form-label i {
        color: #9ca3af;
        margin-right: 0.5rem;
        font-size: 0.875rem;
    }
    
    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        transition: all 0.2s ease;
        font-size: 0.95rem;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .form-control:hover {
        border-color: #9ca3af;
    }
    
    .form-error {
        color: #ef4444;
        font-size: 0.75rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
    }
    
    .form-error i {
        margin-right: 0.25rem;
        font-size: 0.75rem;
    }
    
    .password-strength {
        height: 4px;
        border-radius: 2px;
        margin-top: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .strength-weak { background: #ef4444; width: 33.33%; }
    .strength-medium { background: #f59e0b; width: 66.66%; }
    .strength-strong { background: #10b981; width: 100%; }
    
    .requirement {
        display: flex;
        align-items: center;
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }
    
    .requirement i {
        margin-right: 0.5rem;
        font-size: 0.625rem;
    }
    
    .requirement.met {
        color: #10b981;
    }
    
    .btn-submit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.875rem 2rem;
        border-radius: 0.75rem;
        font-weight: 600;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(102, 126, 234, 0.3);
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(102, 126, 234, 0.4);
    }
    
    .btn-submit:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }
    
    .btn-cancel {
        background: white;
        color: #374151;
        padding: 0.875rem 2rem;
        border-radius: 0.75rem;
        font-weight: 500;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        border: 1px solid #e5e7eb;
    }
    
    .btn-cancel:hover {
        background: #f9fafb;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    .role-card {
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .role-card:hover {
        border-color: #667eea;
        background: #f5f3ff;
    }
    
    .role-card.selected {
        border-color: #667eea;
        background: #f5f3ff;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .role-card input[type="radio"] {
        display: none;
    }
    
    .role-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.5rem;
    }
    
    .role-icon.admin { background: #3b82f620; color: #3b82f6; }
    .role-icon.kepala_sekolah { background: #f59e0b20; color: #f59e0b; }
    .role-icon.operator { background: #10b98120; color: #10b981; }
    .role-icon.guru { background: #6b728020; color: #6b7280; }
    
    /* Grid layout */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 1.5rem;
    }
    
    @media (min-width: 640px) {
        .form-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (min-width: 1024px) {
        .form-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    
    .full-width {
        grid-column: 1 / -1;
    }
    
    /* Alert */
    .alert {
        padding: 1rem;
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
    
    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
    
    .alert i {
        font-size: 1.25rem;
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Tambah Akun Baru</h2>
            <p class="text-sm text-gray-600">Buat akun baru untuk pengguna</p>
        </div>
        <a href="{{ route('admin.accounts.index') }}" 
           class="bg-white text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors duration-200 flex items-center border border-gray-300">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
    <div class="alert alert-error mb-6">
        <i class="fas fa-exclamation-circle"></i>
        <div>
            <strong>Terdapat kesalahan:</strong>
            <ul class="list-disc list-inside mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <!-- Form Card -->
    <div class="form-card">
        <div class="form-header">
            <div class="relative z-10">
                <h3 class="text-2xl font-bold text-white mb-2">Informasi Akun Baru</h3>
                <p class="text-white text-opacity-90">Isi data dengan lengkap dan benar</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.accounts.store') }}" id="createAccountForm">
            @csrf

            <!-- Informasi Akun -->
            <div class="form-section">
                <h4 class="section-title">
                    <i class="fas fa-lock"></i>
                    Informasi Akun
                </h4>

                <div class="form-grid">
                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i>
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               class="form-control @error('email') border-red-500 @enderror"
                               placeholder="contoh@email.com"
                               required>
                        @error('email')
                            <p class="form-error">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-key"></i>
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="form-control @error('password') border-red-500 @enderror"
                               placeholder="Minimal 8 karakter"
                               required
                               onkeyup="checkPasswordStrength(this.value)">
                        <div class="password-strength" id="passwordStrength"></div>
                        @error('password')
                            <p class="form-error">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                        
                        <!-- Password Requirements -->
                        <div class="mt-2">
                            <div class="requirement" id="reqLength">
                                <i class="fas fa-circle"></i>
                                Minimal 8 karakter
                            </div>
                            <div class="requirement" id="reqUppercase">
                                <i class="fas fa-circle"></i>
                                Huruf besar (A-Z)
                            </div>
                            <div class="requirement" id="reqLowercase">
                                <i class="fas fa-circle"></i>
                                Huruf kecil (a-z)
                            </div>
                            <div class="requirement" id="reqNumber">
                                <i class="fas fa-circle"></i>
                                Angka (0-9)
                            </div>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">
                            <i class="fas fa-check-circle"></i>
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               class="form-control"
                               placeholder="Ulangi password"
                               required
                               onkeyup="checkPasswordMatch()">
                        <div class="text-xs mt-1" id="passwordMatchMessage"></div>
                    </div>
                </div>
            </div>

            <!-- Informasi Pribadi -->
            <div class="form-section">
                <h4 class="section-title">
                    <i class="fas fa-user-circle"></i>
                    Informasi Pribadi
                </h4>

                <div class="form-grid">
                    <!-- Nama Lengkap -->
                    <div class="form-group full-width">
                        <label for="name" class="form-label">
                            <i class="fas fa-user"></i>
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               class="form-control @error('name') border-red-500 @enderror"
                               placeholder="Masukkan nama lengkap"
                               required>
                        @error('name')
                            <p class="form-error">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="form-group">
                        <label for="jenis_kelamin" class="form-label">
                            <i class="fas fa-venus-mars"></i>
                            Jenis Kelamin
                        </label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <!-- Tempat Lahir -->
                    <div class="form-group">
                        <label for="tempat_lahir" class="form-label">
                            <i class="fas fa-map-pin"></i>
                            Tempat Lahir
                        </label>
                        <input type="text" 
                               id="tempat_lahir" 
                               name="tempat_lahir" 
                               value="{{ old('tempat_lahir') }}"
                               class="form-control"
                               placeholder="Contoh: Jakarta">
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="form-group">
                        <label for="tanggal_lahir" class="form-label">
                            <i class="fas fa-calendar-alt"></i>
                            Tanggal Lahir
                        </label>
                        <input type="date" 
                               id="tanggal_lahir" 
                               name="tanggal_lahir" 
                               value="{{ old('tanggal_lahir') }}"
                               class="form-control">
                    </div>

                    <!-- No Telepon -->
                    <div class="form-group">
                        <label for="no_telepon" class="form-label">
                            <i class="fas fa-phone"></i>
                            No. Telepon
                        </label>
                        <input type="text" 
                               id="no_telepon" 
                               name="no_telepon" 
                               value="{{ old('no_telepon') }}"
                               class="form-control"
                               placeholder="08123456789">
                    </div>

                    <!-- Alamat -->
                    <div class="form-group full-width">
                        <label for="alamat" class="form-label">
                            <i class="fas fa-map-marker-alt"></i>
                            Alamat
                        </label>
                        <textarea name="alamat" 
                                  id="alamat" 
                                  rows="3"
                                  class="form-control"
                                  placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Role & Status -->
            <div class="form-section">
                <h4 class="section-title">
                    <i class="fas fa-tags"></i>
                    Role & Status
                </h4>

                <div class="form-grid">
                    <!-- Role -->
                    <div class="form-group full-width">
                        <label class="form-label">
                            <i class="fas fa-user-tag"></i>
                            Role / Jabatan <span class="text-red-500">*</span>
                        </label>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-2">
                            <!-- Admin -->
                            <label class="role-card {{ old('role') == 'admin' ? 'selected' : '' }}">
                                <input type="radio" name="role" value="admin" {{ old('role') == 'admin' ? 'checked' : '' }} required>
                                <div class="role-icon admin">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                                <div class="font-medium text-gray-900">Admin</div>
                                <div class="text-xs text-gray-500">Akses penuh ke semua fitur</div>
                            </label>

                            <!-- Kepala Sekolah -->
                            <label class="role-card {{ old('role') == 'kepala_sekolah' ? 'selected' : '' }}">
                                <input type="radio" name="role" value="kepala_sekolah" {{ old('role') == 'kepala_sekolah' ? 'checked' : '' }}>
                                <div class="role-icon kepala_sekolah">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <div class="font-medium text-gray-900">Kepala Sekolah</div>
                                <div class="text-xs text-gray-500">Akses laporan & monitoring</div>
                            </label>

                            <!-- Operator -->
                            <label class="role-card {{ old('role') == 'operator' ? 'selected' : '' }}">
                                <input type="radio" name="role" value="operator" {{ old('role') == 'operator' ? 'checked' : '' }}>
                                <div class="role-icon operator">
                                    <i class="fas fa-cog"></i>
                                </div>
                                <div class="font-medium text-gray-900">Operator</div>
                                <div class="text-xs text-gray-500">Input data & administrasi</div>
                            </label>

                            <!-- Guru -->
                            <label class="role-card {{ old('role') == 'guru' ? 'selected' : '' }}">
                                <input type="radio" name="role" value="guru" {{ old('role') == 'guru' ? 'checked' : '' }}>
                                <div class="role-icon guru">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                                <div class="font-medium text-gray-900">Guru</div>
                                <div class="text-xs text-gray-500">Absensi & nilai</div>
                            </label>
                        </div>
                        
                        @error('role')
                            <p class="form-error">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Status Aktif (Hidden, default true) -->
                    <input type="hidden" name="is_active" value="1">
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-section bg-gray-50">
                <div class="flex flex-col sm:flex-row gap-3 justify-end">
                    <button type="button" 
                            onclick="resetForm()"
                            class="btn-cancel">
                        <i class="fas fa-undo"></i>
                        Reset
                    </button>
                    <button type="submit" 
                            id="submitBtn"
                            class="btn-submit">
                        <i class="fas fa-save"></i>
                        Simpan Akun
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Password strength checker
function checkPasswordStrength(password) {
    const strengthBar = document.getElementById('passwordStrength');
    
    // Requirements
    const hasLength = password.length >= 8;
    const hasUppercase = /[A-Z]/.test(password);
    const hasLowercase = /[a-z]/.test(password);
    const hasNumber = /[0-9]/.test(password);
    
    // Update requirement indicators
    updateRequirement('reqLength', hasLength);
    updateRequirement('reqUppercase', hasUppercase);
    updateRequirement('reqLowercase', hasLowercase);
    updateRequirement('reqNumber', hasNumber);
    
    // Calculate strength
    let strength = 0;
    if (hasLength) strength++;
    if (hasUppercase) strength++;
    if (hasLowercase) strength++;
    if (hasNumber) strength++;
    
    // Update UI
    strengthBar.className = 'password-strength';
    if (password.length === 0) {
        strengthBar.style.width = '0';
    } else if (strength <= 2) {
        strengthBar.classList.add('strength-weak');
    } else if (strength <= 3) {
        strengthBar.classList.add('strength-medium');
    } else {
        strengthBar.classList.add('strength-strong');
    }
}

function updateRequirement(id, met) {
    const element = document.getElementById(id);
    const icon = element.querySelector('i');
    
    if (met) {
        icon.className = 'fas fa-check-circle text-green-500';
        element.classList.add('met');
    } else {
        icon.className = 'fas fa-circle';
        element.classList.remove('met');
    }
}

// Check password match
function checkPasswordMatch() {
    const password = document.getElementById('password').value;
    const confirm = document.getElementById('password_confirmation').value;
    const messageEl = document.getElementById('passwordMatchMessage');
    
    if (confirm.length === 0) {
        messageEl.innerHTML = '';
        return;
    }
    
    if (password === confirm) {
        messageEl.innerHTML = '<span class="text-green-600"><i class="fas fa-check-circle mr-1"></i>Password cocok</span>';
    } else {
        messageEl.innerHTML = '<span class="text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>Password tidak cocok</span>';
    }
}

// Reset form
function resetForm() {
    if (confirm('Apakah Anda yakin ingin mereset form?')) {
        document.getElementById('createAccountForm').reset();
        // Reset password strength
        document.getElementById('passwordStrength').className = 'password-strength';
        // Reset requirements
        ['reqLength', 'reqUppercase', 'reqLowercase', 'reqNumber'].forEach(id => {
            const element = document.getElementById(id);
            const icon = element.querySelector('i');
            icon.className = 'fas fa-circle';
            element.classList.remove('met');
        });
        // Reset role cards
        document.querySelectorAll('.role-card').forEach(card => {
            card.classList.remove('selected');
        });
    }
}

// Role card selection
document.querySelectorAll('.role-card').forEach(card => {
    card.addEventListener('click', function() {
        document.querySelectorAll('.role-card').forEach(c => c.classList.remove('selected'));
        this.classList.add('selected');
        this.querySelector('input[type="radio"]').checked = true;
    });
});

// Form validation before submit
document.getElementById('createAccountForm').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirm = document.getElementById('password_confirmation').value;
    
    if (password !== confirm) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Password tidak cocok',
            text: 'Password dan konfirmasi password harus sama'
        });
        return;
    }
    
    if (password.length < 8) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Password terlalu pendek',
            text: 'Password minimal 8 karakter'
        });
        return;
    }
    
    // Show loading
    window.showLoading();
});
</script>
@endsection