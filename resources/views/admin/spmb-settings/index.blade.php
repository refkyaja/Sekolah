{{-- resources/views/admin/spmb-settings/index.blade.php --}}
{{-- HALAMAN UTAMA SETTING SPMB (PILIH MENU) --}}

@extends('layouts.admin')

@section('title', 'Setting SPMB')
@section('breadcrumb', 'Setting SPMB')

@push('styles')
<style>
    .countdown-box {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        border-radius: 16px;
        padding: 1.5rem;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .countdown-box::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
        background-size: 24px 24px;
        animation: floatBg 30s linear infinite;
    }
    
    @keyframes floatBg {
        0% { transform: translate(0, 0) rotate(0deg); }
        100% { transform: translate(-24px, -24px) rotate(360deg); }
    }
    
    .countdown-item {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(8px);
        border-radius: 12px;
        padding: 1rem;
        min-width: 100px;
        text-align: center;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .countdown-number {
        font-size: 2.5rem;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 0.25rem;
        font-feature-settings: "tnum";
    }
    
    .countdown-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: rgba(255, 255, 255, 0.8);
    }
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 100px;
        font-weight: 700;
        font-size: 1rem;
    }
    
    .status-open {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.25);
    }
    
    .status-closed {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        box-shadow: 0 10px 20px rgba(239, 68, 68, 0.25);
    }
    
    .status-waiting {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        box-shadow: 0 10px 20px rgba(245, 158, 11, 0.25);
    }
    
    .status-published {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        color: white;
        box-shadow: 0 10px 20px rgba(139, 92, 246, 0.25);
    }
    
    .period-card {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 1.5rem;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 p-4 md:p-6">
    <div class="max-w-7xl mx-auto">
        
        {{-- HEADER --}}
        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">⚙️ Setting SPMB</h1>
            <p class="text-gray-600 text-sm mt-1">
                Kelola pengaturan pendaftaran dan pengumuman SPMB
            </p>
        </div>

        {{-- INFO TAHUN AJARAN --}}
        <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-center">
                <i class="fas fa-info-circle text-blue-600 mr-3"></i>
                <div>
                    <p class="text-sm text-blue-800">
                        <span class="font-semibold">Tahun Ajaran Aktif:</span> 
                        {{ $tahunAjaran ?? '2026/2027' }}
                    </p>
                    <p class="text-xs text-blue-600 mt-0.5">
                        Pengaturan akan diterapkan untuk tahun ajaran ini
                    </p>
                </div>
            </div>
        </div>

        {{-- GRID MENU SETTINGS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            
            {{-- CARD 1: PENDAFTARAN --}}
            <a href="{{ route('admin.spmb-settings.pendaftaran') }}" 
               class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all group">
                <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center mb-4 group-hover:bg-blue-600 transition-colors">
                    <i class="fas fa-calendar-alt text-2xl text-blue-600 group-hover:text-white"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Pendaftaran</h3>
                <p class="text-sm text-gray-600 mb-4">
                    Atur jadwal pembukaan/penutupan dan kuota jalur pendaftaran
                </p>
                <span class="text-blue-600 text-sm font-medium group-hover:text-blue-800">
                    Atur Sekarang →
                </span>
            </a>

            {{-- CARD 2: PENGUMUMAN --}}
            <a href="{{ route('admin.spmb-settings.pengumuman') }}" 
               class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-all group">
                <div class="w-14 h-14 bg-purple-100 rounded-lg flex items-center justify-center mb-4 group-hover:bg-purple-600 transition-colors">
                    <i class="fas fa-bullhorn text-2xl text-purple-600 group-hover:text-white"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Pengumuman</h3>
                <p class="text-sm text-gray-600 mb-4">
                    Atur jadwal tampil pengumuman kelulusan di homepage
                </p>
                <span class="text-blue-600 text-sm font-medium group-hover:text-blue-800">
                    Atur Sekarang →
                </span>
            </a>

        </div>

        {{-- ============ SECTION 1: STATUS PENDAFTARAN ============ --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">📋 Status Pendaftaran</h3>
                            <p class="text-xs text-gray-600">Informasi real-time periode pendaftaran</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.spmb-settings.pendaftaran') }}" 
                       class="text-sm bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-pencil-alt mr-2"></i>
                        Ubah Jadwal
                    </a>
                </div>
            </div>
            
            <div class="p-6">
                @php
                    $now = \Carbon\Carbon::now();
                    $mulai = $setting->pendaftaran_mulai;
                    $selesai = $setting->pendaftaran_selesai;
                    
                    if ($mulai && $selesai) {
                        if ($now->between($mulai, $selesai)) {
                            $pendaftaran_status = 'open';
                            $pendaftaran_text = 'Pendaftaran Sedang Dibuka';
                            $pendaftaran_icon = 'fa-door-open';
                            $pendaftaran_class = 'status-open';
                            $pendaftaran_time_text = 'tersisa';
                        } elseif ($now->lt($mulai)) {
                            $pendaftaran_status = 'waiting';
                            $pendaftaran_text = 'Pendaftaran Akan Dibuka';
                            $pendaftaran_icon = 'fa-hourglass-half';
                            $pendaftaran_class = 'status-waiting';
                            $pendaftaran_time_text = 'menuju pembukaan';
                        } else {
                            $pendaftaran_status = 'closed';
                            $pendaftaran_text = 'Pendaftaran Telah Ditutup';
                            $pendaftaran_icon = 'fa-door-closed';
                            $pendaftaran_class = 'status-closed';
                            $pendaftaran_time_text = 'telah berakhir';
                        }
                    } else {
                        $pendaftaran_status = 'closed';
                        $pendaftaran_text = 'Jadwal Belum Diatur';
                        $pendaftaran_icon = 'fa-exclamation-triangle';
                        $pendaftaran_class = 'status-closed';
                        $pendaftaran_time_text = '';
                    }
                @endphp

                {{-- STATUS BADGE --}}
                <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                    <div class="status-badge {{ $pendaftaran_class }}">
                        <i class="fas {{ $pendaftaran_icon }}"></i>
                        <span>{{ $pendaftaran_text }}</span>
                    </div>
                    
                    @if($mulai && $selesai)
                        <div class="flex items-center gap-2 text-sm bg-gray-100 px-4 py-2 rounded-full">
                            <i class="far fa-calendar-alt text-gray-600"></i>
                            <span class="font-medium text-gray-700">
                                {{ $mulai->translatedFormat('d M Y H:i') }} WIB
                            </span>
                            <i class="fas fa-arrow-right text-gray-400 mx-1"></i>
                            <span class="font-medium text-gray-700">
                                {{ $selesai->translatedFormat('d M Y H:i') }} WIB
                            </span>
                        </div>
                    @else
                        <div class="text-sm text-gray-500 bg-gray-100 px-4 py-2 rounded-full">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            Jadwal belum diatur
                        </div>
                    @endif
                </div>

                {{-- COUNTDOWN PENDAFTARAN --}}
                @if($mulai && $selesai && $pendaftaran_status != 'closed')
                <div class="countdown-box mt-4" id="pendaftaran-countdown">
                    <div class="relative z-10">
                        <div class="flex flex-wrap items-end justify-between gap-4 mb-4">
                            <div>
                                <p class="text-sm text-white/80 mb-1">
                                    <i class="fas fa-hourglass-half mr-2"></i>
                                    Waktu {{ $pendaftaran_time_text }}
                                </p>
                                <div class="flex flex-wrap gap-4">
                                    <div class="countdown-item" id="pendaftaran-days">
                                        <div class="countdown-number" id="pendaftaran-days-num">0</div>
                                        <div class="countdown-label">Hari</div>
                                    </div>
                                    <div class="countdown-item" id="pendaftaran-hours">
                                        <div class="countdown-number" id="pendaftaran-hours-num">00</div>
                                        <div class="countdown-label">Jam</div>
                                    </div>
                                    <div class="countdown-item" id="pendaftaran-minutes">
                                        <div class="countdown-number" id="pendaftaran-minutes-num">00</div>
                                        <div class="countdown-label">Menit</div>
                                    </div>
                                    <div class="countdown-item" id="pendaftaran-seconds">
                                        <div class="countdown-number" id="pendaftaran-seconds-num">00</div>
                                        <div class="countdown-label">Detik</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @elseif($mulai && $selesai && $pendaftaran_status == 'closed')
                <div class="mt-4 p-6 bg-gradient-to-r from-red-50 to-orange-50 rounded-xl border border-red-200">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar-times text-red-600 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">Pendaftaran Telah Berakhir</h4>
                            <p class="text-sm text-gray-600">
                                Periode pendaftaran telah selesai pada {{ $selesai->translatedFormat('d F Y H:i') }} WIB
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- ============ SECTION 2: STATUS PENGUMUMAN ============ --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-bullhorn text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">📢 Status Pengumuman</h3>
                            <p class="text-xs text-gray-600">Informasi real-time jadwal pengumuman kelulusan</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.spmb-settings.pengumuman') }}" 
                       class="text-sm bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-pencil-alt mr-2"></i>
                        Ubah Jadwal
                    </a>
                </div>
            </div>
            
            <div class="p-6">
                @php
                    $pengumuman_mulai = $setting->pengumuman_mulai;
                    $pengumuman_selesai = $setting->pengumuman_selesai;
                    
                    if ($pengumuman_mulai && $pengumuman_selesai) {
                        if ($now->between($pengumuman_mulai, $pengumuman_selesai)) {
                            $pengumuman_status = 'published';
                            $pengumuman_text = 'Pengumuman Sedang Ditampilkan';
                            $pengumuman_icon = 'fa-eye';
                            $pengumuman_class = 'status-published';
                            $pengumuman_time_text = 'tersisa';
                        } elseif ($now->lt($pengumuman_mulai)) {
                            $pengumuman_status = 'waiting';
                            $pengumuman_text = 'Pengumuman Akan Ditampilkan';
                            $pengumuman_icon = 'fa-hourglass-half';
                            $pengumuman_class = 'status-waiting';
                            $pengumuman_time_text = 'menuju penayangan';
                        } else {
                            $pengumuman_status = 'closed';
                            $pengumuman_text = 'Pengumuman Telah Berakhir';
                            $pengumuman_icon = 'fa-eye-slash';
                            $pengumuman_class = 'status-closed';
                            $pengumuman_time_text = 'telah berakhir';
                        }
                    } else {
                        $pengumuman_status = 'closed';
                        $pengumuman_text = 'Jadwal Belum Diatur';
                        $pengumuman_icon = 'fa-exclamation-triangle';
                        $pengumuman_class = 'status-closed';
                        $pengumuman_time_text = '';
                    }
                @endphp

                {{-- STATUS BADGE --}}
                <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                    <div class="status-badge {{ $pengumuman_class }}">
                        <i class="fas {{ $pengumuman_icon }}"></i>
                        <span>{{ $pengumuman_text }}</span>
                    </div>
                    
                    @if($pengumuman_mulai && $pengumuman_selesai)
                        <div class="flex items-center gap-2 text-sm bg-gray-100 px-4 py-2 rounded-full">
                            <i class="far fa-calendar-alt text-gray-600"></i>
                            <span class="font-medium text-gray-700">
                                {{ $pengumuman_mulai->translatedFormat('d M Y H:i') }} WIB
                            </span>
                            <i class="fas fa-arrow-right text-gray-400 mx-1"></i>
                            <span class="font-medium text-gray-700">
                                {{ $pengumuman_selesai->translatedFormat('d M Y H:i') }} WIB
                            </span>
                        </div>
                    @else
                        <div class="text-sm text-gray-500 bg-gray-100 px-4 py-2 rounded-full">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            Jadwal belum diatur
                        </div>
                    @endif
                </div>

                {{-- COUNTDOWN PENGUMUMAN --}}
                @if($pengumuman_mulai && $pengumuman_selesai && $pengumuman_status != 'closed')
                <div class="countdown-box mt-4" style="background: linear-gradient(135deg, #6d28d9 0%, #5b21b6 100%);" id="pengumuman-countdown">
                    <div class="relative z-10">
                        <div class="flex flex-wrap items-end justify-between gap-4 mb-4">
                            <div>
                                <p class="text-sm text-white/80 mb-1">
                                    <i class="fas fa-hourglass-half mr-2"></i>
                                    Waktu {{ $pengumuman_time_text }}
                                </p>
                                <div class="flex flex-wrap gap-4">
                                    <div class="countdown-item" id="pengumuman-days">
                                        <div class="countdown-number" id="pengumuman-days-num">0</div>
                                        <div class="countdown-label">Hari</div>
                                    </div>
                                    <div class="countdown-item" id="pengumuman-hours">
                                        <div class="countdown-number" id="pengumuman-hours-num">00</div>
                                        <div class="countdown-label">Jam</div>
                                    </div>
                                    <div class="countdown-item" id="pengumuman-minutes">
                                        <div class="countdown-number" id="pengumuman-minutes-num">00</div>
                                        <div class="countdown-label">Menit</div>
                                    </div>
                                    <div class="countdown-item" id="pengumuman-seconds">
                                        <div class="countdown-number" id="pengumuman-seconds-num">00</div>
                                        <div class="countdown-label">Detik</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @elseif($pengumuman_mulai && $pengumuman_selesai && $pengumuman_status == 'closed')
                <div class="mt-4 p-6 bg-gradient-to-r from-red-50 to-orange-50 rounded-xl border border-red-200">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar-times text-red-600 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">Pengumuman Telah Berakhir</h4>
                            <p class="text-sm text-gray-600">
                                Periode pengumuman telah selesai pada {{ $pengumuman_selesai->translatedFormat('d F Y H:i') }} WIB
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const now = new Date().getTime();
    
    // ============ COUNTDOWN PENDAFTARAN ============
    @if($mulai && $selesai && $pendaftaran_status != 'closed')
    const pendaftaranTarget = @json($pendaftaran_status == 'open' ? $selesai : $mulai);
    const pendaftaranDate = new Date(pendaftaranTarget).getTime();
    
    function updatePendaftaranCountdown() {
        const now = new Date().getTime();
        const distance = pendaftaranDate - now;
        
        if (distance < 0) {
            location.reload();
            return;
        }
        
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        document.getElementById('pendaftaran-days-num').textContent = days;
        document.getElementById('pendaftaran-hours-num').textContent = hours.toString().padStart(2, '0');
        document.getElementById('pendaftaran-minutes-num').textContent = minutes.toString().padStart(2, '0');
        document.getElementById('pendaftaran-seconds-num').textContent = seconds.toString().padStart(2, '0');
    }
    
    updatePendaftaranCountdown();
    setInterval(updatePendaftaranCountdown, 1000);
    @endif
    
    // ============ COUNTDOWN PENGUMUMAN ============
    @if($pengumuman_mulai && $pengumuman_selesai && $pengumuman_status != 'closed')
    const pengumumanTarget = @json($pengumuman_status == 'published' ? $pengumuman_selesai : $pengumuman_mulai);
    const pengumumanDate = new Date(pengumumanTarget).getTime();
    
    function updatePengumumanCountdown() {
        const now = new Date().getTime();
        const distance = pengumumanDate - now;
        
        if (distance < 0) {
            location.reload();
            return;
        }
        
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        document.getElementById('pengumuman-days-num').textContent = days;
        document.getElementById('pengumuman-hours-num').textContent = hours.toString().padStart(2, '0');
        document.getElementById('pengumuman-minutes-num').textContent = minutes.toString().padStart(2, '0');
        document.getElementById('pengumuman-seconds-num').textContent = seconds.toString().padStart(2, '0');
    }
    
    updatePengumumanCountdown();
    setInterval(updatePengumumanCountdown, 1000);
    @endif
});
</script>
@endpush