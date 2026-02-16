@extends('layouts.admin')

@section('title', 'Dokumen Pendaftaran - ' . $spmb->nama_lengkap_anak)

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                    <i class="fas fa-file-alt mr-2"></i>Dokumen Pendaftaran
                </h1>
                <p class="text-gray-600 mt-2">{{ $spmb->nama_lengkap_anak }} - {{ $spmb->no_pendaftaran }}</p>
            </div>
            <div class="flex gap-2">
                <button onclick="showUploadModal()" class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                    <i class="fas fa-upload"></i> Upload Dokumen
                </button>
                <a href="{{ route('admin.spmb.show', $spmb) }}" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Daftar Dokumen -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Daftar Dokumen</h3>
            <p class="text-sm text-gray-600">Kelola dokumen pendaftaran calon siswa</p>
        </div>

        <div class="p-6">
            @if($dokumen->isEmpty())
                <div class="text-center py-12">
                    <div class="mb-4">
                        <i class="fas fa-file-alt text-6xl text-gray-300"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Dokumen</h3>
                    <p class="text-gray-600 mb-4">Belum ada dokumen yang diupload untuk pendaftaran ini.</p>
                    <button onclick="showUploadModal()" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                        <i class="fas fa-upload"></i> Upload Dokumen Pertama
                    </button>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($dokumen as $dok)
                    <div class="border rounded-lg p-4 hover:shadow-md transition relative group">
                        <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition">
                            <button onclick="deleteDokumen({{ $dok->id }})" class="text-red-500 hover:text-red-700 p-1">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="text-3xl">
                                <i class="{{ $dok->icon }}"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-medium text-gray-900 truncate">{{ $dok->jenis_label }}</h4>
                                <p class="text-sm text-gray-500 truncate">{{ $dok->nama_file }}</p>
                                <div class="flex items-center gap-2 mt-2 text-xs text-gray-500">
                                    <span>{{ $dok->ukuran_formatted }}</span>
                                    <span>•</span>
                                    <span>{{ $dok->created_at->format('d/m/Y') }}</span>
                                </div>
                                @if($dok->keterangan)
                                <p class="text-xs text-gray-500 mt-1">{{ $dok->keterangan }}</p>
                                @endif
                                <div class="mt-3">
                                    <a href="{{ route('admin.spmb.dokumen.download', $dok) }}" 
                                       class="text-sm text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-download mr-1"></i> Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Upload Dokumen -->
<div id="uploadModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl max-w-md w-full p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-900">Upload Dokumen</h3>
            <button onclick="hideUploadModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="uploadForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="spmb_id" value="{{ $spmb->id }}">

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Dokumen *</label>
                    <select name="jenis_dokumen" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Jenis</option>
                        <option value="akte">Akta Kelahiran</option>
                        <option value="kk">Kartu Keluarga</option>
                        <option value="ktp">KTP Orang Tua</option>
                        <option value="bukti_transfer">Bukti Transfer</option>
                        <option value="sertifikat_prestasi">Sertifikat Prestasi</option>
                        <option value="surat_mutasi">Surat Mutasi</option>
                        <option value="kartu_bantuan">Kartu Bantuan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">File *</label>
                    <input type="file" name="file" required accept=".pdf,.jpg,.jpeg,.png"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Format: PDF, JPG, PNG (maks. 5MB)</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan (Opsional)</label>
                    <textarea name="keterangan" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Tambahkan keterangan jika perlu"></textarea>
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition">
                    Upload
                </button>
                <button type="button" onclick="hideUploadModal()" class="flex-1 border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium py-2 px-4 rounded-lg transition">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function showUploadModal() {
        document.getElementById('uploadModal').classList.remove('hidden');
        document.getElementById('uploadModal').classList.add('flex');
    }

    function hideUploadModal() {
        document.getElementById('uploadModal').classList.add('hidden');
        document.getElementById('uploadModal').classList.remove('flex');
        document.getElementById('uploadForm').reset();
    }

    document.getElementById('uploadForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        let formData = new FormData(this);
        
        fetch('{{ route("admin.spmb.dokumen.store", $spmb) }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    timer: 1500
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: data.message
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan sistem'
            });
        });
    });

    function deleteDokumen(id) {
        Swal.fire({
            title: 'Hapus Dokumen?',
            text: 'Dokumen yang dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`{{ url('admin/spmb/dokumen') }}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: data.message
                        });
                    }
                });
            }
        });
    }
</script>
@endpush