@extends('layouts.nav-spmb')

@section('title', 'PPDB - Upload Berkas')

@section('content')
<div class="max-w-[960px] mx-auto min-h-screen flex flex-col px-4 py-8">

    {{-- Progress --}}
    <div class="mb-10 space-y-3">
        <div class="flex justify-between items-end">
            <div class="space-y-1">
                <p class="text-primary font-semibold text-sm uppercase tracking-wider">Langkah 3 dari 4</p>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-slate-100">Upload Berkas</h1>
                <p class="text-slate-500 dark:text-slate-400 text-sm">Silakan unggah dokumen pendukung pendaftaran. Pastikan file terbaca dengan jelas.</p>
            </div>
            <p class="text-primary font-bold text-lg">75%</p>
        </div>
        <div class="w-full h-3 bg-primary/10 rounded-full overflow-hidden">
            <div class="h-full bg-primary rounded-full transition-all duration-500" style="width: 75%;"></div>
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

    {{-- Upload Form --}}
    <form action="{{ route('pendaftaran.step3.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        {{-- Upload Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Kartu Keluarga --}}
            <div class="bg-white dark:bg-dark-card p-6 rounded-xl border border-white/5 shadow-sm hover:border-primary/30 transition-all">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 bg-primary/10 rounded-lg text-primary">
                        <span class="material-symbols-outlined">family_restroom</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 dark:text-slate-100">Kartu Keluarga (KK)</h3>
                        <p class="text-xs text-red-500 font-medium">Wajib</p>
                    </div>
                </div>
                <label class="relative flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-primary/20 rounded-xl cursor-pointer bg-primary/5 hover:bg-primary/10 transition-all" id="kk-label">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6" id="kk-placeholder">
                        <span class="material-symbols-outlined text-primary mb-2 text-3xl">cloud_upload</span>
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Klik atau seret file ke sini</p>
                        <p class="text-[10px] text-slate-400 mt-1">PDF, JPG (Maks. 2MB)</p>
                    </div>
                    <div class="hidden items-center gap-2 text-primary font-medium text-sm" id="kk-selected">
                        <span class="material-symbols-outlined">check_circle</span>
                        <span id="kk-filename">-</span>
                    </div>
                    @if(isset($uploadedFiles['kartu_keluarga']))
                    <div class="flex items-center gap-2 text-emerald-500 font-medium text-sm">
                        <span class="material-symbols-outlined">check_circle</span>
                        <span>{{ $uploadedFiles['kartu_keluarga']['original_name'] }}</span>
                    </div>
                    @endif
                    <input class="hidden" type="file" name="kartu_keluarga" id="kartu_keluarga" accept=".pdf,.jpg,.jpeg,.png"/>
                </label>
            </div>

            {{-- Akta Kelahiran --}}
            <div class="bg-white dark:bg-dark-card p-6 rounded-xl border border-white/5 shadow-sm hover:border-primary/30 transition-all">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 bg-primary/10 rounded-lg text-primary">
                        <span class="material-symbols-outlined">child_care</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 dark:text-slate-100">Akta Kelahiran</h3>
                        <p class="text-xs text-red-500 font-medium">Wajib</p>
                    </div>
                </div>
                <label class="relative flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-primary/20 rounded-xl cursor-pointer bg-primary/5 hover:bg-primary/10 transition-all">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6" id="akta-placeholder">
                        <span class="material-symbols-outlined text-primary mb-2 text-3xl">cloud_upload</span>
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Klik atau seret file ke sini</p>
                        <p class="text-[10px] text-slate-400 mt-1">PDF, JPG (Maks. 2MB)</p>
                    </div>
                    <div class="hidden items-center gap-2 text-primary font-medium text-sm" id="akta-selected">
                        <span class="material-symbols-outlined">check_circle</span>
                        <span id="akta-filename">-</span>
                    </div>
                    <input class="hidden" type="file" name="akta_kelahiran" id="akta_kelahiran" accept=".pdf,.jpg,.jpeg,.png"/>
                </label>
            </div>

            {{-- Ijazah/SKL --}}
            <div class="bg-white dark:bg-dark-card p-6 rounded-xl border border-white/5 shadow-sm hover:border-primary/30 transition-all">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 bg-primary/10 rounded-lg text-primary">
                        <span class="material-symbols-outlined">description</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <h3 class="font-bold text-slate-900 dark:text-slate-100">Ijazah / SKL</h3>
                        <span class="text-[10px] px-2 py-0.5 bg-slate-100 dark:bg-slate-700 rounded-full text-slate-500 font-medium italic">Opsional</span>
                    </div>
                </div>
                <label class="relative flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-primary/20 rounded-xl cursor-pointer bg-primary/5 hover:bg-primary/10 transition-all">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6" id="ijazah-placeholder">
                        <span class="material-symbols-outlined text-primary mb-2 text-3xl">cloud_upload</span>
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Klik atau seret file ke sini</p>
                        <p class="text-[10px] text-slate-400 mt-1">PDF, JPG (Maks. 2MB)</p>
                    </div>
                    <div class="hidden items-center gap-2 text-primary font-medium text-sm" id="ijazah-selected">
                        <span class="material-symbols-outlined">check_circle</span>
                        <span id="ijazah-filename">-</span>
                    </div>
                    <input class="hidden" type="file" name="ijazah" id="ijazah" accept=".pdf,.jpg,.jpeg,.png"/>
                </label>
            </div>

            {{-- Pas Foto --}}
            <div class="bg-white dark:bg-dark-card p-6 rounded-xl border border-white/5 shadow-sm hover:border-primary/30 transition-all">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 bg-primary/10 rounded-lg text-primary">
                        <span class="material-symbols-outlined">account_box</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 dark:text-slate-100">Pas Foto (3x4)</h3>
                        <p class="text-xs text-red-500 font-medium">Wajib</p>
                    </div>
                </div>
                <label class="relative flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-primary/20 rounded-xl cursor-pointer bg-primary/5 hover:bg-primary/10 transition-all">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6" id="foto-placeholder">
                        <span class="material-symbols-outlined text-primary mb-2 text-3xl">add_a_photo</span>
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Klik atau seret foto ke sini</p>
                        <p class="text-[10px] text-slate-400 mt-1">JPG, PNG (Maks. 1MB)</p>
                    </div>
                    <div class="hidden items-center gap-2 text-primary font-medium text-sm" id="foto-selected">
                        <span class="material-symbols-outlined">check_circle</span>
                        <span id="foto-filename">-</span>
                    </div>
                    <input class="hidden" type="file" name="pas_foto" id="pas_foto" accept=".jpg,.jpeg,.png"/>
                </label>
            </div>
        </div>

        {{-- Alert --}}
        <div class="bg-primary/10 border border-primary/20 p-4 rounded-xl flex gap-3">
            <span class="material-symbols-outlined text-primary">info</span>
            <p class="text-sm text-slate-700 dark:text-slate-300">Pastikan semua dokumen diunggah dalam format yang didukung dan resolusi yang cukup agar dapat diverifikasi oleh admin sekolah.</p>
        </div>

        {{-- Navigation --}}
        <div class="flex items-center justify-between">
            <a href="{{ route('pendaftaran.step2') }}" class="flex items-center gap-2 px-6 py-3 rounded-full font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
                Kembali
            </a>
            <button type="submit" class="flex items-center gap-2 px-10 py-3 rounded-full font-bold bg-primary text-white hover:opacity-90 transition-opacity shadow-lg shadow-primary/20">
                Selanjutnya
                <span class="material-symbols-outlined">arrow_forward</span>
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // File input labels with preview name
    const fileInputs = [
        { input: 'kartu_keluarga', placeholder: 'kk-placeholder', selected: 'kk-selected', filename: 'kk-filename' },
        { input: 'akta_kelahiran', placeholder: 'akta-placeholder', selected: 'akta-selected', filename: 'akta-filename' },
        { input: 'ijazah', placeholder: 'ijazah-placeholder', selected: 'ijazah-selected', filename: 'ijazah-filename' },
        { input: 'pas_foto', placeholder: 'foto-placeholder', selected: 'foto-selected', filename: 'foto-filename' },
    ];

    fileInputs.forEach(({ input, placeholder, selected, filename }) => {
        const el = document.getElementById(input);
        if (!el) return;
        el.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                document.getElementById(placeholder).classList.add('hidden');
                const sel = document.getElementById(selected);
                sel.classList.remove('hidden');
                sel.classList.add('flex');
                document.getElementById(filename).textContent = this.files[0].name;
            }
        });
    });
</script>
@endpush
@endsection
