{{-- resources/views/admin/tahun-ajaran/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Manajemen Tahun Ajaran')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Manajemen Tahun Ajaran</h1>
        <a href="{{ route('admin.tahun-ajaran.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-plus mr-2"></i>Tambah Tahun Ajaran
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tahun Ajaran</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Semester</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Mulai</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Selesai</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($tahunAjaran as $ta)
                <tr>
                    <td class="px-6 py-4">{{ $ta->tahun_ajaran }}</td>
                    <td class="px-6 py-4">{{ $ta->semester }}</td>
                    <td class="px-6 py-4">{{ $ta->tanggal_mulai->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">{{ $ta->tanggal_selesai->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">
                        @if($ta->is_aktif)
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Aktif</span>
                        @else
                            <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">Tidak Aktif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.tahun-ajaran.edit', $ta) }}" 
                               class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            @if(!$ta->is_aktif)
                            <form action="{{ route('admin.tahun-ajaran.set-active', $ta) }}" 
                                  method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="text-green-600 hover:text-green-900"
                                        onclick="return confirm('Aktifkan tahun ajaran ini?')">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            </form>
                            @endif
                            
                            <form action="{{ route('admin.tahun-ajaran.destroy', $ta) }}" 
                                  method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900"
                                        onclick="return confirm('Hapus tahun ajaran ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4">
            {{ $tahunAjaran->links() }}
        </div>
    </div>
</div>
@endsection