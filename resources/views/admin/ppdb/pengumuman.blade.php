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
<nav aria-label="Breadcrumb" class="flex mb-4 text-xs font-medium text-slate-400 uppercase tracking-widest">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li><a class="hover:text-primary" href="{{ route('admin.ppdb.index') }}">PPDB</a></li>
        <li><span class="mx-2">/</span></li>
        <li class="text-slate-600">Pengumuman Kelulusan</li>
    </ol>
</nav>

<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Pengumuman Kelulusan PPDB</h1>
        <p class="text-sm text-slate-500 mt-1">Daftar calon siswa yang dinyatakan lolos seleksi penerimaan siswa baru.</p>
    </div>
    <div class="flex items-center gap-3">
        <button type="button" onclick="openPublishModal()" class="flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-2xl font-bold text-sm hover:bg-primary/90 transition-all shadow-lg shadow-primary/25">
            <span class="material-symbols-outlined text-lg">campaign</span>
            Publish Pengumuman
        </button>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-8">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th class="pl-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-wider w-16">No</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-wider">Kode Pendaftaran</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-wider">Nama Lengkap</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-wider">Jenis Kelamin</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($siswaLulus as $index => $siswa)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="pl-6 py-4 text-sm font-medium text-slate-400">{{ $siswaLulus->firstItem() + $index }}</td>
                    <td class="px-6 py-4 text-sm font-bold text-primary">{{ $siswa->no_pendaftaran }}</td>
                    <td class="px-6 py-4">
                        <span class="text-sm font-bold text-slate-800">{{ $siswa->nama_lengkap_anak }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600">{{ $siswa->jenis_kelamin ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-700 uppercase tracking-wider">LULUS</span>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.ppdb.show', $siswa) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-50 hover:bg-primary/10 text-slate-500 hover:text-primary rounded-lg transition-all text-[11px] font-bold">
                            <span class="material-symbols-outlined text-sm">visibility</span>
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <span class="material-symbols-outlined text-5xl text-slate-300 mb-3">search_off</span>
                            <p class="text-slate-500 font-medium">Belum ada siswa yang lulus</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($siswaLulus->hasPages())
    <div class="px-6 py-4 border-t border-slate-50 flex items-center justify-between">
        <p class="text-xs text-slate-400 font-medium">Menampilkan <span class="text-slate-900">{{ $siswaLulus->firstItem() }}</span> - <span class="text-slate-900">{{ $siswaLulus->lastItem() }}</span> dari <span class="text-slate-900">{{ $totalLulus }}</span> siswa lulus</p>
        <div class="flex gap-2">
            {{ $siswaLulus->links('pagination::tailwind') }}
        </div>
    </div>
    @endif
</div>

<!-- Publish Modal -->
<div id="publishModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-2xl max-w-md w-full p-8 relative overflow-hidden animate-in fade-in zoom-in duration-300">
        <div class="flex justify-center mb-6">
            <div class="w-20 h-20 bg-primary/10 rounded-3xl flex items-center justify-center">
                <span class="material-symbols-outlined text-primary text-5xl">rocket_launch</span>
            </div>
        </div>
        <h3 class="text-2xl font-bold text-center text-slate-900 dark:text-white mb-4">Konfirmasi Publikasi Pengumuman</h3>
        <div class="space-y-4">
            <p class="text-sm text-slate-500 dark:text-slate-400 text-center leading-relaxed">
                Pengumuman akan dirilis otomatis ketika waktu yang di-setting sudah habis.
            </p>
            <div class="h-px bg-slate-100 dark:bg-slate-800 w-full"></div>
            <p class="text-sm font-semibold text-slate-800 dark:text-slate-200 text-center px-2">
                Apakah Anda ingin memasukkan data calon siswa yang LULUS ke dalam database Data Siswa (Master Data)?
            </p>
            <form id="publishForm" action="{{ route('admin.ppdb.pengumuman.publish') }}" method="POST">
                @csrf
                <div class="bg-slate-50 dark:bg-slate-800/50 p-4 rounded-2xl border border-slate-100 dark:border-slate-800">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" name="konversi_siswa" value="1" class="w-5 h-5 rounded border-slate-300 text-primary focus:ring-primary/20 transition-all cursor-pointer">
                        <span class="text-xs font-medium text-slate-600 dark:text-slate-400 group-hover:text-primary transition-colors">
                            Ya, masukkan ke Data Siswa secara otomatis
                        </span>
                    </label>
                </div>
            </form>
        </div>
        <div class="grid grid-cols-1 gap-3 mt-8">
            <button type="submit" form="publishForm" class="w-full py-3.5 bg-primary text-white rounded-2xl font-bold text-sm hover:bg-primary/90 transition-all shadow-lg shadow-primary/25">
                Ya, Publish Sekarang
            </button>
            <button type="button" onclick="closePublishModal()" class="w-full py-3.5 bg-transparent text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 rounded-2xl font-bold text-sm transition-all hover:bg-slate-50 dark:hover:bg-slate-800">
                Batal
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openPublishModal() {
        document.getElementById('publishModal').classList.remove('hidden');
        document.getElementById('publishModal').classList.add('flex');
    }

    function closePublishModal() {
        document.getElementById('publishModal').classList.add('hidden');
        document.getElementById('publishModal').classList.remove('flex');
    }

    document.getElementById('publishModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closePublishModal();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closePublishModal();
        }
    });
</script>
@endpush
@endsection
