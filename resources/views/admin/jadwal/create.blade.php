@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 p-5 sm:p-8">
        <div class="mb-8">
            <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100">Tambah Jadwal Baru</h2>
            <p class="text-sm text-slate-500">Silakan lengkapi formulir di bawah untuk menambah jadwal pelajaran.</p>
        </div>

        <form method="POST" action="{{ route('admin.jadwal-pelajaran.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Tahun Ajaran --}}
                <div class="space-y-1.5">
                    <label class="text-sm font-bold text-slate-700 dark:text-slate-300">Tahun Ajaran <span class="text-red-500">*</span></label>
                    <select name="tahun_ajaran_id" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 transition-all">
                        @foreach($daftarTahunAjaran as $ta)
                            <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id') == $ta->id || (request('tahun_ajaran_id') == $ta->id) ? 'selected' : '' }}>
                                {{ $ta->tahun_ajaran }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Semester --}}
                <div class="space-y-1.5">
                    <label class="text-sm font-bold text-slate-700 dark:text-slate-300">Semester <span class="text-red-500">*</span></label>
                    <select name="semester" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 transition-all">
                        <option value="Ganjil" {{ old('semester', request('semester')) == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                        <option value="Genap" {{ old('semester', request('semester')) == 'Genap' ? 'selected' : '' }}>Genap</option>
                    </select>
                </div>

                {{-- Kelompok --}}
                <div class="space-y-1.5">
                    <label class="text-sm font-bold text-slate-700 dark:text-slate-300">Kelompok <span class="text-red-500">*</span></label>
                    <select name="kelompok" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 transition-all">
                        <option value="A" {{ old('kelompok', request('kelompok')) == 'A' ? 'selected' : '' }}>Kelompok A</option>
                        <option value="B" {{ old('kelompok', request('kelompok')) == 'B' ? 'selected' : '' }}>Kelompok B</option>
                    </select>
                </div>

                {{-- Hari --}}
                <div class="space-y-1.5">
                    <label class="text-sm font-bold text-slate-700 dark:text-slate-300">Hari <span class="text-red-500">*</span></label>
                    <select name="hari" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 transition-all">
                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $hari)
                            <option value="{{ $hari }}" {{ old('hari') == $hari ? 'selected' : '' }}>{{ $hari }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Mata Pelajaran --}}
            <div class="space-y-1.5">
                <label class="text-sm font-bold text-slate-700 dark:text-slate-300">Mata Pelajaran <span class="text-red-500">*</span></label>
                <input type="text" name="mata_pelajaran" value="{{ old('mata_pelajaran') }}" placeholder="Contoh: Matematika" 
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 transition-all @error('mata_pelajaran') border-red-400 @enderror">
                @error('mata_pelajaran') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Jam Mulai --}}
                <div class="space-y-1.5">
                    <label class="text-sm font-bold text-slate-700 dark:text-slate-300">Jam Mulai <span class="text-red-500">*</span></label>
                    <input type="time" name="jam_mulai" value="{{ old('jam_mulai', '07:30') }}" 
                           class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 transition-all">
                </div>

                {{-- Jam Selesai --}}
                <div class="space-y-1.5">
                    <label class="text-sm font-bold text-slate-700 dark:text-slate-300">Jam Selesai <span class="text-red-500">*</span></label>
                    <input type="time" name="jam_selesai" value="{{ old('jam_selesai', '09:00') }}" 
                           class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 transition-all">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Kategori --}}
                <div class="space-y-1.5">
                    <label class="text-sm font-bold text-slate-700 dark:text-slate-300">Kategori <span class="text-red-500">*</span></label>
                    <select name="kategori" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 transition-all">
                        <option value="akademik" {{ old('kategori') == 'akademik' ? 'selected' : '' }}>Akademik</option>
                        <option value="art" {{ old('kategori') == 'art' ? 'selected' : '' }}>Art / Seni</option>
                        <option value="physical" {{ old('kategori') == 'physical' ? 'selected' : '' }}>Physical / Olahraga</option>
                        <option value="break" {{ old('kategori') == 'break' ? 'selected' : '' }}>Istirahat</option>
                        <option value="special" {{ old('kategori') == 'special' ? 'selected' : '' }}>Khusus / Acara</option>
                    </select>
                </div>

                {{-- Guru --}}
                <div class="space-y-1.5">
                    <label class="text-sm font-bold text-slate-700 dark:text-slate-300">Nama Guru</label>
                    <input type="text" name="guru" value="{{ old('guru') }}" placeholder="Contoh: Sarah Johnson, M.Pd" 
                           class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 transition-all">
                </div>
            </div>

            {{-- Lokasi --}}
            <div class="space-y-1.5">
                <label class="text-sm font-bold text-slate-700 dark:text-slate-300">Lokasi / Ruangan</label>
                <input type="text" name="lokasi" value="{{ old('lokasi') }}" placeholder="Contoh: Ruang Kelas A1" 
                       class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 transition-all">
            </div>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-4">
                <a href="{{ route('admin.jadwal-pelajaran.index', ['kelompok' => request('kelompok', 'A')]) }}" 
                   class="w-full sm:w-auto px-6 py-2.5 text-center border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 rounded-xl font-bold text-sm hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                    Batal
                </a>
                <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-primary text-white rounded-xl font-bold text-sm hover:bg-primary/90 transition-all shadow-lg shadow-primary/25">
                    Simpan Jadwal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
