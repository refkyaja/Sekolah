@if(isset($gurus) && $gurus->count() > 0)
<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
        <tr>
            <!-- Kolom untuk desktop/tablet -->
            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap hidden sm:table-cell">
                No
            </th>
            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                <div class="flex items-center">
                    <span class="hidden sm:inline">Nama Guru</span>
                    <span class="sm:hidden">Guru</span>
                </div>
            </th>
            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap hidden md:table-cell">
                NIP
            </th>
            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                <span class="hidden sm:inline">Jabatan</span>
                <span class="sm:hidden">Jab</span>
            </th>
            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap hidden lg:table-cell">
                Kelompok
            </th>
            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap hidden lg:table-cell">
                Email
            </th>
            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                Aksi
            </th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @foreach($gurus as $index => $guru)
        <tr class="hover:bg-gray-50 transition-colors duration-150">
            <!-- No - Hidden di Mobile -->
            <td class="px-4 sm:px-6 py-3 whitespace-nowrap text-sm text-gray-500 hidden sm:table-cell">
                {{ ($gurus->currentPage() - 1) * $gurus->perPage() + $index + 1 }}
            </td>
            
            <!-- Nama Guru -->
            <td class="px-4 sm:px-6 py-3 whitespace-nowrap">
                <div class="flex items-center">
                    <div class="flex-shrink-0 w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-green-100 to-green-50 rounded-full flex items-center justify-center">
                        <span class="text-green-600 font-bold text-xs sm:text-sm">
                            {{ strtoupper(substr($guru->nama, 0, 1)) }}
                        </span>
                    </div>
                    <div class="ml-3 min-w-0">
                        <div class="text-sm font-medium text-gray-900 truncate max-w-[120px] sm:max-w-[180px] md:max-w-none">
                            {{ $guru->nama }}
                        </div>
                        <div class="text-xs text-gray-500 sm:hidden">
                            NIP: {{ $guru->nip ?: '-' }}
                        </div>
                        @if($guru->jabatan == 'guru' && $guru->kelompok)
                        <div class="text-xs text-blue-600 sm:hidden mt-1">
                            Kel. {{ $guru->kelompok }}
                        </div>
                        @endif
                    </div>
                </div>
            </td>
            
            <!-- NIP - Hidden di Mobile -->
            <td class="px-4 sm:px-6 py-3 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell">
                <div class="truncate max-w-[120px]">
                    {{ $guru->nip ?: '-' }}
                </div>
            </td>
            
            <!-- Jabatan -->
            <td class="px-4 sm:px-6 py-3 whitespace-nowrap">
                @if($guru->jabatan == 'guru')
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        <i class="fas fa-chalkboard-teacher mr-1 text-xs"></i>
                        <span class="hidden sm:inline">Guru</span>
                        <span class="sm:hidden">G</span>
                    </span>
                @else
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        <i class="fas fa-user-tie mr-1 text-xs"></i>
                        <span class="hidden sm:inline">Staff</span>
                        <span class="sm:hidden">S</span>
                    </span>
                @endif
            </td>
            
            <!-- Kelompok - Hidden di Tablet -->
            <td class="px-4 sm:px-6 py-3 whitespace-nowrap text-sm text-gray-900 hidden lg:table-cell">
                @if($guru->jabatan == 'guru' && $guru->kelompok)
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                        {{ $guru->kelompok == 'A' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                        Kelompok {{ $guru->kelompok }}
                    </span>
                @else
                    <span class="text-gray-400 text-xs">-</span>
                @endif
            </td>
            
            <!-- Email - Hidden di Tablet -->
            <td class="px-4 sm:px-6 py-3 text-sm text-gray-900 hidden lg:table-cell">
                <div class="truncate max-w-[180px] xl:max-w-[220px]">
                    {{ $guru->email ?: '-' }}
                </div>
            </td>
            
            <!-- Aksi -->
            <td class="px-4 sm:px-6 py-3 whitespace-nowrap text-sm font-medium">
                <div class="flex items-center space-x-1 sm:space-x-2">
                    <a href="{{ route('admin.guru.show', $guru->id) }}" 
                       class="text-blue-600 hover:text-blue-900 p-1 sm:p-2 hover:bg-blue-50 rounded transition-colors duration-150"
                       title="Detail">
                        <i class="fas fa-eye text-xs sm:text-sm"></i>
                    </a>
                    <a href="{{ route('admin.guru.edit', $guru->id) }}" 
                       class="text-green-600 hover:text-green-900 p-1 sm:p-2 hover:bg-green-50 rounded transition-colors duration-150"
                       title="Edit">
                        <i class="fas fa-edit text-xs sm:text-sm"></i>
                    </a>
                    <form action="{{ route('admin.guru.destroy', $guru->id) }}" method="POST" class="inline" onsubmit="return confirmDelete(event)">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="text-red-600 hover:text-red-900 p-1 sm:p-2 hover:bg-red-50 rounded transition-colors duration-150"
                                title="Hapus">
                            <i class="fas fa-trash text-xs sm:text-sm"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<!-- Empty State -->
<div class="text-center py-12 px-4">
    <div class="mx-auto w-16 h-16 sm:w-20 sm:h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
        <i class="fas fa-chalkboard-teacher text-gray-400 text-xl sm:text-2xl"></i>
    </div>
    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada data guru</h3>
    <p class="text-gray-500 text-sm sm:text-base max-w-md mx-auto">
        @if(isset($search) && !empty($search))
            Tidak ditemukan guru dengan pencarian "{{ $search }}"
        @else
            Belum ada guru yang terdaftar. Mulai dengan menambahkan guru baru.
        @endif
    </p>
    <div class="mt-6">
        <a href="{{ route('admin.guru.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-150">
            <i class="fas fa-plus mr-2"></i> Tambah Guru Pertama
        </a>
        @if(isset($search) && !empty($search))
        <button onclick="window.location.href='{{ route('admin.guru.index') }}'" 
                class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition-colors duration-150 ml-3">
            <i class="fas fa-redo mr-2"></i> Reset Pencarian
        </button>
        @endif
    </div>
</div>
@endif

<script>
function confirmDelete(event) {
    event.preventDefault();
    if (window.innerWidth < 640) {
        // Mobile confirmation
        if (confirm('Hapus data guru ini?')) {
            event.target.closest('form').submit();
        }
    } else {
        // Desktop confirmation
        if (confirm('Yakin ingin menghapus data guru ini?')) {
            event.target.closest('form').submit();
        }
    }
    return false;
}
</script>