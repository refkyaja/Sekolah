{{-- resources/views/admin/galeri/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Kelola Galeri - TK Harapan Bangsa 1')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100">
    {{-- Header --}}
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Kelola Galeri</h2>
                <p class="text-sm text-gray-600 mt-1">Unggah dan kelola foto kegiatan sekolah</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.galeri.create') }}" 
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Galeri
                </a>
            </div>
        </div>
    </div>
    
    {{-- Search & Filter --}}
    <div class="p-6 border-b border-gray-200">
        <form method="GET" action="{{ route('admin.galeri.index') }}">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Cari judul, deskripsi, atau kategori..."
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                
                <div>
                    <select name="kategori" 
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoriList as $kategori)
                            <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>
                                {{ ucfirst($kategori) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <select name="status" 
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Status</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
            </div>
            
            <div class="flex justify-end mt-4">
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Terapkan Filter
                </button>
                
                @if(request()->anyFilled(['search', 'kategori', 'status']))
                    <a href="{{ route('admin.galeri.index') }}" 
                       class="ml-2 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>
    
    {{-- Gallery Grid --}}
    <div class="p-6">
        @if($galeri->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($galeri as $item)
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition-all">
                {{-- Image --}}
                <div class="relative h-48 bg-gray-100 overflow-hidden">
                    {{-- ✅ PAKAI THUMBNAIL_URL --}}
                    <img src="{{ $item->thumbnail_url }}" 
                        alt="{{ $item->judul }}"
                        class="w-full h-full object-cover hover:scale-110 transition-transform duration-500"
                        onerror="this.onerror=null; this.src='{{ asset('images/no-image.jpg') }}'; this.classList.add('p-8', 'opacity-50');">
                    
                    {{-- Status Badge --}}
                    <div class="absolute top-3 left-3">
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $item->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $item->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </div>
                    
                    {{-- Category Badge --}}
                    <div class="absolute top-3 right-3">
                        <span class="px-2 py-1 text-xs font-medium bg-white/90 backdrop-blur-sm rounded-lg shadow-sm">
                            {{ ucfirst($item->kategori) }}
                        </span>
                    </div>
                    
                    {{-- Jumlah Gambar Badge --}}
                    @if($item->jumlah_gambar > 0)
                    <div class="absolute bottom-3 right-3">
                        <span class="px-2 py-1 text-xs font-medium bg-black/70 text-white rounded-lg backdrop-blur-sm">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ $item->jumlah_gambar }}
                        </span>
                    </div>
                    @endif
                </div>
                
                {{-- Content --}}
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 mb-2 truncate" title="{{ $item->judul }}">
                        {{ $item->judul }}
                    </h3>
                    
                    <div class="flex items-center text-sm text-gray-500 mb-3">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $item->tanggal->format('d M Y') }}
                        
                        <svg class="w-4 h-4 ml-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        {{ number_format($item->views ?? 0) }}
                    </div>
                    
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                        {{ Str::limit(strip_tags($item->deskripsi), 100) }}
                    </p>
                    
                    {{-- Actions --}}
                    <div class="flex justify-between items-center border-t pt-4">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.galeri.edit', $item) }}" 
                               class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                               title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            
                            <button type="button" 
                                    onclick="confirmDelete({{ $item->id }})"
                                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                    title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                            
                            <a href="{{ route('admin.galeri.show', $item) }}" 
                               class="p-2 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors"
                               title="Lihat Detail">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                        </div>
                        
                        {{-- Toggle Publish --}}
                        <form action="{{ route('admin.galeri.toggle-publish', $item) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="text-sm px-3 py-1.5 rounded-lg {{ $item->is_published ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' : 'bg-green-100 text-green-800 hover:bg-green-200' }} transition-colors">
                                {{ $item->is_published ? 'Unpublish' : 'Publish' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        {{-- Pagination --}}
        @if($galeri->hasPages())
        <div class="mt-8">
            {{ $galeri->onEachSide(1)->links('vendor.pagination.tailwind') }}
        </div>
        @endif
        
        @else
        {{-- Empty State --}}
        <div class="text-center py-16">
            <div class="text-gray-300 mb-4">
                <svg class="w-20 h-20 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Galeri</h3>
            <p class="text-gray-500 mb-6">Mulai dengan menambahkan galeri pertama Anda.</p>
            <a href="{{ route('admin.galeri.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Galeri
            </a>
        </div>
        @endif
    </div>
</div>

{{-- Form Delete Hidden --}}
<form id="delete-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus galeri ini? Semua gambar akan ikut terhapus.')) {
        const form = document.getElementById('delete-form');
        form.action = `/admin/galeri/${id}`;
        form.submit();
    }
}
</script>
@endpush
@endsection