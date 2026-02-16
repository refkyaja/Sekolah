@extends('layouts.admin')

@section('title', 'Isi Absensi')
@section('breadcrumb', 'Isi Absensi Siswa')

@push('meta')
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 p-3 sm:p-4 md:p-6">
    <div class="max-w-4xl mx-auto">
        <div class="mb-6 sm:mb-8">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800 mb-1">Isi Absensi</h1>
                    <p class="text-gray-600 text-sm sm:text-base">Pilih tanggal dan kelompok lalu isi status kehadiran siswa</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.absensi.index') }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm">Kembali</a>
                </div>
            </div>

            <div class="bg-white rounded-lg p-4 sm:p-6 mb-6">
                <form method="GET" action="{{ route('admin.absensi.fill') }}">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="text-xs text-gray-700">Tanggal</label>
                            <input type="text" name="tanggal" id="fill-tanggal" value="{{ $tanggal }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        </div>
                        <div>
                            <label class="text-xs text-gray-700">Kelompok</label>
                            <select name="kelompok" id="kelompok-select" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" onchange="loadGuruByKelompok()">
                                <option value="" {{ $kelompok == '' ? 'selected' : '' }}>Semua Kelompok</option>
                                <option value="A" {{ $kelompok == 'A' ? 'selected' : '' }}>Kelompok A</option>
                                <option value="B" {{ $kelompok == 'B' ? 'selected' : '' }}>Kelompok B</option>
                                <option value="Bermain" {{ $kelompok == 'Bermain' ? 'selected' : '' }}>Kelompok Bermain</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg">Tampilkan Siswa</button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- TAMPILKAN INFO GURU --}}
            @if($kelompok && isset($guru) && $guru)
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 flex items-start">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                    <i class="fas fa-chalkboard-teacher text-blue-600"></i>
                </div>
                <div>
                    <h3 class="font-medium text-blue-800">Guru Kelompok {{ $kelompok }}</h3>
                    <p class="text-sm text-blue-700">{{ $guru->nama }} (NIP: {{ $guru->nip ?? '-' }})</p>
                    <p class="text-xs text-blue-600 mt-1">Absensi akan dicatat atas nama guru ini</p>
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('admin.absensi.store-batch') }}">
                @csrf
                <input type="hidden" name="tanggal" value="{{ $tanggal }}">
                <input type="hidden" name="kelompok" value="{{ $kelompok }}">
                
                {{-- 🔥 INI YANG KURANG! TAMBAHKAN GURU_ID --}}
                @if(isset($guru) && $guru)
                <input type="hidden" name="guru_id" value="{{ $guru->id }}">
                @endif

                <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                    <div class="mb-3 sm:mb-4 flex items-center justify-between">
                        <h2 class="font-semibold text-gray-800">Daftar Siswa ({{ $siswa->count() }})</h2>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                            <i class="fas fa-save mr-2"></i>Simpan Semua
                        </button>
                    </div>

                    @if($siswa->isEmpty())
                        <div class="text-center text-gray-500 py-8">
                            <i class="fas fa-users text-gray-300 text-4xl mb-3"></i>
                            <p>Tidak ada siswa untuk kelompok ini.</p>
                            @if($kelompok)
                            <p class="text-sm text-gray-400 mt-2">Pastikan kelompok {{ $kelompok }} memiliki siswa terdaftar</p>
                            @endif
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kelompok</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($siswa as $i => $s)
                                    <tr>
                                        <td class="px-3 py-2 text-sm text-gray-700">{{ $i + 1 }}</td>
                                        <td class="px-3 py-2 text-sm text-gray-900">{{ $s->nama_lengkap ?? $s->nama }}</td>
                                        <td class="px-3 py-2 text-sm text-gray-700">
                                            <span class="px-2 py-1 bg-{{ $s->kelompok == 'A' ? 'blue' : ($s->kelompok == 'B' ? 'green' : 'purple') }}-100 text-{{ $s->kelompok == 'A' ? 'blue' : ($s->kelompok == 'B' ? 'green' : 'purple') }}-800 rounded-full text-xs">
                                                Kel. {{ $s->kelompok }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-2 text-sm text-gray-700">
                                            @php $existingStatus = optional($existing->get($s->id))->status ?? 'hadir'; @endphp
                                            <select name="statuses[{{ $s->id }}]" class="border border-gray-300 rounded px-2 py-1 text-sm">
                                                <option value="hadir" {{ $existingStatus == 'hadir' ? 'selected' : '' }}>✅ Hadir</option>
                                                <option value="izin" {{ $existingStatus == 'izin' ? 'selected' : '' }}>📝 Izin</option>
                                                <option value="sakit" {{ $existingStatus == 'sakit' ? 'selected' : '' }}>🤒 Sakit</option>
                                                <option value="tidak_hadir" {{ $existingStatus == 'tidak_hadir' ? 'selected' : '' }}>❌ Alpa</option>
                                            </select>
                                        </td>
                                        <td class="px-3 py-2 text-sm text-gray-700">
                                            <input type="text" name="keterangan[{{ $s->id }}]" value="{{ optional($existing->get($s->id))->keterangan ?? '' }}" class="w-full border border-gray-300 rounded px-2 py-1 text-sm" placeholder="Opsional">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4 pt-3 border-t border-gray-200 flex justify-between items-center text-xs text-gray-500">
                            <span>
                                <i class="fas fa-info-circle mr-1"></i>
                                @if(isset($guru) && $guru)
                                    Dicatat oleh: <strong>{{ $guru->nama }}</strong>
                                @else
                                    <span class="text-yellow-600">⚠️ Guru belum dipilih</span>
                                @endif
                            </span>
                            <span>Total: {{ $siswa->count() }} siswa</span>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL KONFIRMASI KALO GURU BELUM DIPILIH --}}
@if($kelompok && !isset($guru))
<div class="fixed bottom-4 left-4 right-4 sm:left-auto sm:right-4 sm:w-96 bg-yellow-50 border border-yellow-200 rounded-lg shadow-lg p-4 z-50">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <i class="fas fa-exclamation-triangle text-yellow-600"></i>
        </div>
        <div class="ml-3 flex-1">
            <h3 class="text-sm font-medium text-yellow-800">Guru belum ditentukan</h3>
            <p class="text-xs text-yellow-700 mt-1">
                Kelompok {{ $kelompok }} belum memiliki guru. Silakan tambahkan guru di menu Data Guru.
            </p>
            <div class="mt-3">
                <a href="{{ route('admin.guru.create') }}" class="text-xs bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1.5 rounded-lg">
                    Tambah Guru
                </a>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr('#fill-tanggal', { 
            dateFormat: 'Y-m-d', 
            locale: 'id',
            defaultDate: '{{ $tanggal }}'
        });
    });

    function loadGuruByKelompok() {
        const kelompok = document.getElementById('kelompok-select').value;
        if (kelompok) {
            // Redirect dengan parameter kelompok dan tanggal yang sama
            const tanggal = document.getElementById('fill-tanggal').value;
            window.location.href = '{{ route("admin.absensi.fill") }}?tanggal=' + tanggal + '&kelompok=' + kelompok;
        }
    }
</script>
@endpush