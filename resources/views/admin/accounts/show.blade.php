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
<div class="max-w-4xl mx-auto space-y-6">
    <div class="h-20 flex items-center justify-between bg-transparent flex-shrink-0">
        <div class="flex items-center gap-4">
            <a class="p-2.5 bg-white hover:bg-primary hover:text-white rounded-xl transition-all text-slate-400 shadow-sm border border-slate-100 flex items-center justify-center group" href="{{ route('admin.accounts.index') }}">
                <span class="material-symbols-outlined group-hover:text-white">arrow_back</span>
            </a>
            <div>
                <h1 class="text-xl font-bold text-slate-800">Detail Informasi User</h1>
                <nav class="flex text-[10px] font-bold uppercase tracking-widest text-slate-400 gap-2">
                    <span>Manajemen Sistem</span>
                    <span>/</span>
                    <span class="text-primary">User Profile</span>
                </nav>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.accounts.edit', $account) }}" class="flex items-center gap-2 px-6 py-2.5 bg-primary text-white rounded-xl font-bold text-sm hover:opacity-90 transition-all shadow-lg shadow-primary/25">
                <span class="material-symbols-outlined text-lg">edit</span>
                Edit User
            </a>
            <div class="h-8 w-px bg-slate-200 mx-2"></div>
            <div class="flex items-center gap-3">
                @if($account->foto)
                    <img alt="User" class="w-10 h-10 rounded-2xl object-cover shadow-sm ring-2 ring-white" src="{{ asset('storage/'.$account->foto) }}"/>
                @else
                    <div class="w-10 h-10 rounded-2xl bg-primary/10 flex items-center justify-center shadow-sm ring-2 ring-white">
                        <span class="text-primary font-extrabold">{{ strtoupper(substr($account->name, 0, 1)) }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] shadow-xl shadow-primary/5 border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50 bg-gradient-to-r from-slate-50 to-white">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-3xl">account_circle</span>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-800">Informasi Profil User</h3>
                    <p class="text-sm text-slate-500 font-medium">Data detail akun dan akses sistem user yang bersangkutan.</p>
                </div>
            </div>
        </div>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-1">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Nama Lengkap</p>
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-slate-800 font-bold">{{ $account->name }}</p>
                    </div>
                </div>

                <div class="space-y-1">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Email</p>
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-slate-800 font-bold">{{ $account->email }}</p>
                    </div>
                </div>

                <div class="space-y-1">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Role Akses</p>
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-xl">admin_panel_settings</span>
                        <p class="text-slate-800 font-bold">{{ ucfirst(str_replace('_', ' ', $account->role)) }}</p>
                    </div>
                </div>

                <div class="space-y-1">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Jenis Kelamin</p>
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-slate-800 font-bold">{{ $account->jenis_kelamin ?? '-' }}</p>
                    </div>
                </div>

                <div class="space-y-1">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Tempat Tanggal Lahir</p>
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-slate-800 font-bold">
                            @if($account->tempat_lahir || $account->tanggal_lahir)
                                {{ $account->tempat_lahir ?? '-' }}{{ $account->tempat_lahir && $account->tanggal_lahir ? ', ' : '' }}
                                @if($account->tanggal_lahir)
                                    {{ \Carbon\Carbon::parse($account->tanggal_lahir)->translatedFormat('d F Y') }}
                                @endif
                            @else
                                -
                            @endif
                        </p>
                    </div>
                </div>

                <div class="space-y-1">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">No. Telepon</p>
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-slate-800 font-bold">{{ $account->no_telepon ?? '-' }}</p>
                    </div>
                </div>

                <div class="space-y-1">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Status Akun</p>
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 flex items-center">
                        @if($account->is_active)
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-[10px] font-black tracking-widest uppercase">AKTIF</span>
                        @else
                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-[10px] font-black tracking-widest uppercase">NONAKTIF</span>
                        @endif
                    </div>
                </div>

                <div class="space-y-1">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Terakhir Login</p>
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 flex items-center gap-2 text-slate-600">
                        <span class="material-symbols-outlined text-lg">history</span>
                        <p class="text-slate-800 font-bold">
                            @if($account->last_login_at)
                                {{ \Carbon\Carbon::parse($account->last_login_at)->translatedFormat('d M Y, H:i') }}
                            @else
                                -
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-start gap-5 p-6 bg-primary/5 rounded-[1.5rem] border border-primary/10 relative overflow-hidden group">
        <div class="absolute right-0 top-0 w-32 h-32 bg-primary/5 rounded-full -translate-y-1/2 translate-x-1/2 transition-transform duration-500 group-hover:scale-110"></div>
        <div class="w-12 h-12 rounded-xl bg-white flex-shrink-0 flex items-center justify-center shadow-sm">
            <span class="material-symbols-outlined text-primary">info</span>
        </div>
        <div class="relative z-10">
            <h4 class="text-sm font-bold text-slate-800 mb-1">Catatan Penting:</h4>
            <p class="text-xs text-slate-500 leading-relaxed max-w-2xl">
                Akses user ini dibatasi oleh hak istimewa role <span class="text-primary font-bold">{{ ucfirst(str_replace('_', ' ', $account->role)) }}</span>.
            </p>
        </div>
    </div>
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