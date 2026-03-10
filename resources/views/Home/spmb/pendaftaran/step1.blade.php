@extends('layouts.student')

@section('title', 'PPDB - Data Pribadi')

@section('content')
<div class="max-w-[960px] mx-auto min-h-screen flex flex-col px-4 py-8">

    {{-- Progress --}}
    <div class="mb-10">
        <div class="flex justify-between items-end mb-3">
            <div>
                <p class="text-sm font-semibold text-primary uppercase tracking-wider">Langkah 1 dari 4</p>
                <h1 class="text-2xl md:text-3xl font-bold mt-1 text-slate-900 dark:text-slate-100">Formulir Pendaftaran Siswa Baru</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1">Langkah 1: Data Pribadi Calon Siswa</p>
            </div>
            <p class="text-lg font-bold text-primary">25%</p>
        </div>
        <div class="h-3 w-full bg-primary/10 rounded-full overflow-hidden">
            <div class="h-full bg-primary rounded-full transition-all duration-500" style="width: 25%;"></div>
        </div>
    </div>

    {{-- Errors --}}
    @if($errors->any())
    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
        <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-400 space-y-1">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl text-sm text-red-700 dark:text-red-400">
        {{ session('error') }}
    </div>
    @endif

    {{-- Form Card --}}
    <div class="bg-white dark:bg-dark-card rounded-xl shadow-sm border border-white/5 p-6 md:p-8">
        <form action="{{ route('siswa.pendaftaran.step1.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Nama Lengkap --}}
                <div class="col-span-full">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Nama Lengkap Anak <span class="text-red-500">*</span></label>
                    <input name="nama_lengkap_anak" value="{{ old('nama_lengkap_anak', $data['nama_lengkap_anak'] ?? '') }}"
                        class="w-full h-14 px-4 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-slate-900 dark:text-slate-100 placeholder:text-slate-400"
                        placeholder="Masukkan nama lengkap sesuai akta kelahiran" type="text"/>
                </div>

                {{-- Nama Panggilan --}}
                <div class="col-span-full md:col-span-1">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Nama Panggilan</label>
                    <input name="nama_panggilan_anak" value="{{ old('nama_panggilan_anak', $data['nama_panggilan_anak'] ?? '') }}"
                        class="w-full h-14 px-4 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-slate-900 dark:text-slate-100"
                        placeholder="Contoh: Budi" type="text"/>
                </div>

                {{-- Jenis Kelamin --}}
                <div class="col-span-full md:col-span-1">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <div class="flex gap-4 h-14">
                        <label class="flex-1 flex items-center justify-center gap-2 cursor-pointer rounded-xl border dark:border-slate-700 bg-slate-50 dark:bg-slate-800 hover:border-primary/40 transition-all has-[:checked]:border-primary has-[:checked]:bg-primary/5">
                            <input class="hidden peer" name="jenis_kelamin" type="radio" value="Laki-laki" {{ old('jenis_kelamin', $data['jenis_kelamin'] ?? '') == 'Laki-laki' ? 'checked' : '' }}/>
                            <span class="material-symbols-outlined text-primary/60 peer-checked:text-primary">boy</span>
                            <span class="font-medium text-slate-700 dark:text-slate-300">Laki-laki</span>
                        </label>
                        <label class="flex-1 flex items-center justify-center gap-2 cursor-pointer rounded-xl border dark:border-slate-700 bg-slate-50 dark:bg-slate-800 hover:border-primary/40 transition-all has-[:checked]:border-primary has-[:checked]:bg-primary/5">
                            <input class="hidden peer" name="jenis_kelamin" type="radio" value="Perempuan" {{ old('jenis_kelamin', $data['jenis_kelamin'] ?? '') == 'Perempuan' ? 'checked' : '' }}/>
                            <span class="material-symbols-outlined text-primary/60 peer-checked:text-primary">girl</span>
                            <span class="font-medium text-slate-700 dark:text-slate-300">Perempuan</span>
                        </label>
                    </div>
                </div>

                {{-- Tempat Lahir --}}
                <div class="col-span-full md:col-span-1">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Tempat Lahir <span class="text-red-500">*</span></label>
                    <input name="tempat_lahir_anak" value="{{ old('tempat_lahir_anak', $data['tempat_lahir_anak'] ?? '') }}"
                        class="w-full h-14 px-4 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-slate-900 dark:text-slate-100"
                        placeholder="Kota Kelahiran" type="text"/>
                </div>

                {{-- Tanggal Lahir --}}
                <div class="col-span-full md:col-span-1">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input name="tanggal_lahir_anak" value="{{ old('tanggal_lahir_anak', $data['tanggal_lahir_anak'] ?? '') }}"
                        class="w-full h-14 px-4 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-slate-900 dark:text-slate-100"
                        type="date"/>
                </div>

                {{-- Agama --}}
                <div class="col-span-full">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Agama <span class="text-red-500">*</span></label>
                    <select name="agama" class="w-full h-14 px-4 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-slate-900 dark:text-slate-100 appearance-none">
                        <option value="" disabled {{ !old('agama', $data['agama'] ?? null) ? 'selected' : '' }}>Pilih Agama</option>
                        @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Khonghucu'] as $agama)
                        <option value="{{ $agama }}" {{ old('agama', $data['agama'] ?? '') == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Alamat Lengkap --}}
                <div class="col-span-full">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                    <textarea name="alamat_lengkap"
                        class="w-full p-4 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-slate-900 dark:text-slate-100 resize-none"
                        placeholder="Nama jalan, nomor rumah, RT/RW, Kelurahan, Kecamatan" rows="3">{{ old('alamat_lengkap', $data['alamat_lengkap'] ?? '') }}</textarea>
                </div>
            </div>

            {{-- Footer Buttons --}}
            <div class="flex flex-col md:flex-row gap-4 pt-6 border-t border-primary/5">
                <a href="{{ route('siswa.dashboard') }}" class="flex-1 h-14 rounded-xl font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors flex items-center justify-center">
                    Batal
                </a>
                <button type="submit" class="flex-[2] h-14 rounded-xl bg-primary text-white font-bold flex items-center justify-center gap-2 hover:bg-primary/90 shadow-lg shadow-primary/20 transition-all">
                    Selanjutnya
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>
            </div>
        </form>
    </div>

    {{-- Info Card --}}
    <div class="mt-8 p-4 rounded-xl bg-primary/5 border border-primary/10 flex gap-4 items-start">
        <span class="material-symbols-outlined text-primary">info</span>
        <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
            Mohon pastikan data yang diisi sudah sesuai dengan Kartu Keluarga dan Akta Kelahiran anak untuk keperluan sinkronisasi data Dapodik.
        </p>
    </div>
</div>
@endsection
