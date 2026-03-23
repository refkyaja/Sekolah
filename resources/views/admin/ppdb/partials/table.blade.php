{{-- resources/views/admin/ppdb/partials/table.blade.php --}}
<table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700/50">
    <thead class="bg-gray-50 dark:bg-slate-900/50">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                No Pendaftaran
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                Calon Siswa
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                Orang Tua
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                Kelompok & Jalur
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                Status
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                Aksi
            </th>
        </tr>
    </thead>
    <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700/50">
        @forelse ($ppdb as $item)
        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50">
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                    {{ $item->no_pendaftaran ?? 'P-' . str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
                </div>
                <div class="text-xs text-gray-500 dark:text-gray-400">
                    {{ $item->created_at->format('d/m/Y') }}
                </div>
            </td>
            <td class="px-6 py-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                        @if($item->foto_calon_siswa)
                        <img class="h-10 w-10 rounded-full object-cover" 
                             src="{{ Storage::url($item->foto_calon_siswa) }}" 
                             alt="{{ $item->nama_calon_siswa }}">
                        @else
                        <div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                            <i class="fas fa-user text-blue-600 dark:text-blue-500"></i>
                        </div>
                        @endif
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                            {{ $item->nama_calon_siswa }}
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $item->tempat_lahir }}, {{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d/m/Y') }}
                            • {{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </div>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4">
                <div class="text-sm text-gray-900 dark:text-gray-100">{{ $item->nama_ayah }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $item->nama_ibu }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $item->no_hp_ortu }}</div>
            </td>
            <td class="px-6 py-4">
                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                    Kelompok {{ $item->pilihan_kelompok }}
                </div>
                <div class="text-xs">
                    <span class="px-2 py-1 rounded-full bg-gray-100 dark:bg-slate-700 text-gray-800 dark:text-gray-200">
                        {{ ucfirst($item->jalur_pendaftaran) }}
                    </span>
                </div>
            </td>
            <td class="px-6 py-4">
                <div class="flex flex-col gap-2">
                    <button class="quick-status-btn action-btn status-{{ $item->status }}"
                            data-id="{{ $item->id }}"
                            data-status="{{ $item->status }}">
                        @php
                            $statusLabel = match($item->status) {
                                'menunggu' => 'Menunggu Verifikasi',
                                'diproses' => 'Dokumen Verified',
                                'diterima' => 'Lulus',
                                'ditolak' => 'Tidak Lulus',
                                'cadangan' => 'Cadangan',
                                default => ucfirst($item->status),
                            };
                        @endphp
                        {{ $statusLabel }}
                    </button>
                    
                    <button class="quick-payment-btn action-btn payment-{{ $item->status_pembayaran }}"
                            data-id="{{ $item->id }}"
                            data-payment="{{ $item->status_pembayaran }}">
                        @if($item->status_pembayaran == 'belum')
                            Belum Bayar
                        @elseif($item->status_pembayaran == 'pending')
                            Pending
                        @else
                            Lunas
                        @endif
                    </button>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <div class="flex gap-2">
                    <a href="{{ route('admin.ppdb.show', $item) }}" 
                       class="text-blue-600 dark:text-blue-500 hover:text-blue-900 dark:hover:text-blue-300 action-btn bg-blue-50 dark:bg-blue-900/10">
                        <i class="fas fa-eye"></i>
                    </a>
                    
                    <a href="{{ route('admin.ppdb.edit', $item) }}" 
                       class="text-yellow-600 dark:text-yellow-500 hover:text-yellow-900 dark:hover:text-yellow-300 action-btn bg-yellow-50 dark:bg-yellow-900/10">
                        <i class="fas fa-edit"></i>
                    </a>
                    
                    @if($item->status == 'diterima' && $item->status_pembayaran == 'lunas')
                    <button onclick="konversiKeSiswa({{ $item->id }})"
                            class="text-green-600 dark:text-green-500 hover:text-green-900 dark:hover:text-green-300 action-btn bg-green-50 dark:bg-green-900/10"
                            title="Konversi ke Siswa">
                        <i class="fas fa-exchange-alt"></i>
                    </button>
                    @endif
                    
                    <form action="{{ route('admin.ppdb.destroy', $item) }}" 
                          method="POST" 
                          class="inline"
                          onsubmit="return confirm('Hapus data pendaftaran ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="text-red-600 dark:text-red-500 hover:text-red-900 dark:hover:text-red-300 action-btn bg-red-50 dark:bg-red-900/10">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="px-6 py-12 text-center">
                <div class="text-gray-400 dark:text-gray-500">
                    <i class="fas fa-inbox text-4xl mb-3"></i>
                    <p class="text-lg">Tidak ada data pendaftaran</p>
                    @if(request()->anyFilled(['search', 'status', 'kelompok', 'jalur', 'status_pembayaran']))
                    <p class="text-sm mt-2">Coba ubah filter pencarian Anda</p>
                    @endif
                </div>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>