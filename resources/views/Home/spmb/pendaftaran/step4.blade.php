@extends('layouts.student')

@section('title', 'PPDB - Periksa Data')

@section('content')
<div class="max-w-[800px] mx-auto px-4 py-8">

    {{-- Progress --}}
    <div class="flex flex-col gap-3 p-6 bg-white dark:bg-dark-card rounded-xl shadow-sm mb-8 border border-white/5">
        <div class="flex gap-6 justify-between items-center">
            <p class="text-slate-900 dark:text-slate-100 text-base font-bold">Langkah 4 dari 4</p>
            <p class="text-primary text-sm font-bold bg-primary/10 px-3 py-1 rounded-full">100% Selesai</p>
        </div>
        <div class="rounded-full bg-slate-200 dark:bg-slate-800 h-3 overflow-hidden">
            <div class="h-full rounded-full bg-primary" style="width: 100%;"></div>
        </div>
        <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Konfirmasi &amp; Kirim Pendaftaran</p>
    </div>

    {{-- Page Intro --}}
    <div class="flex flex-col gap-2 mb-6">
        <h1 class="text-slate-900 dark:text-slate-100 text-3xl font-extrabold tracking-tight">Periksa Data Anda</h1>
        <p class="text-slate-500 dark:text-slate-400 text-base leading-relaxed">Silakan tinjau kembali seluruh informasi di bawah ini. Pastikan semua data sudah benar sebelum menekan tombol kirim.</p>
    </div>

    @if(session('error'))
    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl text-sm text-red-700 dark:text-red-400">
        {{ session('error') }}
    </div>
    @endif

    {{-- 1. Data Pribadi --}}
    <section class="mb-6 bg-white dark:bg-dark-card rounded-xl shadow-sm border border-white/5 overflow-hidden">
        <div class="bg-primary/5 px-6 py-4 border-b border-primary/10 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">person</span>
                <h3 class="text-slate-900 dark:text-slate-100 text-lg font-bold">1. Data Pribadi Siswa</h3>
            </div>
            <a href="{{ route('siswa.pendaftaran.step1') }}" class="text-xs text-primary font-semibold hover:underline flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">edit</span> Ubah
            </a>
        </div>
        <div class="p-6 space-y-3">
            @php
            $pribadi = [
                'Nama Lengkap'    => $step1['nama_lengkap_anak'] ?? '-',
                'Nama Panggilan'  => $step1['nama_panggilan_anak'] ?? '-',
                'Jenis Kelamin'   => $step1['jenis_kelamin'] ?? '-',
                'Tempat, Tgl Lahir' => ($step1['tempat_lahir_anak'] ?? '-') . ', ' . \Carbon\Carbon::parse($step1['tanggal_lahir_anak'] ?? null)->translatedFormat('d F Y'),
                'Agama'           => $step1['agama'] ?? '-',
                'Alamat'          => $step1['alamat_lengkap'] ?? '-',
            ];
            @endphp
            @foreach($pribadi as $label => $value)
            <div class="flex justify-between items-start border-b border-slate-100 dark:border-slate-800 pb-3 last:border-0 last:pb-0">
                <p class="text-slate-500 dark:text-slate-400 text-sm min-w-[140px]">{{ $label }}</p>
                <p class="text-slate-900 dark:text-slate-100 text-sm font-semibold text-right ml-4">{{ $value }}</p>
            </div>
            @endforeach
        </div>
    </section>

    {{-- 2. Data Orang Tua --}}
    <section class="mb-6 bg-white dark:bg-dark-card rounded-xl shadow-sm border border-white/5 overflow-hidden">
        <div class="bg-primary/5 px-6 py-4 border-b border-primary/10 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">family_restroom</span>
                <h3 class="text-slate-900 dark:text-slate-100 text-lg font-bold">2. Data Orang Tua / Wali</h3>
            </div>
            <a href="{{ route('siswa.pendaftaran.step2') }}" class="text-xs text-primary font-semibold hover:underline flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">edit</span> Ubah
            </a>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h4 class="text-primary text-xs font-bold uppercase tracking-wider mb-3">Data Ayah</h4>
                <div class="space-y-2">
                    <div class="flex flex-col">
                        <span class="text-slate-500 dark:text-slate-400 text-xs">Nama Ayah</span>
                        <span class="text-slate-900 dark:text-slate-100 text-sm font-semibold">{{ $step2['nama_lengkap_ayah'] ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-slate-500 dark:text-slate-400 text-xs">NIK</span>
                        <span class="text-slate-900 dark:text-slate-100 text-sm font-semibold">{{ $step2['nik_ayah'] ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-slate-500 dark:text-slate-400 text-xs">Pekerjaan</span>
                        <span class="text-slate-900 dark:text-slate-100 text-sm font-semibold">{{ $step2['pekerjaan_ayah'] ?? '-' }}</span>
                    </div>
                </div>
            </div>
            <div>
                <h4 class="text-primary text-xs font-bold uppercase tracking-wider mb-3">Data Ibu</h4>
                <div class="space-y-2">
                    <div class="flex flex-col">
                        <span class="text-slate-500 dark:text-slate-400 text-xs">Nama Ibu</span>
                        <span class="text-slate-900 dark:text-slate-100 text-sm font-semibold">{{ $step2['nama_lengkap_ibu'] ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-slate-500 dark:text-slate-400 text-xs">NIK</span>
                        <span class="text-slate-900 dark:text-slate-100 text-sm font-semibold">{{ $step2['nik_ibu'] ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-slate-500 dark:text-slate-400 text-xs">Pekerjaan</span>
                        <span class="text-slate-900 dark:text-slate-100 text-sm font-semibold">{{ $step2['pekerjaan_ibu'] ?? '-' }}</span>
                    </div>
                </div>
            </div>
            {{-- Contact --}}
            <div class="md:col-span-2 pt-4 border-t border-slate-100 dark:border-slate-800">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex flex-col">
                        <span class="text-slate-500 dark:text-slate-400 text-xs">WhatsApp</span>
                        <span class="text-slate-900 dark:text-slate-100 text-sm font-semibold">+62{{ $step2['nomor_telepon'] ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-slate-500 dark:text-slate-400 text-xs">Email</span>
                        <span class="text-slate-900 dark:text-slate-100 text-sm font-semibold">{{ $step2['email'] ?: '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-slate-500 dark:text-slate-400 text-xs">Penghasilan Gabungan</span>
                        <span class="text-slate-900 dark:text-slate-100 text-sm font-semibold">{{ $step2['penghasilan_gabungan'] ?: '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. Dokumen Terunggah --}}
    <section class="mb-6 bg-white dark:bg-dark-card rounded-xl shadow-sm border border-white/5 overflow-hidden">
        <div class="bg-primary/5 px-6 py-4 border-b border-primary/10 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">cloud_done</span>
                <h3 class="text-slate-900 dark:text-slate-100 text-lg font-bold">3. Dokumen Terunggah</h3>
            </div>
            <a href="{{ route('siswa.pendaftaran.step3') }}" class="text-xs text-primary font-semibold hover:underline flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">edit</span> Ubah
            </a>
        </div>
        <div class="p-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
            @php
            $docLabels = ['kartu_keluarga' => 'Kartu Keluarga', 'akta_kelahiran' => 'Akta Kelahiran', 'ijazah' => 'Ijazah/SKL', 'pas_foto' => 'Pas Foto'];
            @endphp
            @foreach($docLabels as $key => $label)
            @if(isset($step3[$key]))
            <div class="flex items-center gap-3 p-3 rounded-lg border border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50">
                <span class="material-symbols-outlined text-primary">description</span>
                <div class="flex flex-col overflow-hidden">
                    <span class="text-xs font-bold text-slate-900 dark:text-slate-100">{{ $label }}</span>
                    <span class="text-[10px] text-slate-500 truncate">{{ $step3[$key]['original_name'] }} &bull; {{ $step3[$key]['size'] }} KB</span>
                </div>
            </div>
            @else
            @if(in_array($key, ['kartu_keluarga', 'akta_kelahiran', 'pas_foto']))
            <div class="flex items-center gap-3 p-3 rounded-lg border border-red-100 dark:border-red-900/30 bg-red-50 dark:bg-red-900/10">
                <span class="material-symbols-outlined text-red-400">error</span>
                <span class="text-xs font-semibold text-red-600 dark:text-red-400">{{ $label }} - Belum diunggah!</span>
            </div>
            @endif
            @endif
            @endforeach
        </div>
    </section>

    {{-- Terms & Conditions --}}
    <form action="{{ route('siswa.pendaftaran.submit') }}" method="POST">
        @csrf
        @if($errors->has('konfirmasi'))
        <div class="mb-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 rounded-xl text-sm text-red-600">
            {{ $errors->first('konfirmasi') }}
        </div>
        @endif
        <div class="p-6 bg-primary/5 rounded-xl mb-6 border border-primary/20">
            <label class="flex gap-4 cursor-pointer">
                <div class="relative flex items-start mt-0.5">
                    <input name="konfirmasi" value="1" class="h-5 w-5 rounded border-primary text-primary focus:ring-primary bg-white dark:bg-dark-card mt-0.5" type="checkbox"/>
                </div>
                <span class="text-sm text-slate-700 dark:text-slate-300 leading-relaxed font-medium">
                    Saya menyatakan bahwa seluruh data yang saya masukkan adalah
                    <span class="font-bold text-slate-900 dark:text-slate-100 underline decoration-primary/50">benar dan sesuai</span>
                    dengan aslinya. Apabila di kemudian hari ditemukan ketidaksesuaian, saya bersedia menerima konsekuensi pembatalan pendaftaran.
                </span>
            </label>
        </div>

        {{-- Action Buttons --}}
        <div class="flex flex-col sm:flex-row gap-4 mb-16">
            <a href="{{ route('siswa.pendaftaran.step3') }}" class="flex-1 flex items-center justify-center gap-2 h-14 rounded-xl border-2 border-primary/20 text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
                <span class="material-symbols-outlined">arrow_back</span>
                Kembali Ke Tahap 3
            </a>
            <button type="submit" class="flex-[2] flex items-center justify-center gap-2 h-14 rounded-xl bg-primary text-white font-bold text-lg hover:bg-primary/90 shadow-lg shadow-primary/25 transition-all active:scale-[0.98]">
                <span class="material-symbols-outlined">send</span>
                Kirim Pendaftaran
            </button>
        </div>
    </form>
</div>
@endsection
