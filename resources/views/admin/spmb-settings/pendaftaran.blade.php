{{-- resources/views/admin/pengaturan-pendaftaran.blade.php --}}
@extends('layouts.admin')

@section('title', 'Pengaturan Pendaftaran SPMB - Admin')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
        --warning-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        --dark-gradient: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
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
        padding: 2.5rem;
    }
    
    .dashboard-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 520px;
        gap: 2.5rem;
        align-items: start;
    }
    
    @media (max-width: 1400px) {
        .dashboard-layout {
            grid-template-columns: 1fr;
        }
        
        .floating-preview {
            position: static !important;
        }
    }
    
    /* ==================== HERO HEADER ==================== */
    .hero-section {
        margin-bottom: 3rem;
        position: relative;
    }
    
    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.625rem;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        padding: 0.625rem 1.25rem;
        border-radius: 100px;
        font-weight: 600;
        font-size: 0.875rem;
        color: #4f46e5;
        border: 1px solid rgba(79, 70, 229, 0.15);
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 20px rgba(79, 70, 229, 0.08);
        animation: fadeInUp 0.6s ease-out;
    }
    
    .hero-badge i {
        font-size: 1rem;
    }
    
    .hero-content h1 {
        font-size: 3.25rem;
        font-weight: 900;
        color: #0f172a;
        line-height: 1.1;
        margin-bottom: 1rem;
        letter-spacing: -0.025em;
        background: linear-gradient(135deg, #0f172a 0%, #334155 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: fadeInUp 0.8s ease-out 0.1s both;
    }
    
    .hero-content p {
        font-size: 1.125rem;
        color: #64748b;
        line-height: 1.6;
        max-width: 700px;
        margin-bottom: 2rem;
        animation: fadeInUp 0.8s ease-out 0.2s both;
    }
    
    /* ==================== GLASS PANELS ==================== */
    .glass-panel {
        background: var(--glass-bg);
        backdrop-filter: blur(40px);
        border-radius: 32px;
        border: 1px solid var(--glass-border);
        box-shadow: var(--shadow-xl);
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        position: relative;
    }
    
    .glass-panel::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.4) 0%, rgba(255,255,255,0.1) 100%);
        border-radius: inherit;
        z-index: 0;
    }
    
    .glass-panel:hover {
        box-shadow: var(--shadow-2xl);
        transform: translateY(-4px);
    }
    
    .glass-panel-content {
        position: relative;
        z-index: 1;
        padding: 2.5rem;
    }
    
    .floating-preview {
        position: sticky;
        top: 2.5rem;
        height: fit-content;
    }
    
    /* ==================== PREMIUM FORM CONTROLS ==================== */
    .form-section {
        margin-bottom: 2.5rem;
    }
    
    .form-section-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.75rem;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid rgba(226, 232, 240, 0.6);
    }
    
    .section-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        color: #4f46e5;
        flex-shrink: 0;
    }
    
    .section-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1e293b;
        margin: 0;
    }
    
    .section-subtitle {
        font-size: 0.9375rem;
        color: #64748b;
        margin: 0.25rem 0 0;
    }
    
    .form-group-premium {
        margin-bottom: 2rem;
    }
    
    .form-label-premium {
        font-weight: 700;
        font-size: 0.875rem;
        color: #334155;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.625rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .form-label-premium i {
        color: #4f46e5;
        font-size: 1rem;
    }
    
    .input-wrapper {
        position: relative;
        transition: all 0.3s ease;
    }
    
    .input-wrapper:hover {
        transform: translateY(-1px);
    }
    
    .input-premium {
        width: 100%;
        padding: 1rem 1.25rem;
        padding-left: 3.5rem;
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        font-size: 0.9375rem;
        color: #1e293b;
        background: rgba(255, 255, 255, 0.9);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-weight: 500;
    }
    
    .input-premium:focus {
        outline: none;
        border-color: #4f46e5;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15);
        background: white;
        transform: translateY(-2px);
    }
    
    .input-premium:disabled {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        color: #94a3b8;
        cursor: not-allowed;
        border-color: #e2e8f0;
    }
    
    .input-icon-premium {
        position: absolute;
        left: 1.25rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 1.125rem;
        transition: all 0.3s ease;
        z-index: 2;
    }
    
    .input-wrapper:focus-within .input-icon-premium {
        color: #4f46e5;
        transform: translateY(-50%) scale(1.1);
    }
    
    .form-hint-premium {
        font-size: 0.8125rem;
        color: #64748b;
        margin-top: 0.625rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 0.75rem;
        background: rgba(241, 245, 249, 0.6);
        border-radius: 8px;
    }
    
    .form-hint-premium code {
        background: rgba(79, 70, 229, 0.1);
        color: #4f46e5;
        padding: 0.125rem 0.375rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    /* ==================== LIVE PREVIEW - DEVICE MOCKUP ==================== */
    .preview-device {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        border-radius: 40px;
        padding: 2.5rem;
        position: relative;
        overflow: hidden;
        border: 16px solid #0f172a;
        box-shadow: 
            inset 0 0 0 1px rgba(255, 255, 255, 0.1),
            0 40px 80px rgba(0, 0, 0, 0.25);
    }
    
    .preview-device::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.03) 1px, transparent 1px);
        background-size: 32px 32px;
        animation: float 20s linear infinite;
    }
    
    @keyframes float {
        0% { transform: translate(0, 0) rotate(0deg); }
        100% { transform: translate(-32px, -32px) rotate(360deg); }
    }
    
    .preview-header {
        text-align: center;
        margin-bottom: 2.5rem;
        position: relative;
    }
    
    .preview-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: white;
        margin: 0 0 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }
    
    .preview-subtitle {
        font-size: 0.9375rem;
        color: rgba(255, 255, 255, 0.7);
        margin: 0;
    }
    
    .preview-content {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }
    
    .preview-card {
        background: white;
        border-radius: 20px;
        padding: 1.75rem;
        margin-bottom: 1.5rem;
        border: 1px solid #f1f5f9;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .preview-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--primary-gradient);
    }
    
    .preview-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }
    
    .preview-card-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.25rem;
    }
    
    .preview-card-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        background: var(--primary-gradient);
        color: white;
        flex-shrink: 0;
    }
    
    .preview-card-title {
        font-size: 0.9375rem;
        font-weight: 800;
        color: #1e293b;
        margin: 0 0 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .preview-card-subtitle {
        font-size: 0.8125rem;
        color: #64748b;
        margin: 0;
    }
    
    .preview-timeline {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .timeline-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem;
        background: #f8fafc;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    
    .timeline-item:hover {
        background: #f1f5f9;
        transform: translateX(4px);
    }
    
    .timeline-icon {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        flex-shrink: 0;
    }
    
    .timeline-icon.start {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }
    
    .timeline-icon.end {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }
    
    .timeline-content {
        flex: 1;
    }
    
    .timeline-label {
        font-size: 0.75rem;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 0.125rem;
    }
    
    .timeline-value {
        font-size: 0.875rem;
        color: #1e293b;
        font-weight: 700;
    }
    
    .preview-button {
        width: 100%;
        padding: 1.25rem;
        border-radius: 18px;
        border: none;
        font-weight: 800;
        font-size: 1rem;
        letter-spacing: 0.02em;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        margin-top: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }
    
    .preview-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.7s ease;
    }
    
    .preview-button:hover::before {
        left: 100%;
    }
    
    .preview-button:hover {
        transform: translateY(-3px) scale(1.02);
    }
    
    .preview-button.active {
        background: var(--success-gradient);
        color: white;
        box-shadow: 0 15px 40px rgba(16, 185, 129, 0.4);
    }
    
    .preview-button.pending {
        background: var(--warning-gradient);
        color: white;
        box-shadow: 0 15px 40px rgba(245, 158, 11, 0.4);
    }
    
    .preview-button.closed {
        background: linear-gradient(135deg, #64748b 0%, #475569 100%);
        color: white;
        box-shadow: 0 15px 40px rgba(100, 116, 139, 0.4);
    }
    
    /* ==================== ACTION BAR ==================== */
    .action-bar-premium {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(40px);
        border-radius: 24px;
        padding: 1.75rem 2rem;
        border: 1px solid rgba(255, 255, 255, 0.8);
        box-shadow: 
            0 20px 60px rgba(0, 0, 0, 0.12),
            0 0 0 1px rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1.5rem;
        margin-top: 3rem;
        animation: slideUp 0.6s ease-out;
    }
    
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .btn-premium-nav {
        padding: 1rem 2rem;
        border-radius: 16px;
        font-weight: 700;
        font-size: 0.9375rem;
        border: 2px solid #e2e8f0;
        background: white;
        color: #475569;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .btn-premium-nav:hover {
        border-color: #c7d2fe;
        background: #f8fafc;
        color: #4f46e5;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(79, 70, 229, 0.1);
    }
    
    .btn-premium-primary {
        padding: 1rem 2.5rem;
        border-radius: 16px;
        font-weight: 700;
        font-size: 0.9375rem;
        border: none;
        background: var(--primary-gradient);
        color: white;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        position: relative;
        overflow: hidden;
    }
    
    .btn-premium-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.6s ease;
    }
    
    .btn-premium-primary:hover::before {
        left: 100%;
    }
    
    .btn-premium-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
    }
    
    .btn-group-premium {
        display: flex;
        gap: 1rem;
    }
    
    /* ==================== ANIMATIONS ==================== */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in {
        animation: fadeInUp 0.6s ease-out;
    }
    
    .animate-delay-1 {
        animation-delay: 0.1s;
    }
    
    .animate-delay-2 {
        animation-delay: 0.2s;
    }
    
    .animate-delay-3 {
        animation-delay: 0.3s;
    }
    
    /* ==================== RESPONSIVE ==================== */
    @media (max-width: 768px) {
        .admin-container {
            padding: 1.25rem;
        }
        
        .hero-content h1 {
            font-size: 2.5rem;
        }
        
        .glass-panel-content {
            padding: 1.75rem;
        }
        
        .preview-device {
            padding: 1.75rem;
            border-radius: 32px;
        }
        
        .action-bar-premium {
            flex-direction: column;
            padding: 1.5rem;
        }
        
        .btn-group-premium {
            width: 100%;
            flex-direction: column;
        }
        
        .btn-premium-nav,
        .btn-premium-primary {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="admin-container">
    <!-- Hero Header -->
    <div class="hero-section">
        <div class="hero-badge animate-fade-in">
            <i class="fas fa-cog"></i>
            <span>KONFIGURASI SISTEM</span>
        </div>
        
        <div class="hero-content">
            <h1>Pengaturan Pendaftaran SPMB</h1>
            <p>Atur jadwal, gelombang, dan kuota pendaftaran SPMB Jabar 2026/2027. Perubahan yang Anda buat akan langsung terlihat di halaman depan.</p>
            
            @if($setting->pendaftaran_mulai && $setting->pendaftaran_selesai)
            <div class="d-flex align-items-center gap-2" style="color: #64748b; font-size: 0.875rem;">
                <i class="far fa-calendar-alt"></i>
                <span>{{ date('d M Y', strtotime($setting->pendaftaran_mulai)) }} - {{ date('d M Y', strtotime($setting->pendaftaran_selesai)) }}</span>
            </div>
            @endif
        </div>
    </div>

    <!-- Main Dashboard Layout -->
    <div class="dashboard-layout">
        <!-- LEFT: Configuration Panel -->
        <div class="glass-panel animate-fade-in animate-delay-1">
            <div class="glass-panel-content">
                <!-- Form Section: General Settings -->
                <div class="form-section">
                    <div class="form-section-header">
                        <div class="section-icon">
                            <i class="fas fa-sliders-h"></i>
                        </div>
                        <div>
                            <h3 class="section-title">Konfigurasi Pendaftaran</h3>
                            <p class="section-subtitle">Atur parameter utama pendaftaran SPMB</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.spmb-settings.pendaftaran.update') }}" id="pendaftaranForm">
                        @csrf
                        @method('PUT')

                        <!-- Tahun Ajaran & Gelombang -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-premium">
                                    <label class="form-label-premium">
                                        <i class="fas fa-calendar-alt"></i>
                                        TAHUN AJARAN
                                    </label>
                                    <div class="input-wrapper">
                                        <input type="text" name="tahun_ajaran" class="input-premium" value="2026/2027" readonly>
                                        <i class="input-icon-premium fas fa-graduation-cap"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group-premium">
                                    <label class="form-label-premium" for="gelombang">
                                        <i class="fas fa-wave-square"></i>
                                        GELOMBANG
                                    </label>
                                    <div class="input-wrapper">
                                        <input type="number" class="input-premium" id="gelombang" name="gelombang" 
                                               value="{{ old('gelombang', $setting->gelombang) }}" min="1" max="5" required>
                                        <i class="input-icon-premium fas fa-hashtag"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Waktu Mulai & Selesai -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-premium">
                                    <label class="form-label-premium" for="pendaftaran_mulai">
                                        <i class="fas fa-play-circle"></i>
                                        WAKTU MULAI
                                    </label>
                                    <div class="input-wrapper">
                                        <input type="datetime-local" class="input-premium" id="pendaftaran_mulai" 
                                               name="pendaftaran_mulai" 
                                               value="{{ old('pendaftaran_mulai', $setting->pendaftaran_mulai ? date('Y-m-d\TH:i', strtotime($setting->pendaftaran_mulai)) : '') }}" 
                                               required>
                                        <i class="input-icon-premium far fa-calendar-plus"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group-premium">
                                    <label class="form-label-premium" for="pendaftaran_selesai">
                                        <i class="fas fa-stop-circle"></i>
                                        WAKTU SELESAI
                                    </label>
                                    <div class="input-wrapper">
                                        <input type="datetime-local" class="input-premium" id="pendaftaran_selesai" 
                                               name="pendaftaran_selesai" 
                                               value="{{ old('pendaftaran_selesai', $setting->pendaftaran_selesai ? date('Y-m-d\TH:i', strtotime($setting->pendaftaran_selesai)) : '') }}" 
                                               required>
                                        <i class="input-icon-premium far fa-calendar-minus"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Section: Kuota Jalur -->
                        <div class="form-section">
                            <div class="form-section-header">
                                <div class="section-icon" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); color: #059669;">
                                    <i class="fas fa-chart-pie"></i>
                                </div>
                                <div>
                                    <h3 class="section-title">Kuota Per Jalur</h3>
                                    <p class="section-subtitle">Atur persentase kuota untuk setiap jalur pendaftaran</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group-premium">
                                        <label class="form-label-premium" for="kuota_zonasi">
                                            <i class="fas fa-map-marker-alt"></i>
                                            ZONASI (%)
                                        </label>
                                        <div class="input-wrapper">
                                            <input type="number" class="input-premium" id="kuota_zonasi" 
                                                name="kuota_zonasi" 
                                                value="{{ old('kuota_zonasi', $setting->kuota_zonasi ?? 50) }}" 
                                                min="0" max="100" step="1" required>
                                            <i class="input-icon-premium fas fa-percent"></i>
                                        </div>
                                        <div class="form-hint-premium">
                                            <i class="fas fa-info-circle"></i>
                                            <span>Kuota untuk jalur <strong>Zonasi</strong>. Minimal 0%, maksimal 100%.</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group-premium">
                                        <label class="form-label-premium" for="kuota_afirmasi">
                                            <i class="fas fa-hand-holding-heart"></i>
                                            AFIRMASI (%)
                                        </label>
                                        <div class="input-wrapper">
                                            <input type="number" class="input-premium" id="kuota_afirmasi" 
                                                name="kuota_afirmasi" 
                                                value="{{ old('kuota_afirmasi', $setting->kuota_afirmasi ?? 15) }}" 
                                                min="0" max="100" step="1" required>
                                            <i class="input-icon-premium fas fa-percent"></i>
                                        </div>
                                        <div class="form-hint-premium">
                                            <i class="fas fa-info-circle"></i>
                                            <span>Kuota untuk jalur <strong>Afirmasi</strong>. Minimal 0%, maksimal 100%.</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group-premium">
                                        <label class="form-label-premium" for="kuota_prestasi">
                                            <i class="fas fa-trophy"></i>
                                            PRESTASI (%)
                                        </label>
                                        <div class="input-wrapper">
                                            <input type="number" class="input-premium" id="kuota_prestasi" 
                                                name="kuota_prestasi" 
                                                value="{{ old('kuota_prestasi', $setting->kuota_prestasi ?? 30) }}" 
                                                min="0" max="100" step="1" required>
                                            <i class="input-icon-premium fas fa-percent"></i>
                                        </div>
                                        <div class="form-hint-premium">
                                            <i class="fas fa-info-circle"></i>
                                            <span>Kuota untuk jalur <strong>Prestasi</strong>. Minimal 0%, maksimal 100%.</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group-premium">
                                        <label class="form-label-premium" for="kuota_mutasi">
                                            <i class="fas fa-exchange-alt"></i>
                                            MUTASI (%)
                                        </label>
                                        <div class="input-wrapper">
                                            <input type="number" class="input-premium" id="kuota_mutasi" 
                                                name="kuota_mutasi" 
                                                value="{{ old('kuota_mutasi', $setting->kuota_mutasi ?? 5) }}" 
                                                min="0" max="100" step="1" required>
                                            <i class="input-icon-premium fas fa-percent"></i>
                                        </div>
                                        <div class="form-hint-premium">
                                            <i class="fas fa-info-circle"></i>
                                            <span>Kuota untuk jalur <strong>Mutasi</strong>. Minimal 0%, maksimal 100%.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Total Kuota dengan Progress Bar --}}
                            @php
                                $totalKuota = ($setting->kuota_zonasi ?? 50) + 
                                            ($setting->kuota_afirmasi ?? 15) + 
                                            ($setting->kuota_prestasi ?? 30) + 
                                            ($setting->kuota_mutasi ?? 5);
                                $isValid = $totalKuota <= 100;
                            @endphp
                            <div class="mt-4 p-4 {{ $isValid ? 'bg-blue-50' : 'bg-red-50' }} rounded-xl">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-semibold {{ $isValid ? 'text-blue-700' : 'text-red-700' }}">
                                        <i class="fas {{ $isValid ? 'fa-check-circle' : 'fa-exclamation-triangle' }} mr-2"></i>
                                        TOTAL KUOTA: <span id="total-kuota">{{ $totalKuota }}</span>%
                                    </span>
                                    <span class="text-xs {{ $isValid ? 'text-blue-600' : 'text-red-600' }}">
                                        Maksimal 100%
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div id="progress-kuota" class="h-2.5 rounded-full transition-all duration-500 {{ $isValid ? 'bg-blue-600' : 'bg-red-600' }}" 
                                        style="width: {{ min($totalKuota, 100) }}%"></div>
                                </div>
                                @if(!$isValid)
                                    <p class="text-xs text-red-600 mt-2">
                                        <i class="fas fa-exclamation-circle"></i>
                                        Total kuota melebihi 100%! Harap kurangi beberapa jalur.
                                    </p>
                                @endif
                            </div>
                        </div>

                        <!-- Pesan Selesai -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group-premium">
                                    <label class="form-label-premium" for="pesan_selesai">
                                        <i class="fas fa-comment-alt"></i>
                                        PESAN SELESAI
                                    </label>
                                    <textarea class="input-premium" id="pesan_selesai" name="pesan_selesai" rows="3" 
                                              style="padding-left: 1.25rem; padding-top: 1rem;"
                                              placeholder="Contoh: 'Pendaftaran telah ditutup untuk tahun ajaran ini'">{{ old('pesan_selesai', $setting->pesan_selesai) }}
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Bar -->
    <div class="action-bar-premium animate-fade-in animate-delay-3">
        <a href="{{ route('admin.dashboard') }}" class="btn-premium-nav">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Dashboard
        </a>
        
        <div class="btn-group-premium">
            <button type="button" class="btn-premium-nav" onclick="document.getElementById('pendaftaranForm').reset()">
                <i class="fas fa-redo"></i>
                Reset Form
            </button>
            
            <button type="submit" form="pendaftaranForm" class="btn-premium-primary">
                <i class="fas fa-save"></i>
                Simpan Perubahan
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('pendaftaranForm');
    const mulaiInput = document.getElementById('pendaftaran_mulai');
    const selesaiInput = document.getElementById('pendaftaran_selesai');
    
    // ============== VALIDASI TANGGAL ==============
    function validateDates() {
        if (mulaiInput.value && selesaiInput.value) {
            const mulai = new Date(mulaiInput.value);
            const selesai = new Date(selesaiInput.value);
            
            if (selesai <= mulai) {
                selesaiInput.style.borderColor = '#ef4444';
                selesaiInput.style.boxShadow = '0 0 0 4px rgba(239, 68, 68, 0.15)';
                selesaiInput.setCustomValidity('Waktu selesai harus setelah waktu mulai');
                return false;
            } else {
                selesaiInput.style.borderColor = '#10b981';
                selesaiInput.style.boxShadow = '0 0 0 4px rgba(16, 185, 129, 0.15)';
                selesaiInput.setCustomValidity('');
                return true;
            }
        }
        return true;
    }
    
    // ============== INPUT ANIMATIONS ==============
    const inputs = document.querySelectorAll('.input-premium');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'translateY(-2px)';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'translateY(0)';
        });
    });
    
    // ============== DATE VALIDATION ==============
    if (mulaiInput) {
        mulaiInput.addEventListener('change', function() {
            validateDates();
            this.style.borderColor = '#4f46e5';
            this.style.boxShadow = '0 0 0 4px rgba(79, 70, 229, 0.15)';
        });
    }
    
    if (selesaiInput) {
        selesaiInput.addEventListener('change', function() {
            validateDates();
        });
    }
    
    // ============== VALIDASI KUOTA ==============
    const kuotaZonasi = document.getElementById('kuota_zonasi');
    const kuotaAfirmasi = document.getElementById('kuota_afirmasi');
    const kuotaPrestasi = document.getElementById('kuota_prestasi');
    const kuotaMutasi = document.getElementById('kuota_mutasi');
    const totalSpan = document.getElementById('total-kuota');
    const progressBar = document.getElementById('progress-kuota');
    
    // Fungsi menghitung total kuota
    function hitungTotalKuota() {
        // Ambil nilai, jika kosong atau NaN anggap 0
        const zonasi = parseInt(kuotaZonasi?.value) || 0;
        const afirmasi = parseInt(kuotaAfirmasi?.value) || 0;
        const prestasi = parseInt(kuotaPrestasi?.value) || 0;
        const mutasi = parseInt(kuotaMutasi?.value) || 0;
        
        const total = zonasi + afirmasi + prestasi + mutasi;
        
        // Update tampilan total
        if (totalSpan) {
            totalSpan.textContent = total;
        }
        
        // Update progress bar
        if (progressBar) {
            progressBar.style.width = Math.min(total, 100) + '%';
        }
        
        // Update warna berdasarkan validitas
        const container = totalSpan?.closest('.mt-4');
        if (container) {
            if (total > 100) {
                container.classList.remove('bg-blue-50');
                container.classList.add('bg-red-50');
                totalSpan?.classList.remove('text-blue-700');
                totalSpan?.classList.add('text-red-700');
                progressBar?.classList.remove('bg-blue-600');
                progressBar?.classList.add('bg-red-600');
            } else {
                container.classList.remove('bg-red-50');
                container.classList.add('bg-blue-50');
                totalSpan?.classList.remove('text-red-700');
                totalSpan?.classList.add('text-blue-700');
                progressBar?.classList.remove('bg-red-600');
                progressBar?.classList.add('bg-blue-600');
            }
        }
        
        return total;
    }
    
    // Event listener untuk setiap input kuota
    if (kuotaZonasi) {
        kuotaZonasi.addEventListener('input', hitungTotalKuota);
        // Validasi min/max
        kuotaZonasi.addEventListener('change', function() {
            let value = parseInt(this.value) || 0;
            if (value < 0) this.value = 0;
            if (value > 100) this.value = 100;
            hitungTotalKuota();
        });
    }
    
    if (kuotaAfirmasi) {
        kuotaAfirmasi.addEventListener('input', hitungTotalKuota);
        kuotaAfirmasi.addEventListener('change', function() {
            let value = parseInt(this.value) || 0;
            if (value < 0) this.value = 0;
            if (value > 100) this.value = 100;
            hitungTotalKuota();
        });
    }
    
    if (kuotaPrestasi) {
        kuotaPrestasi.addEventListener('input', hitungTotalKuota);
        kuotaPrestasi.addEventListener('change', function() {
            let value = parseInt(this.value) || 0;
            if (value < 0) this.value = 0;
            if (value > 100) this.value = 100;
            hitungTotalKuota();
        });
    }
    
    if (kuotaMutasi) {
        kuotaMutasi.addEventListener('input', hitungTotalKuota);
        kuotaMutasi.addEventListener('change', function() {
            let value = parseInt(this.value) || 0;
            if (value < 0) this.value = 0;
            if (value > 100) this.value = 100;
            hitungTotalKuota();
        });
    }
    
    // Hitung total saat halaman dimuat
    hitungTotalKuota();
    
    // ============== VALIDASI FORM SEBELUM SUBMIT ==============
    form.addEventListener('submit', function(e) {
        // Validasi tanggal
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
                confirmButtonColor: '#4f46e5',
                confirmButtonText: 'Mengerti',
                customClass: {
                    popup: 'rounded-3xl',
                    confirmButton: 'px-6 py-3 rounded-xl font-semibold'
                },
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            });
            return;
        }
        
        // Validasi total kuota
        const totalKuota = hitungTotalKuota();
        if (totalKuota > 100) {
            e.preventDefault();
            
            Swal.fire({
                icon: 'error',
                title: 'Validasi Kuota Gagal',
                text: 'Total kuota tidak boleh melebihi 100%! Saat ini: ' + totalKuota + '%',
                confirmButtonColor: '#4f46e5',
                confirmButtonText: 'Mengerti',
                customClass: {
                    popup: 'rounded-3xl',
                    confirmButton: 'px-6 py-3 rounded-xl font-semibold'
                },
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            });
            return;
        }
        
        // Jika lolos validasi, tampilkan loading
        const submitBtn = document.querySelector('[type="submit"]');
        if (submitBtn) {
            const originalHtml = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
            submitBtn.disabled = true;
        }
        
        // Add success animation
        form.style.transition = 'all 0.5s ease';
        form.style.boxShadow = '0 0 0 4px rgba(16, 185, 129, 0.3)';
        
        setTimeout(() => {
            form.style.boxShadow = '';
        }, 2000);
    });
    
    // Auto-validate on page load
    validateDates();
    
    // Add shake animation for CSS
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