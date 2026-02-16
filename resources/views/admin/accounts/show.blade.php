@extends('layouts.admin')

@section('title', 'Detail Akun - ' . $account->name)
@section('breadcrumb', 'Detail Akun')

@push('styles')
<style>
    /* Profile Header dengan background gradien yang lebih terang */
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 1rem 1rem 0 0;
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }
    
    /* Decorative shapes */
    .profile-header::before {
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
    
    .profile-header::after {
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
    
    /* Profile photo */
    .profile-photo-large {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
        position: relative;
        z-index: 10;
    }
    
    /* Info card */
    .info-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 10px 40px -15px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.3);
    }
    
    /* Section title */
    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #374151;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e5e7eb;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }
    
    .section-title i {
        color: #667eea;
        margin-right: 0.75rem;
        font-size: 1.25rem;
    }
    
    /* Info box */
    .info-box {
        background: #f9fafb;
        border-radius: 0.75rem;
        padding: 1rem 1.25rem;
        transition: all 0.2s ease;
        border: 1px solid #f3f4f6;
    }
    
    .info-box:hover {
        background: #f3f4f6;
        border-color: #e5e7eb;
    }
    
    .info-label {
        font-size: 0.75rem;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
    }
    
    .info-label i {
        color: #9ca3af;
        margin-right: 0.5rem;
        font-size: 0.875rem;
    }
    
    .info-value {
        font-size: 1rem;
        font-weight: 500;
        color: #111827;
        word-break: break-word;
    }
    
    /* Badges */
    .role-badge {
        padding: 0.5rem 1.25rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .role-admin { background: #3b82f6; color: white; }
    .role-kepala_sekolah { background: #f59e0b; color: white; }
    .role-operator { background: #10b981; color: white; }
    .role-guru { background: #6b7280; color: white; }
    
    .status-badge {
        padding: 0.5rem 1.25rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .status-active {
        background: #10b981;
        color: white;
    }
    
    .status-inactive {
        background: #ef4444;
        color: white;
    }
    
    /* Action buttons */
    .action-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        font-weight: 500;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
    }
    
    .action-btn i {
        font-size: 1rem;
    }
    
    .btn-edit {
        background: white;
        color: #4f46e5;
        border: 1px solid #e5e7eb;
    }
    
    .btn-edit:hover {
        background: #f9fafb;
    }
    
    .btn-reset {
        background: #3b82f6;
        color: white;
    }
    
    .btn-reset:hover {
        background: #2563eb;
    }
    
    /* Detail grid */
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 1.5rem;
    }
    
    @media (min-width: 768px) {
        .detail-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    /* Activity item */
    .activity-item {
        background: #f9fafb;
        border-radius: 0.75rem;
        padding: 1rem;
        transition: all 0.2s ease;
        border: 1px solid #f3f4f6;
    }
    
    .activity-item:hover {
        background: #f3f4f6;
        transform: translateX(4px);
    }
    
    /* Back button */
    .back-btn {
        background: white;
        color: #374151;
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        font-weight: 500;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        border: 1px solid #e5e7eb;
    }
    
    .back-btn:hover {
        background: #f9fafb;
        transform: translateX(-4px);
    }
    
    /* Self account indicator */
    .self-indicator {
        background: rgba(255, 255, 255, 0.2);
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 500;
        backdrop-filter: blur(4px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    
    /* Responsive */
    @media (max-width: 640px) {
        .profile-header {
            padding: 1.5rem;
        }
        
        .profile-photo-large {
            width: 100px;
            height: 100px;
        }
        
        .action-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header with Back Button -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Detail Akun</h2>
            <p class="text-sm text-gray-600">Informasi lengkap akun pengguna</p>
        </div>
        <a href="{{ route('admin.accounts.index') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
    </div>

    <!-- Main Info Card -->
    <div class="info-card mb-6">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="flex flex-col md:flex-row items-center gap-6 relative z-10">
                <!-- Profile Photo -->
                <div class="flex-shrink-0">
                    @if($account->foto)
                        <img src="{{ asset('storage/'.$account->foto) }}" 
                             alt="Profile" 
                             class="profile-photo-large">
                    @else
                        <div class="profile-photo-large bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                            <span class="text-4xl font-bold text-white">{{ strtoupper(substr($account->name, 0, 1)) }}</span>
                        </div>
                    @endif
                </div>
                
                <!-- Basic Info -->
                <div class="flex-1 text-center md:text-left">
                    <div class="flex flex-col md:flex-row items-center md:items-start gap-4">
                        <div>
                            <h3 class="text-3xl font-bold text-white mb-2">{{ $account->name }}</h3>
                            <div class="flex flex-wrap items-center justify-center md:justify-start gap-3">
                                <span class="role-badge role-{{ $account->role }}">
                                    <i class="fas fa-tag mr-2"></i>
                                    {{ ucfirst(str_replace('_', ' ', $account->role)) }}
                                </span>
                                <span class="status-badge {{ $account->is_active ? 'status-active' : 'status-inactive' }}">
                                    <i class="fas fa-{{ $account->is_active ? 'check-circle' : 'times-circle' }} mr-2"></i>
                                    {{ $account->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                                @if($account->id === auth()->id())
                                    <span class="self-indicator">
                                        <i class="fas fa-user-shield mr-2"></i>
                                        Akun Anda
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 md:ml-auto">
                            <a href="{{ route('admin.accounts.edit', $account) }}" 
                               class="action-btn btn-edit">
                                <i class="fas fa-edit"></i>
                                Edit Akun
                            </a>
                            <button onclick="resetPassword({{ $account->id }}, '{{ $account->name }}')" 
                                    class="action-btn btn-reset">
                                <i class="fas fa-key"></i>
                                Reset Password
                            </button>
                        </div>
                    </div>
                    
                    <p class="text-white text-opacity-90 mt-4 flex items-center justify-center md:justify-start">
                        <i class="fas fa-envelope mr-3"></i>
                        {{ $account->email }}
                        @if($account->email_verified_at)
                            <i class="fas fa-check-circle text-green-300 ml-2" title="Email terverifikasi {{ $account->email_verified_at->diffForHumans() }}"></i>
                        @endif
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Detail Information -->
        <div class="p-6">
            <div class="detail-grid">
                <!-- Left Column - Personal Info -->
                <div>
                    <h4 class="section-title">
                        <i class="fas fa-user-circle"></i>
                        Informasi Pribadi
                    </h4>
                    
                    <div class="space-y-3">
                        <div class="info-box">
                            <div class="info-label">
                                <i class="fas fa-user"></i>
                                Nama Lengkap
                            </div>
                            <div class="info-value">{{ $account->name }}</div>
                        </div>
                        
                        <div class="info-box">
                            <div class="info-label">
                                <i class="fas fa-venus-mars"></i>
                                Jenis Kelamin
                            </div>
                            <div class="info-value">{{ $account->jenis_kelamin ?? '-' }}</div>
                        </div>
                        
                        <div class="info-box">
                            <div class="info-label">
                                <i class="fas fa-calendar-alt"></i>
                                Tempat, Tanggal Lahir
                            </div>
                            <div class="info-value">
                                @if($account->tempat_lahir || $account->tanggal_lahir)
                                    {{ $account->tempat_lahir ?? '-' }}{{ $account->tempat_lahir && $account->tanggal_lahir ? ', ' : '' }}
                                    @if($account->tanggal_lahir)
                                        {{ \Carbon\Carbon::parse($account->tanggal_lahir)->translatedFormat('d F Y') }}
                                    @endif
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        
                        <div class="info-box">
                            <div class="info-label">
                                <i class="fas fa-phone"></i>
                                No. Telepon
                            </div>
                            <div class="info-value">{{ $account->no_telepon ?? '-' }}</div>
                        </div>
                        
                        <div class="info-box">
                            <div class="info-label">
                                <i class="fas fa-map-marker-alt"></i>
                                Alamat
                            </div>
                            <div class="info-value">{{ $account->alamat ?? '-' }}</div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column - Account Info -->
                <div>
                    <h4 class="section-title">
                        <i class="fas fa-lock"></i>
                        Informasi Akun
                    </h4>
                    
                    <div class="space-y-3">
                        <div class="info-box">
                            <div class="info-label">
                                <i class="fas fa-envelope"></i>
                                Email
                            </div>
                            <div class="info-value">{{ $account->email }}</div>
                            <div class="text-xs text-gray-500 mt-2 flex items-center">
                                @if($account->email_verified_at)
                                    <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                    Terverifikasi {{ \Carbon\Carbon::parse($account->email_verified_at)->diffForHumans() }}
                                @else
                                    <i class="fas fa-times-circle text-red-500 mr-1"></i>
                                    Belum terverifikasi
                                @endif
                            </div>
                        </div>
                        
                        <div class="info-box">
                            <div class="info-label">
                                <i class="fas fa-clock"></i>
                                Terakhir Login
                            </div>
                            <div class="info-value">
                                @if($account->last_login_at)
                                    {{ \Carbon\Carbon::parse($account->last_login_at)->translatedFormat('d F Y H:i') }}
                                @else
                                    <span class="text-gray-400">Belum pernah login</span>
                                @endif
                            </div>
                            @if($account->last_login_ip)
                                <div class="text-xs text-gray-500 mt-1">
                                    <i class="fas fa-globe mr-1"></i> IP: {{ $account->last_login_ip }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="info-box">
                            <div class="info-label">
                                <i class="fas fa-calendar-plus"></i>
                                Bergabung Sejak
                            </div>
                            <div class="info-value">
                                {{ $account->created_at->translatedFormat('d F Y H:i') }}
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-history mr-1"></i>
                                {{ $account->created_at->diffForHumans() }}
                            </div>
                        </div>
                        
                        <div class="info-box">
                            <div class="info-label">
                                <i class="fas fa-pencil-alt"></i>
                                Terakhir Diperbarui
                            </div>
                            <div class="info-value">
                                {{ $account->updated_at->translatedFormat('d F Y H:i') }}
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-history mr-1"></i>
                                {{ $account->updated_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Log Section -->
    @if($account->activities && $account->activities->count() > 0)
    <div class="info-card p-6">
        <h4 class="section-title">
            <i class="fas fa-history"></i>
            Aktivitas Terbaru
        </h4>
        
        <div class="space-y-3">
            @foreach($account->activities()->latest()->limit(5)->get() as $activity)
            <div class="activity-item">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0
                        @if($activity->action == 'login') bg-green-500
                        @elseif($activity->action == 'logout') bg-gray-500
                        @elseif($activity->action == 'update_profile') bg-blue-500
                        @elseif($activity->action == 'change_password') bg-yellow-500
                        @elseif($activity->action == 'update_photo') bg-purple-500
                        @else bg-indigo-500
                        @endif">
                        
                        @if($activity->action == 'login')
                            <i class="fas fa-sign-in-alt text-white text-sm"></i>
                        @elseif($activity->action == 'logout')
                            <i class="fas fa-sign-out-alt text-white text-sm"></i>
                        @elseif($activity->action == 'update_profile')
                            <i class="fas fa-user-edit text-white text-sm"></i>
                        @elseif($activity->action == 'change_password')
                            <i class="fas fa-key text-white text-sm"></i>
                        @elseif($activity->action == 'update_photo')
                            <i class="fas fa-camera text-white text-sm"></i>
                        @else
                            <i class="fas fa-history text-white text-sm"></i>
                        @endif
                    </div>
                    
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-900">
                                {{ $activity->description ?? ucfirst(str_replace('_', ' ', $activity->action)) }}
                            </p>
                            <span class="text-xs text-gray-500">
                                {{ $activity->created_at->diffForHumans() }}
                            </span>
                        </div>
                        @if($activity->ip_address)
                        <div class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-globe mr-1"></i>{{ $activity->ip_address }}
                            @if($activity->device)
                                • <i class="fas fa-{{ strtolower($activity->device) == 'mobile' ? 'mobile-alt' : 'desktop' }} mr-1"></i>{{ $activity->device }}
                            @endif
                            @if($activity->browser)
                                • <i class="fas fa-compass mr-1"></i>{{ $activity->browser }}
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        @if($account->activities()->count() > 5)
        <div class="text-center mt-4">
            <a href="#" class="text-sm text-indigo-600 hover:text-indigo-800">
                Lihat semua aktivitas <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        @endif
    </div>
    @endif

    <!-- Danger Zone -->
    @if($account->id !== auth()->id() && in_array(auth()->user()->role, ['admin', 'super_admin']))
    <div class="info-card p-6 mt-6 border-2 border-red-200 bg-gradient-to-r from-red-50 to-white">
        <h4 class="section-title text-red-600">
            <i class="fas fa-exclamation-triangle text-red-500"></i>
            Danger Zone
        </h4>
        
        <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
            <div>
                <p class="font-medium text-gray-900">Hapus Akun Ini</p>
                <p class="text-sm text-gray-600">Setelah dihapus, semua data akun akan hilang permanen. Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <button onclick="deleteAccount({{ $account->id }}, '{{ $account->name }}')" 
                    class="bg-red-600 text-white px-6 py-3 rounded-xl hover:bg-red-700 transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:scale-105">
                <i class="fas fa-trash mr-2"></i>
                Hapus Akun
            </button>
        </div>
    </div>
    @endif
</div>

<!-- Reset Password Modal -->
<div id="resetPasswordModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4 shadow-2xl transform transition-all">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">Reset Password</h3>
            <button onclick="closeResetModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <p class="text-gray-600 mb-4">
            Password untuk akun <span class="font-semibold text-indigo-600">{{ $account->name }}</span> akan direset menjadi:
        </p>
        
        <div class="bg-indigo-50 p-4 rounded-lg text-center mb-6">
            <code class="text-2xl font-mono font-bold text-indigo-700">password123</code>
        </div>
        
        <div class="flex justify-end gap-3">
            <button type="button" onclick="closeResetModal()" 
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                Batal
            </button>
            <button type="button" onclick="confirmReset()" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Reset Password
            </button>
        </div>
    </div>
</div>

<!-- Hidden Forms -->
<form id="delete-form-{{ $account->id }}" action="{{ route('admin.accounts.destroy', $account) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<form id="reset-password-form-{{ $account->id }}" action="{{ route('admin.accounts.reset-password', $account) }}" method="POST" class="hidden">
    @csrf
    <input type="hidden" name="new_password" value="password123">
    <input type="hidden" name="new_password_confirmation" value="password123">
</form>

@endsection

@push('scripts')
<script>
    let selectedUserId = {{ $account->id }};
    let selectedUserName = "{{ $account->name }}";
    
    // Reset Password Modal
    function resetPassword(userId, userName) {
        selectedUserId = userId;
        selectedUserName = userName;
        document.getElementById('resetPasswordModal').classList.remove('hidden');
        document.getElementById('resetPasswordModal').classList.add('flex');
    }
    
    function closeResetModal() {
        document.getElementById('resetPasswordModal').classList.add('hidden');
        document.getElementById('resetPasswordModal').classList.remove('flex');
    }
    
    function confirmReset() {
        Swal.fire({
            title: 'Konfirmasi Reset Password',
            text: `Apakah Anda yakin ingin mereset password untuk akun ${selectedUserName}? Password akan menjadi "password123".`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#ef4444',
            confirmButtonText: 'Ya, reset!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`reset-password-form-${selectedUserId}`).submit();
            }
            closeResetModal();
        });
    }
    
    // Delete Account
    function deleteAccount(userId, userName) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: `Apakah Anda yakin ingin menghapus akun ${userName}? Tindakan ini tidak dapat dibatalkan.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${userId}`).submit();
            }
        });
    }
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeResetModal();
        }
    });
    
    // Close modal when clicking outside
    document.getElementById('resetPasswordModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeResetModal();
        }
    });
</script>
@endpush