@extends('layouts.student')

@section('title', 'PPDB - Data Orang Tua')

@section('content')
<div class="max-w-[960px] mx-auto min-h-screen flex flex-col px-4 py-8">

    {{-- Progress --}}
    <div class="mb-10">
        <div class="flex justify-between items-end mb-3">
            <div>
                <p class="text-sm font-semibold text-primary uppercase tracking-wider">Langkah 2 dari 4</p>
                <h1 class="text-2xl md:text-3xl font-bold mt-1 text-slate-900 dark:text-slate-100">Data Orang Tua / Wali</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1">Isi data orang tua atau wali calon siswa</p>
            </div>
            <p class="text-lg font-bold text-primary">50%</p>
        </div>
        <div class="h-3 w-full bg-primary/10 rounded-full overflow-hidden">
            <div class="h-full bg-primary rounded-full transition-all duration-500" style="width: 50%;"></div>
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

    {{-- Form Card --}}
    <div class="bg-white dark:bg-dark-card rounded-xl shadow-sm border border-white/5 p-6 md:p-8 flex flex-col gap-10">
        <form action="{{ route('siswa.pendaftaran.step2.store') }}" method="POST">
            @csrf

            {{-- Section: Ayah --}}
            <section class="flex flex-col gap-6">
                <div class="flex items-center gap-3 border-b border-slate-100 dark:border-slate-800 pb-3">
                    <span class="material-symbols-outlined text-primary">person</span>
                    <h2 class="text-slate-900 dark:text-slate-100 text-xl font-bold leading-tight">Informasi Ayah</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <label class="flex flex-col gap-2">
                        <span class="text-slate-700 dark:text-slate-300 text-sm font-semibold">Nama Lengkap Ayah <span class="text-red-500">*</span></span>
                        <input name="nama_lengkap_ayah" value="{{ old('nama_lengkap_ayah', $data['nama_lengkap_ayah'] ?? '') }}"
                            class="form-input rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 focus:border-primary focus:ring-primary h-12 text-slate-900 dark:text-slate-100"
                            placeholder="Contoh: Budi Santoso" type="text"/>
                    </label>
                    <label class="flex flex-col gap-2">
                        <span class="text-slate-700 dark:text-slate-300 text-sm font-semibold">NIK Ayah <span class="text-red-500">*</span></span>
                        <input name="nik_ayah" value="{{ old('nik_ayah', $data['nik_ayah'] ?? '') }}"
                            class="form-input rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 focus:border-primary focus:ring-primary h-12 text-slate-900 dark:text-slate-100"
                            placeholder="16 Digit NIK" maxlength="16" type="text"/>
                    </label>
                    <label class="flex flex-col gap-2">
                        <span class="text-slate-700 dark:text-slate-300 text-sm font-semibold">Pekerjaan</span>
                        <select name="pekerjaan_ayah" class="form-select rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 focus:border-primary focus:ring-primary h-12 text-slate-900 dark:text-slate-100">
                            <option value="">Pilih Pekerjaan</option>
                            @foreach(['PNS','Karyawan Swasta','Wiraswasta','TNI/POLRI','Lainnya'] as $pekerjaan)
                            <option value="{{ $pekerjaan }}" {{ old('pekerjaan_ayah', $data['pekerjaan_ayah'] ?? '') == $pekerjaan ? 'selected' : '' }}>{{ $pekerjaan }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="flex flex-col gap-2">
                        <span class="text-slate-700 dark:text-slate-300 text-sm font-semibold">Pendidikan Terakhir</span>
                        <select name="pendidikan_ayah" class="form-select rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 focus:border-primary focus:ring-primary h-12 text-slate-900 dark:text-slate-100">
                            <option value="">Pilih Pendidikan</option>
                            @foreach(['SMA/Sederajat','D3','S1/D4','S2','S3'] as $pendidikan)
                            <option value="{{ $pendidikan }}" {{ old('pendidikan_ayah', $data['pendidikan_ayah'] ?? '') == $pendidikan ? 'selected' : '' }}>{{ $pendidikan }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
            </section>

            {{-- Section: Ibu --}}
            <section class="flex flex-col gap-6">
                <div class="flex items-center gap-3 border-b border-slate-100 dark:border-slate-800 pb-3">
                    <span class="material-symbols-outlined text-primary">person_3</span>
                    <h2 class="text-slate-900 dark:text-slate-100 text-xl font-bold leading-tight">Informasi Ibu</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <label class="flex flex-col gap-2">
                        <span class="text-slate-700 dark:text-slate-300 text-sm font-semibold">Nama Lengkap Ibu <span class="text-red-500">*</span></span>
                        <input name="nama_lengkap_ibu" value="{{ old('nama_lengkap_ibu', $data['nama_lengkap_ibu'] ?? '') }}"
                            class="form-input rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 focus:border-primary focus:ring-primary h-12 text-slate-900 dark:text-slate-100"
                            placeholder="Contoh: Siti Aminah" type="text"/>
                    </label>
                    <label class="flex flex-col gap-2">
                        <span class="text-slate-700 dark:text-slate-300 text-sm font-semibold">NIK Ibu <span class="text-red-500">*</span></span>
                        <input name="nik_ibu" value="{{ old('nik_ibu', $data['nik_ibu'] ?? '') }}"
                            class="form-input rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 focus:border-primary focus:ring-primary h-12 text-slate-900 dark:text-slate-100"
                            placeholder="16 Digit NIK" maxlength="16" type="text"/>
                    </label>
                    <label class="flex flex-col gap-2">
                        <span class="text-slate-700 dark:text-slate-300 text-sm font-semibold">Pekerjaan</span>
                        <select name="pekerjaan_ibu" class="form-select rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 focus:border-primary focus:ring-primary h-12 text-slate-900 dark:text-slate-100">
                            <option value="">Pilih Pekerjaan</option>
                            @foreach(['Ibu Rumah Tangga','PNS','Karyawan Swasta','Wiraswasta','Lainnya'] as $pekerjaan)
                            <option value="{{ $pekerjaan }}" {{ old('pekerjaan_ibu', $data['pekerjaan_ibu'] ?? '') == $pekerjaan ? 'selected' : '' }}>{{ $pekerjaan }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="flex flex-col gap-2">
                        <span class="text-slate-700 dark:text-slate-300 text-sm font-semibold">Pendidikan Terakhir</span>
                        <select name="pendidikan_ibu" class="form-select rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 focus:border-primary focus:ring-primary h-12 text-slate-900 dark:text-slate-100">
                            <option value="">Pilih Pendidikan</option>
                            @foreach(['SMA/Sederajat','D3','S1/D4','S2','S3'] as $pendidikan)
                            <option value="{{ $pendidikan }}" {{ old('pendidikan_ibu', $data['pendidikan_ibu'] ?? '') == $pendidikan ? 'selected' : '' }}>{{ $pendidikan }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
            </section>

            {{-- Section: Kontak & Penghasilan --}}
            <section class="flex flex-col gap-6">
                <div class="flex items-center gap-3 border-b border-slate-100 dark:border-slate-800 pb-3">
                    <span class="material-symbols-outlined text-primary">payments</span>
                    <h2 class="text-slate-900 dark:text-slate-100 text-xl font-bold leading-tight">Kontak &amp; Penghasilan</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <label class="flex flex-col gap-2">
                        <span class="text-slate-700 dark:text-slate-300 text-sm font-semibold">Nomor WhatsApp Aktif <span class="text-red-500">*</span></span>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-medium text-sm">+62</span>
                            <input name="nomor_telepon" value="{{ old('nomor_telepon', $data['nomor_telepon'] ?? '') }}"
                                class="form-input rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 focus:border-primary focus:ring-primary h-12 w-full pl-14 text-slate-900 dark:text-slate-100"
                                placeholder="8123456789" type="tel"/>
                        </div>
                    </label>
                    <label class="flex flex-col gap-2">
                        <span class="text-slate-700 dark:text-slate-300 text-sm font-semibold">Alamat Email</span>
                        <input name="email" value="{{ old('email', $data['email'] ?? '') }}"
                            class="form-input rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 focus:border-primary focus:ring-primary h-12 text-slate-900 dark:text-slate-100"
                            placeholder="contoh@email.com" type="email"/>
                    </label>
                    <label class="flex flex-col gap-2 md:col-span-2">
                        <span class="text-slate-700 dark:text-slate-300 text-sm font-semibold">Penghasilan Bulanan Gabungan</span>
                        <select name="penghasilan_gabungan" class="form-select rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 focus:border-primary focus:ring-primary h-12 text-slate-900 dark:text-slate-100">
                            <option value="">Pilih Rentang Penghasilan</option>
                            @foreach(['Kurang dari Rp 2.000.000','Rp 2.000.000 - Rp 5.000.000','Rp 5.000.000 - Rp 10.000.000','Lebih dari Rp 10.000.000'] as $penghasilan)
                            <option value="{{ $penghasilan }}" {{ old('penghasilan_gabungan', $data['penghasilan_gabungan'] ?? '') == $penghasilan ? 'selected' : '' }}>{{ $penghasilan }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
            </section>

            {{-- Navigation Buttons --}}
            <div class="flex flex-col-reverse md:flex-row justify-between gap-4 pt-4">
                <a href="{{ route('siswa.pendaftaran.step1') }}" class="flex items-center justify-center gap-2 px-8 py-4 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-bold hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Sebelumnya
                </a>
                <button type="submit" class="flex items-center justify-center gap-2 px-10 py-4 rounded-xl bg-primary text-white font-bold hover:bg-primary/90 transition-all shadow-md">
                    Simpan &amp; Lanjut
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
