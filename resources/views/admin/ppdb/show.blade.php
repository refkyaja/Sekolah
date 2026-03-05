@extends('layouts.admin')

@section('title', 'Detail Pendaftaran - ' . ($spmb->nama_lengkap_anak ?? 'PPDB'))

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
</style>
@endpush

@section('content')
<nav aria-label="Breadcrumb" class="flex mb-4 text-xs font-medium text-slate-400 uppercase tracking-widest">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li><a class="hover:text-primary" href="{{ route('admin.ppdb.index') }}">PPDB</a></li>
        <li><span class="mx-2">/</span></li>
        <li><a class="hover:text-primary" href="{{ route('admin.ppdb.index') }}">Pendaftaran</a></li>
        <li><span class="mx-2">/</span></li>
        <li class="text-slate-600">Detail Pendaftaran</li>
    </ol>
</nav>

@php
$statusBadge = '';
$statusText = $spmb->status_pendaftaran ?? 'Menunggu Verifikasi';
switch($statusText) {
    case 'Lulus':
        $statusBadge = 'bg-green-100 text-green-700';
        $statusLabel = 'LULUS';
        break;
    case 'Tidak Lulus':
        $statusBadge = 'bg-red-100 text-red-700';
        $statusLabel = 'TIDAK LULUS';
        break;
    case 'Dokumen Verified':
        $statusBadge = 'bg-blue-100 text-blue-700';
        $statusLabel = 'DOKUMEN VERIFIED';
        break;
    case 'Revisi Dokumen':
        $statusBadge = 'bg-amber-100 text-amber-700';
        $statusLabel = 'REVISI DOKUMEN';
        break;
    default:
        $statusBadge = 'bg-orange-100 text-orange-700';
        $statusLabel = 'MENUNGGU VERIFIKASI';
}
@endphp

<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div class="flex items-center gap-4">
        <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center">
            <span class="material-symbols-outlined text-primary text-3xl">account_circle</span>
        </div>
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">{{ $spmb->nama_lengkap_anak ?? '-' }}</h1>
                <span class="inline-flex items-center px-4 py-1 rounded-full text-xs font-bold {{ $statusBadge }} uppercase tracking-widest">{{ $statusLabel }}</span>
            </div>
            <p class="text-sm font-medium text-slate-500 mt-1 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">confirmation_number</span>
                {{ $spmb->no_pendaftaran ?? '-' }}
            </p>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.ppdb.index') }}" class="flex items-center gap-2 px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-50 transition-all shadow-sm">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            Kembali
        </a>
        <button onclick="window.print()" class="flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-xl font-bold text-sm hover:bg-primary/90 transition-all shadow-lg shadow-primary/25">
            <span class="material-symbols-outlined text-lg">print</span>
            Cetak Bukti
        </button>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-8">
        <!-- Data Pendaftaran -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-50 bg-slate-50/50 flex items-center gap-3">
                <span class="material-symbols-outlined text-primary">app_registration</span>
                <h3 class="font-bold text-slate-800">Data Pendaftaran</h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Kode Pendaftaran</p>
                    <p class="text-sm font-bold text-primary">{{ $spmb->no_pendaftaran ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Tanggal Daftar</p>
                    <p class="text-sm font-semibold text-slate-700">{{ $spmb->created_at ? $spmb->created_at->format('d M Y, H:i') : '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Status</p>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-bold {{ $statusBadge }} uppercase tracking-wider">{{ $statusLabel }}</span>
                </div>
            </div>
        </div>

        <!-- Identitas Anak -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-50 bg-slate-50/50 flex items-center gap-3">
                <span class="material-symbols-outlined text-primary">child_care</span>
                <h3 class="font-bold text-slate-800">Identitas Anak</h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-12">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">NIK</p>
                    <p class="text-sm font-semibold text-slate-700">{{ $spmb->nik_anak ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Nama Lengkap</p>
                    <p class="text-sm font-semibold text-slate-700">{{ $spmb->nama_lengkap_anak ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Nama Panggilan</p>
                    <p class="text-sm font-semibold text-slate-700">{{ $spmb->nama_panggilan_anak ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Tempat, Tanggal Lahir</p>
                    <p class="text-sm font-semibold text-slate-700">{{ $spmb->tempat_lahir_anak ?? '-' }}, {{ $spmb->tanggal_lahir_anak ? \Carbon\Carbon::parse($spmb->tanggal_lahir_anak)->format('d M Y') : '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Jenis Kelamin</p>
                    <p class="text-sm font-semibold text-slate-700">{{ $spmb->jenis_kelamin ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Agama</p>
                    <p class="text-sm font-semibold text-slate-700">{{ $spmb->agama ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Alamat Lengkap -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-50 bg-slate-50/50 flex items-center gap-3">
                <span class="material-symbols-outlined text-primary">location_on</span>
                <h3 class="font-bold text-slate-800">Alamat Lengkap</h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-12">
                <div class="md:col-span-2">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Alamat Lengkap</p>
                    <p class="text-sm font-semibold text-slate-700 leading-relaxed">{{ $spmb->nama_jalan_rumah ?? '-' }}, RT {{ $spmb->rt ?? '-' }} RW {{ $spmb->rw ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Provinsi</p>
                    <p class="text-sm font-semibold text-slate-700">{{ $spmb->provinsi_rumah ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Kota/Kabupaten</p>
                    <p class="text-sm font-semibold text-slate-700">{{ $spmb->kota_kabupaten_rumah ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Kecamatan</p>
                    <p class="text-sm font-semibold text-slate-700">{{ $spmb->kecamatan_rumah ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Kelurahan</p>
                    <p class="text-sm font-semibold text-slate-700">{{ $spmb->kelurahan_rumah ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Catatan Pendaftaran -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-50 bg-slate-50/50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">history_edu</span>
                    <h3 class="font-bold text-slate-800">Catatan Pendaftaran</h3>
                </div>
                <button onclick="openCatatanModal()" class="flex items-center gap-1.5 px-3 py-1.5 bg-lavender/40 text-primary rounded-lg text-xs font-bold hover:bg-lavender/60 transition-all">
                    <span class="material-symbols-outlined text-sm">add</span>
                    Tambah Catatan
                </button>
            </div>
            <div class="p-6">
                @if($spmb->riwayatStatus && $spmb->riwayatStatus->count() > 0)
                <div class="relative pl-8 space-y-8 before:content-[''] before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-[2px] before:bg-slate-100">
                    @foreach($spmb->riwayatStatus->take(5) as $riwayat)
                    <div class="relative">
                        <div class="absolute -left-[29px] top-1 w-5 h-5 rounded-full {{ $loop->first ? 'bg-primary' : 'bg-slate-300' }} border-4 border-white shadow-sm z-10"></div>
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center justify-between">
                                <h4 class="text-sm font-bold text-slate-800">{{ $riwayat->status_baru ?? 'Pendaftaran Baru' }}</h4>
                                <span class="text-[10px] font-medium text-slate-400 uppercase tracking-widest">{{ $riwayat->created_at ? $riwayat->created_at->format('d M Y, H:i') : '-' }}</span>
                            </div>
                            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                                <p class="text-sm text-slate-600 leading-relaxed">{{ $riwayat->keterangan ?? 'Tidak ada keterangan' }}</p>
                            </div>
                            @if($riwayat->user)
                            <div class="flex items-center gap-2">
                                <div class="w-5 h-5 rounded-full bg-primary/10 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[12px] text-primary">person</span>
                                </div>
                                <p class="text-[10px] font-bold text-slate-500">{{ $riwayat->user->name ?? 'Admin' }} ({{ $riwayat->role_pengubah ?? 'admin' }})</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8">
                    <span class="material-symbols-outlined text-4xl text-slate-300 mb-2">history</span>
                    <p class="text-sm text-slate-500">Belum ada riwayat catatan</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="space-y-8">
        <!-- Data Orang Tua -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-50 bg-slate-50/50 flex items-center gap-3">
                <span class="material-symbols-outlined text-primary">family_restroom</span>
                <h3 class="font-bold text-slate-800">Data Orang Tua</h3>
            </div>
            <div class="p-6 space-y-8">
                <!-- Data Ayah -->
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1.5 h-4 bg-primary rounded-full"></div>
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest">Data Ayah</h4>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Ayah</p>
                            <p class="text-sm font-semibold text-slate-700">{{ $spmb->nama_lengkap_ayah ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">NIK Ayah</p>
                            <p class="text-sm font-semibold text-slate-700">{{ $spmb->nik_ayah ?? '-' }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pekerjaan</p>
                                <p class="text-sm font-semibold text-slate-700">{{ $spmb->pekerjaan_ayah ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">No HP</p>
                                <p class="text-sm font-semibold text-slate-700">{{ $spmb->nomor_telepon_ayah ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Ibu -->
                <div class="pt-6 border-t border-slate-100">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1.5 h-4 bg-pink-500 rounded-full"></div>
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest">Data Ibu</h4>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Ibu</p>
                            <p class="text-sm font-semibold text-slate-700">{{ $spmb->nama_lengkap_ibu ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">NIK Ibu</p>
                            <p class="text-sm font-semibold text-slate-700">{{ $spmb->nik_ibu ?? '-' }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pekerjaan</p>
                                <p class="text-sm font-semibold text-slate-700">{{ $spmb->pekerjaan_ibu ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">No HP</p>
                                <p class="text-sm font-semibold text-slate-700">{{ $spmb->nomor_telepon_ibu ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dokumen Terlampir -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-50 bg-slate-50/50 flex items-center gap-3">
                <span class="material-symbols-outlined text-primary">description</span>
                <h3 class="font-bold text-slate-800">Dokumen Terlampir</h3>
            </div>
            <div class="p-6 space-y-3">
                @if($spmb->dokumen && $spmb->dokumen->count() > 0)
                    @foreach($spmb->dokumen as $dokumen)
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl group border border-transparent hover:border-primary/20 transition-all">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                <span class="material-symbols-outlined text-red-600">picture_as_pdf</span>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-700">{{ ucfirst($dokumen->jenis_dokumen) }}</p>
                                <p class="text-[10px] text-slate-400">{{ $dokumen->nama_file }}</p>
                            </div>
                        </div>
                        @if($dokumen->path_file)
                        @php $dokumenUrl = isset($dokumen->url) ? $dokumen->url : asset('storage/' . $dokumen->path_file); @endphp
                        <button type="button" onclick="openDokumenModal('{{ $dokumenUrl }}')" class="px-3 py-1.5 bg-white text-primary text-xs font-bold rounded-lg border border-primary/20 hover:bg-primary hover:text-white transition-all">View</button>
                        @else
                        <span class="text-xs text-slate-400">-</span>
                        @endif
                    </div>
                    @endforeach
                @else
                <div class="text-center py-6">
                    <span class="material-symbols-outlined text-4xl text-slate-300 mb-2">folder_open</span>
                    <p class="text-sm text-slate-500">Belum ada dokumen</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Status Information -->
<div class="bg-white rounded-2xl p-8 mt-8 border border-slate-100 shadow-sm">
    <div class="flex items-center gap-2 mb-8">
        <span class="material-symbols-outlined text-primary">info</span>
        <h3 class="text-lg font-bold text-slate-800 tracking-tight">Status Information Definitions</h3>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="flex items-start gap-4">
            <div class="w-2 h-10 bg-orange-400 rounded-full mt-1"></div>
            <div>
                <h4 class="text-sm font-bold text-slate-800">Menunggu Verifikasi</h4>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">Pendaftaran baru masuk dan perlu diperiksa.</p>
            </div>
        </div>
        <div class="flex items-start gap-4">
            <div class="w-2 h-10 bg-yellow-400 rounded-full mt-1"></div>
            <div>
                <h4 class="text-sm font-bold text-slate-800">Revisi Dokumen</h4>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">Menunggu perbaikan berkas dari orang tua.</p>
            </div>
        </div>
        <div class="flex items-start gap-4">
            <div class="w-2 h-10 bg-blue-500 rounded-full mt-1"></div>
            <div>
                <h4 class="text-sm font-bold text-slate-800">Dokumen Verified</h4>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">Berkas lengkap dan valid.</p>
            </div>
        </div>
        <div class="flex items-start gap-4">
            <div class="w-2 h-10 bg-green-500 rounded-full mt-1"></div>
            <div>
                <h4 class="text-sm font-bold text-slate-800">Lulus</h4>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">Calon siswa diterima.</p>
            </div>
        </div>
        <div class="flex items-start gap-4">
            <div class="w-2 h-10 bg-red-500 rounded-full mt-1"></div>
            <div>
                <h4 class="text-sm font-bold text-slate-800">Tidak Lulus</h4>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">Calon siswa tidak diterima.</p>
            </div>
        </div>
    </div>
</div>

<!-- Add Catatan Modal -->
<div id="catatanModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md mx-4 shadow-2xl">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-slate-800">Tambah Catatan</h3>
            <button onclick="closeCatatanModal()" class="text-slate-400 hover:text-slate-600">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <form method="POST" action="{{ route('admin.ppdb.updateStatus', $spmb) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-3 bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-sm">
                    <option value="{{ $spmb->status_pendaftaran }}" selected>{{ $spmb->status_pendaftaran }}</option>
                    <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
                    <option value="Revisi Dokumen">Revisi Dokumen</option>
                    <option value="Dokumen Verified">Dokumen Verified</option>
                    <option value="Lulus">Lulus</option>
                    <option value="Tidak Lulus">Tidak Lulus</option>
                </select>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-2">Catatan</label>
                <textarea name="catatan" rows="4" class="w-full px-4 py-3 bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-sm" placeholder="Tambahkan catatan..."></textarea>
            </div>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeCatatanModal()" class="flex-1 px-6 py-3 border border-slate-200 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-50 transition-all">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-6 py-3 bg-primary text-white rounded-xl font-bold text-sm hover:bg-primary/90 transition-all">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Dokumen Preview Modal -->
<div id="dokumenModal" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden shadow-2xl">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 class="text-lg font-bold text-slate-800">Preview Dokumen</h3>
            <button onclick="closeDokumenModal()" class="text-slate-400 hover:text-slate-600 p-1">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="p-4 overflow-auto max-h-[calc(90vh-80px)] flex items-center justify-center bg-slate-100">
            <iframe id="dokumenFrame" src="" class="w-full h-[70vh] rounded-lg border-0"></iframe>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openCatatanModal() {
        document.getElementById('catatanModal').classList.remove('hidden');
        document.getElementById('catatanModal').classList.add('flex');
    }

    function closeCatatanModal() {
        document.getElementById('catatanModal').classList.add('hidden');
        document.getElementById('catatanModal').classList.remove('flex');
    }

    function openDokumenModal(url) {
        document.getElementById('dokumenFrame').src = url;
        document.getElementById('dokumenModal').classList.remove('hidden');
        document.getElementById('dokumenModal').classList.add('flex');
    }

    function closeDokumenModal() {
        document.getElementById('dokumenModal').classList.add('hidden');
        document.getElementById('dokumenModal').classList.remove('flex');
        document.getElementById('dokumenFrame').src = '';
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

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCatatanModal();
            closeDokumenModal();
        }
    });
</script>
@endpush
@endsection
