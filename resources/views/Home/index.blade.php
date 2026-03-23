@extends('layouts.home')

@section('title', 'TK PGRI Harapan Bangsa 1 - Bandung')

@section('content')
{{-- 1. Hero Section --}}
<header class="relative hero-gradient pt-28 pb-16 md:pt-48 md:pb-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid lg:grid-cols-2 gap-8 lg:gap-16 items-center">
            
            {{-- Text Content (Mobile: 1st, Desktop: 1st) --}}
            <div class="space-y-6 md:space-y-8 text-center lg:text-left order-1 lg:order-1" data-home-animate="fade-right">
                @if($spmbSetting && $spmbSetting->isPendaftaranDibuka())
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/50 border border-white/80 text-primary text-[10px] md:text-xs font-bold tracking-wide uppercase mx-auto lg:mx-0">
                    <span class="material-symbols-outlined text-sm">stars</span>
                    Pendaftaran Siswa Baru T.A. {{ $tahunAjaranAktif ? $tahunAjaranAktif->tahun_ajaran : date('Y') }}/{{ $tahunAjaranAktif ? (intval(substr($tahunAjaranAktif->tahun_ajaran, 0, 4)) + 1) : date('Y') + 1 }}
                </div>
                @endif
                <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold text-primary leading-tight lg:leading-[1.05]">
                    Tumbuh Ceria <br/> <span class="text-slate-900">Belajar Bersama Kami</span>
                </h1>
                <p class="text-base md:text-lg text-slate-500 max-w-lg mx-auto lg:mx-0 leading-relaxed">
                    Membentuk generasi cerdas, ceria, dan berakhlak mulia melalui pendidikan anak usia dini yang berkualitas dan penuh kasih sayang di TK PGRI Harapan Bangsa 1.
                </p>
                {{-- Desktop Button --}}
                <div class="hidden lg:flex flex-wrap justify-center lg:justify-start gap-4 pt-4">
                    <a href="{{ route('ppdb.index') }}" class="w-full sm:w-auto bg-primary hover:scale-105 text-white px-10 py-5 rounded-full text-lg font-bold transition-all shadow-2xl shadow-primary/30 inline-flex items-center justify-center">
                        Daftar Sekarang <span class="material-symbols-outlined align-middle ml-2">chevron_right</span>
                    </a>
                </div>
            </div>

            {{-- Hero Images Grid (Mobile: 2nd, Desktop: 2nd) --}}
            <div class="relative grid grid-cols-2 gap-3 md:gap-4 max-w-xl mx-auto lg:max-w-none order-2 lg:order-2 mt-2 lg:mt-0" data-home-stagger>
                <div class="space-y-3 md:space-y-4">
                    <div class="aspect-square rounded-[2rem] md:rounded-[3rem] overflow-hidden shadow-2xl bg-accent-blue p-2">
                        <img class="w-full h-full object-cover rounded-[1.5rem] md:rounded-[2.5rem]" 
                             alt="Anak-anak sekolah" 
                             src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=1000&auto=format&fit=crop"/>
                    </div>
                    <div class="aspect-square rounded-[2rem] md:rounded-[3rem] overflow-hidden shadow-xl bg-accent-green flex items-center justify-center p-4 md:p-8">
                        <div class="text-center">
                            <h4 class="text-primary font-bold text-lg md:text-2xl mb-1">Belajar Bersama</h4>
                            <p class="text-primary/60 text-[10px] md:text-xs uppercase tracking-wider">di Harapan Bangsa 1</p>
                        </div>
                    </div>
                </div>
                <div class="space-y-3 md:space-y-4 pt-8 md:pt-12">
                    <div class="aspect-square rounded-[2rem] md:rounded-[3rem] overflow-hidden shadow-xl bg-accent-pink p-2">
                        <img class="w-full h-full object-cover rounded-[1.5rem] md:rounded-[2.5rem]" 
                             alt="Belajar" 
                             src="https://images.unsplash.com/photo-1512820790803-83ca734da794?q=80&w=1000&auto=format&fit=crop"/>
                    </div>
                    <div class="aspect-square rounded-[2rem] md:rounded-[3rem] overflow-hidden shadow-2xl bg-primary flex flex-col items-center justify-center text-white p-4 md:p-6 text-center">
                        <span class="material-symbols-outlined text-3xl md:text-4xl mb-2">location_on</span>
                        <h5 class="font-bold text-base md:text-lg leading-tight">Bandung</h5>
                        <p class="text-[9px] md:text-[10px] opacity-60 uppercase tracking-tighter">Aktivitas Sekolah</p>
                    </div>
                </div>
            </div>

            {{-- Mobile Button (Mobile: 3rd) --}}
            <div class="flex lg:hidden flex-wrap justify-center gap-4 pt-4 mt-2 order-3 w-full max-w-xl mx-auto">
                <a href="{{ route('ppdb.index') }}" class="w-full sm:w-auto bg-primary hover:scale-105 text-white px-10 py-5 rounded-full text-lg font-bold transition-all shadow-2xl shadow-primary/30 inline-flex items-center justify-center">
                    Daftar Sekarang <span class="material-symbols-outlined align-middle ml-2">chevron_right</span>
                </a>
            </div>
            
        </div>
    </div>

    {{-- Info Bar --}}
    <div class="max-w-4xl mx-auto px-4 mt-16 md:mt-20 relative z-20" data-home-animate="zoom-in">
        <div class="bg-white rounded-[2rem] shadow-xl p-6 md:p-8 grid grid-cols-1 sm:grid-cols-2 gap-6 md:gap-8 border border-slate-100">
            <div class="flex items-center gap-4">
                <div class="size-12 md:size-14 bg-accent-blue rounded-2xl flex items-center justify-center text-primary shrink-0">
                    <span class="material-symbols-outlined">mail</span>
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] font-bold text-slate-400 uppercase">Email</p>
                    <p class="font-bold text-slate-800 text-sm md:text-base truncate">info@tkpgrihb1.sch.id</p>
                </div>
            </div>
            <div class="flex items-center gap-4 border-t sm:border-t-0 sm:border-l border-slate-100 pt-6 sm:pt-0 sm:pl-8">
                <div class="size-12 md:size-14 bg-accent-pink rounded-2xl flex items-center justify-center text-cta-pink shrink-0">
                    <span class="material-symbols-outlined">call</span>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase">Telepon</p>
                    <p class="font-bold text-slate-800 text-sm md:text-base">+62-812-3456-7890</p>
                </div>
            </div>
        </div>
    </div>
</header>

{{-- 2. Tentang Sekolah (About Us) --}}
<section class="py-20 md:py-32 bg-white" data-home-animate="fade-up">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:grid lg:grid-cols-2 gap-12 md:gap-20 items-center">
            {{-- Photo --}}
            <div class="relative w-full px-4 sm:px-0 order-1">
                <div class="blob-bg bg-accent-yellow absolute inset-0 -rotate-3 md:-rotate-6"></div>
                <img class="relative z-10 w-full rounded-2xl shadow-lg max-h-[500px] object-cover" 
                     alt="Guru dan siswa" 
                     src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?q=80&w=1000&auto=format&fit=crop"/>
            </div>

            {{-- Text --}}
            <div class="space-y-6 md:space-y-8 text-center lg:text-left px-4 sm:px-0 order-2">
                <div>
                    <p class="text-sm font-bold text-primary tracking-widest uppercase mb-4">Tentang Kami</p>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 leading-tight">Komitmen Untuk Masa Depan Anak Anda</h2>
                </div>
                <p class="text-lg md:text-xl text-slate-500 leading-relaxed">
                    TK PGRI Harapan Bangsa 1 Bandung berkomitmen untuk membentuk anak yang cerdas, mandiri, dan berbudi pekerti luhur melalui metode belajar sambil bermain dalam lingkungan yang inklusif, aman, dan religius.
                </p>
                <div class="space-y-4 text-left max-w-md mx-auto lg:mx-0">
                    <div class="flex items-start gap-4">
                        <div class="size-6 rounded-full bg-accent-green flex items-center justify-center text-primary mt-1 shrink-0">
                            <span class="material-symbols-outlined text-sm">check</span>
                        </div>
                        <p class="font-medium text-slate-700">Lingkungan Belajar yang Aman &amp; Nyaman</p>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="size-6 rounded-full bg-accent-blue flex items-center justify-center text-primary mt-1 shrink-0">
                            <span class="material-symbols-outlined text-sm">check</span>
                        </div>
                        <p class="font-medium text-slate-700">Pendidik Berpengalaman &amp; Tersertifikasi</p>
                    </div>
                </div>
                <div class="flex justify-center lg:justify-start">
                    <a href="{{ route('profil') }}" class="text-primary font-bold flex items-center gap-2 group text-lg md:text-base">
                        Baca Selengkapnya 
                        <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 3. Keunggulan Sekolah (Advantages) --}}
<section class="py-20 md:py-32 bg-slate-50" data-home-animate="fade-up">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 md:mb-20">
            <p class="text-xs font-bold text-primary tracking-widest uppercase mb-4">Keunggulan Pendidikan</p>
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900">Keunggulan Sekolah Kami</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8" data-home-stagger>
            <div class="bg-accent-yellow p-8 md:p-10 rounded-[2rem] md:rounded-[2.5rem] shadow-sm hover:shadow-xl transition-all group flex flex-col items-center text-center">
                <div class="mb-6 md:mb-8">
                    <h3 class="text-6xl md:text-8xl font-black text-slate-900/10 leading-none">AB</h3>
                </div>
                <h4 class="text-xl md:text-2xl font-bold text-slate-900 mb-4">Berbasis Bermain</h4>
                <p class="text-slate-600 text-sm md:text-base">Mendorong eksplorasi melalui aktivitas yang menyenangkan bagi perkembangan kognitif anak.</p>
            </div>
            
            <div class="bg-accent-pink p-8 md:p-10 rounded-[2rem] md:rounded-[2.5rem] shadow-sm hover:shadow-xl transition-all group flex flex-col items-center text-center">
                <div class="mb-6 md:mb-8">
                    <h3 class="text-6xl md:text-8xl font-black text-slate-900/10 leading-none">BC</h3>
                </div>
                <h4 class="text-xl md:text-2xl font-bold text-slate-900 mb-4">Kurikulum Merdeka</h4>
                <p class="text-slate-600 text-sm md:text-base">Fokus pada kemandirian dan kreativitas anak usia dini sesuai minat dan bakatnya.</p>
            </div>

            <div class="sm:col-span-2 lg:col-span-1 bg-accent-purple p-8 md:p-10 rounded-[2rem] md:rounded-[2.5rem] shadow-sm hover:shadow-xl transition-all group flex flex-col items-center text-center">
                <div class="mb-6 md:mb-8">
                    <h3 class="text-6xl md:text-8xl font-black text-slate-900/10 leading-none">12</h3>
                </div>
                <h4 class="text-xl md:text-2xl font-bold text-slate-900 mb-4">Guru Profesional</h4>
                <p class="text-slate-600 text-sm md:text-base">Didampingi oleh tenaga pendidik yang berdedikasi tinggi dan berpengalaman.</p>
            </div>
        </div>

        <div class="flex justify-center mt-12 md:mt-16 px-4">
            <a href="{{ route('kurikulum') }}" class="w-full sm:w-auto bg-primary text-white px-10 py-5 rounded-full font-bold hover:scale-105 transition-all shadow-xl shadow-primary/20 inline-flex items-center justify-center">
                Lihat Semua Keunggulan
            </a>
        </div>
    </div>
</section>

{{-- 4. Kurikulum Unggulan (Curriculum) --}}
<section class="py-20 md:py-32 bg-white" data-home-animate="fade-up">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-accent-blue rounded-[2.5rem] md:rounded-[4rem] p-8 md:p-12 lg:p-20 flex flex-col lg:flex-row items-center gap-12 lg:gap-16 overflow-hidden relative">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-white/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-primary/5 rounded-full blur-3xl"></div>
            
            <div class="lg:w-1/2 relative w-full order-1 lg:order-2">
                <div class="bg-white/50 p-2 md:p-4 rounded-[2rem] md:rounded-[3rem] backdrop-blur-sm">
                    <img class="w-full h-64 md:h-96 object-cover rounded-[1.5rem] md:rounded-[2.5rem] shadow-lg" 
                         alt="Ilustrasi belajar" 
                         src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=1000&auto=format&fit=crop"/>
                </div>
            </div>

            <div class="lg:w-1/2 space-y-6 md:space-y-8 relative z-10 text-center lg:text-left w-full order-2 lg:order-1">
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-primary leading-tight">Kurikulum Unggulan Kami</h2>
                <p class="text-lg md:text-xl text-slate-600 leading-relaxed">
                    Kami mengadaptasi Kurikulum Merdeka yang disesuaikan dengan kebutuhan tumbuh kembang anak usia dini, fokus pada kemandirian dan eksplorasi.
                </p>
                <div class="flex flex-col gap-4 text-left">
                    <div class="flex items-center gap-4 bg-white/50 p-4 rounded-2xl border border-white">
                        <span class="material-symbols-outlined text-primary shrink-0">verified</span>
                        <span class="font-bold text-slate-700 text-sm md:text-base">Penguatan Karakter &amp; Moral Agama</span>
                    </div>
                    <div class="flex items-center gap-4 bg-white/50 p-4 rounded-2xl border border-white">
                        <span class="material-symbols-outlined text-primary shrink-0">lightbulb</span>
                        <span class="font-bold text-slate-700 text-sm md:text-base">Pembelajaran Kreatif &amp; Berbasis Proyek</span>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('kurikulum') }}" class="w-full sm:w-auto bg-primary text-white px-8 py-4 rounded-full font-bold shadow-lg text-center inline-block">Detail Kurikulum</a>
                    <a href="{{ route('home') }}#bukutamu-section" class="w-full sm:w-auto bg-white text-primary border border-primary/10 px-8 py-4 rounded-full font-bold shadow-sm text-center inline-block">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 5. Galeri --}}
@if($galeris && $galeris->count() > 0)
<section class="py-20 md:py-32" data-home-animate="fade-up">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-10 md:mb-16 text-center lg:text-left px-4">
            <p class="text-xs font-bold text-primary tracking-widest uppercase mb-4">Informasi Visual</p>
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900">Galeri Kegiatan</h2>
        </div>
        <div class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar gap-4 md:grid md:grid-cols-4 md:h-[600px] px-4 md:px-0" data-home-stagger>
            @foreach($galeris->take(4) as $key => $galeri)
                @if($key == 0)
                <div class="min-w-[80%] sm:min-w-[60%] md:min-w-0 md:col-span-1 md:row-span-2 snap-center aspect-[4/5] md:aspect-auto shrink-0 group relative overflow-hidden rounded-3xl">
                    <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="{{ $galeri->judul }}" src="{{ $galeri->thumbnail_url }}"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-6">
                        <p class="text-white font-bold opacity-0 group-hover:opacity-100 transition-opacity">{{ $galeri->judul }}</p>
                    </div>
                </div>
                @elseif($key == 1)
                <div class="min-w-[80%] sm:min-w-[60%] md:min-w-0 md:col-span-1 md:row-span-1 bg-accent-yellow rounded-3xl p-6 flex flex-col justify-end min-h-[150px] snap-center shrink-0">
                    <p class="font-bold text-slate-400 text-xs">Momen Belajar</p>
                    <h5 class="font-bold text-slate-800 text-lg">Ceria &amp; Aktif</h5>
                </div>
                <div class="min-w-[80%] sm:min-w-[60%] md:min-w-0 md:col-span-1 md:row-span-2 bg-accent-blue rounded-3xl overflow-hidden p-2 snap-center aspect-[4/5] md:aspect-auto shrink-0 group relative">
                    <img class="w-full h-full object-cover rounded-2xl group-hover:scale-110 transition-transform duration-500" alt="{{ $galeri->judul }}" src="{{ $galeri->thumbnail_url }}"/>
                </div>
                @elseif($key == 2)
                <div class="hidden md:block md:col-span-1 md:row-span-1 group relative overflow-hidden rounded-3xl">
                    <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="{{ $galeri->judul }}" src="{{ $galeri->thumbnail_url }}"/>
                </div>
                @elseif($key == 3)
                <div class="hidden md:block md:col-span-1 md:row-span-1 group relative overflow-hidden rounded-3xl">
                    <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="{{ $galeri->judul }}" src="{{ $galeri->thumbnail_url }}"/>
                </div>
                @endif
            @endforeach
            <div class="min-w-[80%] sm:min-w-[60%] md:min-w-0 md:col-span-1 md:row-span-1 bg-slate-100 rounded-3xl flex items-center justify-center p-8 min-h-[150px] snap-center shrink-0 hover:bg-slate-200 transition-colors cursor-pointer" onclick="window.location='{{ route('galeri.index') }}'">
                <div class="text-center">
                    <span class="material-symbols-outlined text-4xl text-slate-400">arrow_forward</span>
                    <p class="font-bold text-slate-500 text-xs mt-2 uppercase">Buka Galeri</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- 6. Testimoni (Testimonials) --}}
@if($testimonis && $testimonis->count() > 0)
<section class="py-20 md:py-32 bg-accent-purple/30 overflow-hidden" data-home-animate="fade-up">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 md:mb-16">
            <p class="text-xs font-bold text-primary tracking-widest uppercase mb-4">Apa Kata Mereka?</p>
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900">Testimoni Orang Tua</h2>
        </div>

        <div class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar gap-6 md:grid md:grid-cols-3 px-4 md:px-0 pb-8" data-home-stagger>
            @php $colors = ['bg-accent-yellow', 'bg-accent-pink', 'bg-accent-green']; @endphp
            @foreach($testimonis->take(3) as $index => $testimoni)
                @php $colorClass = $colors[$index % 3]; @endphp
                <div class="min-w-[85%] sm:min-w-[60%] md:min-w-0 bg-white p-8 rounded-[2.5rem] shadow-xl border-t-8 border-{{ str_replace('bg-accent-', 'accent-', $colorClass) }} relative snap-center shrink-0">
                    <div class="absolute -top-6 left-8 size-12 {{ $colorClass }} rounded-full flex items-center justify-center {{ $index % 2 == 1 ? 'text-cta-pink' : 'text-primary' }}">
                        <span class="material-symbols-outlined">format_quote</span>
                    </div>
                    <p class="text-slate-600 italic mb-6 leading-relaxed">"{{ $testimoni->isi }}"</p>
                    <div class="flex items-center gap-4">
                        @if($testimoni->foto)
                            <img src="{{ asset('storage/' . $testimoni->foto) }}" alt="{{ $testimoni->nama }}" class="size-12 rounded-full object-cover bg-slate-200">
                        @else
                            <div class="size-12 rounded-full bg-slate-200 flex items-center justify-center text-slate-400 font-bold">
                                {{ substr($testimoni->nama, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h5 class="font-bold text-slate-900">{{ $testimoni->nama }}</h5>
                            <p class="text-[10px] text-slate-400 uppercase font-bold">{{ $testimoni->jabatan ?? 'Orang Tua' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- 7. Berita Sekolah --}}
<section class="py-20 md:py-32 bg-slate-50 overflow-hidden" data-home-animate="fade-up">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-10 md:mb-16 text-center lg:text-left px-4">
            <p class="text-xs font-bold text-primary tracking-widest uppercase mb-4">Informasi Terkini</p>
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900">Berita Sekolah</h2>
        </div>
        
        <div class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar gap-6 md:grid md:grid-cols-3 px-4 md:px-0 pb-8" data-home-stagger>
            @forelse($beritas ?? [] as $berita)
                <article class="min-w-[85%] sm:min-w-[60%] md:min-w-0 bg-white rounded-[2rem] shadow-sm overflow-hidden hover:shadow-xl transition-all border border-slate-100 group snap-center shrink-0 flex flex-col">
                    <div class="h-56 md:h-64 overflow-hidden relative">
                        @if($berita->gambar)
                            <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="{{ $berita->judul }}" src="{{ asset('storage/' . $berita->gambar) }}"/>
                        @else
                            <div class="w-full h-full bg-slate-200 flex items-center justify-center group-hover:scale-110 transition-transform duration-500">
                                <span class="material-symbols-outlined text-5xl text-slate-400">newsmode</span>
                            </div>
                        @endif
                    </div>
                    <div class="p-6 md:p-8 flex flex-col flex-1">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="px-3 py-1 rounded-full bg-accent-blue text-primary text-[10px] font-bold uppercase">Berita</span>
                            <span class="text-[10px] text-slate-400 font-medium">{{ \Carbon\Carbon::parse($berita->tanggal_publish)->translatedFormat('d M Y') }}</span>
                        </div>
                        <h4 class="text-lg md:text-xl font-bold mb-4 leading-tight">{{ $berita->judul }}</h4>
                        <p class="text-slate-500 text-sm mb-6 leading-relaxed line-clamp-2 flex-1">{{ strip_tags($berita->isi_berita) }}</p>
                        <a href="{{ route('berita.show', $berita->slug) }}" class="text-primary text-sm font-bold flex items-center gap-1 mt-auto">
                            Selengkapnya <span class="material-symbols-outlined text-sm transition-transform group-hover:translate-x-1">arrow_forward</span>
                        </a>
                    </div>
                </article>
            @empty
                <div class="w-full min-w-full md:min-w-0 md:col-span-3 flex flex-col items-center justify-center text-center py-12">
                    <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-3xl">inbox</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-700 mb-2">Belum ada berita</h3>
                    <p class="text-slate-500 text-sm">Berita terbaru sekolah akan tampil di sini.</p>
                </div>
            @endforelse
        </div>
        
        @if($beritas && $beritas->count() > 0)
        <div class="text-center mt-4">
            <a href="{{ route('berita.index') }}" class="inline-flex items-center gap-2 text-primary font-bold hover:text-slate-900 transition-colors">
                Lihat Semua Berita <span class="material-symbols-outlined">arrow_forward</span>
            </a>
        </div>
        @endif
    </div>
</section>

{{-- 8. PPDB (Registration Cta) --}}
<section class="py-20 md:py-32 bg-white" data-home-animate="zoom-in">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-accent-yellow rounded-[2.5rem] md:rounded-[4rem] p-8 md:p-16 lg:p-20 text-center relative overflow-hidden">
            <div class="absolute top-0 right-0 w-48 h-48 bg-white/30 rounded-full -mr-24 -mt-24 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/30 rounded-full -ml-24 -mb-24 blur-3xl"></div>
            
            <div class="relative z-10 max-w-3xl mx-auto space-y-6 md:space-y-8">
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 leading-tight">Penerimaan Peserta Didik Baru</h2>
                <p class="text-lg md:text-xl text-slate-700">
                    Ayo berikan awal pendidikan terbaik bagi putra-putri anda bersama kami. Proses pendaftaran mudah melalui portal online kami.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center pt-4">
                    <a href="{{ route('ppdb.index') }}" class="w-full sm:w-auto inline-flex justify-center items-center bg-primary text-white px-10 md:px-12 py-5 rounded-full text-lg md:text-xl font-bold shadow-2xl hover:scale-105 transition-all">Daftar Sekarang</a>
                    <a href="{{ route('ppdb.index') }}" class="w-full sm:w-auto inline-flex justify-center items-center bg-white text-primary border border-primary/10 px-10 md:px-12 py-5 rounded-full text-lg md:text-xl font-bold hover:bg-slate-50 transition-all">Syarat Pendaftaran</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 9. Hubungi Kami & Maps --}}
<section class="py-20 md:py-24 bg-white" data-home-animate="fade-up">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-start" data-home-stagger>
            <div class="space-y-10 md:space-y-12">
                <div class="text-center lg:text-left">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900">Hubungi Kami</h2>
                    <p class="text-slate-500 mt-4 text-base md:text-lg">Kami siap menjawab pertanyaan anda seputar pendidikan anak.</p>
                </div>
                
                <div class="space-y-8 max-w-xl mx-auto lg:mx-0">
                    <div class="flex items-start gap-6">
                        <div class="size-12 md:size-14 bg-accent-blue rounded-2xl flex items-center justify-center text-primary shrink-0 shadow-sm">
                            <span class="material-symbols-outlined text-xl md:text-2xl">location_on</span>
                        </div>
                        <div>
                            <h5 class="font-bold text-slate-900 text-lg">Alamat</h5>
                            <p class="text-slate-600 text-sm md:text-base leading-relaxed">Jl. Harapan No. 123, Kel. Sukamaju, Kec. Cicendo, Kota Bandung, Jawa Barat</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-6">
                        <div class="size-12 md:size-14 bg-accent-green rounded-2xl flex items-center justify-center text-primary shrink-0 shadow-sm">
                            <span class="material-symbols-outlined text-xl md:text-2xl">call</span>
                        </div>
                        <div>
                            <h5 class="font-bold text-slate-900 text-lg">Telepon</h5>
                            <p class="text-slate-600 text-sm md:text-base leading-relaxed">(022) 123-4567 | <br class="sm:hidden"/>WhatsApp: 0812-3456-7890</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-6">
                        <div class="size-12 md:size-14 bg-accent-yellow rounded-2xl flex items-center justify-center text-primary shrink-0 shadow-sm">
                            <span class="material-symbols-outlined text-xl md:text-2xl">mail</span>
                        </div>
                        <div>
                            <h5 class="font-bold text-slate-900 text-lg">Email</h5>
                            <p class="text-slate-600 text-sm md:text-base leading-relaxed">info@tkpgrihb1.sch.id</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-slate-100 rounded-[2rem] md:rounded-[3rem] overflow-hidden h-[400px] md:h-[500px] shadow-2xl relative border-4 md:border-8 border-white group">
                <div class="absolute left-4 right-4 top-4 z-10 rounded-2xl bg-white/92 backdrop-blur-md border border-white shadow-lg px-5 py-4">
                    <p class="text-[10px] font-bold tracking-[0.3em] uppercase text-primary">Lokasi Sekolah</p>
                    <h3 class="mt-2 text-lg md:text-xl font-extrabold text-slate-900">TK PGRI Harapan Bangsa 1</h3>
                    <p class="mt-1 text-sm text-slate-500">Bandung, Jawa Barat</p>
                </div>
                <div class="w-full h-full relative">
                    <iframe class="absolute inset-0 w-full h-full" src="https://maps.google.com/maps?q=-6.930155090671853,107.6494546294907&z=17&hl=id&output=embed" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 10. Buku Tamu (Guestbook) --}}
<section class="py-20 md:py-32 bg-slate-50" id="bukutamu-section" data-home-animate="fade-up">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-[2rem] md:rounded-[3rem] shadow-2xl p-8 md:p-12 lg:p-16 relative">
            <div class="size-14 md:size-16 bg-accent-pink rounded-2xl flex items-center justify-center text-cta-pink absolute -top-7 md:-top-8 left-1/2 -translate-x-1/2 shadow-xl">
                <span class="material-symbols-outlined text-3xl">forum</span>
            </div>
            
            <div class="text-center mb-10 md:mb-12 mt-4">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4">Buku Tamu</h2>
                <p class="text-slate-500 text-sm md:text-base">Bagikan kesan dan pesan Anda setelah berkunjung ke TK PGRI Harapan Bangsa 1</p>
            </div>

            @if(session('success'))
            <div class="mb-6 bg-green-50/50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl text-sm flex items-start gap-4" role="alert">
                <span class="material-symbols-outlined text-green-500">check_circle</span>
                <p>{{ session('success') }}</p>
            </div>
            @endif

            <form action="{{ route('buku-tamu.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] md:text-xs font-bold text-slate-400 uppercase ml-4">Nama Lengkap *</label>
                        <input name="nama" value="{{ old('nama') }}" required class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-primary/20 text-slate-800 text-base @error('nama') ring-red-500 @enderror" placeholder="Masukkan nama Anda" type="text"/>
                        @error('nama')<p class="text-xs text-red-500 ml-4">{{ $message }}</p>@enderror
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] md:text-xs font-bold text-slate-400 uppercase ml-4">Email</label>
                        <input name="email" value="{{ old('email') }}" class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-primary/20 text-slate-800 text-base @error('email') ring-red-500 @enderror" placeholder="email@anda.com" type="email"/>
                        @error('email')<p class="text-xs text-red-500 ml-4">{{ $message }}</p>@enderror
                    </div>
                </div>
                
                <div class="space-y-2">
                    <label class="text-[10px] md:text-xs font-bold text-slate-400 uppercase ml-4">Status *</label>
                    <select name="status" required class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-primary/20 text-slate-800 appearance-none text-base @error('status') ring-red-500 @enderror">
                        <option value="parent" {{ old('status') == 'parent' ? 'selected' : '' }}>Orang Tua Calon Siswa</option>
                        <option value="alumni" {{ old('status') == 'alumni' ? 'selected' : '' }}>Alumni</option>
                        <option value="visitor" {{ old('status') == 'visitor' ? 'selected' : '' }}>Masyarakat Umum / Visitor</option>
                    </select>
                    @error('status')<p class="text-xs text-red-500 ml-4">{{ $message }}</p>@enderror
                </div>
                
                <div class="space-y-2">
                    <label class="text-[10px] md:text-xs font-bold text-slate-400 uppercase ml-4">Pesan/Kesan *</label>
                    <textarea name="pesan_kesan" required class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-primary/20 text-slate-800 h-32 text-base @error('pesan_kesan') ring-red-500 @enderror" placeholder="Tuliskan pesan atau kesan Anda di sini...">{{ old('pesan_kesan') }}</textarea>
                    @error('pesan_kesan')<p class="text-xs text-red-500 ml-4">{{ $message }}</p>@enderror
                </div>
                
                <button class="w-full bg-cta-pink text-white py-5 rounded-2xl font-bold text-lg shadow-xl shadow-cta-pink/20 hover:opacity-90 transition-all flex items-center justify-center gap-2" type="submit">
                    <span class="material-symbols-outlined">send</span> Kirim Pesan
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
