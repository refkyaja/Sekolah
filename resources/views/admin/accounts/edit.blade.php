@extends('layouts.admin')

@section('title', 'Edit Akun - ' . $account->name)
@section('breadcrumb', 'Edit Akun')

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
    
    .form-control:disabled {
        background: #f3f4f6;
        cursor: not-allowed;
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
    
    /* Status toggle */
    .status-toggle {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.5rem 0;
    }
    
    .toggle-switch {
        position: relative;
        width: 60px;
        height: 30px;
        background-color: #e5e7eb;
        border-radius: 30px;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .toggle-switch.active {
        background-color: #10b981;
    }
    
    .toggle-switch::before {
        content: '';
        position: absolute;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background-color: white;
        top: 2px;
        left: 2px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    
    .toggle-switch.active::before {
        left: 32px;
    }
    
    .toggle-label {
        font-size: 0.875rem;
        color: #374151;
    }
    
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
    
    /* Info panel */
    .info-panel {
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        border-radius: 0.75rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .info-panel i {
        color: #0284c7;
        font-size: 1.25rem;
    }
    
    .info-panel p {
        color: #0369a1;
        font-size: 0.875rem;
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Akun</h2>
            <p class="text-sm text-gray-600">Edit informasi akun pengguna</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.accounts.show', $account) }}" 
               class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors duration-200 flex items-center">
                <i class="fas fa-eye mr-2"></i>
                Lihat Detail
            </a>
            <a href="{{ route('admin.accounts.index') }}" 
               class="bg-white text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors duration-200 flex items-center border border-gray-300">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Info Panel untuk akun sendiri -->
    @if($account->id === auth()->id())
    <div class="info-panel">
        <i class="fas fa-info-circle"></i>
        <p>Anda sedang mengedit akun Anda sendiri. Beberapa perubahan mungkin mempengaruhi akses Anda ke sistem.</p>
    </div>
    @endif

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
                <h3 class="text-2xl font-bold text-white mb-2">Edit Akun: {{ $account->name }}</h3>
                <p class="text-white text-opacity-90">Ubah informasi akun sesuai kebutuhan</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.accounts.update', $account) }}" id="editAccountForm">
            @csrf
            @method('PUT')

            <!-- Informasi Akun -->
            <div class="form-section">
                <h4 class="section-title">
                    <i class="fas fa-lock"></i>
                    Informasi Akun
                </h4>

                <div class="form-grid">
                    <!-- Email (readonly) -->
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i>
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $account->email) }}"
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

                    <!-- Password (kosong, tidak diisi) -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-key"></i>
                            Password
                        </label>
                        <div class="form-control bg-gray-50 text-gray-500 flex items-center justify-between">
                            <span>••••••••</span>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('resetPasswordForm').submit();" 
                               class="text-indigo-600 hover:text-indigo-800 text-sm">
                                Reset Password
                            </a>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah password</p>
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
                               value="{{ old('name', $account->name) }}"
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
                            <option value="Laki-laki" {{ old('jenis_kelamin', $account->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $account->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
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
                               value="{{ old('tempat_lahir', $account->tempat_lahir) }}"
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
                               value="{{ old('tanggal_lahir', $account->tanggal_lahir ? $account->tanggal_lahir->format('Y-m-d') : '') }}"
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
                               value="{{ old('no_telepon', $account->no_telepon) }}"
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
                                  placeholder="Alamat lengkap">{{ old('alamat', $account->alamat) }}</textarea>
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
                            <label class="role-card {{ old('role', $account->role) == 'admin' ? 'selected' : '' }}">
                                <input type="radio" name="role" value="admin" {{ old('role', $account->role) == 'admin' ? 'checked' : '' }} required>
                                <div class="role-icon admin">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                                <div class="font-medium text-gray-900">Admin</div>
                                <div class="text-xs text-gray-500">Akses penuh ke semua fitur</div>
                            </label>

                            <!-- Kepala Sekolah -->
                            <label class="role-card {{ old('role', $account->role) == 'kepala_sekolah' ? 'selected' : '' }}">
                                <input type="radio" name="role" value="kepala_sekolah" {{ old('role', $account->role) == 'kepala_sekolah' ? 'checked' : '' }}>
                                <div class="role-icon kepala_sekolah">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <div class="font-medium text-gray-900">Kepala Sekolah</div>
                                <div class="text-xs text-gray-500">Akses laporan & monitoring</div>
                            </label>

                            <!-- Operator -->
                            <label class="role-card {{ old('role', $account->role) == 'operator' ? 'selected' : '' }}">
                                <input type="radio" name="role" value="operator" {{ old('role', $account->role) == 'operator' ? 'checked' : '' }}>
                                <div class="role-icon operator">
                                    <i class="fas fa-cog"></i>
                                </div>
                                <div class="font-medium text-gray-900">Operator</div>
                                <div class="text-xs text-gray-500">Input data & administrasi</div>
                            </label>

                            <!-- Guru -->
                            <label class="role-card {{ old('role', $account->role) == 'guru' ? 'selected' : '' }}">
                                <input type="radio" name="role" value="guru" {{ old('role', $account->role) == 'guru' ? 'checked' : '' }}>
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

                    <!-- Status Aktif -->
                    <div class="form-group full-width">
                        <label class="form-label">
                            <i class="fas fa-toggle-on"></i>
                            Status Akun
                        </label>
                        
                        <div class="status-toggle">
                            <div class="toggle-switch {{ old('is_active', $account->is_active) ? 'active' : '' }}" 
                                 onclick="toggleStatus(this)">
                            </div>
                            <input type="hidden" name="is_active" id="is_active" value="{{ old('is_active', $account->is_active) ? '1' : '0' }}">
                            <span class="toggle-label" id="statusLabel">
                                {{ old('is_active', $account->is_active) ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                        
                        @if($account->id === auth()->id())
                        <p class="text-xs text-yellow-600 mt-2">
                            <i class="fas fa-exclamation-triangle"></i>
                            Anda tidak dapat menonaktifkan akun sendiri
                        </p>
                        @endif
                    </div>
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
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Hidden Form untuk Reset Password -->
<form id="resetPasswordForm" action="{{ route('admin.accounts.reset-password', $account) }}" method="POST" class="hidden">
    @csrf
    <input type="hidden" name="new_password" value="password123">
    <input type="hidden" name="new_password_confirmation" value="password123">
</form>

<script>
// Toggle Status Switch
function toggleStatus(element) {
    // Cegah jika ini akun sendiri
    @if($account->id === auth()->id())
        Swal.fire({
            icon: 'warning',
            title: 'Tidak Diizinkan',
            text: 'Anda tidak dapat mengubah status akun Anda sendiri.',
            confirmButtonColor: '#3085d6'
        });
        return;
    @endif
    
    const isActive = element.classList.contains('active');
    const hiddenInput = document.getElementById('is_active');
    const statusLabel = document.getElementById('statusLabel');
    
    if (isActive) {
        element.classList.remove('active');
        hiddenInput.value = '0';
        statusLabel.textContent = 'Nonaktif';
    } else {
        element.classList.add('active');
        hiddenInput.value = '1';
        statusLabel.textContent = 'Aktif';
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

// Reset form ke nilai awal
function resetForm() {
    Swal.fire({
        title: 'Konfirmasi Reset',
        text: 'Apakah Anda yakin ingin mereset form ke nilai awal?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, reset!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.reload();
        }
    });
}

// Konfirmasi sebelum submit jika mengubah role sendiri
document.getElementById('editAccountForm').addEventListener('submit', function(e) {
    @if($account->id === auth()->id())
    const originalRole = "{{ $account->role }}";
    const newRole = document.querySelector('input[name="role"]:checked')?.value;
    
    if (originalRole !== newRole) {
        e.preventDefault();
        Swal.fire({
            title: 'Peringatan!',
            text: 'Anda mengubah role akun Anda sendiri. Ini dapat mempengaruhi akses Anda ke sistem. Lanjutkan?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, lanjutkan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.showLoading();
                e.target.submit();
            }
        });
    } else {
        window.showLoading();
    }
    @else
    window.showLoading();
    @endif
});

// Konfirmasi reset password
document.querySelector('a[href="#"]').addEventListener('click', function(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Konfirmasi Reset Password',
        text: 'Password akan direset menjadi "password123". Lanjutkan?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, reset!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('resetPasswordForm').submit();
        }
    });
});
</script>
@endsection