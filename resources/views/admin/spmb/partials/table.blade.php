@if(isset($spmb) && $spmb->count() > 0)
<!-- Bulk Action Bar -->
<div id="bulkActionBar" class="hidden fixed bottom-6 left-1/2 transform -translate-x-1/2 z-50 bg-white rounded-xl shadow-2xl border border-gray-200 px-5 py-3 flex items-center gap-3 animate-slide-up">
    <div class="flex items-center gap-2 bg-blue-50 px-3 py-1.5 rounded-lg">
        <i class="fas fa-check-square text-blue-600 text-sm"></i>
        <span id="selectedCount" class="text-sm font-semibold text-blue-700">0</span>
        <span class="text-sm text-blue-600">terpilih</span>
    </div>
    
    <div class="w-px h-6 bg-gray-200"></div>
    
    <button type="button" 
            onclick="bulkUpdateStatus()"
            id="bulkStatusBtn"
            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors">
        <i class="fas fa-sliders-h mr-1.5"></i>
        <span class="hidden sm:inline">Update Status</span>
        <span class="sm:hidden">Status</span>
    </button>
    
    <button type="button" 
            onclick="bulkKonversi()"
            id="bulkKonversiBtn"
            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-purple-700 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors">
        <i class="fas fa-user-graduate mr-1.5"></i>
        <span class="hidden sm:inline">Konversi ke Siswa</span>
        <span class="sm:hidden">Konversi</span>
    </button>
    
    <button type="button" 
            onclick="bulkDelete()"
            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-700 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
        <i class="fas fa-trash mr-1.5"></i>
        <span class="hidden sm:inline">Hapus</span>
        <span class="sm:hidden">Hapus</span>
    </button>
    
    <button type="button" 
            onclick="clearSelection()"
            class="inline-flex items-center px-2 py-1.5 text-xs font-medium text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
        <i class="fas fa-times"></i>
    </button>
</div>

<!-- Header Info & Select All -->
<div class="px-4 sm:px-6 py-3 bg-gray-50 border-b border-gray-200 flex flex-wrap items-center justify-between gap-3">
    <div class="flex items-center gap-4">
        <div class="flex items-center">
            <input type="checkbox" 
                   id="selectAllCheckbox" 
                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer transition-all"
                   onclick="toggleSelectAll(this)">
            <label for="selectAllCheckbox" class="ml-2 text-sm font-medium text-gray-700 cursor-pointer select-none">
                Pilih Semua
            </label>
        </div>
        
        @if(request()->has('search') && !empty(request('search')))
        <div class="flex items-center text-sm text-gray-500">
            <i class="fas fa-search mr-1 text-gray-400 text-xs"></i>
            Hasil pencarian: {{ $spmb->total() }} data
        </div>
        @endif
    </div>
    
    <div class="flex items-center gap-2">
        <span class="text-xs text-gray-500">
            <span id="selectedCountText">0</span> dari {{ $spmb->total() }} dipilih
        </span>
        @if($spmb->total() > 0)
        <button onclick="clearSelection()" 
                id="clearSelectionBtn"
                class="text-xs text-gray-500 hover:text-gray-700 hover:bg-gray-200 px-2 py-1 rounded hidden">
            <i class="fas fa-times mr-1"></i> Hapus pilihan
        </button>
        @endif
    </div>
</div>

<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <!-- Checkbox Column -->
                <th class="pl-4 pr-2 py-3 text-left w-10">
                    <span class="sr-only">Pilih</span>
                </th>
                
                <!-- No -->
                <th class="pl-4 pr-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap hidden sm:table-cell">
                    No
                </th>
                
                <!-- No. Pendaftaran -->
                <th class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                    <span class="hidden sm:inline">No. Pendaftaran</span>
                    <span class="sm:hidden">No. Daftar</span>
                </th>
                
                <!-- Nama Anak -->
                <th class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                    <span class="hidden sm:inline">Nama Lengkap Anak</span>
                    <span class="sm:hidden">Nama Anak</span>
                </th>
                
                <!-- Jenis Kelamin -->
                <th class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap hidden md:table-cell">
                    JK
                </th>
                
                <!-- Usia -->
                <th class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap hidden lg:table-cell">
                    Usia
                </th>
                
                <!-- Jenis Daftar -->
                <th class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap hidden xl:table-cell">
                    Jenis Daftar
                </th>
                
                <!-- Status Pendaftaran -->
                <th class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                    Status
                </th>
                
                <!-- Aksi -->
                <th class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                    Aksi
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($spmb as $index => $item)
            <tr id="row-{{ $item->id }}" class="hover:bg-gray-50 transition-colors duration-150 group">
                <!-- Checkbox -->
                <td class="pl-4 pr-2 py-3 whitespace-nowrap w-10">
                    <input type="checkbox" 
                           name="selected_items[]" 
                           value="{{ $item->id }}"
                           data-status="{{ $item->status_pendaftaran }}"
                           data-can-konversi="{{ $item->status_pendaftaran == 'Diterima' && !$item->siswa ? 'true' : 'false' }}"
                           class="item-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer transition-all"
                           onclick="updateSelectedCount()">
                </td>
                
                <!-- No - Hidden di Mobile -->
                <td class="pl-4 pr-4 py-3 whitespace-nowrap text-sm text-gray-500 hidden sm:table-cell">
                    {{ ($spmb->currentPage() - 1) * $spmb->perPage() + $index + 1 }}
                </td>
                
                <!-- No Pendaftaran -->
                <td class="px-2 sm:px-6 py-3 whitespace-nowrap">
                    <div class="text-xs sm:text-sm font-mono font-medium text-gray-900">
                        {{ $item->no_pendaftaran }}
                    </div>
                    <div class="text-xs text-gray-400 mt-1">
                        {{ $item->created_at->format('d/m/Y H:i') }}
                    </div>
                </td>
                
                <!-- Nama Anak -->
                <td class="px-2 sm:px-6 py-3 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-blue-100 to-blue-50 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 font-bold text-xs sm:text-sm">
                                {{ strtoupper(substr($item->nama_lengkap_anak, 0, 1)) }}
                            </span>
                        </div>
                        <div class="ml-3 min-w-0">
                            <div class="text-sm font-medium text-gray-900 truncate max-w-[120px] sm:max-w-[180px]">
                                {{ $item->nama_lengkap_anak }}
                            </div>
                            <div class="text-xs text-gray-500 truncate">
                                {{ $item->nama_panggilan_anak ?: '-' }}
                            </div>
                        </div>
                    </div>
                </td>
                
                <!-- Jenis Kelamin -->
                <td class="px-2 sm:px-6 py-3 whitespace-nowrap hidden md:table-cell">
                    @if($item->jenis_kelamin == 'Laki-laki')
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <i class="fas fa-mars mr-1"></i> L
                        </span>
                    @else
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-pink-100 text-pink-800">
                            <i class="fas fa-venus mr-1"></i> P
                        </span>
                    @endif
                </td>
                
                <!-- Usia -->
                <td class="px-2 sm:px-6 py-3 whitespace-nowrap hidden lg:table-cell">
                    <span class="text-sm text-gray-900">{{ $item->usia_label }}</span>
                    <div class="text-xs text-gray-500 mt-1">
                        {{ $item->tanggal_lahir_anak->format('d/m/Y') }}
                    </div>
                </td>
                
                <!-- Jenis Daftar -->
                <td class="px-2 sm:px-6 py-3 whitespace-nowrap hidden xl:table-cell">
                    @if($item->jenis_daftar == 'Siswa Baru')
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-user-plus mr-1"></i> Baru
                        </span>
                    @else
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                            <i class="fas fa-exchange-alt mr-1"></i> Pindahan
                        </span>
                    @endif
                </td>
                
                <!-- Status Pendaftaran -->
                <td class="px-2 sm:px-6 py-3 whitespace-nowrap">
                    @if($item->status_pendaftaran == 'Diterima')
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1 text-xs"></i>
                            <span class="hidden sm:inline">Diterima</span>
                            <span class="sm:hidden">T</span>
                        </span>
                    @elseif($item->status_pendaftaran == 'Menunggu Verifikasi')
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            <i class="fas fa-clock mr-1 text-xs"></i>
                            <span class="hidden sm:inline">Menunggu</span>
                            <span class="sm:hidden">M</span>
                        </span>
                    @elseif($item->status_pendaftaran == 'Mundur')
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            <i class="fas fa-times-circle mr-1 text-xs"></i>
                            <span class="hidden sm:inline">Mundur</span>
                            <span class="sm:hidden">X</span>
                        </span>
                    @endif
                    
                    @if($item->is_aktif)
                        <span class="inline-flex items-center px-2 py-1 mt-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <i class="fas fa-check-circle mr-1 text-xs"></i> Aktif
                        </span>
                    @endif
                </td>
                
                <!-- Aksi -->
                <td class="px-2 sm:px-6 py-3 whitespace-nowrap text-sm font-medium">
                    <div class="flex items-center space-x-0.5 sm:space-x-2">
                        <a href="{{ route('admin.spmb.show', $item->id) }}" 
                           class="text-blue-600 hover:text-blue-900 p-1.5 sm:p-2 hover:bg-blue-50 rounded transition-colors duration-150"
                           title="Detail">
                            <i class="fas fa-eye text-xs sm:text-sm"></i>
                        </a>
                        
                        <a href="{{ route('admin.spmb.edit', $item->id) }}" 
                           class="text-green-600 hover:text-green-900 p-1.5 sm:p-2 hover:bg-green-50 rounded transition-colors duration-150"
                           title="Edit">
                            <i class="fas fa-edit text-xs sm:text-sm"></i>
                        </a>
                        
                        <button type="button"
                                data-spmb-id="{{ $item->id }}"
                                data-spmb-name="{{ $item->nama_lengkap_anak }}"
                                data-spmb-status="{{ $item->status_pendaftaran }}"
                                class="update-status-btn text-indigo-600 hover:text-indigo-900 p-1.5 sm:p-2 hover:bg-indigo-50 rounded transition-colors duration-150"
                                title="Update Status">
                            <i class="fas fa-sliders-h text-xs sm:text-sm"></i>
                        </button>
                        
                        @if($item->status_pendaftaran == 'Diterima' && !$item->siswa)
                            <button type="button"
                                    onclick="konversiKeSiswa({{ $item->id }}, '{{ $item->nama_lengkap_anak }}')"
                                    class="text-purple-600 hover:text-purple-900 p-1.5 sm:p-2 hover:bg-purple-50 rounded transition-colors duration-150"
                                    title="Konversi ke Siswa">
                                <i class="fas fa-user-graduate text-xs sm:text-sm"></i>
                            </button>
                        @endif
                        
                        <button type="button"
                                onclick="confirmDelete({{ $item->id }}, '{{ $item->nama_lengkap_anak }}')"
                                class="text-red-600 hover:text-red-900 p-1.5 sm:p-2 hover:bg-red-50 rounded transition-colors duration-150"
                                title="Hapus">
                            <i class="fas fa-trash text-xs sm:text-sm"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


<!-- Modal Update Status -->
<div id="updateStatusModal" class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0">
        <!-- Header -->
        <div class="px-5 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-sliders-h text-indigo-500 mr-2"></i>
                    <span id="modalTitle">Update Status Pendaftaran</span>
                </h3>
                <button type="button" 
                        class="close-modal text-gray-400 hover:text-gray-600 hover:bg-gray-100 w-8 h-8 rounded-full flex items-center justify-center">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <p id="modalSubtitle" class="text-xs text-gray-500 mt-1">
                ID: <span id="modalSpmbId" class="font-mono font-medium">#</span> • 
                <span id="modalStudentName" class="font-medium text-gray-700"></span>
            </p>
        </div>
        
        <!-- Body -->
        <div class="px-5 py-4">
            <form id="updateStatusForm" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Status Pendaftaran -->
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                        <i class="fas fa-flag text-gray-400 mr-1.5 text-xs"></i>
                        Status Pendaftaran
                    </label>
                    <div class="grid grid-cols-1 gap-2">
                        <label class="relative flex items-center p-2.5 border rounded-lg cursor-pointer transition-all has-[:checked]:border-yellow-500 has-[:checked]:bg-yellow-50">
                            <input type="radio" name="status" value="Menunggu Verifikasi" class="mr-2">
                            <span class="text-sm flex items-center">
                                <i class="fas fa-clock text-yellow-600 mr-2"></i> Menunggu Verifikasi
                            </span>
                        </label>
                        <label class="relative flex items-center p-2.5 border rounded-lg cursor-pointer transition-all has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                            <input type="radio" name="status" value="Diterima" class="mr-2">
                            <span class="text-sm flex items-center">
                                <i class="fas fa-check-circle text-green-600 mr-2"></i> Diterima
                            </span>
                        </label>
                        <label class="relative flex items-center p-2.5 border rounded-lg cursor-pointer transition-all has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                            <input type="radio" name="status" value="Mundur" class="mr-2">
                            <span class="text-sm flex items-center">
                                <i class="fas fa-times-circle text-red-600 mr-2"></i> Mundur
                            </span>
                        </label>
                    </div>
                </div>
                
                <!-- Catatan -->
                <div class="mb-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5 flex items-center">
                        <i class="fas fa-sticky-note text-gray-400 mr-1.5 text-xs"></i>
                        Catatan
                    </label>
                    <textarea name="catatan" rows="2" 
                              class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                              placeholder="Tambahkan catatan..."></textarea>
                </div>
            </form>
        </div>
        
        <!-- Footer -->
        <div class="px-5 py-3 border-t border-gray-200 bg-gray-50 rounded-b-xl flex justify-end space-x-2">
            <button type="button" 
                    class="close-modal px-4 py-2 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                Batal
            </button>
            <button type="button" 
                    id="saveStatus" 
                    class="px-4 py-2 text-xs font-medium text-white bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg hover:from-indigo-600 hover:to-indigo-700 flex items-center">
                <i class="fas fa-save mr-1.5"></i> Simpan
            </button>
        </div>
    </div>
</div>

<!-- Modal Bulk Update Status -->
<div id="bulkUpdateStatusModal" class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0">
        <!-- Header -->
        <div class="px-5 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-sliders-h text-indigo-500 mr-2"></i>
                    Update Status Massal
                </h3>
                <button type="button" 
                        class="close-bulk-modal text-gray-400 hover:text-gray-600 hover:bg-gray-100 w-8 h-8 rounded-full flex items-center justify-center">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <p class="text-xs text-gray-500 mt-1">
                <span id="bulkSelectedCount" class="font-semibold text-indigo-600"></span> data pendaftaran akan diupdate
            </p>
        </div>
        
        <!-- Body -->
        <div class="px-5 py-4">
            <form id="bulkUpdateStatusForm" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Status Pendaftaran -->
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                        <i class="fas fa-flag text-gray-400 mr-1.5 text-xs"></i>
                        Pilih Status Baru
                    </label>
                    <div class="grid grid-cols-1 gap-2">
                        <label class="relative flex items-center p-2.5 border rounded-lg cursor-pointer transition-all hover:bg-gray-50 has-[:checked]:border-yellow-500 has-[:checked]:bg-yellow-50">
                            <input type="radio" name="bulk_status" value="Menunggu Verifikasi" class="mr-2">
                            <span class="text-sm flex items-center">
                                <i class="fas fa-clock text-yellow-600 mr-2"></i> Menunggu Verifikasi
                            </span>
                        </label>
                        <label class="relative flex items-center p-2.5 border rounded-lg cursor-pointer transition-all hover:bg-gray-50 has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                            <input type="radio" name="bulk_status" value="Diterima" class="mr-2">
                            <span class="text-sm flex items-center">
                                <i class="fas fa-check-circle text-green-600 mr-2"></i> Diterima
                            </span>
                        </label>
                        <label class="relative flex items-center p-2.5 border rounded-lg cursor-pointer transition-all hover:bg-gray-50 has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                            <input type="radio" name="bulk_status" value="Mundur" class="mr-2">
                            <span class="text-sm flex items-center">
                                <i class="fas fa-times-circle text-red-600 mr-2"></i> Mundur
                            </span>
                        </label>
                    </div>
                </div>
                
                <!-- Catatan -->
                <div class="mb-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5 flex items-center">
                        <i class="fas fa-sticky-note text-gray-400 mr-1.5 text-xs"></i>
                        Catatan (opsional)
                    </label>
                    <textarea name="bulk_catatan" rows="2" 
                              class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                              placeholder="Tambahkan catatan untuk semua data yang dipilih..."></textarea>
                </div>
                
                <!-- Warning -->
                <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-triangle text-yellow-600 text-xs mt-0.5 mr-2"></i>
                        <p class="text-xs text-yellow-700">
                            Tindakan ini akan mengupdate status <span id="bulkWarningCount" class="font-bold"></span> data pendaftaran yang dipilih.
                        </p>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Footer -->
        <div class="px-5 py-3 border-t border-gray-200 bg-gray-50 rounded-b-xl flex justify-end space-x-2">
            <button type="button" 
                    class="close-bulk-modal px-4 py-2 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                Batal
            </button>
            <button type="button" 
                    id="saveBulkStatus" 
                    class="px-4 py-2 text-xs font-medium text-white bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg hover:from-indigo-600 hover:to-indigo-700 flex items-center">
                <i class="fas fa-save mr-1.5"></i> Update Semua
            </button>
        </div>
    </div>
</div>

<!-- Form Hapus (Hidden) -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Form Konversi (Hidden) -->
<form id="konversiForm" method="POST" style="display: none;">
    @csrf
</form>

<!-- Form Bulk Delete (Hidden) -->
<form id="bulkDeleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Form Bulk Konversi (Hidden) -->
<form id="bulkKonversiForm" method="POST" style="display: none;">
    @csrf
</form>

<style>
@keyframes slide-up {
    from {
        opacity: 0;
        transform: translate(-50%, 20px);
    }
    to {
        opacity: 1;
        transform: translate(-50%, 0);
    }
}

.animate-slide-up {
    animation: slide-up 0.3s ease-out;
}

.item-checkbox:checked {
    background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3e%3c/svg%3e");
    background-color: #2563eb;
    border-color: #2563eb;
}

tr.selected {
    background-color: #eff6ff;
}

tr.selected:hover {
    background-color: #dbeafe;
}

/* Horizontal scroll untuk tabel di mobile */
.overflow-x-auto {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    width: 100%;
}

/* Pastikan tabel tidak overflow di mobile */
.min-w-full {
    min-width: 100%;
    width: auto;
}

/* Atur lebar kolom agar lebih baik di mobile */
table td, table th {
    white-space: nowrap;
}

/* Bulk action bar mobile */
@media (max-width: 640px) {
    #bulkActionBar {
        width: 95%;
        padding: 0.75rem 1rem;
        gap: 0.5rem;
        bottom: 1rem;
    }
    
    #bulkActionBar button {
        padding: 0.375rem 0.625rem;
        font-size: 0.7rem;
    }
    
    #bulkActionBar .bg-blue-50 {
        padding: 0.375rem 0.625rem;
    }
}

/* Modal mobile */
@media (max-width: 640px) {
    #updateStatusModal > div,
    #bulkUpdateStatusModal > div {
        margin: 1rem;
        width: calc(100% - 2rem);
    }
    
    .grid-cols-1 {
        gap: 0.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // === INITIALIZATION ===
    let selectedItems = new Set();
    
    // === DOM ELEMENTS ===
    const bulkModal = document.getElementById('bulkUpdateStatusModal');
    const bulkModalContent = bulkModal?.querySelector('div > div');
    const closeBulkButtons = document.querySelectorAll('.close-bulk-modal');
    const modal = document.getElementById('updateStatusModal');
    const modalContent = modal?.querySelector('div > div');
    const closeButtons = document.querySelectorAll('.close-modal');
    const saveBtn = document.getElementById('saveStatus');
    const updateForm = document.getElementById('updateStatusForm');
    const saveBulkBtn = document.getElementById('saveBulkStatus');
    
    // === SELECT ALL FUNCTIONALITY ===
    window.toggleSelectAll = function(checkbox) {
        const itemCheckboxes = document.querySelectorAll('.item-checkbox');
        itemCheckboxes.forEach(cb => {
            cb.checked = checkbox.checked;
            if (checkbox.checked) {
                selectedItems.add(cb.value);
                cb.closest('tr')?.classList.add('selected');
            } else {
                selectedItems.delete(cb.value);
                cb.closest('tr')?.classList.remove('selected');
            }
        });
        updateSelectedCount();
    };
    
    // === UPDATE SELECTED COUNT ===
    window.updateSelectedCount = function() {
        selectedItems.clear();
        document.querySelectorAll('.item-checkbox:checked').forEach(cb => {
            selectedItems.add(cb.value);
            cb.closest('tr')?.classList.add('selected');
        });
        
        document.querySelectorAll('.item-checkbox:not(:checked)').forEach(cb => {
            cb.closest('tr')?.classList.remove('selected');
        });
        
        const count = selectedItems.size;
        const selectedCountEl = document.getElementById('selectedCount');
        const selectedCountTextEl = document.getElementById('selectedCountText');
        const bulkActionBar = document.getElementById('bulkActionBar');
        const clearSelectionBtn = document.getElementById('clearSelectionBtn');
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');
        const totalCheckboxes = document.querySelectorAll('.item-checkbox').length;
        
        if (selectedCountEl) selectedCountEl.innerHTML = count;
        if (selectedCountTextEl) selectedCountTextEl.innerHTML = count;
        
        // Update select all checkbox state
        if (selectAllCheckbox) {
            if (count === 0) {
                selectAllCheckbox.checked = false;
                selectAllCheckbox.indeterminate = false;
            } else if (count === totalCheckboxes) {
                selectAllCheckbox.checked = true;
                selectAllCheckbox.indeterminate = false;
            } else {
                selectAllCheckbox.indeterminate = true;
            }
        }
        
        // Show/hide bulk action bar
        if (count > 0) {
            bulkActionBar?.classList.remove('hidden');
            clearSelectionBtn?.classList.remove('hidden');
            
            // Check if any selected item can be converted
            const hasConvertible = Array.from(document.querySelectorAll('.item-checkbox:checked')).some(cb => 
                cb.dataset.canKonversi === 'true'
            );
            
            const bulkKonversiBtn = document.getElementById('bulkKonversiBtn');
            if (bulkKonversiBtn) {
                if (hasConvertible) {
                    bulkKonversiBtn.classList.remove('hidden');
                } else {
                    bulkKonversiBtn.classList.add('hidden');
                }
            }
        } else {
            bulkActionBar?.classList.add('hidden');
            clearSelectionBtn?.classList.add('hidden');
        }
    };
    
    // === CLEAR SELECTION ===
    window.clearSelection = function() {
        document.querySelectorAll('.item-checkbox').forEach(cb => {
            cb.checked = false;
            cb.closest('tr')?.classList.remove('selected');
        });
        selectedItems.clear();
        updateSelectedCount();
        
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');
        if (selectAllCheckbox) {
            selectAllCheckbox.checked = false;
            selectAllCheckbox.indeterminate = false;
        }
    };
    
    // === ROW CLICK TO TOGGLE CHECKBOX ===
    document.querySelectorAll('tbody tr').forEach(row => {
        row.addEventListener('click', function(e) {
            // Ignore click on checkbox, links, buttons, and icons
            if (e.target.type === 'checkbox' || 
                e.target.closest('a') || 
                e.target.closest('button') ||
                e.target.closest('i') ||
                e.target.closest('svg')) {
                return;
            }
            
            const checkbox = this.querySelector('.item-checkbox');
            if (checkbox) {
                checkbox.checked = !checkbox.checked;
                checkbox.dispatchEvent(new Event('change', { bubbles: true }));
            }
        });
    });
    
    // === CHECKBOX CHANGE EVENT ===
    document.querySelectorAll('.item-checkbox').forEach(cb => {
        cb.addEventListener('change', function(e) {
            e.stopPropagation();
            if (this.checked) {
                this.closest('tr')?.classList.add('selected');
            } else {
                this.closest('tr')?.classList.remove('selected');
            }
            updateSelectedCount();
        });
    });
    
    // === BULK DELETE ===
    window.bulkDelete = function() {
        const count = selectedItems.size;
        if (count === 0) {
            alert('Pilih minimal satu data untuk dihapus!');
            return;
        }
        
        if (confirm(`Apakah Anda yakin ingin menghapus ${count} data pendaftaran?\nData yang dihapus tidak dapat dikembalikan.`)) {
            const formData = new FormData();
            formData.append('action', 'delete');
            selectedItems.forEach(id => formData.append('ids[]', id));
            
            fetch('{{ route("admin.spmb.batchAction") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(result => {
                if (result.success) {
                    showNotification(result.message, 'success');
                    clearSelection();
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showNotification(result.message || 'Gagal menghapus data', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan koneksi', 'error');
            });
        }
    };
    
    // === BULK KONVERSI ===
    window.bulkKonversi = function() {
        const count = selectedItems.size;
        if (count === 0) {
            alert('Pilih minimal satu data untuk dikonversi!');
            return;
        }
        
        // Check eligibility for conversion
        const nonConvertible = Array.from(document.querySelectorAll('.item-checkbox:checked')).filter(cb => 
            cb.dataset.canKonversi !== 'true'
        );
        
        if (nonConvertible.length > 0) {
            alert(`${nonConvertible.length} data tidak dapat dikonversi karena bukan berstatus "Diterima" atau sudah dikonversi sebelumnya.`);
            return;
        }
        
        if (confirm(`Konversi ${count} data pendaftaran menjadi data siswa?`)) {
            const formData = new FormData();
            formData.append('action', 'konversi');
            selectedItems.forEach(id => formData.append('ids[]', id));
            
            fetch('{{ route("admin.spmb.batchAction") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(result => {
                if (result.success) {
                    showNotification(result.message, 'success');
                    clearSelection();
                    setTimeout(() => location.reload(), 2000);
                } else {
                    showNotification(result.message || 'Gagal mengkonversi data', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan koneksi', 'error');
            });
        }
    };
    
    // === BULK UPDATE STATUS MODAL ===
    window.bulkUpdateStatus = function() {
        const count = selectedItems.size;
        if (count === 0) {
            alert('Pilih minimal satu data untuk diupdate status!');
            return;
        }
        
        document.getElementById('bulkSelectedCount').innerHTML = count + ' ' + (count > 1 ? 'data' : 'data');
        document.getElementById('bulkWarningCount').innerHTML = count + ' ' + (count > 1 ? 'data' : 'data');
        
        bulkModal.classList.remove('hidden');
        setTimeout(() => {
            bulkModalContent.style.opacity = '1';
            bulkModalContent.style.transform = 'scale(1)';
        }, 10);
        document.body.style.overflow = 'hidden';
    };
    
    // === HIDE BULK MODAL ===
    function hideBulkModal() {
        if (!bulkModalContent) return;
        
        bulkModalContent.style.opacity = '0';
        bulkModalContent.style.transform = 'scale(0.95)';
        setTimeout(() => {
            bulkModal.classList.add('hidden');
            document.body.style.overflow = '';
            document.getElementById('bulkUpdateStatusForm')?.reset();
        }, 200);
    }
    
    // === SAVE BULK STATUS ===
    if (saveBulkBtn) {
        saveBulkBtn.addEventListener('click', async function() {
            const selectedStatus = document.querySelector('input[name="bulk_status"]:checked');
            if (!selectedStatus) {
                alert('Pilih status baru!');
                return;
            }
            
            const count = selectedItems.size;
            const originalText = this.innerHTML;
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-1.5"></i>Memproses...';
            
            try {
                const formData = new FormData();
                formData.append('action', 'update-status');
                formData.append('status', selectedStatus.value);
                
                const catatan = document.querySelector('textarea[name="bulk_catatan"]')?.value || '';
                formData.append('catatan', catatan);
                
                selectedItems.forEach(id => formData.append('ids[]', id));
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
                
                const response = await fetch('{{ route("admin.spmb.batchAction") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showNotification(result.message, 'success');
                    hideBulkModal();
                    clearSelection();
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showNotification(result.message || 'Gagal memperbarui status', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan koneksi', 'error');
            } finally {
                this.disabled = false;
                this.innerHTML = originalText;
            }
        });
    }
    
    // === CLOSE BULK MODAL BUTTONS ===
    closeBulkButtons.forEach(btn => {
        btn.addEventListener('click', hideBulkModal);
    });
    
    // === CLICK OUTSIDE BULK MODAL ===
    bulkModal?.addEventListener('click', function(e) {
        if (e.target === bulkModal) hideBulkModal();
    });
    
    // === SINGLE UPDATE STATUS MODAL ===
    window.showModal = function(spmbId, spmbName, currentStatus) {
        document.getElementById('modalSpmbId').innerHTML = '#' + spmbId;
        document.getElementById('modalStudentName').innerHTML = spmbName;
        updateForm.action = `/admin/spmb/${spmbId}/status`;
        
        document.querySelectorAll('input[name="status"]').forEach(radio => {
            radio.checked = (radio.value === currentStatus);
        });
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            modalContent.style.opacity = '1';
            modalContent.style.transform = 'scale(1)';
        }, 10);
        document.body.style.overflow = 'hidden';
    };
    
    // === HIDE SINGLE MODAL ===
    function hideModal() {
        if (!modalContent) return;
        
        modalContent.style.opacity = '0';
        modalContent.style.transform = 'scale(0.95)';
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
            updateForm?.reset();
        }, 200);
    }
    
    // === OPEN SINGLE MODAL FROM BUTTON ===
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.update-status-btn');
        if (btn) {
            e.preventDefault();
            showModal(btn.dataset.spmbId, btn.dataset.spmbName, btn.dataset.spmbStatus);
        }
    });
    
    // === CLOSE SINGLE MODAL BUTTONS ===
    closeButtons.forEach(btn => {
        btn.addEventListener('click', hideModal);
    });
    
    // === CLICK OUTSIDE SINGLE MODAL ===
    modal?.addEventListener('click', function(e) {
        if (e.target === modal) hideModal();
    });
    
    // === SAVE SINGLE STATUS ===
    saveBtn?.addEventListener('click', async function() {
        if (!document.querySelector('input[name="status"]:checked')) {
            alert('Pilih status pendaftaran!');
            return;
        }
        
        const originalText = saveBtn.innerHTML;
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1.5"></i>Menyimpan...';
        
        try {
            const formData = new FormData(updateForm);
            const response = await fetch(updateForm.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                updateTableRow(result.spmb);
                hideModal();
                showNotification('Status berhasil diperbarui!', 'success');
                
                if (result.spmb.status_pendaftaran === 'Diterima') {
                    setTimeout(() => location.reload(), 1500);
                }
            } else {
                showNotification(result.message || 'Gagal memperbarui data', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan koneksi', 'error');
        } finally {
            saveBtn.disabled = false;
            saveBtn.innerHTML = originalText;
        }
    });
    
    // === UPDATE TABLE ROW AFTER STATUS CHANGE ===
    function updateTableRow(data) {
        const row = document.querySelector(`button[data-spmb-id="${data.id}"]`)?.closest('tr');
        if (!row) return;
        
        // Update status cell
        const statusCell = row.querySelector('td:nth-child(8)'); // Kolom status (sesuaikan index)
        if (statusCell && data.status_pendaftaran) {
            const badges = {
                'Diterima': ['bg-green-100', 'text-green-800', 'fa-check-circle', 'Diterima', 'T'],
                'Menunggu Verifikasi': ['bg-yellow-100', 'text-yellow-800', 'fa-clock', 'Menunggu', 'M'],
                'Mundur': ['bg-red-100', 'text-red-800', 'fa-times-circle', 'Mundur', 'X']
            };
            const b = badges[data.status_pendaftaran];
            if (b) {
                statusCell.innerHTML = `
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${b[0]} ${b[1]}">
                        <i class="fas ${b[2]} mr-1 text-xs"></i>
                        <span class="hidden sm:inline">${b[3]}</span>
                        <span class="sm:hidden">${b[4]}</span>
                    </span>
                    ${data.is_aktif ? '<span class="inline-flex items-center px-2 py-1 mt-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800"><i class="fas fa-check-circle mr-1 text-xs"></i> Aktif</span>' : ''}
                `;
            }
        }
        
        // Update button status data attribute
        const updateBtn = row.querySelector('.update-status-btn');
        if (updateBtn) {
            updateBtn.dataset.spmbStatus = data.status_pendaftaran;
        }
        
        // Update checkbox conversion eligibility
        const checkbox = row.querySelector('.item-checkbox');
        if (checkbox) {
            checkbox.dataset.canKonversi = (data.status_pendaftaran === 'Diterima' && !data.siswa) ? 'true' : 'false';
        }
        
        // Show/hide konversi button
        const konversiBtn = row.querySelector('button[onclick*="konversiKeSiswa"]');
        if (konversiBtn) {
            if (data.status_pendaftaran === 'Diterima' && !data.siswa) {
                konversiBtn.classList.remove('hidden');
                konversiBtn.style.display = 'inline-flex';
            } else {
                konversiBtn.classList.add('hidden');
                konversiBtn.style.display = 'none';
            }
        }
    }
    
    // === ESCAPE KEY HANDLER ===
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (modal && !modal.classList.contains('hidden')) {
                hideModal();
            }
            if (bulkModal && !bulkModal.classList.contains('hidden')) {
                hideBulkModal();
            }
        }
    });
});

// === DELETE FUNCTION (SINGLE) ===
function confirmDelete(spmbId, spmbName) {
    if (confirm(`Apakah Anda yakin ingin menghapus pendaftaran "${spmbName}"?\nData yang dihapus tidak dapat dikembalikan.`)) {
        const form = document.getElementById('deleteForm');
        form.action = `/admin/spmb/${spmbId}`;
        form.submit();
    }
}

// === KONVERSI FUNCTION (SINGLE) ===
function konversiKeSiswa(spmbId, spmbName) {
    if (confirm(`Konversi "${spmbName}" menjadi data siswa?`)) {
        const form = document.getElementById('konversiForm');
        form.action = `/admin/spmb/${spmbId}/konversi`;
        form.submit();
    }
}

// === NOTIFICATION FUNCTION ===
function showNotification(message, type = 'success') {
    // Remove existing notification
    const existingNotification = document.querySelector('.fixed.top-4.right-4');
    if (existingNotification) {
        existingNotification.remove();
    }
    
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg transform transition-all duration-300 translate-x-0 ${
        type === 'success' ? 'bg-green-50 border border-green-200 text-green-800' : 
        type === 'error' ? 'bg-red-50 border border-red-200 text-red-800' :
        'bg-blue-50 border border-blue-200 text-blue-800'
    }`;
    
    const icon = type === 'success' ? 'fa-check-circle' : 
                 type === 'error' ? 'fa-exclamation-circle' : 
                 'fa-info-circle';
    
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${icon} mr-2"></i>
            <span class="text-sm font-medium">${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        notification.style.opacity = '0';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}
</script>

@else
<!-- Empty State -->
<div class="text-center py-12 px-4">
    <div class="mx-auto w-16 h-16 sm:w-20 sm:h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
        <i class="fas fa-user-graduate text-gray-400 text-xl sm:text-2xl"></i>
    </div>
    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada data pendaftaran</h3>
    <p class="text-gray-500 text-sm sm:text-base max-w-md mx-auto">
        @if(request()->has('search') && !empty(request('search')))
            Tidak ditemukan pendaftaran dengan pencarian "{{ request('search') }}"
        @else
            Belum ada pendaftaran SPMB. Mulai dengan menambahkan pendaftaran baru.
        @endif
    </p>
    <div class="mt-6">
        <a href="{{ route('admin.spmb.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-150">
            <i class="fas fa-plus mr-2"></i> Tambah Pendaftaran
        </a>
        @if(request()->has('search') && !empty(request('search')))
        <a href="{{ route('admin.spmb.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition-colors duration-150 ml-3">
            <i class="fas fa-redo mr-2"></i> Reset Pencarian
        </a>
        @endif
    </div>
</div>
@endif