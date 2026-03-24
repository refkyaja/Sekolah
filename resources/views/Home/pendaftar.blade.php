<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftar PPDB - TK PGRI Harapan Bangsa 1</title>
    
    {{-- Fonts & Icons --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    {{-- Vite Scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800 min-h-screen">

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('ppdb.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white text-slate-600 hover:text-primary font-bold shadow-sm border border-slate-200 hover:border-primary/30 transition-all">
            <span class="material-symbols-outlined text-xl">arrow_back</span>
            Kembali ke Beranda PPDB
        </a>
    </div>

    {{-- Header dengan Foto --}}
    <div class="relative h-[250px] md:h-[300px] w-full overflow-hidden rounded-[2rem] shadow-lg mb-8 group">
        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105" style="background-image: url('{{ asset('images/ppdb.jpeg') }}');"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/40 to-transparent flex flex-col justify-end p-8 md:p-12">
            <h1 class="text-white text-3xl md:text-5xl font-extrabold tracking-tight mb-3">Data Pendaftar PPDB</h1>
            <p class="text-white/85 text-base md:text-lg leading-relaxed max-w-2xl font-medium">
                Daftar calon peserta didik beserta informasi pengumuman hasil seleksi Penerimaan Peserta Didik Baru.
            </p>
        </div>
    </div>

<section class="mb-16">
    <div class="max-w-7xl mx-auto">
        
        {{-- Tabs Navigation --}}
        <div class="flex flex-col sm:flex-row gap-4 mb-8 bg-white p-2 md:p-3 rounded-2xl md:rounded-full shadow-sm w-full md:w-fit mx-auto">
            <a href="{{ route('pendaftar.index', ['tab' => 'pendaftar']) }}" 
               class="flex items-center justify-center gap-2 px-6 md:px-8 py-3 md:py-4 rounded-xl md:rounded-full font-bold transition-all text-sm md:text-base {{ $tab == 'pendaftar' ? 'bg-primary text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }}">
                <span class="material-symbols-outlined text-xl">group</span>
                Lihat Pendaftar
            </a>
            <a href="{{ route('pendaftar.index', ['tab' => 'pengumuman']) }}" 
               class="flex items-center justify-center gap-2 px-6 md:px-8 py-3 md:py-4 rounded-xl md:rounded-full font-bold transition-all text-sm md:text-base {{ $tab == 'pengumuman' ? 'bg-primary text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }}">
                <span class="material-symbols-outlined text-xl">campaign</span>
                Lihat Pengumuman
            </a>
        </div>

        {{-- Content Area --}}
        <div class="bg-white rounded-[2rem] shadow-xl border border-slate-100 overflow-hidden">
            
            @if($tab == 'pendaftar')
                {{-- TAB PENDAFTAR --}}
                <div class="p-6 md:p-10 border-b border-slate-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">Daftar Pendaftar PPDB</h2>
                        <p class="text-slate-500 mt-1">Total: {{ $pendaftars->count() }} Pendaftar</p>
                    </div>
                    
                    {{-- Filter Sorting --}}
                    <form action="{{ route('pendaftar.index') }}" method="GET" class="flex items-center gap-2 w-full md:w-auto mt-4 md:mt-0">
                        <input type="hidden" name="tab" value="pendaftar">
                        <label for="sort" class="text-sm font-bold text-slate-500 hidden md:block">Urutkan:</label>
                        <select name="sort" onchange="this.form.submit()" class="w-full md:w-auto bg-slate-50 border border-slate-200 rounded-xl py-2.5 px-4 text-sm font-bold text-slate-700 cursor-pointer focus:ring-2 focus:ring-primary/20 shadow-sm outline-none">
                            <option value="upload_terbaru" {{ $sort == 'upload_terbaru' ? 'selected' : '' }}>Upload Terbaru</option>
                            <option value="upload_terlama" {{ $sort == 'upload_terlama' ? 'selected' : '' }}>Upload Terlama</option>
                            <option value="az" {{ $sort == 'az' ? 'selected' : '' }}>Nama (A-Z)</option>
                            <option value="za" {{ $sort == 'za' ? 'selected' : '' }}>Nama (Z-A)</option>
                            <option value="termuda" {{ $sort == 'termuda' ? 'selected' : '' }}>Usia Termuda</option>
                            <option value="tertua" {{ $sort == 'tertua' ? 'selected' : '' }}>Usia Tertua</option>
                        </select>
                    </form>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-y border-slate-200">
                                <th class="py-4 px-6 font-bold text-slate-700 text-sm whitespace-nowrap">No</th>
                                <th class="py-4 px-6 font-bold text-slate-700 text-sm whitespace-nowrap">No. Pendaftaran</th>
                                <th class="py-4 px-6 font-bold text-slate-700 text-sm whitespace-nowrap">Nama Lengkap</th>
                                <th class="py-4 px-6 font-bold text-slate-700 text-sm whitespace-nowrap">Usia</th>
                                <th class="py-4 px-6 font-bold text-slate-700 text-sm whitespace-nowrap">Jenis Kelamin</th>
                                <th class="py-4 px-6 font-bold text-slate-700 text-sm whitespace-nowrap">Asal Kota/Kab</th>
                                <th class="py-4 px-6 font-bold text-slate-700 text-sm whitespace-nowrap">Tanggal Daftar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($pendaftars as $index => $pendaftar)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-4 px-6 text-slate-600">{{ $index + 1 }}</td>
                                <td class="py-4 px-6 font-medium text-primary">{{ $pendaftar->no_pendaftaran }}</td>
                                <td class="py-4 px-6 font-bold text-slate-900 uppercase">{{ $pendaftar->nama_lengkap_anak }}</td>
                                <td class="py-4 px-6 text-slate-600 font-medium">{{ $pendaftar->usia }}</td>
                                <td class="py-4 px-6 text-slate-600">{{ $pendaftar->jenis_kelamin }}</td>
                                <td class="py-4 px-6 text-slate-600">{{ $pendaftar->kota_kabupaten_rumah }}</td>
                                <td class="py-4 px-6 text-slate-600">{{ $pendaftar->created_at->translatedFormat('d F Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-slate-400">
                                        <span class="material-symbols-outlined text-5xl mb-3 opacity-50">group_off</span>
                                        <p class="text-lg font-medium">Belum ada data pendaftar.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            @else
                {{-- TAB PENGUMUMAN --}}
                <div class="p-6 md:p-10 border-b border-slate-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">Pengumuman Kelulusan</h2>
                        <p class="text-slate-500 mt-1">Hasil seleksi Penerimaan Peserta Didik Baru</p>
                    </div>

                    @if($spmbSetting && $spmbSetting->isPengumumanTampil())
                    <form action="{{ route('pendaftar.index') }}" method="GET" class="flex items-center gap-2 w-full md:w-auto mt-4 md:mt-0">
                        <input type="hidden" name="tab" value="pengumuman">
                        <label for="sort_pengumuman" class="text-sm font-bold text-slate-500 hidden md:block">Urutkan:</label>
                        <select name="sort" onchange="this.form.submit()" class="w-full md:w-auto bg-slate-50 border border-slate-200 rounded-xl py-2.5 px-4 text-sm font-bold text-slate-700 cursor-pointer focus:ring-2 focus:ring-primary/20 shadow-sm outline-none">
                            <option value="upload_terbaru" {{ $sort == 'upload_terbaru' ? 'selected' : '' }}>Upload Terbaru</option>
                            <option value="upload_terlama" {{ $sort == 'upload_terlama' ? 'selected' : '' }}>Upload Terlama</option>
                            <option value="az" {{ $sort == 'az' ? 'selected' : '' }}>Nama (A-Z)</option>
                            <option value="za" {{ $sort == 'za' ? 'selected' : '' }}>Nama (Z-A)</option>
                            <option value="termuda" {{ $sort == 'termuda' ? 'selected' : '' }}>Usia Termuda</option>
                            <option value="tertua" {{ $sort == 'tertua' ? 'selected' : '' }}>Usia Tertua</option>
                        </select>
                    </form>
                    @endif
                </div>

                @if($spmbSetting && $spmbSetting->isPengumumanTampil())
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-y border-slate-200">
                                    <th class="py-4 px-6 font-bold text-slate-700 text-sm whitespace-nowrap">No</th>
                                    <th class="py-4 px-6 font-bold text-slate-700 text-sm whitespace-nowrap">No. Pendaftaran</th>
                                    <th class="py-4 px-6 font-bold text-slate-700 text-sm whitespace-nowrap">Nama Lengkap</th>
                                    <th class="py-4 px-6 font-bold text-slate-700 text-sm whitespace-nowrap">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @php
                                    $pengumumans = $pendaftars->whereIn('status_pendaftaran', ['Lulus', 'Tidak Lulus']);
                                @endphp
                                @forelse($pengumumans as $index => $peng)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="py-4 px-6 text-slate-600">{{ $loop->iteration }}</td>
                                    <td class="py-4 px-6 font-medium text-slate-900">{{ $peng->no_pendaftaran }}</td>
                                    <td class="py-4 px-6 font-bold text-slate-900 uppercase">{{ $peng->nama_lengkap_anak }}</td>
                                    <td class="py-4 px-6">
                                        @if($peng->status_pendaftaran == 'Lulus')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold uppercase tracking-wider">
                                                <span class="material-symbols-outlined text-[14px]">check_circle</span>
                                                Diterima
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold uppercase tracking-wider">
                                                <span class="material-symbols-outlined text-[14px]">cancel</span>
                                                Tidak Diterima
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-slate-400">
                                            <span class="material-symbols-outlined text-5xl mb-3 opacity-50">event_busy</span>
                                            <p class="text-lg font-medium">Belum ada data pengumuman kelulusan.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-10 md:p-16 text-center">
                        <div class="size-24 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-6 text-slate-400">
                            <span class="material-symbols-outlined text-5xl">lock_clock</span>
                        </div>
                        <h3 class="text-xl md:text-2xl font-bold text-slate-800 mb-2">Pengumuman Belum Tersedia</h3>
                        <p class="text-slate-500 max-w-md mx-auto">
                            Saat ini belum waktunya pengumuman kelulusan. Silakan periksa kembali pada jadwal yang telah ditentukan.
                        </p>
                    </div>
                @endif
            @endif

        </div>
    </div>
</section>

</div>
</body>
</html>
