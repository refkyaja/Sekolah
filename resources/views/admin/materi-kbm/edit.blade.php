@php
    $role = auth()->user()->role;
    $layout = match ($role) {
        'admin' => 'layouts.admin',
        'operator' => 'layouts.operator',
        'kepala_sekolah' => 'layouts.kepala-sekolah',
        'guru' => 'layouts.guru',
        default => 'layouts.app',
    };
    $routePrefix = match ($role) {
        'admin' => 'admin',
        'operator' => 'operator',
        'kepala_sekolah' => 'kepala-sekolah',
        'guru' => 'guru',
        default => 'admin',
    };
@endphp

@extends($layout)

@section('title', 'Edit Materi KBM')
@section('breadcrumb', 'Materi KBM / Edit')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 sm:p-8">
        <form method="POST" action="{{ route($routePrefix . '.materi-kbm.update', $materiKbm) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Mata Pelajaran --}}
            <div class="mb-5">
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Mata Pelajaran <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-3 gap-2">
                    @foreach($daftarMapel as $mapel)
                    @php
                        $mapelIcons = ['Baca' => 'menu_book', 'Tulis' => 'edit_note', 'Menghitung' => 'calculate'];
                        $mapelColors = [
                            'Baca'        => 'peer-checked:bg-purple-600 peer-checked:border-purple-600 peer-checked:text-white',
                            'Tulis'       => 'peer-checked:bg-blue-600 peer-checked:border-blue-600 peer-checked:text-white',
                            'Menghitung'  => 'peer-checked:bg-emerald-600 peer-checked:border-emerald-600 peer-checked:text-white',
                        ];
                        $isSelected = old('mata_pelajaran', $materiKbm->mata_pelajaran) == $mapel;
                    @endphp
                    <label class="relative cursor-pointer">
                        <input type="radio" name="mata_pelajaran" value="{{ $mapel }}"
                            class="peer sr-only" {{ $isSelected ? 'checked' : '' }}>
                        <div class="flex flex-col items-center justify-center gap-1.5 p-3 sm:p-4 border-2 border-slate-200 rounded-xl text-slate-500 hover:border-slate-300 transition-all {{ $mapelColors[$mapel] ?? '' }} text-center select-none">
                            <span class="material-symbols-outlined text-2xl">{{ $mapelIcons[$mapel] ?? 'book' }}</span>
                            <span class="text-xs font-bold">{{ $mapel }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('mata_pelajaran')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Judul Materi --}}
            <div class="mb-5">
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Judul Materi <span class="text-red-500">*</span>
                </label>
                <input type="text" name="judul_materi"
                    value="{{ old('judul_materi', $materiKbm->judul_materi) }}"
                    placeholder="Contoh: Membaca Huruf Vokal"
                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm transition-all @error('judul_materi') border-red-400 @enderror"/>
                @error('judul_materi')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kelompok --}}
            <div class="mb-5">
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Kelompok <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($daftarKelas as $kls)
                    <label class="relative cursor-pointer">
                        <input type="radio" name="kelas" value="{{ $kls }}"
                            class="peer sr-only" {{ old('kelas', $materiKbm->kelas) == $kls ? 'checked' : '' }}>
                        <div class="flex items-center justify-center gap-2 p-3 border-2 border-slate-200 rounded-xl text-slate-500 hover:border-slate-300 transition-all peer-checked:bg-primary peer-checked:border-primary peer-checked:text-white text-sm font-bold select-none">
                            <span class="material-symbols-outlined text-lg">group</span>
                            {{ $kls }}
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('kelas')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal Publish --}}
            <div class="mb-5">
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    Tanggal Publish <span class="text-red-500">*</span>
                </label>
                <input type="date" name="tanggal_publish"
                    value="{{ old('tanggal_publish', $materiKbm->tanggal_publish->format('Y-m-d')) }}"
                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm transition-all @error('tanggal_publish') border-red-400 @enderror"/>
                @error('tanggal_publish')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div class="mb-5">
                <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi</label>
                <textarea name="deskripsi" rows="3"
                    placeholder="Deskripsi singkat tentang materi ini..."
                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm transition-all resize-none">{{ old('deskripsi', $materiKbm->deskripsi) }}</textarea>
            </div>

            {{-- File saat ini --}}
            @if($materiKbm->file_path)
            <div class="mb-4 flex items-center gap-3 p-3 bg-purple-50 border border-purple-100 rounded-xl">
                <span class="material-symbols-outlined text-primary flex-shrink-0">description</span>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-slate-700 truncate">{{ $materiKbm->file_name }}</p>
                    <p class="text-xs text-slate-400">{{ $materiKbm->file_type }} • {{ $materiKbm->file_size_formatted }}</p>
                </div>
                <a href="{{ route($routePrefix . '.materi-kbm.download', $materiKbm) }}"
                    class="text-primary hover:text-purple-700 text-xs font-bold flex-shrink-0">Download</a>
            </div>
            <p class="text-xs text-slate-400 mb-3">Upload file baru di bawah untuk mengganti file yang ada.</p>
            @endif

            {{-- Upload File --}}
            <div class="mb-7">
                <label class="block text-sm font-bold text-slate-700 mb-2">
                    {{ $materiKbm->file_path ? 'Ganti File Materi' : 'Upload File Materi' }}
                </label>
                <label for="fileInput"
                    class="flex flex-col items-center justify-center gap-2 border-2 border-dashed border-slate-200 rounded-xl p-6 text-center hover:border-primary/40 transition-colors bg-slate-50 cursor-pointer group">
                    <span class="material-symbols-outlined text-4xl text-slate-300 group-hover:text-primary/60 transition-colors">upload_file</span>
                    <p class="text-sm text-slate-500">PDF, Word, PowerPoint, Excel, Gambar, Video, ZIP</p>
                    <p class="text-xs text-slate-400">Maks. 50 MB</p>
                    <span class="mt-1 px-4 py-1.5 bg-primary text-white rounded-lg text-sm font-bold group-hover:bg-purple-700 transition-all">
                        Pilih File
                    </span>
                    <p class="text-xs text-slate-400" id="fileNameDisplay">Belum ada file dipilih</p>
                    <input type="file" name="file" class="hidden" id="fileInput"
                        accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.jpg,.jpeg,.png,.mp4,.zip,.rar"
                        onchange="showFileName(this)"/>
                </label>
                @error('file')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row gap-3">
                <button type="submit"
                    class="flex items-center justify-center gap-2 px-6 py-2.5 bg-primary text-white rounded-xl font-bold text-sm hover:bg-purple-700 transition-all shadow-lg shadow-primary/20 w-full sm:w-auto">
                    <span class="material-symbols-outlined text-xl">save</span>
                    Perbarui Materi
                </button>
                <a href="{{ route($routePrefix . '.materi-kbm.index') }}"
                    class="flex items-center justify-center px-6 py-2.5 border border-slate-200 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-50 transition-all w-full sm:w-auto">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function showFileName(input) {
        const display = document.getElementById('fileNameDisplay');
        if (input.files && input.files[0]) {
            display.textContent = input.files[0].name;
            display.classList.remove('text-slate-400');
            display.classList.add('text-primary', 'font-medium');
        } else {
            display.textContent = 'Belum ada file dipilih';
            display.classList.add('text-slate-400');
            display.classList.remove('text-primary', 'font-medium');
        }
    }
</script>
@endpush
