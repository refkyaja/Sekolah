@extends('layouts.admin')

@push('styles')
<style>
    .sidebar-scroll::-webkit-scrollbar { width: 4px; }
    .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
    .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.2); border-radius: 10px; }
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    #sidebar-toggle:checked ~ aside { width: 80px; }
    #sidebar-toggle:checked ~ aside .logo-text, #sidebar-toggle:checked ~ aside .nav-text, #sidebar-toggle:checked ~ aside .nav-section-title, #sidebar-toggle:checked ~ aside .system-status { display: none; }
    #sidebar-toggle:checked ~ aside .nav-item { justify-content: center; padding-left: 0; padding-right: 0; }
    #sidebar-toggle:checked ~ aside .nav-section-divider { display: block; border-top: 1px solid rgba(255, 255, 255, 0.1); margin: 1rem 0.5rem; }
    .nav-section-divider { display: none; }
    aside { transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
</style>
@endpush

@section('content')
<nav aria-label="Breadcrumb" class="flex mb-4 text-xs font-medium text-slate-400 dark:text-slate-500 uppercase tracking-widest">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li><a class="hover:text-primary" href="{{ route('admin.ppdb.index') }}">PPDB</a></li>
        <li><span class="mx-2">/</span></li>
        <li class="text-slate-600 dark:text-slate-400">Pengumuman Kelulusan</li>
    </ol>
</nav>

<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100 tracking-tight">Pengumuman Kelulusan PPDB</h1>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Daftar calon siswa yang dinyatakan lolos seleksi penerimaan siswa baru.</p>
    </div>
    <div class="flex items-center gap-3">
        @if($isPengumumanPublished)
            <div class="flex items-center gap-2 px-4 py-2 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-xl text-sm font-medium">
                <span class="material-symbols-outlined text-lg">check_circle</span>
                Sudah Dipublish
            </div>
            <a href="{{ route('admin.ppdb.riwayat') }}" class="flex items-center gap-2 px-6 py-3 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-2xl font-bold text-sm hover:bg-slate-200 dark:hover:bg-slate-600 transition-all">
                <span class="material-symbols-outlined text-lg">history</span>
                Lihat Riwayat
            </a>
        @else
            <button type="button" onclick="openPublishModal()" class="flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-2xl font-bold text-sm hover:bg-primary/90 transition-all shadow-lg shadow-primary/25">
                <span class="material-symbols-outlined text-lg">campaign</span>
                Publish Pengumuman
            </button>
        @endif
    </div>
</div>

@if($isPengumumanPublished)
<div class="bg-green-50 dark:bg-green-900/10 border border-green-200 rounded-2xl p-8 mb-8">
    <div class="flex items-center gap-4">
        <div class="w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-2xl flex items-center justify-center">
            <span class="material-symbols-outlined text-green-600 dark:text-green-500 text-4xl">check_circle</span>
        </div>
        <div>
            <h3 class="text-xl font-bold text-green-800 mb-1">Pengumuman Sudah Dipublish</h3>
            <p class="text-green-700 dark:text-green-400 text-sm">Data siswa telah dipindahkan ke Riwayat PPDB dan Data Siswa (Master Data).</p>
            <a href="{{ route('admin.ppdb.riwayat') }}" class="inline-flex items-center gap-1 mt-3 px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition-colors">
                <span class="material-symbols-outlined text-lg">folder_open</span>
                Lihat Riwayat PPDB
            </a>
        </div>
    </div>
</div>
@else
<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-800/50 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-primary">group</span>
            <h3 class="font-bold text-slate-800 dark:text-slate-100 uppercase tracking-tight text-sm">Daftar Seleksi PPDB</h3>
        </div>
        @if(!$isPengumumanPublished)
        <div class="flex items-center gap-2">
            <div class="relative group bulk-action-dropdown">
                <button type="button" class="px-4 py-2 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 text-[11px] font-bold rounded-xl hover:bg-slate-200 dark:hover:bg-slate-600 transition-all flex items-center gap-2 border border-slate-200 dark:border-slate-600">
                    <span class="material-symbols-outlined text-sm">edit_notifications</span>
                    Aksi Terpilih
                    <span class="material-symbols-outlined text-sm">expand_more</span>
                </button>
                <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl shadow-xl overflow-hidden z-30 hidden group-hover:block pointer-events-auto">
                    <button type="button" onclick="bulkUpdateStatus('Lulus')" class="w-full text-left px-4 py-3 text-[11px] font-bold text-green-600 hover:bg-slate-50 dark:hover:bg-slate-700 flex items-center gap-2 border-b border-slate-50 dark:border-slate-700">
                        <span class="material-symbols-outlined text-sm">check_circle</span>
                        Set Lulus
                    </button>
                    <button type="button" onclick="bulkUpdateStatus('Tidak Lulus')" class="w-full text-left px-4 py-3 text-[11px] font-bold text-red-600 hover:bg-slate-50 dark:hover:bg-slate-700 flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">cancel</span>
                        Set Tidak Lulus
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-700">
                    <th class="pl-6 py-4 w-12">
                        <input type="checkbox" id="selectAllPublish" class="w-4 h-4 rounded border-slate-300 text-primary">
                    </th>
                    <th class="px-4 py-4 text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider">Pendaftar</th>
                    <th class="px-4 py-4 text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider">Status Dokumen</th>
                    <th class="px-4 py-4 text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider">Hasil Seleksi</th>
                    <th class="px-4 py-4 text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider text-center">Status Publish</th>
                    <th class="px-4 py-4 text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
                @forelse($siswaLulus as $index => $siswa)
                @php
                    $isVerified = $siswa->status_pendaftaran !== 'Menunggu Verifikasi' && $siswa->status_pendaftaran !== 'Revisi Dokumen';
                    $statusClass = match($siswa->status_pendaftaran) {
                        'Lulus' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                        'Tidak Lulus' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                        'Dokumen Verified' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                        default => 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400'
                    };
                @endphp
                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/50 transition-colors group">
                    <td class="pl-6 py-4">
                        <input type="checkbox" name="ids[]" value="{{ $siswa->id }}" class="publish-checkbox w-4 h-4 rounded border-slate-300 text-primary" {{ $siswa->is_published ? 'checked' : '' }}>
                    </td>
                    <td class="px-4 py-4">
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-slate-800 dark:text-slate-100">{{ $siswa->nama_lengkap_anak }}</span>
                            <span class="text-[10px] text-slate-400 uppercase tracking-widest font-medium">{{ $siswa->no_pendaftaran }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-4">
                        @if($isVerified)
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-green-600 dark:text-green-500 uppercase tracking-wider">
                                <span class="material-symbols-outlined text-[14px]">verified</span>
                                Verified
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-500 uppercase tracking-wider">
                                <span class="material-symbols-outlined text-[14px]">hourglass_empty</span>
                                Pending
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-4">
                        <select onchange="updateStatus('{{ $siswa->id }}', this.value)" class="text-[11px] font-bold bg-slate-50 dark:bg-slate-900 border-slate-100 dark:border-slate-700 rounded-lg focus:ring-primary/20 focus:border-primary px-3 py-1.5 transition-all outline-none {{ $statusClass }}">
                            <option value="Dokumen Verified" {{ $siswa->status_pendaftaran == 'Dokumen Verified' ? 'selected' : '' }}>Verified (Belum Ada Hasil)</option>
                            <option value="Lulus" {{ $siswa->status_pendaftaran == 'Lulus' ? 'selected' : '' }}>LULUS</option>
                            <option value="Tidak Lulus" {{ $siswa->status_pendaftaran == 'Tidak Lulus' ? 'selected' : '' }}>TIDAK LULUS</option>
                        </select>
                    </td>
                    <td class="px-4 py-4 text-center">
                        @if($siswa->is_published)
                            <span class="inline-flex items-center justify-center p-1.5 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-500 rounded-full" title="Tampil di Homepage">
                                <span class="material-symbols-outlined text-sm">visibility</span>
                            </span>
                        @else
                            <span class="inline-flex items-center justify-center p-1.5 bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 rounded-full" title="Hidden">
                                <span class="material-symbols-outlined text-sm">visibility_off</span>
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-4 text-center">
                        <a href="{{ route('admin.ppdb.show', $siswa) }}" class="p-2 bg-slate-50 dark:bg-slate-900 hover:bg-primary/10 text-slate-400 hover:text-primary rounded-lg transition-all" title="Detail">
                            <span class="material-symbols-outlined text-sm">visibility</span>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-500">Belum ada data pendaftar</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
    @if($siswaLulus->hasPages())
    <div class="px-6 py-4 border-t border-slate-50 dark:border-slate-700/50 flex items-center justify-between">
        <p class="text-xs text-slate-400 dark:text-slate-500 font-medium">Menampilkan <span class="text-slate-900 dark:text-slate-100">{{ $siswaLulus->firstItem() }}</span> - <span class="text-slate-900 dark:text-slate-100">{{ $siswaLulus->lastItem() }}</span> dari <span class="text-slate-900 dark:text-slate-100">{{ $totalLulus }}</span> siswa lulus</p>
        <div class="flex gap-2">
            {{ $siswaLulus->links('pagination::tailwind') }}
        </div>
    </div>
    @endif
</div>
@endif

@if(!$isPengumumanPublished)
<!-- Publish Modal -->
<div id="publishModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-800 dark:bg-slate-900 rounded-3xl shadow-2xl max-w-md w-full p-8 relative overflow-hidden animate-in fade-in zoom-in duration-300">
        <div class="flex justify-center mb-6">
            <div class="w-20 h-20 bg-primary/10 rounded-3xl flex items-center justify-center">
                <span class="material-symbols-outlined text-primary text-5xl">rocket_launch</span>
            </div>
        </div>
        <h3 class="text-2xl font-bold text-center text-slate-900 dark:text-slate-100 dark:text-white mb-4">Konfirmasi Publikasi Pengumuman</h3>
        <div class="space-y-4">
            <p id="publishCountText" class="text-sm text-slate-500 dark:text-slate-400 text-center leading-relaxed">
                Pengumuman akan dirilis untuk pendaftar yang dipilih.
            </p>
            <div class="h-px bg-slate-100 dark:bg-slate-700 dark:bg-slate-800 w-full"></div>
            <p class="text-sm font-semibold text-slate-800 dark:text-slate-100 dark:text-slate-200 text-center px-2">
                Apakah Anda ingin memasukkan data calon siswa yang LULUS ke dalam database Data Siswa (Master Data)?
            </p>
            <form id="publishForm" action="{{ route('admin.ppdb.pengumuman.publish') }}" method="POST">
                @csrf
                <div id="selectedIdsContainer"></div>
                <div class="space-y-4">
                    <div class="bg-slate-50 dark:bg-slate-900 dark:bg-slate-800/50 p-4 rounded-2xl border border-slate-100 dark:border-slate-700 dark:border-slate-800">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" name="konversi_siswa" value="1" class="w-5 h-5 rounded border-slate-300 text-primary focus:ring-primary/20 transition-all cursor-pointer" onchange="toggleKelompokSelection(this.checked)">
                            <span class="text-xs font-medium text-slate-600 dark:text-slate-400 dark:text-slate-400 group-hover:text-primary transition-colors">
                                Ya, masukkan ke Data Siswa secara otomatis
                            </span>
                        </label>
                    </div>

                    <div id="kelompokSelection" class="hidden animate-in fade-in slide-in-from-top-2 duration-300">
                        <label class="block text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2">Target Kelompok Siswa</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="relative flex flex-col p-4 bg-slate-50 dark:bg-slate-900 border-2 border-slate-100 dark:border-slate-700 rounded-2xl cursor-pointer hover:border-primary/50 transition-all has-[:checked]:border-primary has-[:checked]:bg-primary/5 group">
                                <input type="radio" name="kelompok_tujuan" value="A" checked class="hidden">
                                <span class="text-lg font-black text-slate-800 dark:text-slate-100 group-has-[:checked]:text-primary mb-1 text-center">A</span>
                                <span class="text-[10px] text-slate-400 dark:text-slate-500 text-center uppercase tracking-widest font-bold">TK Kelompok A</span>
                            </label>
                            <label class="relative flex flex-col p-4 bg-slate-50 dark:bg-slate-900 border-2 border-slate-100 dark:border-slate-700 rounded-2xl cursor-pointer hover:border-primary/50 transition-all has-[:checked]:border-primary has-[:checked]:bg-primary/5 group">
                                <input type="radio" name="kelompok_tujuan" value="B" class="hidden">
                                <span class="text-lg font-black text-slate-800 dark:text-slate-100 group-has-[:checked]:text-primary mb-1 text-center">B</span>
                                <span class="text-[10px] text-slate-400 dark:text-slate-500 text-center uppercase tracking-widest font-bold">TK Kelompok B</span>
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="grid grid-cols-1 gap-3 mt-8">
            <button type="submit" form="publishForm" class="w-full py-3.5 bg-primary text-white rounded-2xl font-bold text-sm hover:bg-primary/90 transition-all shadow-lg shadow-primary/25 flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-lg">check_circle</span>
                Ya, Publish Pengumuman
            </button>
            <button type="button" onclick="closePublishModal()" class="w-full py-3.5 bg-transparent text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-200 rounded-2xl font-bold text-sm transition-all hover:bg-slate-50 dark:hover:bg-slate-700 dark:hover:bg-slate-800">
                Batal
            </button>
        </div>
    </div>
</div>
@endif

<form id="bulkStatusForm" action="{{ route('admin.ppdb.bulk-update-status') }}" method="POST" class="hidden">
    @csrf
    <input type="hidden" name="selected_ids" id="bulkStatusIds">
    <input type="hidden" name="status" id="bulkStatusValue">
</form>

@push('scripts')
<script>
    function toggleKelompokSelection(show) {
        const div = document.getElementById('kelompokSelection');
        if (div) {
            div.classList.toggle('hidden', !show);
        }
    }

    function updateStatus(id, status) {
        const select = event.target;
        select.style.opacity = '0.5';
        select.disabled = true;

        fetch(`{{ url('admin/ppdb/pengumuman/hasil-seleksi') }}/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (status === 'Lulus') {
                    select.className = 'text-[11px] font-bold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 border-slate-100 dark:border-slate-700 rounded-lg focus:ring-primary/20 focus:border-primary px-3 py-1.5 transition-all outline-none';
                } else if (status === 'Tidak Lulus') {
                    select.className = 'text-[11px] font-bold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 border-slate-100 dark:border-slate-700 rounded-lg focus:ring-primary/20 focus:border-primary px-3 py-1.5 transition-all outline-none';
                } else {
                    select.className = 'text-[11px] font-bold bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border-slate-100 dark:border-slate-700 rounded-lg focus:ring-primary/20 focus:border-primary px-3 py-1.5 transition-all outline-none';
                }
            } else {
                alert('Gagal memperbarui status: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memperbarui status.');
        })
        .finally(() => {
            select.style.opacity = '1';
            select.disabled = false;
        });
    }

    function getSelectedIds() {
        return Array.from(document.querySelectorAll('.publish-checkbox:checked'))
            .map(cb => cb.value);
    }

    function bulkUpdateStatus(status) {
        const ids = getSelectedIds();
        if (ids.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Tidak Ada Data Terpilih',
                text: 'Silakan pilih pendaftar yang ingin diubah statusnya.',
                confirmButtonColor: '#6B46C1',
            });
            return;
        }

        Swal.fire({
            title: 'Update Status Terpilih?',
            text: `Anda akan mengubah status ${ids.length} pendaftar menjadi ${status}.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: status === 'Lulus' ? '#10b981' : '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Update',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('bulkStatusIds').value = ids.join(',');
                document.getElementById('bulkStatusValue').value = status;
                document.getElementById('bulkStatusForm').submit();
            }
        });
    }

    function openPublishModal() {
        const ids = getSelectedIds();
        const container = document.getElementById('selectedIdsContainer');
        container.innerHTML = '';
        
        if (ids.length > 0) {
            ids.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = id;
                container.appendChild(input);
            });
        }
        
        const modal = document.getElementById('publishModal');
        const countText = document.getElementById('publishCountText');
        
        if (ids.length > 0) {
            countText.innerHTML = `Anda telah memilih <b>${ids.length}</b> pendaftar untuk dipublish.`;
        } else {
            countText.innerHTML = `Tidak ada pendaftar terpilih. <br><span class="text-primary font-bold">Semua pendaftar</span> yang sudah memiliki hasil (Lulus/Tidak Lulus) akan dipublish secara otomatis.`;
        }

        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    function closePublishModal() {
        const modal = document.getElementById('publishModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    document.getElementById('selectAllPublish')?.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.publish-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    document.getElementById('publishModal')?.addEventListener('click', function(e) {
        if (e.target === this) closePublishModal();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closePublishModal();
    });
</script>
@endpush
@endsection
