{{-- resources/views/admin/spmb-settings/pengumuman.blade.php --}}
@extends('layouts.admin')

@section('title', 'Pengaturan Pengumuman SPMB - Admin')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
        --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
        --warning-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        --danger-gradient: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        --info-gradient: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        --glass-bg: rgba(255, 255, 255, 0.72);
        --glass-border: rgba(255, 255, 255, 0.95);
        --shadow-xl: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
        --shadow-2xl: 0 50px 100px -20px rgba(0, 0, 0, 0.12);
    }
    
    * {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        letter-spacing: -0.01em;
    }
    
    body {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
        overflow-x: hidden;
    }
    
    /* ==================== MAIN LAYOUT ==================== */
    .admin-container {
        max-width: 1800px;
        margin: 0 auto;
        padding: 2rem;
    }
    
    /* ==================== PREMIUM CARD ==================== */
    .premium-card {
        background: white;
        border-radius: 24px;
        box-shadow: var(--shadow-xl);
        border: 1px solid rgba(255, 255, 255, 0.95);
        overflow: hidden;
        transition: all 0.3s ease;
        margin: 10px;
    }
    
    .premium-card:hover {
        box-shadow: var(--shadow-2xl);
    }
    
    .premium-card-header {
        padding: 1.5rem 2rem;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .premium-card-title {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .premium-card-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        background: var(--primary-gradient);
        color: white;
    }
    
    /* ==================== FORM CONTROLS ==================== */
    .form-section {
        padding: 2rem;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .form-section:last-child {
        border-bottom: none;
    }
    
    .form-section-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .section-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);
        color: #6d28d9;
    }
    
    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }
    
    .section-subtitle {
        font-size: 0.875rem;
        color: #64748b;
        margin: 0.25rem 0 0;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        font-weight: 600;
        font-size: 0.875rem;
        color: #334155;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .form-label i {
        color: #6d28d9;
        font-size: 0.875rem;
    }
    
    .input-wrapper {
        position: relative;
    }
    
    .input-field {
        width: 100%;
        padding: 0.875rem 1rem;
        padding-left: 2.75rem;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 0.9375rem;
        color: #1e293b;
        background: white;
        transition: all 0.2s ease;
    }
    
    .input-field:focus {
        outline: none;
        border-color: #6d28d9;
        box-shadow: 0 0 0 3px rgba(109, 40, 217, 0.1);
    }
    
    .input-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 1rem;
    }
    
    .input-hint {
        font-size: 0.75rem;
        color: #64748b;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    /* ==================== STATUS BADGE ==================== */
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.375rem 0.75rem;
        border-radius: 100px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .status-published {
        background: rgba(139, 92, 246, 0.1);
        color: #6d28d9;
        border: 1px solid rgba(139, 92, 246, 0.2);
    }
    
    .status-ready {
        background: rgba(245, 158, 11, 0.1);
        color: #92400e;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }
    
    .status-draft {
        background: rgba(100, 116, 139, 0.1);
        color: #334155;
        border: 1px solid rgba(100, 116, 139, 0.2);
    }
    
    .status-closed {
        background: rgba(239, 68, 68, 0.1);
        color: #991b1b;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }
    
    /* ==================== TABLE PREMIUM ==================== */
    .table-premium {
        width: 100%;
        border-collapse: collapse;
    }
    
    .table-premium th {
        background: #f8fafc;
        padding: 1rem 1.5rem;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #475569;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .table-premium td {
        padding: 1rem 1.5rem;
        font-size: 0.875rem;
        color: #1e293b;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .table-premium tr:hover td {
        background: #f8fafc;
    }
    
    /* ==================== ACTION BUTTONS ==================== */
    .btn {
        padding: 0.875rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
        cursor: pointer;
    }
    
    .btn-primary {
        background: var(--primary-gradient);
        color: white;
        box-shadow: 0 4px 6px rgba(109, 40, 217, 0.25);
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px rgba(109, 40, 217, 0.3);
    }
    
    .btn-outline {
        background: white;
        border: 2px solid #e2e8f0;
        color: #475569;
    }
    
    .btn-outline:hover {
        border-color: #6d28d9;
        color: #6d28d9;
        background: #f8fafc;
    }
    
    .btn-success {
        background: var(--success-gradient);
        color: white;
        box-shadow: 0 4px 6px rgba(16, 185, 129, 0.25);
    }
    
    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px rgba(16, 185, 129, 0.3);
    }
    
    .btn-warning {
        background: var(--warning-gradient);
        color: white;
        box-shadow: 0 4px 6px rgba(245, 158, 11, 0.25);
    }
    
    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px rgba(245, 158, 11, 0.3);
    }
    
    .action-bar {
        background: white;
        border-top: 1px solid #e2e8f0;
        padding: 1.5rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    /* ==================== ANIMATIONS ==================== */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out;
    }
    
    .animate-delay-1 { animation-delay: 0.1s; }
    .animate-delay-2 { animation-delay: 0.2s; }
    .animate-delay-3 { animation-delay: 0.3s; }
</style>
@endpush

@section('content')
<div class="admin-container">
    
    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 animate-fade-in">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">📢 Pengaturan Pengumuman</h1>
            <p class="text-gray-600">
                Atur jadwal, status, dan lihat siswa yang lulus
            </p>
        </div>
        <div class="bg-purple-50 px-4 py-2 rounded-lg">
            <span class="text-sm text-purple-700">
                <i class="fas fa-calendar-alt mr-2"></i>
                Tahun Ajaran {{ $setting->tahun_ajaran ?? '2026/2027' }}
            </span>
        </div>
    </div>

    {{-- MAIN GRID --}}
    <div class="row g-4">
        
        {{-- LEFT COLUMN: FORM PENGATURAN PENGUMUMAN --}}
        <div class="col-lg-7 animate-fade-in animate-delay-1">
            <div class="premium-card">
                <div class="premium-card-header">
                    <div class="premium-card-title">
                        <div class="premium-card-icon">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <div>
                            <h5 class="font-bold text-gray-800 mb-1">Konfigurasi Pengumuman</h5>
                            <p class="text-sm text-gray-600 mb-0">Atur jadwal dan status pengumuman kelulusan</p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.spmb-settings.pengumuman.update') }}" id="pengumumanForm">
                    @csrf
                    @method('PUT')

                    {{-- SECTION: JADWAL PENGUMUMAN --}}
                    <div class="form-section">
                        <div class="form-section-header">
                            <div class="section-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div>
                                <h6 class="section-title">Jadwal Pengumuman</h6>
                                <p class="section-subtitle">Atur periode penayangan pengumuman kelulusan</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-play-circle"></i>
                                        TANGGAL MULAI
                                    </label>
                                    <div class="input-wrapper">
                                        <input type="datetime-local" class="input-field" id="pengumuman_mulai" 
                                               name="pengumuman_mulai" 
                                               value="{{ old('pengumuman_mulai', $setting->pengumuman_mulai ? date('Y-m-d\TH:i', strtotime($setting->pengumuman_mulai)) : '') }}" 
                                               required>
                                        <i class="input-icon far fa-calendar-plus"></i>
                                    </div>
                                    <div class="input-hint">
                                        <i class="fas fa-info-circle"></i>
                                        Pengumuman akan otomatis tampil setelah tanggal ini
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-stop-circle"></i>
                                        TANGGAL SELESAI
                                    </label>
                                    <div class="input-wrapper">
                                        <input type="datetime-local" class="input-field" id="pengumuman_selesai" 
                                               name="pengumuman_selesai" 
                                               value="{{ old('pengumuman_selesai', $setting->pengumuman_selesai ? date('Y-m-d\TH:i', strtotime($setting->pengumuman_selesai)) : '') }}" 
                                               required>
                                        <i class="input-icon far fa-calendar-minus"></i>
                                    </div>
                                    <div class="input-hint">
                                        <i class="fas fa-info-circle"></i>
                                        Pengumuman akan otomatis disembunyikan setelah tanggal ini
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SECTION: STATUS PENGUMUMAN --}}
                    <div class="form-section">
                        <div class="form-section-header">
                            <div class="section-icon" style="background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%); color: #7e22ce;">
                                <i class="fas fa-toggle-on"></i>
                            </div>
                            <div>
                                <h6 class="section-title">Status Pengumuman</h6>
                                <p class="section-subtitle">Atur mode penayangan pengumuman</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-flag"></i>
                                        STATUS SAAT INI
                                    </label>
                                    <div class="input-wrapper">
                                        <select class="input-field" id="status_pengumuman" name="status_pengumuman" required>
                                            <option value="draft" {{ $setting->status_pengumuman == 'draft' ? 'selected' : '' }}>📝 Draft - Tersembunyi (Proses Penilaian)</option>
                                            <option value="ready" {{ $setting->status_pengumuman == 'ready' ? 'selected' : '' }}>⏳ Ready - Countdown (Menjelang Pengumuman)</option>
                                            <option value="published" {{ $setting->status_pengumuman == 'published' ? 'selected' : '' }}>🎉 Published - Sedang Ditampilkan</option>
                                            <option value="closed" {{ $setting->status_pengumuman == 'closed' ? 'selected' : '' }}>🔒 Closed - Masa Pengumuman Selesai</option>
                                        </select>
                                        <i class="input-icon fas fa-power-off"></i>
                                    </div>
                                    <div class="input-hint">
                                        <i class="fas fa-info-circle"></i>
                                        <span id="statusHint">
                                            @if($setting->status_pengumuman == 'draft')
                                                Pengumuman tidak tampil, cocok saat masih mengolah nilai
                                            @elseif($setting->status_pengumuman == 'ready')
                                                Menampilkan countdown di homepage, hasil belum bisa dilihat
                                            @elseif($setting->status_pengumuman == 'published')
                                                Hasil kelulusan bisa dilihat oleh siswa
                                            @else
                                                Pengumuman ditutup, menampilkan pesan penutupan
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SECTION: AKSI CEPAT PUBLISH --}}
                    <div class="form-section">
                        <div class="form-section-header">
                            <div class="section-icon" style="background: linear-gradient(135deg, #fef9c3 0%, #fef08a 100%); color: #854d0e;">
                                <i class="fas fa-bolt"></i>
                            </div>
                            <div>
                                <h6 class="section-title">Aksi Cepat</h6>
                                <p class="section-subtitle">Publikasi atau sembunyikan pengumuman instan</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex gap-3">
                                    @if($setting->status_pengumuman == 'published')
                                    <form action="{{ route('admin.spmb-settings.unpublish') }}" method="POST" id="unpublishForm">
                                        @csrf
                                        <button type="submit" class="btn btn-warning" id="unpublishBtn">
                                            <i class="fas fa-eye-slash mr-2"></i>
                                            Sembunyikan Pengumuman
                                        </button>
                                    </form>
                                    @else
                                    <form action="{{ route('admin.spmb-settings.publish') }}" method="POST" id="publishForm">
                                        @csrf
                                        <button type="submit" class="btn btn-success" id="publishBtn">
                                            <i class="fas fa-eye mr-2"></i>
                                            Tampilkan Pengumuman Sekarang
                                        </button>
                                    </form>
                                    @endif
                                    
                                    <a href="{{ route('home') }}" target="_blank" class="btn btn-outline">
                                        <i class="fas fa-external-link-alt mr-2"></i>
                                        Lihat Homepage
                                    </a>
                                </div>
                                <div class="input-hint mt-3">
                                    <i class="fas fa-info-circle"></i>
                                    Tombol ini akan langsung mengubah status pengumuman, mengabaikan jadwal
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ACTION BUTTONS --}}
                    <div class="action-bar">
                        <a href="{{ route('admin.spmb-settings.index') }}" class="btn btn-outline">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline" onclick="document.getElementById('pengumumanForm').reset()">
                                <i class="fas fa-redo mr-2"></i>
                                Reset
                            </button>
                            <button type="submit" form="pengumumanForm" class="btn btn-primary" id="submitBtn">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- RIGHT COLUMN: SISWA LULUS --}}
        <div class="col-lg-5 animate-fade-in animate-delay-2">
            <div class="premium-card h-100">
                <div class="premium-card-header">
                    <div class="premium-card-title">
                        <div class="premium-card-icon" style="background: var(--success-gradient);">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div>
                            <h5 class="font-bold text-gray-800 mb-1">🎓 Siswa Lulus</h5>
                        </div>
                    </div>
                    <a href="{{ route('admin.spmb.index', ['status' => 'diterima']) }}" 
                       class="btn btn-outline btn-sm">
                        Lihat Semua
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <div style="padding: 1.5rem;">
                    {{-- STATISTIK CEPAT --}}
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="p-3 bg-success bg-opacity-10 rounded-lg border border-success border-opacity-20">
                                <span class="text-success text-xs fw-bold">✅ TOTAL LULUS</span>
                                <h4 class="text-2xl fw-bold text-success mt-1 mb-0">{{ $totalLulus ?? 0 }}</h4>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-primary bg-opacity-10 rounded-lg border border-primary border-opacity-20">
                                <span class="text-primary text-xs fw-bold">📋 TOTAL PENDAFTAR</span>
                                <h4 class="text-2xl fw-bold text-primary mt-1 mb-0">{{ $totalPendaftar ?? 0 }}</h4>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-3 bg-purple-50 rounded-lg border border-purple-200">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-purple-700 text-sm fw-semibold">
                                        <i class="fas fa-chart-line mr-2"></i>
                                        PERSENTASE KELULUSAN
                                    </span>
                                    <span class="text-2xl fw-bold text-purple-700">
                                        {{ $totalPendaftar > 0 ? round(($totalLulus / $totalPendaftar) * 100, 1) : 0 }}%
                                    </span>
                                </div>
                                <div class="progress mt-2" style="height: 8px;">
                                    <div class="progress-bar bg-purple-600" 
                                         role="progressbar" 
                                         style="width: {{ $totalPendaftar > 0 ? ($totalLulus / $totalPendaftar) * 100 : 0 }}%;"
                                         aria-valuenow="{{ $totalPendaftar > 0 ? ($totalLulus / $totalPendaftar) * 100 : 0 }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TABEL SISWA LULUS --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-semibold text-gray-700 mb-0">📋 Daftar Siswa Lulus</h6>
                        <span class="badge bg-purple-100 text-purple-800 px-3 py-2">
                            {{ $siswaLulus->total() ?? 0 }} Siswa
                        </span>
                    </div>
                    
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table-premium">
                            <thead>
                                <tr>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Jalur</th>
                                    <th width="50"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($siswaLulus as $siswa)
                                <tr>
                                    <td>
                                        <span class="font-mono text-xs">{{ $siswa->nik ?? $siswa->nilik }}</span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-gray-800">
                                            {{ $siswa->nama_calon_siswa ?? $siswa->name_oslon_clowa }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $siswa->no_pendaftaran }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-purple-100 text-purple-800 px-3 py-2">
                                            {{ ucfirst($siswa->jalur_pendaftaran) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.spmb.show', $siswa->id) }}" 
                                           class="text-primary hover:text-primary-600"
                                           data-bs-toggle="tooltip" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="text-gray-500">
                                            <i class="fas fa-user-slash fa-3x mb-3"></i>
                                            <p class="mb-0 fw-semibold">Belum ada siswa lulus</p>
                                            <p class="small">Siswa yang lulus seleksi akan muncul di sini</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINATION --}}
                    @if(isset($siswaLulus) && $siswaLulus->hasPages())
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $siswaLulus->onEachSide(0)->links('vendor.pagination.simple-tailwind') }}
                    </div>
                    @endif

                    {{-- JUMLAH LULUS PER JALUR --}}
                    @if(isset($statistikJalur) && count($statistikJalur) > 0)
                    <div class="mt-4 pt-4 border-top border-gray-200">
                        <p class="text-xs fw-semibold text-gray-500 mb-3">📊 JUMLAH LULUS PER JALUR</p>
                        <div class="row g-2">
                            @foreach($statistikJalur as $jalur => $jumlah)
                            <div class="col-6">
                                <div class="d-flex justify-content-between align-items-center p-2 bg-gray-50 rounded">
                                    <span class="text-xs text-gray-600">{{ ucfirst($jalur) }}</span>
                                    <span class="badge bg-purple-100 text-purple-800 px-2 py-1">{{ $jumlah }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('pengumumanForm');
    const publishForm = document.getElementById('publishForm');
    const unpublishForm = document.getElementById('unpublishForm');
    const mulaiInput = document.getElementById('pengumuman_mulai');
    const selesaiInput = document.getElementById('pengumuman_selesai');
    const statusSelect = document.getElementById('status_pengumuman');
    const statusHint = document.getElementById('statusHint');
    const submitBtn = document.getElementById('submitBtn');
    
    // ============== VALIDASI TANGGAL ==============
    function validateDates() {
        if (mulaiInput?.value && selesaiInput?.value) {
            const mulai = new Date(mulaiInput.value);
            const selesai = new Date(selesaiInput.value);
            
            if (selesai <= mulai) {
                selesaiInput.style.borderColor = '#ef4444';
                selesaiInput.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.1)';
                return false;
            } else {
                selesaiInput.style.borderColor = '#10b981';
                selesaiInput.style.boxShadow = '0 0 0 3px rgba(16, 185, 129, 0.1)';
                return true;
            }
        }
        return true;
    }
    
    // ============== STATUS HINT ==============
    if (statusSelect) {
        statusSelect.addEventListener('change', function() {
            const status = this.value;
            let hint = '';
            
            switch(status) {
                case 'draft':
                    hint = 'Pengumuman tidak tampil, cocok saat masih mengolah nilai';
                    break;
                case 'ready':
                    hint = 'Menampilkan countdown di homepage, hasil belum bisa dilihat';
                    break;
                case 'published':
                    hint = 'Hasil kelulusan bisa dilihat oleh siswa';
                    break;
                case 'closed':
                    hint = 'Pengumuman ditutup, menampilkan pesan penutupan';
                    break;
            }
            
            statusHint.textContent = hint;
            
            // Animasi
            this.style.transition = 'all 0.3s ease';
            this.style.borderColor = '#6d28d9';
            this.style.boxShadow = '0 0 0 3px rgba(109, 40, 217, 0.1)';
            
            setTimeout(() => {
                this.style.boxShadow = '';
            }, 1000);
        });
    }
    
    // ============== DATE VALIDATION ==============
    if (mulaiInput) {
        mulaiInput.addEventListener('change', validateDates);
        mulaiInput.addEventListener('change', function() {
            this.style.borderColor = '#6d28d9';
            this.style.boxShadow = '0 0 0 3px rgba(109, 40, 217, 0.1)';
        });
    }
    
    if (selesaiInput) {
        selesaiInput.addEventListener('change', validateDates);
    }
    
    // ============== FORM SUBMIT ==============
    // ============== FORM SUBMIT ==============
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateDates()) {
                e.preventDefault();
                
                selesaiInput.style.animation = 'shake 0.5s';
                setTimeout(() => {
                    selesaiInput.style.animation = '';
                }, 500);
                
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: 'Waktu selesai harus setelah waktu mulai',
                    confirmButtonColor: '#6d28d9',
                    confirmButtonText: 'Mengerti',
                    customClass: {
                        popup: 'rounded-4',
                        confirmButton: 'px-4 py-2 rounded-3 fw-semibold'
                    }
                });
                return;
            }
            
            // ✅ AMBIL TOMBOL SUBMIT DENGAN ID
            const submitBtn = document.getElementById('submitBtn');
            
            if (submitBtn) {
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...';
                submitBtn.disabled = true;
                
                setTimeout(() => {
                    if (submitBtn.disabled) {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }
                }, 10000);
            }
        });
    }
    
    // ============== PUBLISH FORM ==============
    if (publishForm) {
        publishForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Publikasi Pengumuman?',
                text: 'Pengumuman akan langsung tampil di homepage!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Publikasi!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-4',
                    confirmButton: 'px-4 py-2 rounded-3 fw-semibold',
                    cancelButton: 'px-4 py-2 rounded-3 fw-semibold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const btn = document.getElementById('publishBtn');
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mempublikasi...';
                    btn.disabled = true;
                    this.submit();
                }
            });
        });
    }
    
    // ============== UNPUBLISH FORM ==============
    if (unpublishForm) {
        unpublishForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Sembunyikan Pengumuman?',
                text: 'Pengumuman akan disembunyikan dari homepage!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f59e0b',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Sembunyikan!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-4',
                    confirmButton: 'px-4 py-2 rounded-3 fw-semibold',
                    cancelButton: 'px-4 py-2 rounded-3 fw-semibold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const btn = document.getElementById('unpublishBtn');
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Menyembunyikan...';
                    btn.disabled = true;
                    this.submit();
                }
            });
        });
    }
    
    // ============== TOOLTIP ==============
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // ============== SHAKE ANIMATION ==============
    const style = document.createElement('style');
    style.textContent = `
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
    `;
    document.head.appendChild(style);
});
</script>
@endpush