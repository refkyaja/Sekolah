<div>
    @php
        $role = auth()->user()->role;
        $user = auth()->user();
        $routePrefix = match ($role) {
            'admin' => 'admin',
            'operator' => 'operator',
            'kepala_sekolah' => 'kepala-sekolah',
            'guru' => 'guru',
            default => 'admin',
        };
        $canManagePpdb = $user->canAccessModule('ppdb', 'delete');
        $canCreatePpdb = $user->canAccessModule('ppdb', 'create') && \Illuminate\Support\Facades\Route::has($routePrefix . '.ppdb.create');
        $canEditPpdb = $user->canAccessModule('ppdb', 'update') && \Illuminate\Support\Facades\Route::has($routePrefix . '.ppdb.edit');
    @endphp

    <div class="bg-white rounded-2xl p-6 mb-8 border border-slate-100 shadow-sm flex flex-wrap items-center gap-4">
        <div class="flex-1 min-w-[250px] relative">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">search</span>
            <input
                wire:model.live.debounce.300ms="search"
                class="w-full pl-12 pr-4 py-3 bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-sm transition-all"
                placeholder="Cari Kode Pendaftaran atau Nama..."
                type="text"
            />
        </div>

        <div class="w-full md:w-56">
            <select wire:model.live="status_pendaftaran" class="w-full px-4 py-3 bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-sm text-slate-600 transition-all cursor-pointer">
                <option value="">Semua Status</option>
                <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
                <option value="Revisi Dokumen">Revisi Dokumen</option>
                <option value="Dokumen Verified">Dokumen Verified</option>
                <option value="Lulus">Lulus</option>
                <option value="Tidak Lulus">Tidak Lulus</option>
            </select>
        </div>

        @if($search || $status_pendaftaran)
        <button type="button" wire:click="resetFilters" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-200 transition-all">
            Reset Filter
        </button>
        @endif

        @if($canManagePpdb && !empty($selectedIds))
        <div class="w-full md:w-56" x-data="{ open: false }">
            <div class="relative">
                <button type="button" @click="open = !open" class="w-full px-4 py-3 bg-primary text-white rounded-xl font-bold text-sm flex items-center justify-between">
                    <span>Aksi Massal ({{ count($selectedIds) }})</span>
                    <span class="material-symbols-outlined text-base">expand_more</span>
                </button>
                <div x-show="open" @click.away="open = false" class="absolute z-10 w-full mt-2 bg-white border border-slate-100 rounded-xl shadow-xl overflow-hidden">
                    <button type="button" onclick="confirm('Ubah status Lulus untuk {{ count($selectedIds) }} data?') && @this.bulkLulus()" class="w-full px-4 py-3 text-left text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-[20px] text-green-600">check_circle</span>
                        Lulus Terpilih
                    </button>
                    <button type="button" onclick="confirm('Hapus {{ count($selectedIds) }} data terpilih? Tindakan ini tidak dapat dibatalkan.') && @this.bulkDelete()" class="w-full px-4 py-3 text-left text-sm font-semibold text-rose-600 hover:bg-rose-50 transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-[20px]">delete</span>
                        Hapus Terpilih
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-8 relative">
        <div wire:loading.delay class="absolute inset-0 bg-white/40 z-10 flex items-center justify-center">
            <div class="bg-white px-4 py-2 rounded-full shadow-lg flex items-center gap-2 border border-slate-100">
                <span class="material-symbols-outlined animate-spin text-primary text-xl">progress_activity</span>
                <span class="text-xs font-bold text-slate-600">Memproses...</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse data-table">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        @if($canManagePpdb)
                            <th class="pl-6 py-4 w-12">
                                <input wire:model.live="selectAll" class="w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary transition-all cursor-pointer" type="checkbox" />
                            </th>
                        @endif
                        <th class="px-4 py-4 text-[11px] font-black text-slate-400 uppercase tracking-wider w-16">No</th>
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-wider">Kode Pendaftaran</th>
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-wider">Nama Lengkap</th>
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-wider">Jenis Kelamin</th>
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-wider">Tanggal &amp; Waktu Pendaftaran</th>
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($spmb as $index => $item)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        @if($canManagePpdb)
                            <td class="pl-6 py-4">
                                <input wire:model.live="selectedIds" class="w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary transition-all cursor-pointer" type="checkbox" value="{{ $item->id }}" />
                            </td>
                        @endif
                        <td class="px-4 py-4 text-sm font-medium text-slate-400">{{ $spmb->firstItem() + $index }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-primary">{{ $item->no_pendaftaran ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-slate-800">{{ $item->nama_lengkap_anak ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            @if($item->jenis_kelamin == 'Laki-laki')
                                Laki-laki
                            @elseif($item->jenis_kelamin == 'Perempuan')
                                Perempuan
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $item->created_at ? $item->created_at->format('d M Y, H:i') : '-' }}</td>
                        <td class="px-6 py-4">
                            @switch($item->status_pendaftaran)
                                @case('Menunggu Verifikasi')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-orange-100 text-orange-700 uppercase tracking-wider">Menunggu Verifikasi</span>
                                    @break
                                @case('Revisi Dokumen')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700 uppercase tracking-wider">Revisi Dokumen</span>
                                    @break
                                @case('Dokumen Verified')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700 uppercase tracking-wider">Dokumen Verified</span>
                                    @break
                                @case('Lulus')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-700 uppercase tracking-wider">Lulus</span>
                                    @break
                                @case('Tidak Lulus')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-700 uppercase tracking-wider">Tidak Lulus</span>
                                    @break
                                @default
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-yellow-100 text-yellow-700 uppercase tracking-wider">{{ $item->status_pendaftaran ?? '-' }}</span>
                            @endswitch
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route($routePrefix . '.ppdb.show', $item->id) }}" class="p-2 bg-slate-50 hover:bg-primary/10 text-slate-400 hover:text-primary rounded-lg transition-all" title="Show">
                                    <span class="material-symbols-outlined text-lg">visibility</span>
                                </a>
                                @if($canEditPpdb)
                                    <a href="{{ route($routePrefix . '.ppdb.edit', $item->id) }}" class="p-2 bg-slate-50 hover:bg-primary/10 text-slate-400 hover:text-primary rounded-lg transition-all" title="Edit">
                                        <span class="material-symbols-outlined text-lg">edit</span>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ $canManagePpdb ? '8' : '7' }}" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <span class="material-symbols-outlined text-5xl text-slate-300 mb-3">folder_off</span>
                                <p class="text-slate-500 font-medium">Tidak ada data pendaftaran</p>
                                @if($canCreatePpdb)
                                    <a href="{{ route($routePrefix . '.ppdb.create') }}" class="text-primary hover:underline text-sm mt-2">Tambah data baru</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-slate-50 flex items-center justify-between">
            <p class="text-xs text-slate-400 font-medium">Showing <span class="text-slate-900">{{ $spmb->firstItem() ?? 0 }}</span> to <span class="text-slate-900">{{ $spmb->lastItem() ?? 0 }}</span> of <span class="text-slate-900">{{ $spmb->total() }}</span> pendaftar</p>
            <div>
                {{ $spmb->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</div>
