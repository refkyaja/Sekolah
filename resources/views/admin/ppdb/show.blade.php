{{-- resources/views/admin/ppdb/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Data PPDB')

@push('styles')
    <!-- PPDB Detail CSS -->
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/components/ppdb-detail.css') }}">
@endpush

@push('scripts')
    <!-- PPDB Detail JS -->
    <script type="module" src="{{ Vite::asset('resources/js/components/ppdb-detail.js') }}"></script>
@endpush

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                    <i class="fas fa-file-alt mr-2"></i>Detail Data PPDB
                </h1>
                <div class="flex items-center gap-4 mt-2">
                    <span class="text-gray-600">No. Pendaftaran:</span>
                    <span class="font-mono bg-gray-100 px-3 py-1 rounded-lg">
                        {{ $ppdb->no_pendaftaran }}
                    </span>
                </div>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.ppdb.index') }}" 
                   class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                
                <!-- Link ke data siswa jika sudah dikonversi -->
                @php
                    $existingSiswa = $ppdb->siswa ?? null;
                @endphp
                @if($existingSiswa)
                <a href="{{ route('admin.siswa.show', $existingSiswa) }}" 
                   class="flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
                    <i class="fas fa-user-graduate mr-2"></i>Lihat Data Siswa
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Status Banner -->
    <div class="mb-8">
        @php
            $statusColors = [
                'menunggu' => 'bg-gray-100 border-gray-300 text-gray-800',
                'diproses' => 'bg-yellow-100 border-yellow-300 text-yellow-800',
                'diterima' => 'bg-green-100 border-green-300 text-green-800',
                'ditolak' => 'bg-red-100 border-red-300 text-red-800',
                'cadangan' => 'bg-blue-100 border-blue-300 text-blue-800',
            ];
        @endphp
        
        <div class="p-4 border rounded-xl {{ $statusColors[$ppdb->status] ?? 'bg-gray-100 border-gray-300' }}">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="font-bold text-lg">Status Pendaftaran: 
                        <span class="uppercase">{{ $ppdb->status ?? 'diproses' }}</span>
                    </h3>
                    <p class="text-sm mt-1">
                        Tanggal Pendaftaran: {{ \Carbon\Carbon::parse($ppdb->tanggal_pendaftaran)->translatedFormat('d F Y') }}
                    </p>
                </div>
                
                <!-- Status Pembayaran -->
                <div>
                    @php
                        $paymentColors = [
                            'belum' => 'bg-red-100 text-red-800',
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'lunas' => 'bg-green-100 text-green-800',
                        ];
                    @endphp
                    <span class="px-4 py-2 rounded-lg font-bold {{ $paymentColors[$ppdb->status_pembayaran] ?? 'bg-gray-100 text-gray-800' }}">
                        <i class="fas fa-money-bill-wave mr-2"></i>
                        {{ ucfirst($ppdb->status_pembayaran ?? 'belum') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Kolom Kiri: Data Calon Siswa -->
        <div class="space-y-6">
            <!-- Data Calon Siswa Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="card-header bg-blue-50">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-child mr-3 text-blue-600"></i>
                        Data Calon Siswa
                    </h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="info-label">Nama Lengkap</label>
                            <p class="info-value">{{ $ppdb->nama_calon_siswa }}</p>
                        </div>
                        <div>
                            <label class="info-label">Jenis Kelamin</label>
                            <p class="mt-1">
                                @if($ppdb->jenis_kelamin == 'L')
                                <span class="badge badge-blue">
                                    <i class="fas fa-mars mr-1"></i> Laki-laki
                                </span>
                                @else
                                <span class="badge badge-pink">
                                    <i class="fas fa-venus mr-1"></i> Perempuan
                                </span>
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="info-label">Tempat Lahir</label>
                            <p class="info-value">{{ $ppdb->tempat_lahir }}</p>
                        </div>
                        <div>
                            <label class="info-label">Tanggal Lahir</label>
                            <p class="info-value">
                                {{ \Carbon\Carbon::parse($ppdb->tanggal_lahir)->translatedFormat('d F Y') }}
                                <span class="text-gray-500 ml-2">
                                    ({{ \Carbon\Carbon::parse($ppdb->tanggal_lahir)->age }} tahun)
                                </span>
                            </p>
                        </div>
                    </div>
                    
                    <div>
                        <label class="info-label">Alamat</label>
                        <p class="mt-1 whitespace-pre-line">{{ $ppdb->alamat }}</p>
                    </div>
                    
                    <div>
                        <label class="info-label">Agama</label>
                        <p class="info-value">{{ $ppdb->agama ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Data Orang Tua Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="card-header bg-green-50">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-users mr-3 text-green-600"></i>
                        Data Orang Tua
                    </h3>
                </div>
                <div class="card-body space-y-6">
                    <!-- Data Ayah -->
                    <div class="space-y-4">
                        <h4 class="font-medium text-gray-900 border-l-4 border-blue-500 pl-3">
                            <i class="fas fa-male text-blue-600 mr-2"></i>Data Ayah
                        </h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="info-label">Nama Ayah</label>
                                <p class="info-value">{{ $ppdb->nama_ayah }}</p>
                            </div>
                            <div>
                                <label class="info-label">Pekerjaan</label>
                                <p class="info-value">{{ $ppdb->pekerjaan_ayah ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Data Ibu -->
                    <div class="space-y-4">
                        <h4 class="font-medium text-gray-900 border-l-4 border-pink-500 pl-3">
                            <i class="fas fa-female text-pink-600 mr-2"></i>Data Ibu
                        </h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="info-label">Nama Ibu</label>
                                <p class="info-value">{{ $ppdb->nama_ibu }}</p>
                            </div>
                            <div>
                                <label class="info-label">Pekerjaan</label>
                                <p class="info-value">{{ $ppdb->pekerjaan_ibu ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Kontak -->
                    <div class="space-y-4 pt-4 border-t border-gray-200">
                        <h4 class="font-medium text-gray-900">
                            <i class="fas fa-phone text-green-600 mr-2"></i>Kontak Orang Tua
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="info-label">No. HP/WhatsApp</label>
                                <p class="mt-1">
                                    <a href="https://wa.me/62{{ substr($ppdb->no_hp_ortu, 1) }}" 
                                       target="_blank"
                                       class="text-green-600 hover:text-green-800 inline-flex items-center">
                                        <i class="fab fa-whatsapp mr-2"></i>
                                        {{ $ppdb->no_hp_ortu }}
                                    </a>
                                </p>
                            </div>
                            <div>
                                <label class="info-label">Email</label>
                                <p class="mt-1">
                                    @if($ppdb->email_ortu)
                                    <a href="mailto:{{ $ppdb->email_ortu }}" 
                                       class="text-blue-600 hover:text-blue-800">
                                        {{ $ppdb->email_ortu }}
                                    </a>
                                    @else
                                    <span class="text-gray-500">-</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Data Pendaftaran -->
        <div class="space-y-6">
            <!-- Data Pendaftaran Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="card-header bg-purple-50">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-graduation-cap mr-3 text-purple-600"></i>
                        Data Pendaftaran
                    </h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="info-label">Pilihan Kelompok</label>
                            <p class="mt-1">
                                <span class="badge badge-purple">
                                    Kelompok {{ $ppdb->pilihan_kelompok ?? 'A' }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="info-label">Jalur Pendaftaran</label>
                            <p class="mt-1">
                                @php
                                    $jalurLabels = [
                                        'reguler' => 'Reguler',
                                        'prestasi' => 'Prestasi',
                                        'afirmasi' => 'Afirmasi',
                                    ];
                                @endphp
                                <span class="badge badge-yellow">
                                    {{ $jalurLabels[$ppdb->jalur_pendaftaran] ?? 'Reguler' }}
                                </span>
                            </p>
                        </div>
                    </div>
                    
                    @if($ppdb->catatan_khusus)
                    <div>
                        <label class="info-label">Catatan Khusus</label>
                        <div class="mt-2 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="text-yellow-800 whitespace-pre-line">{{ $ppdb->catatan_khusus }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Informasi Sistem Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="card-header bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-900 flex items-center">
                        <i class="fas fa-info-circle mr-3 text-gray-600"></i>
                        Informasi Sistem
                    </h3>
                </div>
                <div class="card-body space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="info-label">Tanggal Daftar</label>
                            <p class="info-value">
                                {{ \Carbon\Carbon::parse($ppdb->created_at)->translatedFormat('d F Y H:i') }}
                            </p>
                        </div>
                        <div>
                            <label class="info-label">Terakhir Diupdate</label>
                            <p class="info-value">
                                {{ \Carbon\Carbon::parse($ppdb->updated_at)->translatedFormat('d F Y H:i') }}
                                <span class="text-gray-500 ml-1">
                                    ({{ \Carbon\Carbon::parse($ppdb->updated_at)->diffForHumans() }})
                                </span>
                            </p>
                        </div>
                    </div>
                    
                    @if($ppdb->tanggal_verifikasi)
                    <div>
                        <label class="info-label">Tanggal Verifikasi</label>
                        <p class="info-value">
                            {{ \Carbon\Carbon::parse($ppdb->tanggal_verifikasi)->translatedFormat('d F Y H:i') }}
                        </p>
                    </div>
                    @endif
                    
                    @if($ppdb->verifikator)
                    <div>
                        <label class="info-label">Verifikator</label>
                        <p class="info-value">{{ $ppdb->verifikator }}</p>
                    </div>
                    @endif
                    
                    @if($ppdb->catatan_admin)
                    <div>
                        <label class="info-label">Catatan Admin</label>
                        <div class="mt-2 p-3 bg-gray-50 border border-gray-200 rounded-lg">
                            <p class="text-gray-700 whitespace-pre-line">{{ $ppdb->catatan_admin }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6">
                    <div class="flex flex-wrap gap-4 mb-4">
                        <a href="{{ route('admin.ppdb.edit', $ppdb) }}" 
                           class="btn btn-primary flex-1">
                            <i class="fas fa-edit mr-2"></i>Edit Data
                        </a>
                        
                        @if($ppdb->status !== 'diterima' && $ppdb->status !== 'ditolak')
                        <button onclick="showStatusModal()"
                                class="btn btn-warning flex-1">
                            <i class="fas fa-sync-alt mr-2"></i>Ubah Status
                        </button>
                        @endif
                        
                        @if(!$existingSiswa && $ppdb->status === 'diterima' && $ppdb->status_pembayaran === 'lunas')
                        <form action="{{ route('admin.ppdb.konversi', $ppdb) }}" 
                              method="POST" class="flex-1"
                              onsubmit="return confirm('Konversi data PPDB ini ke data siswa?')">
                            @csrf
                            <button type="submit" 
                                    class="w-full btn btn-success">
                                <i class="fas fa-exchange-alt mr-2"></i>Konversi ke Siswa
                            </button>
                        </form>
                        @endif
                        
                        <form action="{{ route('admin.ppdb.destroy', $ppdb) }}" 
                              method="POST" 
                              class="flex-1"
                              onsubmit="return confirm('Hapus data PPDB ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full btn btn-danger">
                                <i class="fas fa-trash mr-2"></i>Hapus Data
                            </button>
                        </form>
                    </div>
                    
                    <!-- Konversi Warning -->
                    @if($existingSiswa)
                    <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-600 text-xl mr-3"></i>
                            <div>
                                <h4 class="font-medium text-green-800">Data sudah dikonversi menjadi siswa</h4>
                                <p class="text-sm text-green-700 mt-1">
                                    Data ini sudah dikonversi menjadi data siswa. 
                                    <a href="{{ route('admin.siswa.show', $existingSiswa) }}" class="font-medium underline">Lihat data siswa</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div id="statusModal" class="modal-overlay hidden">
    <div class="modal-container">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Update Status PPDB</h3>
            <button onclick="closeStatusModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="statusForm" method="POST" action="{{ route('admin.ppdb.updateStatus', $ppdb) }}" class="space-y-4">
            @csrf
            @method('PATCH')
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status Baru</label>
                <select name="status" class="form-select">
                    <option value="menunggu" {{ $ppdb->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="diproses" {{ $ppdb->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="diterima" {{ $ppdb->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="ditolak" {{ $ppdb->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    <option value="cadangan" {{ $ppdb->status == 'cadangan' ? 'selected' : '' }}>Cadangan</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                <textarea name="catatan" rows="3" 
                          class="form-textarea"
                          placeholder="Tambahkan catatan jika diperlukan..."></textarea>
            </div>
            
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeStatusModal()" 
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit" 
                        class="btn btn-primary px-4 py-2">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection