@php
    $role = auth()->user()->role;
    $user = auth()->user();
    $layout = match ($role) {
        'admin' => 'layouts.admin',
        'operator' => 'layouts.operator',
        'kepala_sekolah' => 'layouts.kepala-sekolah',
        'guru' => 'layouts.guru',
        default => 'layouts.app',
    };
    $routePrefix = match ($role) {
        'admin' => 'admin',
        'operator' => 'operator',
        'kepala_sekolah' => 'kepala-sekolah',
        'guru' => 'guru',
        default => 'admin',
    };
    $readOnly = $readOnly ?? false;
    $canUpdatePpdb = $user->canAccessModule('ppdb', 'update') && !$readOnly;
    $canAddCatatan = $canUpdatePpdb && \Illuminate\Support\Facades\Route::has($routePrefix . '.ppdb.catatan');
    $canVerifyDokumen = $canUpdatePpdb && \Illuminate\Support\Facades\Route::has($routePrefix . '.ppdb.verifikasiDokumen');
@endphp

@extends($layout)

@push('styles')
<style>
    .sidebar-scroll::-webkit-scrollbar {
        width: 4px;
    }
    .sidebar-scroll::-webkit-scrollbar-track {
        background: transparent;
    }
    .sidebar-scroll::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
    }
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    #sidebar-toggle:checked ~ aside {
        width: 80px;
    }
    #sidebar-toggle:checked ~ aside .logo-text,
    #sidebar-toggle:checked ~ aside .nav-text,
    #sidebar-toggle:checked ~ aside .nav-section-title,
    #sidebar-toggle:checked ~ aside .system-status {
        display: none;
    }
    #sidebar-toggle:checked ~ aside .nav-item {
        justify-content: center;
        padding-left: 0;
        padding-right: 0;
    }
    #sidebar-toggle:checked ~ aside .nav-section-divider {
        display: block;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        margin: 1rem 0.5rem;
    }
    .nav-section-divider {
        display: none;
    }
    aside {
        transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Desktop layout */
    .desktop-grid {
        display: none;
    }
    
    .mobile-layout {
        display: block;
    }
    
    @media (min-width: 1024px) {
        .desktop-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }
        
        .mobile-layout {
            display: none;
        }
    }

    /* Mobile order */
    @media (max-width: 1023px) {
        .mobile-order-1 { order: 1; } /* Data Pendaftaran */
        .mobile-order-2 { order: 2; } /* Identitas Anak */
        .mobile-order-3 { order: 3; } /* Alamat Lengkap */
        .mobile-order-4 { order: 4; } /* Data Orang Tua */
        .mobile-order-5 { order: 5; } /* Dokumen Terlampir */
        .mobile-order-6 { order: 6; } /* Catatan Pendaftaran */
        .mobile-order-7 { order: 7; } /* Status Information */
    }

    /* Fix modal positioning */
    .fixed {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 9999;
    }
    
    #catatanModal, #dokumenModal {
        display: none;
        align-items: center;
        justify-content: center;
    }
    
    #catatanModal.flex, #dokumenModal.flex {
        display: flex;
    }
    
    /* Ensure modal content is centered and not cut off */
    #catatanModal > div, #dokumenModal > div {
        max-height: 90vh;
        overflow-y: auto;
        margin: 1rem;
        width: 100%;
    }
    
    #catatanModal > div {
        max-width: 28rem; /* 448px - md */
    }
    
    #dokumenModal > div {
        max-width: 64rem; /* 1024px - 4xl */
    }
</style>
@endpush

@section('content')
<nav aria-label="Breadcrumb" class="flex mb-4 text-xs font-medium text-slate-400 dark:text-slate-500 uppercase tracking-widest">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li><a class="hover:text-primary" href="{{ route($routePrefix . '.ppdb.index') }}">PPDB</a></li>
        <li><span class="mx-2">/</span></li>
        <li><a class="hover:text-primary" href="{{ route($routePrefix . '.ppdb.index') }}">Pendaftaran</a></li>
        <li><span class="mx-2">/</span></li>
        <li class="text-slate-600 dark:text-slate-400">Detail Pendaftaran</li>
    </ol>
</nav>

@php
$statusBadge = '';
$statusText = $spmb->status_pendaftaran ?? 'Menunggu Verifikasi';
switch($statusText) {
    case 'Lulus':
        $statusBadge = 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400';
        $statusLabel = 'LULUS';
        break;
    case 'Tidak Lulus':
        $statusBadge = 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400';
        $statusLabel = 'TIDAK LULUS';
        break;
    case 'Dokumen Verified':
        $statusBadge = 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400';
        $statusLabel = 'DOKUMEN VERIFIED';
        break;
    case 'Revisi Dokumen':
        $statusBadge = 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400';
        $statusLabel = 'REVISI DOKUMEN';
        break;
    default:
        $statusBadge = 'bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400';
        $statusLabel = 'MENUNGGU VERIFIKASI';
}
@endphp

@if($spmb->catatan_admin)
<div class="bg-amber-50 dark:bg-amber-900/10 border border-amber-200 rounded-2xl p-6 mb-8">
    <div class="flex items-start gap-4">
        <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-xl flex items-center justify-center flex-shrink-0">
            <span class="material-symbols-outlined text-amber-600 dark:text-amber-500">info</span>
        </div>
        <div class="flex-1">
            <h4 class="font-bold text-slate-800 dark:text-slate-100 mb-1">Catatan untuk Siswa</h4>
            <p class="text-slate-600 dark:text-slate-400 text-sm">{{ $spmb->catatan_admin }}</p>
        </div>
    </div>
</div>
@endif

@php
    $catatanTimeline = $spmb->riwayatStatus
        ? $spmb->riwayatStatus
            ->filter(fn($riwayat) => filled($riwayat->keterangan))
            ->sortByDesc('created_at')
            ->values()
        : collect();
    $catatanUtama = $catatanTimeline->take(5);
    $catatanLainnya = $catatanTimeline->slice(5)->values();
@endphp

<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div class="flex items-center gap-4">
        <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center overflow-hidden">
            @if($spmb->foto_calon_siswa)
                <img src="{{ asset('storage/' . $spmb->foto_calon_siswa) }}" alt="Foto" class="w-full h-full object-cover">
            @else
                <span class="material-symbols-outlined text-primary text-3xl">account_circle</span>
            @endif
        </div>
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100 tracking-tight">{{ $spmb->nama_lengkap_anak ?? '-' }}</h1>
                <span class="inline-flex items-center px-4 py-1 rounded-full text-xs font-bold {{ $statusBadge }} uppercase tracking-widest">{{ $statusLabel }}</span>
            </div>
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mt-1 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">confirmation_number</span>
                {{ $spmb->no_pendaftaran ?? '-' }}
            </p>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route($routePrefix . '.ppdb.index') }}" class="flex items-center gap-2 px-6 py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-400 rounded-xl font-bold text-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            Kembali
        </a>
        <button onclick="window.print()" class="flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-xl font-bold text-sm hover:bg-primary/90 transition-all shadow-lg shadow-primary/25">
            <span class="material-symbols-outlined text-lg">print</span>
            Cetak Bukti
        </button>
    </div>
</div>

<!-- DESKTOP VERSION (2 Columns) -->
<div class="desktop-grid">
    <!-- Left Column -->
    <div class="space-y-8">
        <!-- Data Pendaftaran -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-800/50 flex items-center gap-3">
                <span class="material-symbols-outlined text-primary">app_registration</span>
                <h3 class="font-bold text-slate-800 dark:text-slate-100">Data Pendaftaran</h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Kode Pendaftaran</p>
                    <p class="text-sm font-bold text-primary">{{ $spmb->no_pendaftaran ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Tanggal Daftar</p>
                    <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->created_at ? $spmb->created_at->format('d M Y, H:i') : '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Status</p>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-bold {{ $statusBadge }} uppercase tracking-wider">{{ $statusLabel }}</span>
                </div>
            </div>
        </div>

        <!-- Identitas Anak -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-800/50 flex items-center gap-3">
                <span class="material-symbols-outlined text-primary">child_care</span>
                <h3 class="font-bold text-slate-800 dark:text-slate-100">Identitas Anak</h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-12">
                <div>
                    <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">NIK</p>
                    <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->nik_anak ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Nama Lengkap</p>
                    <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->nama_lengkap_anak ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Nama Panggilan</p>
                    <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->nama_panggilan_anak ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Tempat, Tanggal Lahir</p>
                    <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->tempat_lahir_anak ?? '-' }}, {{ $spmb->tanggal_lahir_anak ? \Carbon\Carbon::parse($spmb->tanggal_lahir_anak)->format('d M Y') : '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Umur</p>
                    <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->usia }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Jenis Kelamin</p>
                    <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->jenis_kelamin ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Agama</p>
                    <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->agama ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Alamat Lengkap -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-800/50 flex items-center gap-3">
                <span class="material-symbols-outlined text-primary">location_on</span>
                <h3 class="font-bold text-slate-800 dark:text-slate-100">Alamat Lengkap</h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-12">
                <div class="md:col-span-2">
                    <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Alamat Lengkap</p>
                    <p class="text-sm font-semibold text-slate-700 dark:text-slate-300 leading-relaxed">{{ $spmb->nama_jalan_rumah ?? '-' }}, RT {{ $spmb->rt ?? '-' }} RW {{ $spmb->rw ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Provinsi</p>
                    <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->provinsi_rumah ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Kota/Kabupaten</p>
                    <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->kota_kabupaten_rumah ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Kecamatan</p>
                    <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->kecamatan_rumah ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Kelurahan</p>
                    <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->kelurahan_rumah ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Catatan Pendaftaran -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-800/50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">history_edu</span>
                    <h3 class="font-bold text-slate-800 dark:text-slate-100">Catatan Pendaftaran</h3>
                </div>
                @if($canAddCatatan)
                    <button onclick="openCatatanModal()" class="flex items-center gap-1.5 px-3 py-1.5 bg-lavender/40 text-primary rounded-lg text-xs font-bold hover:bg-lavender/60 transition-all">
                        <span class="material-symbols-outlined text-sm">add</span>
                        Tambah Catatan
                    </button>
                @endif
            </div>
            <div class="p-6">
                @if($catatanTimeline->count() > 0)
                <div class="relative pl-8 space-y-8 before:content-[''] before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-[2px] before:bg-slate-100">
                    @foreach($catatanUtama as $riwayat)
                    <div class="relative">
                        <div class="absolute -left-[29px] top-1 w-5 h-5 rounded-full {{ $loop->first ? 'bg-slate-900' : 'bg-white dark:bg-slate-800' }} {{ $loop->first ? 'border-4 border-slate-200 dark:border-slate-600' : 'border-2 border-slate-300' }} shadow-sm z-10"></div>
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center justify-between">
                                <h4 class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ $riwayat->status_baru ?? 'Pendaftaran Baru' }}</h4>
                                <span class="text-[10px] font-medium text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ $riwayat->created_at ? $riwayat->created_at->format('d M Y, H:i') : '-' }}</span>
                            </div>
                            <div class="bg-slate-50 dark:bg-slate-900 rounded-xl p-4 border border-slate-100 dark:border-slate-700">
                                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">{{ $riwayat->keterangan ?? 'Tidak ada keterangan' }}</p>
                            </div>
                            @if($riwayat->user)
                            <div class="flex items-center gap-2">
                                <div class="w-5 h-5 rounded-full bg-primary/10 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[12px] text-primary">person</span>
                                </div>
                                <p class="text-[10px] font-bold text-slate-500 dark:text-slate-400">{{ $riwayat->user->name ?? 'Admin' }} ({{ $riwayat->role_pengubah ?? 'admin' }})</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @if($catatanLainnya->count() > 0)
                <details class="mt-6 rounded-2xl border border-slate-200 dark:border-slate-600 bg-slate-50/80 p-4">
                    <summary class="cursor-pointer list-none text-sm font-bold text-slate-700 dark:text-slate-300">
                        Lainnya
                        <span class="ml-2 text-xs font-medium text-slate-400 dark:text-slate-500">({{ $catatanLainnya->count() }} catatan lama)</span>
                    </summary>
                    <div class="relative mt-4 pl-8 space-y-8 before:content-[''] before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-[2px] before:bg-slate-100">
                        @foreach($catatanLainnya as $riwayat)
                        <div class="relative">
                            <div class="absolute -left-[29px] top-1 w-5 h-5 rounded-full bg-white dark:bg-slate-800 border-2 border-slate-300 shadow-sm z-10"></div>
                            <div class="flex flex-col gap-2">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ $riwayat->status_baru ?? 'Pendaftaran Baru' }}</h4>
                                    <span class="text-[10px] font-medium text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ $riwayat->created_at ? $riwayat->created_at->format('d M Y, H:i') : '-' }}</span>
                                </div>
                                <div class="bg-white dark:bg-slate-800 rounded-xl p-4 border border-slate-100 dark:border-slate-700">
                                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">{{ $riwayat->keterangan ?? 'Tidak ada keterangan' }}</p>
                                </div>
                                @if($riwayat->user)
                                <div class="flex items-center gap-2">
                                    <div class="w-5 h-5 rounded-full bg-primary/10 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-[12px] text-primary">person</span>
                                    </div>
                                    <p class="text-[10px] font-bold text-slate-500 dark:text-slate-400">{{ $riwayat->user->name ?? 'Admin' }} ({{ $riwayat->role_pengubah ?? 'admin' }})</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </details>
                @endif
                @else
                <div class="text-center py-8">
                    <span class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-600 mb-2">history</span>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Belum ada riwayat catatan</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="space-y-8">
        <!-- Data Orang Tua -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-800/50 flex items-center gap-3">
                <span class="material-symbols-outlined text-primary">family_restroom</span>
                <h3 class="font-bold text-slate-800 dark:text-slate-100">Data Orang Tua</h3>
            </div>
            <div class="p-6 space-y-8">
                <!-- Data Ayah -->
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1.5 h-4 bg-primary rounded-full"></div>
                        <h4 class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Data Ayah</h4>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Nama Ayah</p>
                            <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->nama_lengkap_ayah ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">NIK Ayah</p>
                            <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->nik_ayah ?? '-' }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Pekerjaan</p>
                                <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->pekerjaan_ayah ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">No HP</p>
                                <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->nomor_telepon_ayah ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Ibu -->
                <div class="pt-6 border-t border-slate-100 dark:border-slate-700">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1.5 h-4 bg-pink-500 rounded-full"></div>
                        <h4 class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Data Ibu</h4>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Nama Ibu</p>
                            <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->nama_lengkap_ibu ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">NIK Ibu</p>
                            <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->nik_ibu ?? '-' }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Pekerjaan</p>
                                <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->pekerjaan_ibu ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">No HP</p>
                                <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->nomor_telepon_ibu ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dokumen Terlampir -->
        <div id="section-dokumen" class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-800/50">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary">description</span>
                        <h3 class="font-bold text-slate-800 dark:text-slate-100">Dokumen Terlampir</h3>
                    </div>
                    
                    @php
                    $allVerified = ($spmb->verifikasi_akte ?? false) && ($spmb->verifikasi_kk ?? false) && ($spmb->verifikasi_ktp ?? false) && ($spmb->verifikasi_bukti_transfer ?? false);
                    @endphp
                    @if($allVerified)
                    <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-bold rounded-full flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">check_circle</span>
                        Lengkap
                    </span>
                    @else
                    <span class="px-3 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-xs font-bold rounded-full flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">hourglass_empty</span>
                        Belum Lengkap
                    </span>
                    @endif
                </div>
                
                @php
                $progress = $spmb->progress_verifikasi;
                @endphp
                <div class="flex items-center gap-3 mt-1">
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400 whitespace-nowrap">{{ $progress['terverifikasi'] }}/{{ $progress['total'] }} Dokumen Terverifikasi</span>
                    <div class="flex-1 h-2 bg-slate-200 rounded-full overflow-hidden max-w-xs">
                        <div class="h-full bg-primary transition-all" style="width: {{ $progress['persentase'] }}%"></div>
                    </div>
                </div>
            </div>
            
            <div class="p-4 space-y-2">
                @php
                $docTypes = [
                    'akte_kelahiran' => ['label' => 'Akta Kelahiran', 'icon' => 'article'],
                    'kartu_keluarga' => ['label' => 'Kartu Keluarga', 'icon' => 'group'],
                    'ktp_orang_tua' => ['label' => 'KTP Orang Tua', 'icon' => 'badge'],
                    'bukti_pembayaran' => ['label' => 'Bukti Pembayaran', 'icon' => 'receipt_long']
                ];
                @endphp
                
                @foreach($docTypes as $key => $doc)
                @php
                $docData = $spmb->dokumen->firstWhere('jenis_dokumen', $key);
                $hasUploadedDoc = $docData && filled($docData->path_file);
                $verifiedField = 'verifikasi_' . ($key === 'akte_kelahiran' ? 'akte' : ($key === 'kartu_keluarga' ? 'kk' : ($key === 'ktp_orang_tua' ? 'ktp' : 'bukti_transfer')));
                $isVerified = $spmb->$verifiedField ?? false;
                
                $fileName = $docData->nama_file ?? 'Belum diupload';
                $displayName = strlen($fileName) > 20 ? substr($fileName, 0, 17) . '...' : $fileName;
                $catatanDoc = $docData->keterangan ?? null;
                @endphp
                <div class="p-3 bg-slate-50 dark:bg-slate-900 rounded-xl border {{ $isVerified ? 'border-green-200' : ($catatanDoc ? 'border-amber-200' : 'border-slate-200 dark:border-slate-600') }} transition-all">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            <div class="w-10 h-10 {{ $isVerified ? 'bg-green-100 dark:bg-green-900/30' : 'bg-slate-200' }} rounded-xl flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined {{ $isVerified ? 'text-green-600 dark:text-green-500' : 'text-slate-500 dark:text-slate-400' }} text-xl">{{ $doc['icon'] }}</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-bold text-slate-800 dark:text-slate-100 truncate">{{ $doc['label'] }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ $displayName }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 ml-2 flex-shrink-0">
                            @if($isVerified)
                                <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-[10px] font-bold rounded-full flex items-center gap-1 whitespace-nowrap">
                                    <span class="material-symbols-outlined text-xs">check_circle</span>
                                    Verified
                                </span>
                            @elseif($catatanDoc)
                                <span class="px-2 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-[10px] font-bold rounded-full flex items-center gap-1 whitespace-nowrap">
                                    <span class="material-symbols-outlined text-xs">edit_note</span>
                                    Butuh Revisi
                                </span>
                            @else
                                <span class="px-2 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-[10px] font-bold rounded-full flex items-center gap-1 whitespace-nowrap">
                                    <span class="material-symbols-outlined text-xs">hourglass_empty</span>
                                    Pending
                                </span>
                            @endif
                            
                            @if($hasUploadedDoc)
                            <button type="button" onclick="openDokumenModal('{{ asset('storage/' . $docData->path_file) }}')" class="p-1.5 bg-white dark:bg-slate-800 text-primary rounded-lg border border-primary/20 hover:bg-primary hover:text-white transition-all" title="Lihat Dokumen">
                                <span class="material-symbols-outlined text-sm">visibility</span>
                            </button>
                            @endif
                            
                            @if($canVerifyDokumen)
                                @if($isVerified)
                                    <form action="{{ route($routePrefix . '.ppdb.verifikasiDokumen', $spmb) }}" method="POST" class="inline" onsubmit="return confirm('Batalkan verifikasi dokumen {{ $doc['label'] }}? Status akan dikembalikan ke Pending.');">
                                        @csrf
                                        <input type="hidden" name="jenis" value="{{ $key }}">
                                        <input type="hidden" name="action" value="unverify">
                                        <button type="submit" class="p-1.5 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-all" title="Batalkan Verifikasi">
                                            <span class="material-symbols-outlined text-sm">undo</span>
                                        </button>
                                    </form>
                                @else
                                    @if($hasUploadedDoc)
                                        <div class="flex gap-1">
                                            <form action="{{ route($routePrefix . '.ppdb.verifikasiDokumen', $spmb) }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="jenis" value="{{ $key }}">
                                                <input type="hidden" name="action" value="verify">
                                                <button type="submit" class="p-1.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all" title="Verifikasi Dokumen">
                                                    <span class="material-symbols-outlined text-sm">check</span>
                                                </button>
                                            </form>
                                            <button type="button" onclick="openRevisiModal('{{ $key }}', '{{ $doc['label'] }}', '{{ $catatanDoc }}')" class="p-1.5 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-all" title="Minta Revisi">
                                                <span class="material-symbols-outlined text-sm">edit_note</span>
                                            </button>
                                        </div>
                                    @else
                                        <button type="button" disabled class="p-1.5 bg-slate-200 text-slate-400 dark:text-slate-500 rounded-lg cursor-not-allowed" title="Dokumen belum diupload">
                                            <span class="material-symbols-outlined text-sm">check</span>
                                        </button>
                                    @endif
                                @endif
                            @endif
                        </div>
                    </div>
                    @if($catatanDoc)
                    <div class="mt-2 text-[11px] bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-400 p-2 rounded-lg border border-amber-100 dark:border-amber-900/30 flex items-start gap-1.5">
                        <span class="material-symbols-outlined text-xs mt-0.5">info</span>
                        <p><span class="font-bold uppercase tracking-wider text-[9px] mr-1">Catatan Admin:</span> {{ $catatanDoc }}</p>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- MOBILE VERSION (Single Column with Custom Order) -->
<div class="mobile-layout space-y-8">
    <!-- Data Pendaftaran - Order 1 -->
    <div class="mobile-order-1 bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-800/50 flex items-center gap-3">
            <span class="material-symbols-outlined text-primary">app_registration</span>
            <h3 class="font-bold text-slate-800 dark:text-slate-100">Data Pendaftaran</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Kode Pendaftaran</p>
                <p class="text-sm font-bold text-primary">{{ $spmb->no_pendaftaran ?? '-' }}</p>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Tanggal Daftar</p>
                <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->created_at ? $spmb->created_at->format('d M Y, H:i') : '-' }}</p>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Status</p>
                <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-bold {{ $statusBadge }} uppercase tracking-wider">{{ $statusLabel }}</span>
            </div>
        </div>
    </div>

    <!-- Identitas Anak - Order 2 -->
    <div class="mobile-order-2 bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-800/50 flex items-center gap-3">
            <span class="material-symbols-outlined text-primary">child_care</span>
            <h3 class="font-bold text-slate-800 dark:text-slate-100">Identitas Anak</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-12">
            <div>
                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">NIK</p>
                <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->nik_anak ?? '-' }}</p>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Nama Lengkap</p>
                <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->nama_lengkap_anak ?? '-' }}</p>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Nama Panggilan</p>
                <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->nama_panggilan_anak ?? '-' }}</p>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Tempat, Tanggal Lahir</p>
                <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->tempat_lahir_anak ?? '-' }}, {{ $spmb->tanggal_lahir_anak ? \Carbon\Carbon::parse($spmb->tanggal_lahir_anak)->format('d M Y') : '-' }}</p>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Usia Saat Ini</p>
                <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->usia }}</p>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Jenis Kelamin</p>
                <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->jenis_kelamin ?? '-' }}</p>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Agama</p>
                <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->agama ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Alamat Lengkap - Order 3 -->
    <div class="mobile-order-3 bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-800/50 flex items-center gap-3">
            <span class="material-symbols-outlined text-primary">location_on</span>
            <h3 class="font-bold text-slate-800 dark:text-slate-100">Alamat Lengkap</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-12">
            <div class="md:col-span-2">
                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Alamat Lengkap</p>
                <p class="text-sm font-semibold text-slate-700 dark:text-slate-300 leading-relaxed">{{ $spmb->nama_jalan_rumah ?? '-' }}, RT {{ $spmb->rt ?? '-' }} RW {{ $spmb->rw ?? '-' }}</p>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Provinsi</p>
                <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->provinsi_rumah ?? '-' }}</p>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Kota/Kabupaten</p>
                <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->kota_kabupaten_rumah ?? '-' }}</p>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Kecamatan</p>
                <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->kecamatan_rumah ?? '-' }}</p>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Kelurahan</p>
                <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->kelurahan_rumah ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Data Orang Tua - Order 4 -->
    <div class="mobile-order-4 bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-800/50 flex items-center gap-3">
            <span class="material-symbols-outlined text-primary">family_restroom</span>
            <h3 class="font-bold text-slate-800 dark:text-slate-100">Data Orang Tua</h3>
        </div>
        <div class="p-6 space-y-8">
            <!-- Data Ayah -->
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-1.5 h-4 bg-primary rounded-full"></div>
                    <h4 class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Data Ayah</h4>
                </div>
                <div class="space-y-4">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Nama Ayah</p>
                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->nama_lengkap_ayah ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">NIK Ayah</p>
                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->nik_ayah ?? '-' }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Pekerjaan</p>
                            <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->pekerjaan_ayah ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">No HP</p>
                            <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->nomor_telepon_ayah ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Ibu -->
            <div class="pt-6 border-t border-slate-100 dark:border-slate-700">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-1.5 h-4 bg-pink-500 rounded-full"></div>
                    <h4 class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Data Ibu</h4>
                </div>
                <div class="space-y-4">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Nama Ibu</p>
                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->nama_lengkap_ibu ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">NIK Ibu</p>
                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->nik_ibu ?? '-' }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Pekerjaan</p>
                            <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->pekerjaan_ibu ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">No HP</p>
                            <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $spmb->nomor_telepon_ibu ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dokumen Terlampir - Order 5 -->
    <div class="mobile-order-5 bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-800/50">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">description</span>
                    <h3 class="font-bold text-slate-800 dark:text-slate-100">Dokumen Terlampir</h3>
                </div>
                
                @php
                $allVerified = ($spmb->verifikasi_akte ?? false) && ($spmb->verifikasi_kk ?? false) && ($spmb->verifikasi_ktp ?? false) && ($spmb->verifikasi_bukti_transfer ?? false);
                @endphp
                @if($allVerified)
                <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-bold rounded-full flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">check_circle</span>
                    Lengkap
                </span>
                @else
                <span class="px-3 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-xs font-bold rounded-full flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">hourglass_empty</span>
                    Belum Lengkap
                </span>
                @endif
            </div>
            
            @php
            $progress = $spmb->progress_verifikasi;
            @endphp
            <div class="flex items-center gap-3 mt-1">
                <span class="text-xs font-medium text-slate-500 dark:text-slate-400 whitespace-nowrap">{{ $progress['terverifikasi'] }}/{{ $progress['total'] }} Dokumen Terverifikasi</span>
                <div class="flex-1 h-2 bg-slate-200 rounded-full overflow-hidden max-w-xs">
                    <div class="h-full bg-primary transition-all" style="width: {{ $progress['persentase'] }}%"></div>
                </div>
            </div>
        </div>
        
        <div class="p-4 space-y-2">
            @php
            $docTypes = [
                'akte_kelahiran' => ['label' => 'Akta Kelahiran', 'icon' => 'article'],
                'kartu_keluarga' => ['label' => 'Kartu Keluarga', 'icon' => 'group'],
                'ktp_orang_tua' => ['label' => 'KTP Orang Tua', 'icon' => 'badge'],
                'bukti_pembayaran' => ['label' => 'Bukti Pembayaran', 'icon' => 'receipt_long']
            ];
            @endphp
            
            @foreach($docTypes as $key => $doc)
            @php
            $docData = $spmb->dokumen->firstWhere('jenis_dokumen', $key);
            $hasUploadedDoc = $docData && filled($docData->path_file);
            $verifiedField = 'verifikasi_' . ($key === 'akte_kelahiran' ? 'akte' : ($key === 'kartu_keluarga' ? 'kk' : ($key === 'ktp_orang_tua' ? 'ktp' : 'bukti_transfer')));
            $isVerified = $spmb->$verifiedField ?? false;
            
            $fileName = $docData->nama_file ?? 'Belum diupload';
            $displayName = strlen($fileName) > 20 ? substr($fileName, 0, 17) . '...' : $fileName;
            @endphp
            <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900 rounded-xl border {{ $isVerified ? 'border-green-200' : 'border-slate-200 dark:border-slate-600' }}">
                <div class="flex items-center gap-3 flex-1 min-w-0">
                    <div class="w-10 h-10 {{ $isVerified ? 'bg-green-100 dark:bg-green-900/30' : 'bg-slate-200' }} rounded-xl flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined {{ $isVerified ? 'text-green-600 dark:text-green-500' : 'text-slate-500 dark:text-slate-400' }} text-xl">{{ $doc['icon'] }}</span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-bold text-slate-800 dark:text-slate-100 truncate">{{ $doc['label'] }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ $displayName }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 ml-2 flex-shrink-0">
                    @if($isVerified)
                    <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-[10px] font-bold rounded-full flex items-center gap-1 whitespace-nowrap">
                        <span class="material-symbols-outlined text-xs">check_circle</span>
                        Verified
                    </span>
                    @else
                    <span class="px-2 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-[10px] font-bold rounded-full flex items-center gap-1 whitespace-nowrap">
                        <span class="material-symbols-outlined text-xs">hourglass_empty</span>
                        Pending
                    </span>
                    @endif
                    
                    @if($hasUploadedDoc)
                    <button type="button" onclick="openDokumenModal('{{ asset('storage/' . $docData->path_file) }}')" class="p-1.5 bg-white dark:bg-slate-800 text-primary rounded-lg border border-primary/20 hover:bg-primary hover:text-white transition-all" title="Lihat Dokumen">
                        <span class="material-symbols-outlined text-sm">visibility</span>
                    </button>
                    @endif
                    
                    @if($canVerifyDokumen)
                        @if($isVerified)
                        <form action="{{ route($routePrefix . '.ppdb.verifikasiDokumen', $spmb) }}" method="POST" class="inline" onsubmit="return confirm('Batalkan verifikasi dokumen {{ $doc['label'] }}? Status akan dikembalikan ke Pending.');">
                            @csrf
                            <input type="hidden" name="jenis" value="{{ $key }}">
                            <input type="hidden" name="action" value="unverify">
                            <button type="submit" class="p-1.5 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-all" title="Batalkan Verifikasi">
                                <span class="material-symbols-outlined text-sm">undo</span>
                            </button>
                        </form>
                        @else
                        @if($hasUploadedDoc)
                        <form action="{{ route($routePrefix . '.ppdb.verifikasiDokumen', $spmb) }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="jenis" value="{{ $key }}">
                            <input type="hidden" name="action" value="verify">
                            <button type="submit" class="p-1.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all" title="Verifikasi Dokumen">
                                <span class="material-symbols-outlined text-sm">check</span>
                            </button>
                        </form>
                        @else
                        <button type="button" disabled class="p-1.5 bg-slate-200 text-slate-400 dark:text-slate-500 rounded-lg cursor-not-allowed" title="Dokumen belum diupload">
                            <span class="material-symbols-outlined text-sm">check</span>
                        </button>
                        @endif
                        @endif
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Catatan Pendaftaran - Order 6 -->
    <div class="mobile-order-6 bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-800/50 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-primary">history_edu</span>
                <h3 class="font-bold text-slate-800 dark:text-slate-100">Catatan Pendaftaran</h3>
            </div>
            @if($canAddCatatan)
                <button onclick="openCatatanModal()" class="flex items-center gap-1.5 px-3 py-1.5 bg-lavender/40 text-primary rounded-lg text-xs font-bold hover:bg-lavender/60 transition-all">
                    <span class="material-symbols-outlined text-sm">add</span>
                    Tambah Catatan
                </button>
            @endif
        </div>
        <div class="p-6">
            @if($catatanTimeline->count() > 0)
            <div class="relative pl-8 space-y-8 before:content-[''] before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-[2px] before:bg-slate-100 dark:before:bg-slate-700">
                @foreach($catatanUtama as $riwayat)
                <div class="relative">
                    <div class="absolute -left-[29px] top-1 w-5 h-5 rounded-full {{ $loop->first ? 'bg-slate-900 dark:bg-slate-100' : 'bg-white dark:bg-slate-800' }} {{ $loop->first ? 'border-4 border-slate-200 dark:border-slate-700' : 'border-2 border-slate-300 dark:border-slate-600' }} shadow-sm z-10"></div>
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center justify-between">
                            <h4 class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ $riwayat->status_baru ?? 'Pendaftaran Baru' }}</h4>
                            <span class="text-[10px] font-medium text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ $riwayat->created_at ? $riwayat->created_at->format('d M Y, H:i') : '-' }}</span>
                        </div>
                        <div class="bg-slate-50 dark:bg-slate-900 rounded-xl p-4 border border-slate-100 dark:border-slate-700">
                            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">{{ $riwayat->keterangan ?? 'Tidak ada keterangan' }}</p>
                        </div>
                        @if($riwayat->user)
                        <div class="flex items-center gap-2">
                            <div class="w-5 h-5 rounded-full bg-primary/10 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[12px] text-primary">person</span>
                            </div>
                            <p class="text-[10px] font-bold text-slate-500 dark:text-slate-400">{{ $riwayat->user->name ?? 'Admin' }} ({{ $riwayat->role_pengubah ?? 'admin' }})</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @if($catatanLainnya->count() > 0)
            <details class="mt-6 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 shadow-inner p-5 transition-all outline-none group">
                <summary class="cursor-pointer list-none text-sm font-bold text-slate-700 dark:text-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span>Lainnya</span>
                        <span class="text-xs font-medium text-slate-400 dark:text-slate-500">({{ $catatanLainnya->count() }} catatan lama)</span>
                    </div>
                    <span class="material-symbols-outlined text-slate-400 group-open:rotate-180 transition-transform">expand_more</span>
                </summary>
                <div class="relative mt-4 pl-8 space-y-8 before:content-[''] before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-[2px] before:bg-slate-100 dark:before:bg-slate-700">
                    @foreach($catatanLainnya as $riwayat)
                    <div class="relative">
                        <div class="absolute -left-[29px] top-1 w-5 h-5 rounded-full bg-white dark:bg-slate-800 border-2 border-slate-300 dark:border-slate-600 shadow-sm z-10"></div>
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center justify-between">
                                <h4 class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ $riwayat->status_baru ?? 'Pendaftaran Baru' }}</h4>
                                <span class="text-[10px] font-medium text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ $riwayat->created_at ? $riwayat->created_at->format('d M Y, H:i') : '-' }}</span>
                            </div>
                            <div class="bg-white dark:bg-slate-800 rounded-xl p-4 border border-slate-100 dark:border-slate-700">
                                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">{{ $riwayat->keterangan ?? 'Tidak ada keterangan' }}</p>
                            </div>
                            @if($riwayat->user)
                            <div class="flex items-center gap-2">
                                <div class="w-5 h-5 rounded-full bg-primary/10 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[12px] text-primary">person</span>
                                </div>
                                <p class="text-[10px] font-bold text-slate-500 dark:text-slate-400">{{ $riwayat->user->name ?? 'Admin' }} ({{ $riwayat->role_pengubah ?? 'admin' }})</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </details>
            @endif
            @else
            <div class="text-center py-8">
                <span class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-600 mb-2">history</span>
                <p class="text-sm text-slate-500 dark:text-slate-400">Belum ada riwayat catatan</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Status Information - Order 7 -->
    <div class="mobile-order-7 bg-white dark:bg-slate-800 rounded-2xl p-8 border border-slate-100 dark:border-slate-700 shadow-sm">
        <div class="flex items-center gap-2 mb-8">
            <span class="material-symbols-outlined text-primary">info</span>
            <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 tracking-tight">Status Information Definitions</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="flex items-start gap-4">
                <div class="w-2 h-10 bg-orange-400 rounded-full mt-1"></div>
                <div>
                    <h4 class="text-sm font-bold text-slate-800 dark:text-slate-100">Menunggu Verifikasi</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">Pendaftaran baru masuk dan perlu diperiksa.</p>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <div class="w-2 h-10 bg-yellow-400 rounded-full mt-1"></div>
                <div>
                    <h4 class="text-sm font-bold text-slate-800 dark:text-slate-100">Revisi Dokumen</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">Menunggu perbaikan berkas dari orang tua.</p>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <div class="w-2 h-10 bg-blue-500 rounded-full mt-1"></div>
                <div>
                    <h4 class="text-sm font-bold text-slate-800 dark:text-slate-100">Dokumen Verified</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">Berkas lengkap dan valid.</p>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <div class="w-2 h-10 bg-green-500 rounded-full mt-1"></div>
                <div>
                    <h4 class="text-sm font-bold text-slate-800 dark:text-slate-100">Lulus</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">Calon siswa diterima.</p>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <div class="w-2 h-10 bg-red-500 rounded-full mt-1"></div>
                <div>
                    <h4 class="text-sm font-bold text-slate-800 dark:text-slate-100">Tidak Lulus</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">Calon siswa tidak diterima.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Catatan Modal dengan Checkbox -->
@if($canAddCatatan)
<div id="catatanModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 w-full max-w-md mx-4 shadow-2xl">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100">Tambah Catatan</h3>
            <button onclick="closeCatatanModal()" class="text-slate-400 dark:text-slate-500 hover:text-slate-600">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <form method="POST" action="{{ route($routePrefix . '.ppdb.catatan', $spmb) }}">
            @csrf
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">Pilih Dokumen yang akan direvisi:</label>
                
                @php
                    $verifiedAkte = $spmb->verifikasi_akte ?? false;
                    $verifiedKK = $spmb->verifikasi_kk ?? false;
                    $verifiedKTP = $spmb->verifikasi_ktp ?? false;
                    $verifiedBukti = $spmb->verifikasi_bukti_transfer ?? false;
                @endphp
                
                <div class="space-y-3">
                    <!-- Checkbox untuk Akta Kelahiran -->
                    <label class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900 rounded-xl cursor-pointer hover:bg-slate-100 transition-all border {{ $verifiedAkte ? 'border-green-200' : 'border-slate-200 dark:border-slate-600' }}">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="jenis_dokumen[]" value="akte_kelahiran" class="w-4 h-4 text-primary rounded focus:ring-primary/20">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Akta Kelahiran</span>
                        </div>
                        @if($verifiedAkte)
                            <span class="flex items-center gap-1 text-xs font-bold text-green-600 dark:text-green-500 bg-green-100 dark:bg-green-900/30 px-2 py-1 rounded-full">
                                <span class="material-symbols-outlined text-sm">check_circle</span>
                                Verified
                            </span>
                        @else
                            <span class="flex items-center gap-1 text-xs font-bold text-amber-600 dark:text-amber-500 bg-amber-100 dark:bg-amber-900/30 px-2 py-1 rounded-full">
                                <span class="material-symbols-outlined text-sm">hourglass_empty</span>
                                Pending
                            </span>
                        @endif
                    </label>
                    
                    <!-- Checkbox untuk Kartu Keluarga -->
                    <label class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900 rounded-xl cursor-pointer hover:bg-slate-100 transition-all border {{ $verifiedKK ? 'border-green-200' : 'border-slate-200 dark:border-slate-600' }}">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="jenis_dokumen[]" value="kartu_keluarga" class="w-4 h-4 text-primary rounded focus:ring-primary/20">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Kartu Keluarga</span>
                        </div>
                        @if($verifiedKK)
                            <span class="flex items-center gap-1 text-xs font-bold text-green-600 dark:text-green-500 bg-green-100 dark:bg-green-900/30 px-2 py-1 rounded-full">
                                <span class="material-symbols-outlined text-sm">check_circle</span>
                                Verified
                            </span>
                        @else
                            <span class="flex items-center gap-1 text-xs font-bold text-amber-600 dark:text-amber-500 bg-amber-100 dark:bg-amber-900/30 px-2 py-1 rounded-full">
                                <span class="material-symbols-outlined text-sm">hourglass_empty</span>
                                Pending
                            </span>
                        @endif
                    </label>
                    
                    <!-- Checkbox untuk KTP Orang Tua -->
                    <label class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900 rounded-xl cursor-pointer hover:bg-slate-100 transition-all border {{ $verifiedKTP ? 'border-green-200' : 'border-slate-200 dark:border-slate-600' }}">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="jenis_dokumen[]" value="ktp_orang_tua" class="w-4 h-4 text-primary rounded focus:ring-primary/20">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">KTP Orang Tua</span>
                        </div>
                        @if($verifiedKTP)
                            <span class="flex items-center gap-1 text-xs font-bold text-green-600 dark:text-green-500 bg-green-100 dark:bg-green-900/30 px-2 py-1 rounded-full">
                                <span class="material-symbols-outlined text-sm">check_circle</span>
                                Verified
                            </span>
                        @else
                            <span class="flex items-center gap-1 text-xs font-bold text-amber-600 dark:text-amber-500 bg-amber-100 dark:bg-amber-900/30 px-2 py-1 rounded-full">
                                <span class="material-symbols-outlined text-sm">hourglass_empty</span>
                                Pending
                            </span>
                        @endif
                    </label>

                    <!-- Checkbox untuk Bukti Pembayaran -->
                    <label class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900 rounded-xl cursor-pointer hover:bg-slate-100 transition-all border {{ $verifiedBukti ? 'border-green-200' : 'border-slate-200 dark:border-slate-600' }}">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="jenis_dokumen[]" value="bukti_pembayaran" class="w-4 h-4 text-primary rounded focus:ring-primary/20">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Bukti Pembayaran</span>
                        </div>
                        @if($verifiedBukti)
                            <span class="flex items-center gap-1 text-xs font-bold text-green-600 dark:text-green-500 bg-green-100 dark:bg-green-900/30 px-2 py-1 rounded-full">
                                <span class="material-symbols-outlined text-sm">check_circle</span>
                                Verified
                            </span>
                        @else
                            <span class="flex items-center gap-1 text-xs font-bold text-amber-600 dark:text-amber-500 bg-amber-100 dark:bg-amber-900/30 px-2 py-1 rounded-full">
                                <span class="material-symbols-outlined text-sm">hourglass_empty</span>
                                Pending
                            </span>
                        @endif
                    </label>
                    
                    <!-- Divider -->
                    <div class="relative py-2">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-slate-200 dark:border-slate-600"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="bg-white dark:bg-slate-800 px-2 text-xs text-slate-400 dark:text-slate-500">ATAU</span>
                        </div>
                    </div>
                    
                    <!-- Checkbox untuk Semua Dokumen dengan fitur select all -->
                    <label class="flex items-center justify-between p-3 bg-primary/5 rounded-xl cursor-pointer hover:bg-primary/10 transition-all border-2 border-primary/20">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="selectAll" class="w-4 h-4 text-primary rounded focus:ring-primary/20">
                            <span class="text-sm font-bold text-primary">Pilih Semua Dokumen</span>
                        </div>
                        @php
                            $totalVerified = ($verifiedAkte ? 1 : 0) + ($verifiedKK ? 1 : 0) + ($verifiedKTP ? 1 : 0) + ($verifiedBukti ? 1 : 0);
                        @endphp
                        <span class="text-xs font-bold text-slate-600 dark:text-slate-400 bg-slate-200 px-2 py-1 rounded-full">
                            {{ $totalVerified }}/4 Verified
                        </span>
                    </label>
                </div>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Catatan untuk Siswa</label>
                <textarea name="catatan_admin" rows="4" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border-none dark:text-slate-100 rounded-xl focus:ring-2 focus:ring-primary/20 text-sm" placeholder="Catatan ini akan dilihat oleh siswa..."></textarea>
            </div>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeCatatanModal()" class="flex-1 px-6 py-3 border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-400 rounded-xl font-bold text-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition-all">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-6 py-3 bg-primary text-white rounded-xl font-bold text-sm hover:bg-primary/90 transition-all">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endif

<!-- Revisi Modal -->
<div id="revisiModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[100] hidden items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl max-w-md w-full p-8 relative overflow-hidden animate-in fade-in zoom-in duration-300">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-amber-600 dark:text-amber-500 text-2xl">edit_note</span>
            </div>
            <div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100">Minta Revisi Dokumen</h3>
                <p id="revisiDocLabel" class="text-sm text-slate-500 dark:text-slate-400">Pilih dokumen untuk direvisi</p>
            </div>
        </div>
        
        <form id="revisiForm" action="{{ route($routePrefix . '.ppdb.verifikasiDokumen', $spmb) }}" method="POST">
            @csrf
            <input type="hidden" name="jenis" id="revisiJenisInput">
            <input type="hidden" name="action" value="revision">
            
            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Alasan Revisi / Catatan Admin</label>
                <textarea name="keterangan" id="revisiCatatanInput" rows="4" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 dark:text-slate-100 rounded-xl focus:ring-2 focus:ring-primary/20 text-sm focus:border-primary transition-all outline-none" placeholder="Jelaskan alasan revisi atau apa yang perlu diperbaiki..."></textarea>
                <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-2 italic">* Catatan ini akan dilihat oleh siswa di dashboard mereka.</p>
            </div>
            
            <div class="grid grid-cols-2 gap-3">
                <button type="button" onclick="closeRevisiModal()" class="px-6 py-3 border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-400 rounded-xl font-bold text-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition-all">
                    Batal
                </button>
                <button type="submit" class="px-6 py-3 bg-amber-500 text-white rounded-xl font-bold text-sm hover:bg-amber-600 transition-all shadow-lg shadow-amber-500/25">
                    Minta Revisi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Dokumen Preview Modal -->
<div id="dokumenModal" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-slate-800 rounded-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden shadow-2xl">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 dark:border-slate-700">
            <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100">Preview Dokumen</h3>
            <button onclick="closeDokumenModal()" class="text-slate-400 dark:text-slate-500 hover:text-slate-600 p-1">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="p-4 overflow-auto max-h-[calc(90vh-80px)] flex items-center justify-center bg-slate-100 dark:bg-slate-700">
            <iframe id="dokumenFrame" src="" class="w-full h-[70vh] rounded-lg border-0"></iframe>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Fitur Select All
    document.getElementById('selectAll')?.addEventListener('change', function(e) {
        const checkboxes = document.querySelectorAll('input[name="jenis_dokumen[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = e.target.checked;
        });
    });

    // Update "Select All" checkbox berdasarkan status checkbox lainnya
    document.querySelectorAll('input[name="jenis_dokumen[]"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[name="jenis_dokumen[]"]');
            const selectAll = document.getElementById('selectAll');
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            if (selectAll) {
                selectAll.checked = allChecked;
            }
        });
    });

    function openCatatanModal() {
        const modal = document.getElementById('catatanModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    function closeCatatanModal() {
        const modal = document.getElementById('catatanModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    function openDokumenModal(url) {
        const frame = document.getElementById('dokumenFrame');
        const modal = document.getElementById('dokumenModal');
        if (frame && modal) {
            frame.src = url;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    function closeDokumenModal() {
        const frame = document.getElementById('dokumenFrame');
        const modal = document.getElementById('dokumenModal');
        if (frame && modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            frame.src = '';
        }
    }

    function openRevisiModal(jenis, label, catatan = '') {
        const modal = document.getElementById('revisiModal');
        const jenisInput = document.getElementById('revisiJenisInput');
        const labelText = document.getElementById('revisiDocLabel');
        const catatanInput = document.getElementById('revisiCatatanInput');
        
        if (modal && jenisInput && labelText) {
            jenisInput.value = jenis;
            labelText.innerText = 'Dokumen: ' + label;
            catatanInput.value = catatan !== 'null' ? catatan : '';
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    function closeRevisiModal() {
        const modal = document.getElementById('revisiModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    // Close modal on outside click
    document.getElementById('catatanModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeCatatanModal();
        }
    });

    document.getElementById('dokumenModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeDokumenModal();
        }
    });

    document.getElementById('revisiModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeRevisiModal();
        }
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCatatanModal();
            closeDokumenModal();
            closeRevisiModal();
        }
    });
</script>
@endpush
