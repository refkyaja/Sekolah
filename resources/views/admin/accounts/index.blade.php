@extends('layouts.admin')

@section('title', 'Kelola Semua Akun')
@section('breadcrumb', 'Akun')

@push('styles')
<style>
    /* Status and Role Badges */
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
        white-space: nowrap;
    }
    .status-active {
        background: #10b98120;
        color: #10b981;
        border: 1px solid #10b98140;
    }
    .status-inactive {
        background: #ef444420;
        color: #ef4444;
        border: 1px solid #ef444440;
    }
    .role-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
        white-space: nowrap;
    }
    .role-admin { background: #3b82f620; color: #3b82f6; border: 1px solid #3b82f640; }
    .role-kepala_sekolah { background: #f59e0b20; color: #f59e0b; border: 1px solid #f59e0b40; }
    .role-operator { background: #10b98120; color: #10b981; border: 1px solid #10b98140; }
    .role-guru { background: #6b728020; color: #6b7280; border: 1px solid #6b728040; }
    
    /* Filter Section */
    .filter-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        align-items: flex-end;
    }
    
    .filter-item {
        flex: 1 1 200px;
        min-width: 160px;
    }
    
    /* Table Responsive */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        margin: 0 -1px;
    }
    
    .table-min-width {
        min-width: 1000px;
    }
    
    /* Mobile Card View (for small screens) */
    @media (max-width: 768px) {
        .desktop-table {
            display: none;
        }
        
        .mobile-cards {
            display: block;
        }
        
        .user-card {
            background: white;
            border-radius: 0.75rem;
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid #e5e7eb;
        }
        
        .user-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.75rem;
        }
        
        .user-card-body {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }
        
        .user-card-footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 0.5rem;
            padding-top: 0.75rem;
            border-top: 1px solid #e5e7eb;
        }
        
        .user-info-label {
            font-size: 0.7rem;
            color: #6b7280;
            margin-bottom: 0.15rem;
        }
        
        .user-info-value {
            font-size: 0.85rem;
            color: #1f2937;
            font-weight: 500;
        }
    }
    
    @media (min-width: 769px) {
        .desktop-table {
            display: block;
        }
        
        .mobile-cards {
            display: none;
        }
    }
    
    /* Action Buttons */
    .action-btn {
        padding: 0.5rem;
        border-radius: 0.5rem;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
    }
    
    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    .action-btn i {
        font-size: 0.9rem;
    }
    
    /* Self account highlight */
    .self-account {
        background-color: #f0f9ff;
        border-left: 4px solid #3b82f6;
    }
    
    .self-account-mobile {
        border-left: 4px solid #3b82f6;
        background-color: #f0f9ff;
    }
    
    /* Stats Cards */
    .stats-card {
        background: white;
        border-radius: 0.75rem;
        padding: 1rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }
    
    .stats-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    /* Bulk Actions */
    .bulk-actions-wrapper {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    @media (min-width: 640px) {
        .bulk-actions-wrapper {
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
        }
    }
    
    /* Filter Buttons */
    .filter-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    /* Avatar */
    .avatar {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }
    
    @media (min-width: 640px) {
        .avatar {
            width: 2.5rem;
            height: 2.5rem;
        }
    }
    
    /* Loading state */
    .loading {
        opacity: 0.7;
        pointer-events: none;
    }
</style>
@endpush

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Kelola Semua Akun</h1>
        <p class="text-sm sm:text-base text-gray-600 mt-1">Kelola semua akun pengguna dalam sistem</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-3 sm:gap-4 mb-6">
        <div class="stats-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-600">Total Akun</p>
                    <p class="text-lg sm:text-2xl font-bold text-gray-900">{{ $totalAccounts }}</p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-indigo-600 text-sm sm:text-base"></i>
                </div>
            </div>
        </div>
        
        <div class="stats-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-600">Aktif</p>
                    <p class="text-lg sm:text-2xl font-bold text-green-600">{{ $totalActive }}</p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-sm sm:text-base"></i>
                </div>
            </div>
        </div>
        
        <div class="stats-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-600">Nonaktif</p>
                    <p class="text-lg sm:text-2xl font-bold text-red-600">{{ $totalInactive }}</p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-times-circle text-red-600 text-sm sm:text-base"></i>
                </div>
            </div>
        </div>
        
        <div class="stats-card col-span-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-600">Admin</p>
                    <p class="text-lg sm:text-2xl font-bold text-blue-600">{{ $totalByRole['admin'] }}</p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-shield text-blue-600 text-sm sm:text-base"></i>
                </div>
            </div>
        </div>
        
        <div class="stats-card col-span-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-600">Guru</p>
                    <p class="text-lg sm:text-2xl font-bold text-gray-600">{{ $totalByRole['guru'] }}</p>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chalkboard-teacher text-gray-600 text-sm sm:text-base"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions Bar -->
    <div class="bg-white rounded-xl shadow-sm mb-6">
        <div class="p-4 sm:p-6">
            <!-- Bulk Actions & Add Button -->
            <div class="bulk-actions-wrapper mb-4">
                <a href="{{ route('admin.accounts.create') }}" 
                   class="inline-flex items-center justify-center bg-indigo-600 text-white px-4 py-2.5 rounded-lg hover:bg-indigo-700 transition-colors duration-200 text-sm sm:text-base w-full sm:w-auto">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Akun
                </a>
                
                <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                    <select id="bulkAction" class="border rounded-lg px-3 py-2.5 text-sm bg-white focus:ring-2 focus:ring-indigo-500 w-full sm:w-40">
                        <option value="">Pilih Aksi</option>
                        <option value="activate">Aktifkan</option>
                        <option value="deactivate">Nonaktifkan</option>
                        <option value="delete">Hapus</option>
                    </select>
                    <button onclick="bulkAction()" class="bg-gray-600 text-white px-4 py-2.5 rounded-lg hover:bg-gray-700 text-sm w-full sm:w-auto transition-colors">
                        Terapkan
                    </button>
                </div>
            </div>
            
            <!-- Search & Filter -->
            <form method="GET" class="filter-container">
                <div class="filter-item">
                    <label class="block text-xs text-gray-600 mb-1">Cari</label>
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="text" 
                               name="search" 
                               placeholder="Nama atau email..." 
                               value="{{ request('search') }}"
                               class="w-full pl-9 pr-4 py-2.5 border rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
                
                <div class="filter-item">
                    <label class="block text-xs text-gray-600 mb-1">Role</label>
                    <select name="role" class="w-full border rounded-lg px-3 py-2.5 text-sm bg-white focus:ring-2 focus:ring-indigo-500">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="kepala_sekolah" {{ request('role') == 'kepala_sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                        <option value="operator" {{ request('role') == 'operator' ? 'selected' : '' }}>Operator</option>
                        <option value="guru" {{ request('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                    </select>
                </div>
                
                <div class="filter-item">
                    <label class="block text-xs text-gray-600 mb-1">Status</label>
                    <select name="status" class="w-full border rounded-lg px-3 py-2.5 text-sm bg-white focus:ring-2 focus:ring-indigo-500">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                
                <div class="filter-buttons">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2.5 rounded-lg hover:bg-indigo-700 text-sm transition-colors flex items-center">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    
                    @if(request()->anyFilled(['search', 'role', 'status']))
                    <a href="{{ route('admin.accounts.index') }}" class="bg-gray-500 text-white px-4 py-2.5 rounded-lg hover:bg-gray-600 text-sm transition-colors flex items-center">
                        <i class="fas fa-times mr-1"></i> Reset
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Desktop Table View -->
    <div class="desktop-table">
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="table-responsive">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 sm:px-6 py-4 text-left">
                                <input type="checkbox" id="selectAll" class="rounded border-gray-300 w-4 h-4">
                            </th>
                            <th class="px-4 sm:px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ route('admin.accounts.index', array_merge(request()->query(), ['sort' => 'name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="hover:text-gray-700 flex items-center gap-1">
                                    Nama
                                    @if(request('sort') == 'name')
                                        <i class="fas fa-chevron-{{ request('direction') == 'asc' ? 'up' : 'down' }} text-xs"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="px-4 sm:px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-4 sm:px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-4 sm:px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-4 sm:px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <a href="{{ route('admin.accounts.index', array_merge(request()->query(), ['sort' => 'last_login_at', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="hover:text-gray-700 flex items-center gap-1">
                                    Terakhir Login
                                    @if(request('sort') == 'last_login_at')
                                        <i class="fas fa-chevron-{{ request('direction') == 'asc' ? 'up' : 'down' }} text-xs"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="px-4 sm:px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors duration-200 {{ $user->id === auth()->id() ? 'self-account' : '' }}">
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                @if($user->id !== auth()->id())
                                    <input type="checkbox" name="user_ids[]" value="{{ $user->id }}" class="user-checkbox rounded border-gray-300 w-4 h-4">
                                @else
                                    <span class="text-xs text-blue-600 font-medium">Anda</span>
                                @endif
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        @if($user->foto)
                                            <img class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover" src="{{ asset('storage/'.$user->foto) }}" alt="">
                                        @else
                                            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-indigo-100 flex items-center justify-center avatar">
                                                <span class="text-indigo-600 font-medium text-sm">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-2 sm:ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex items-center">
                                    {{ $user->email }}
                                    @if($user->email_verified_at)
                                        <i class="fas fa-check-circle text-green-500 ml-1 text-xs" title="Email terverifikasi"></i>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                <span class="role-badge role-{{ $user->role }}">
                                    {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                </span>
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                <span class="status-badge {{ $user->is_active ? 'status-active' : 'status-inactive' }}">
                                    {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($user->last_login_at)
                                    {{ \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() }}
                                @else
                                    <span class="text-gray-400">Belum pernah login</span>
                                @endif
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.accounts.show', $user) }}" 
                                       class="action-btn text-indigo-600 hover:bg-indigo-50" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <a href="{{ route('admin.accounts.edit', $user) }}" 
                                       class="action-btn text-yellow-600 hover:bg-yellow-50" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <button onclick="resetPassword({{ $user->id }}, '{{ $user->name }}')" 
                                            class="action-btn text-blue-600 hover:bg-blue-50" title="Reset Password">
                                        <i class="fas fa-key"></i>
                                    </button>
                                    
                                    @if($user->id !== auth()->id())
                                        <button onclick="toggleStatus({{ $user->id }}, '{{ $user->name }}', {{ $user->is_active ? 'false' : 'true' }})" 
                                                class="action-btn {{ $user->is_active ? 'text-red-600 hover:bg-red-50' : 'text-green-600 hover:bg-green-50' }}"
                                                title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                            <i class="fas fa-{{ $user->is_active ? 'ban' : 'check-circle' }}"></i>
                                        </button>
                                        
                                        <button onclick="deleteAccount({{ $user->id }}, '{{ $user->name }}')" 
                                                class="action-btn text-red-600 hover:bg-red-50" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-users text-5xl mb-4 text-gray-300"></i>
                                <p class="text-lg">Tidak ada akun ditemukan</p>
                                <p class="text-sm text-gray-400 mt-1">Coba ubah filter atau tambah akun baru</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($users->hasPages())
            <div class="px-4 sm:px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $users->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Mobile Card View -->
    <div class="mobile-cards">
        <div class="space-y-3">
            @forelse($users as $user)
            <div class="user-card {{ $user->id === auth()->id() ? 'self-account-mobile' : '' }}">
                <div class="user-card-header">
                    <div class="flex items-center gap-3">
                        @if($user->id !== auth()->id())
                            <input type="checkbox" name="user_ids[]" value="{{ $user->id }}" class="user-checkbox-mobile rounded border-gray-300 w-5 h-5">
                        @endif
                        <div class="flex items-center gap-2">
                            @if($user->foto)
                                <img class="w-10 h-10 rounded-full object-cover" src="{{ asset('storage/'.$user->foto) }}" alt="">
                            @else
                                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center avatar">
                                    <span class="text-indigo-600 font-medium">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                            @endif
                            <div>
                                <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                @if($user->id === auth()->id())
                                    <span class="text-xs text-blue-600">(Akun Anda)</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <span class="role-badge role-{{ $user->role }}">
                        {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                    </span>
                </div>
                
                <div class="user-card-body">
                    <div>
                        <div class="user-info-label">Email</div>
                        <div class="user-info-value flex items-center">
                            {{ $user->email }}
                            @if($user->email_verified_at)
                                <i class="fas fa-check-circle text-green-500 ml-1 text-xs"></i>
                            @endif
                        </div>
                    </div>
                    
                    <div>
                        <div class="user-info-label">Status</div>
                        <div class="user-info-value">
                            <span class="status-badge {{ $user->is_active ? 'status-active' : 'status-inactive' }}">
                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="col-span-2">
                        <div class="user-info-label">Terakhir Login</div>
                        <div class="user-info-value">
                            @if($user->last_login_at)
                                {{ \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() }}
                            @else
                                <span class="text-gray-400">Belum pernah login</span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="user-card-footer">
                    <a href="{{ route('admin.accounts.show', $user) }}" 
                       class="action-btn text-indigo-600 hover:bg-indigo-50">
                        <i class="fas fa-eye"></i>
                    </a>
                    
                    <a href="{{ route('admin.accounts.edit', $user) }}" 
                       class="action-btn text-yellow-600 hover:bg-yellow-50">
                        <i class="fas fa-edit"></i>
                    </a>
                    
                    <button onclick="resetPassword({{ $user->id }}, '{{ $user->name }}')" 
                            class="action-btn text-blue-600 hover:bg-blue-50">
                        <i class="fas fa-key"></i>
                    </button>
                    
                    @if($user->id !== auth()->id())
                        <button onclick="toggleStatus({{ $user->id }}, '{{ $user->name }}', {{ $user->is_active ? 'false' : 'true' }})" 
                                class="action-btn {{ $user->is_active ? 'text-red-600 hover:bg-red-50' : 'text-green-600 hover:bg-green-50' }}">
                            <i class="fas fa-{{ $user->is_active ? 'ban' : 'check-circle' }}"></i>
                        </button>
                        
                        <button onclick="deleteAccount({{ $user->id }}, '{{ $user->name }}')" 
                                class="action-btn text-red-600 hover:bg-red-50">
                            <i class="fas fa-trash"></i>
                        </button>
                    @endif
                </div>
            </div>
            @empty
            <div class="bg-white rounded-xl p-8 text-center text-gray-500">
                <i class="fas fa-users text-5xl mb-4 text-gray-300"></i>
                <p class="text-lg">Tidak ada akun ditemukan</p>
                <p class="text-sm text-gray-400 mt-1">Coba ubah filter atau tambah akun baru</p>
            </div>
            @endforelse
        </div>
        
        <!-- Mobile Pagination -->
        @if($users->hasPages())
        <div class="mt-4">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Hidden Forms -->
<form id="bulkActionForm" action="{{ route('admin.accounts.bulk-action') }}" method="POST" class="hidden">
    @csrf
    <input type="hidden" name="action" id="bulkActionInput">
    <div id="bulkUserIdsContainer"></div>
</form>

@foreach($users as $user)
    <form id="reset-password-form-{{ $user->id }}" action="{{ route('admin.accounts.reset-password', $user) }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="new_password" value="password123">
        <input type="hidden" name="new_password_confirmation" value="password123">
    </form>
    
    <form id="toggle-form-{{ $user->id }}" action="{{ route('admin.accounts.toggle-status', $user) }}" method="POST" class="hidden">
        @csrf
        @method('PATCH')
    </form>
    
    <form id="delete-form-{{ $user->id }}" action="{{ route('admin.accounts.destroy', $user) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
@endforeach

<!-- Reset Password Modal -->
<div id="resetPasswordModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Reset Password</h3>
        <p class="text-sm text-gray-600 mb-4">Password untuk akun <span id="resetUserName" class="font-semibold"></span> akan direset menjadi:</p>
        <div class="bg-gray-100 p-3 rounded-lg text-center mb-6">
            <code class="text-lg font-mono font-bold text-indigo-600">password123</code>
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
@endsection

@push('scripts')
<script>
    let selectedUserId = null;
    let selectedUserName = '';

    // Select All functionality (Desktop)
    document.getElementById('selectAll')?.addEventListener('change', function() {
        document.querySelectorAll('.user-checkbox').forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Bulk Action
    function bulkAction() {
        const action = document.getElementById('bulkAction').value;
        if (!action) {
            Swal.fire('Peringatan', 'Pilih aksi terlebih dahulu', 'warning');
            return;
        }
        
        // Get selected users from both desktop and mobile
        const selected = [];
        document.querySelectorAll('.user-checkbox:checked, .user-checkbox-mobile:checked').forEach(cb => {
            selected.push(cb.value);
        });
        
        if (selected.length === 0) {
            Swal.fire('Peringatan', 'Pilih minimal satu akun', 'warning');
            return;
        }
        
        let actionText = '';
        let confirmColor = '#3085d6';
        
        if (action === 'activate') {
            actionText = 'mengaktifkan';
            confirmColor = '#10b981';
        } else if (action === 'deactivate') {
            actionText = 'menonaktifkan';
            confirmColor = '#f59e0b';
        } else if (action === 'delete') {
            actionText = 'menghapus';
            confirmColor = '#ef4444';
        }
        
        Swal.fire({
            title: 'Konfirmasi',
            text: `Apakah Anda yakin ingin ${actionText} ${selected.length} akun?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: confirmColor,
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, lanjutkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("admin.accounts.bulk-action") }}';
                
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfInput);
                
                const actionInput = document.createElement('input');
                actionInput.type = 'hidden';
                actionInput.name = 'action';
                actionInput.value = action;
                form.appendChild(actionInput);
                
                selected.forEach(id => {
                    const idInput = document.createElement('input');
                    idInput.type = 'hidden';
                    idInput.name = 'user_ids[]';
                    idInput.value = id;
                    form.appendChild(idInput);
                });
                
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    // Reset Password
    function resetPassword(userId, userName) {
        selectedUserId = userId;
        selectedUserName = userName;
        document.getElementById('resetUserName').textContent = userName;
        document.getElementById('resetPasswordModal').classList.remove('hidden');
        document.getElementById('resetPasswordModal').classList.add('flex');
    }

    function closeResetModal() {
        document.getElementById('resetPasswordModal').classList.add('hidden');
        document.getElementById('resetPasswordModal').classList.remove('flex');
        selectedUserId = null;
        selectedUserName = '';
    }

    function confirmReset() {
        if (selectedUserId) {
            Swal.fire({
                title: 'Konfirmasi Reset Password',
                text: `Apakah Anda yakin ingin mereset password untuk akun ${selectedUserName}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, reset!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`reset-password-form-${selectedUserId}`).submit();
                }
                closeResetModal();
            });
        }
    }

    // Toggle Status
    function toggleStatus(userId, userName, activate) {
        const action = activate ? 'mengaktifkan' : 'menonaktifkan';
        Swal.fire({
            title: 'Konfirmasi',
            text: `Apakah Anda yakin ingin ${action} akun ${userName}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, lanjutkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`toggle-form-${userId}`).submit();
            }
        });
    }

    // Delete Account
    function deleteAccount(userId, userName) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: `Apakah Anda yakin ingin menghapus akun ${userName}? Tindakan ini tidak dapat dibatalkan.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${userId}`).submit();
            }
        });
    }

    // Close modal with Escape key and click outside
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeResetModal();
        }
    });

    document.getElementById('resetPasswordModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeResetModal();
        }
    });

    // Mobile select all functionality
    function toggleMobileSelectAll() {
        const checkboxes = document.querySelectorAll('.user-checkbox-mobile');
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
        checkboxes.forEach(cb => cb.checked = !allChecked);
    }

    // Loading state for form submissions
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            document.body.classList.add('loading');
        });
    });
</script>
@endpush