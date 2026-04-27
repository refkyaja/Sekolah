@extends('layouts.home')

@section('title', 'TK PGRI Harapan Bangsa 1 - Bandung')

@section('content')
{{-- 1. Hero Section --}}
<header class="relative hero-gradient pt-8 pb-8 md:pt-24 md:pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid lg:grid-cols-2 gap-8 lg:gap-16 items-center">
            
            {{-- Text Content (Mobile: 1st, Desktop: 1st) --}}
            <div class="space-y-6 md:space-y-8 text-center lg:text-left order-1 lg:order-1" data-home-animate="fade-right">
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
                             src="{{ asset('images/homepage.jpeg') }}"/>
                    </div>
                    <div class="aspect-square rounded-[2rem] md:rounded-[3rem] overflow-hidden shadow-xl bg-accent-green p-2">
                        <img class="w-full h-full object-cover rounded-[1.5rem] md:rounded-[2.5rem]" 
                             alt="Aktivitas Siswa" 
                             src="{{ asset('images/homepage-2.jpeg') }}"/>
                    </div>
                </div>
                <div class="space-y-3 md:space-y-4 pt-8 md:pt-12">
                    <div class="aspect-square rounded-[2rem] md:rounded-[3rem] overflow-hidden shadow-xl bg-accent-pink p-2">
                        <img class="w-full h-full object-cover rounded-[1.5rem] md:rounded-[2.5rem]" 
                             alt="Belajar" 
                             src="{{ asset('images/homepage-1.jpeg') }}"/>
                    </div>
                    <div class="aspect-square rounded-[2rem] md:rounded-[3rem] overflow-hidden shadow-2xl bg-primary p-2">
                         <img class="w-full h-full object-cover rounded-[1.5rem] md:rounded-[2.5rem]" 
                             alt="Fasilitas Sekolah" 
                             src="{{ asset('images/homepage-3.jpeg') }}"/>
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
                    <p class="font-bold text-slate-800 text-sm md:text-base truncate">tkpgriharapanbangsa1@gmail.com</p>
                </div>
            </div>
            <div class="flex items-center gap-4 border-t sm:border-t-0 sm:border-l border-slate-100 pt-6 sm:pt-0 sm:pl-8">
                <div class="size-12 md:size-14 bg-accent-pink rounded-2xl flex items-center justify-center text-cta-pink shrink-0">
                    <span class="material-symbols-outlined">call</span>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase">Telepon</p>
                    <p class="font-bold text-slate-800 text-sm md:text-base">0821-3030-3614</p>
                </div>
            </div>
        </div>
    </div>
</header>

{{-- 2. Tentang Sekolah (About Us) --}}
<section class="pt-10 pb-20 md:pt-16 md:pb-32 bg-white" data-home-animate="fade-up">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:grid lg:grid-cols-2 gap-12 md:gap-20 items-center">
            {{-- Photo --}}
            <div class="relative w-full px-4 sm:px-0 order-1">
                <div class="blob-bg bg-accent-yellow absolute inset-0 -rotate-3 md:-rotate-6"></div>
                <img class="relative z-10 w-full rounded-2xl shadow-lg max-h-[500px] object-cover" 
                     alt="Guru sedang mengajar sambil bermain" 
                     src="{{ asset('images/home-1.jpeg') }}"/>
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
                        Lihat Profil Sekolah
                        <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 3. Keunggulan Sekolah (Advantages) --}}
<section class="py-12 md:py-20 bg-slate-50" data-home-animate="fade-up">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 md:mb-20">
            <p class="text-xs font-bold text-primary tracking-widest uppercase mb-4">Keunggulan Pendidikan</p>
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900">Keunggulan Sekolah Kami</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8" data-home-stagger>
            <div class="bg-accent-yellow p-8 md:p-10 rounded-[2rem] md:rounded-[2.5rem] shadow-sm hover:shadow-xl transition-all group flex flex-col items-center text-center">
                <div class="mb-6 md:mb-8 flex justify-center">
                    <span class="material-symbols-outlined text-[5rem] md:text-[6.5rem] text-slate-900/10 leading-none">extension</span>
                </div>
                <h4 class="text-xl md:text-2xl font-bold text-slate-900 mb-4">Berbasis Bermain</h4>
                <p class="text-slate-600 text-sm md:text-base">Mendorong eksplorasi melalui aktivitas yang menyenangkan bagi perkembangan kognitif anak.</p>
            </div>
            
            <div class="bg-accent-pink p-8 md:p-10 rounded-[2rem] md:rounded-[2.5rem] shadow-sm hover:shadow-xl transition-all group flex flex-col items-center text-center">
                <div class="mb-6 md:mb-8 flex justify-center">
                    <img src="{{ asset('images/kurikulum-merdeka.png') }}" alt="Logo Kurikulum Merdeka" class="w-24 md:w-32 h-auto object-contain mix-blend-multiply opacity-20">
                </div>
                <h4 class="text-xl md:text-2xl font-bold text-slate-900 mb-4">Kurikulum Merdeka</h4>
                <p class="text-slate-600 text-sm md:text-base">Fokus pada kemandirian dan kreativitas anak usia dini sesuai minat dan bakatnya.</p>
            </div>

            <div class="sm:col-span-2 lg:col-span-1 bg-accent-purple p-8 md:p-10 rounded-[2rem] md:rounded-[2.5rem] shadow-sm hover:shadow-xl transition-all group flex flex-col items-center text-center">
                <div class="mb-6 md:mb-8 flex justify-center">
                    <span class="material-symbols-outlined text-[5rem] md:text-[6.5rem] text-slate-900/10 leading-none">workspace_premium</span>
                </div>
                <h4 class="text-xl md:text-2xl font-bold text-slate-900 mb-4">Guru Profesional</h4>
                <p class="text-slate-600 text-sm md:text-base">Didampingi oleh tenaga pendidik yang berdedikasi tinggi dan berpengalaman.</p>
            </div>
        </div>

    </div>
</section>

{{-- 4. Kurikulum Unggulan (Curriculum) --}}
<section class="py-12 md:py-20 bg-white" data-home-animate="fade-up">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-accent-blue rounded-[2.5rem] md:rounded-[4rem] p-8 md:p-12 lg:p-20 flex flex-col lg:flex-row items-center gap-12 lg:gap-16 overflow-hidden relative">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-white/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-primary/5 rounded-full blur-3xl"></div>
            
            <div class="lg:w-1/2 relative w-full order-1 lg:order-2">
                <div class="bg-white/50 p-2 md:p-4 rounded-[2rem] md:rounded-[3rem] backdrop-blur-sm">
                    <img class="w-full h-64 md:h-96 object-cover rounded-[1.5rem] md:rounded-[2.5rem] shadow-lg" 
                         alt="Aktivitas kreatif anak usia dini" 
                         src="{{ asset('images/home-2.jpeg') }}"/>
                </div>
            </div>

            <div class="lg:w-1/2 space-y-6 md:space-y-8 relative z-10 text-center lg:text-left w-full order-2 lg:order-1">
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-primary leading-tight">Kurikulum &amp; Layanan Prioritas</h2>
                <p class="text-lg md:text-xl text-slate-600 leading-relaxed">
                    Sekolah kami menerapkan Kurikulum Merdeka dan layanan terpadu PAUD Holistik Integratif (HIBER) yang berpusat pada anak untuk membentuk karakter cerdas dan berakhlak mulia.
                </p>
                <div class="flex flex-col gap-4 text-left">
                    <div class="flex items-center gap-4 bg-white/50 p-4 rounded-2xl border border-white">
                        <span class="material-symbols-outlined text-primary shrink-0">auto_awesome</span>
                        <span class="font-bold text-slate-700 text-sm md:text-base">Kurikulum Berpusat Pada Anak</span>
                    </div>
                    <div class="flex items-center gap-4 bg-white/50 p-4 rounded-2xl border border-white">
                        <span class="material-symbols-outlined text-primary shrink-0">foundation</span>
                        <span class="font-bold text-slate-700 text-sm md:text-base">Pendidikan Holistik Berbasis Karakter</span>
                    </div>
                    <div class="flex items-center gap-4 bg-white/50 p-4 rounded-2xl border border-white">
                        <span class="material-symbols-outlined text-primary shrink-0">family_restroom</span>
                        <span class="font-bold text-slate-700 text-sm md:text-base">Layanan Terpadu PAUD HIBER</span>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('kurikulum') }}" class="w-full sm:w-auto bg-primary text-white px-8 py-4 rounded-full font-bold shadow-lg text-center inline-block">Detail Kurikulum</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 5. Galeri --}}
<section class="pt-8 pb-16 md:pt-12 md:pb-24 bg-white" data-home-animate="fade-up">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-10 md:mb-16 text-center lg:text-left">
            <p class="text-xs font-bold text-primary tracking-widest uppercase mb-3">Momen Berharga</p>
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900">Eksplorasi Galeri Sekolah</h2>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-6" data-home-stagger>
            @foreach($galeris->take(4) as $key => $galeri)
                @if($key == 0)
                <div class="col-span-2 md:col-span-2 md:row-span-2 relative group overflow-hidden rounded-2xl md:rounded-[2.5rem] shadow-sm aspect-video md:aspect-auto">
                    <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $galeri->judul }}" src="{{ $galeri->thumbnail_url }}"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-all duration-500 flex items-end p-6 md:p-10">
                        <div>
                            <p class="text-white/70 text-[10px] md:text-xs font-bold uppercase tracking-widest mb-2">Kegiatan Terkini</p>
                            <h4 class="text-white font-bold text-lg md:text-2xl leading-tight">{{ $galeri->judul }}</h4>
                        </div>
                    </div>
                </div>
                @else
                <div class="col-span-1 relative group overflow-hidden rounded-xl md:rounded-3xl shadow-sm aspect-square">
                    <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $galeri->judul }}" src="{{ $galeri->thumbnail_url }}"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-all duration-500 flex items-end p-4 md:p-6">
                        <p class="text-white font-bold text-xs md:text-sm leading-tight">{{ $galeri->judul }}</p>
                    </div>
                </div>
                @endif
            @endforeach
            
            <a href="{{ route('galeri.index') }}" class="col-span-1 md:col-span-1 md:row-span-1 bg-slate-50 hover:bg-primary group rounded-xl md:rounded-3xl flex flex-col items-center justify-center p-4 transition-all duration-500 border border-slate-100 min-h-[120px] md:min-h-0">
                <div class="size-10 md:size-12 bg-white rounded-full flex items-center justify-center text-primary shadow-sm group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined">arrow_forward</span>
                </div>
                <p class="font-bold text-slate-500 group-hover:text-white text-[10px] md:text-xs mt-3 uppercase tracking-widest">Lihat Semua</p>
            </a>
        </div>
    </div>
</section>

{{-- 6. Testimoni (Testimonials) --}}
@if($testimonis && $testimonis->count() > 0)
<section class="py-10 md:py-16 bg-accent-purple/30 overflow-hidden" data-home-animate="fade-up">
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


{{-- 8. PPDB (Registration Cta) --}}
<section class="py-10 md:py-16 bg-white" data-home-animate="zoom-in">
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
<section class="py-10 md:py-16 bg-white" data-home-animate="fade-up">
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
                            <p class="text-slate-600 text-sm md:text-base leading-relaxed">3J9X+WF7 halaman sdn, Jl. Terusan PSM No.1, Sukapura, Kec. Kiaracondong, Kota Bandung, Jawa Barat 40285</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-6">
                        <div class="size-12 md:size-14 bg-accent-green rounded-2xl flex items-center justify-center text-primary shrink-0 shadow-sm">
                            <span class="material-symbols-outlined text-xl md:text-2xl">call</span>
                        </div>
                        <div>
                            <h5 class="font-bold text-slate-900 text-lg">Telepon</h5>
                            <p class="text-slate-600 text-sm md:text-base leading-relaxed">0821-3030-3614 | <br class="sm:hidden"/>WhatsApp: 0821-3030-3614</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-6">
                        <div class="size-12 md:size-14 bg-accent-yellow rounded-2xl flex items-center justify-center text-primary shrink-0 shadow-sm">
                            <span class="material-symbols-outlined text-xl md:text-2xl">mail</span>
                        </div>
                        <div>
                            <h5 class="font-bold text-slate-900 text-lg">Email</h5>
                            <p class="text-slate-600 text-sm md:text-base leading-relaxed">tkpgriharapanbangsa1@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-slate-100 rounded-[2rem] md:rounded-[3rem] overflow-hidden h-[400px] md:h-[500px] shadow-2xl relative border-4 md:border-8 border-white group">
                <div class="absolute top-3 left-3 w-[220px] md:w-[270px] z-10 bg-white shadow-xl p-2.5 md:p-4 flex flex-col gap-1 rounded-[2px] border border-slate-100">
                    <div class="flex justify-between items-start gap-3">
                        <div class="flex-1">
                            <h3 class="text-[11px] md:text-[15px] font-bold text-slate-900 leading-tight">TK PGRI HARAPAN BANGSA 1</h3>
                            <p class="text-[9px] md:text-[11px] text-slate-500 leading-relaxed mt-1">
                                3J9X+WF7 halaman sdn, Jl. Terusan PSM No.1, Sukapura, Kec. Kiaracondong, Kota Bandung, Jawa Barat 40285
                            </p>
                        </div>
                        <div class="flex gap-1 shrink-0">
                            {{-- Button Open --}}
                            <a href="https://maps.google.com/maps?q=-6.930155090671853,107.6494546294907" target="_blank" class="size-6 md:size-7 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center text-primary shadow-sm hover:bg-slate-100 transition-colors">
                                <span class="material-symbols-outlined text-[13px] md:text-[15px]">open_in_new</span>
                            </a>
                            {{-- Button Directions --}}
                            <a href="https://www.google.com/maps/dir//-6.930155090671853,107.6494546294907" target="_blank" class="size-6 md:size-7 rounded-full bg-primary flex items-center justify-center text-white shadow-md hover:opacity-90 transition-opacity">
                                <span class="material-symbols-outlined text-[14px] md:text-[16px]">directions</span>
                            </a>
                        </div>
                    </div>
                    <div class="mt-1.5 pt-1.5 border-t border-slate-100">
                        <p class="text-[9px] text-slate-400">Tidak ada ulasan</p>
                    </div>
                </div>

                <div class="w-full h-full relative">
                    <iframe class="absolute inset-0 w-full h-full" src="https://maps.google.com/maps?q=-6.930155090671853,107.6494546294907+(TK%20PGRI%20HARAPAN%20BANGSA%201)&z=17&hl=id&output=embed" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 10. Buku Tamu (Guestbook) --}}
<section class="py-10 md:py-16 bg-slate-50" id="bukutamu-section" data-home-animate="fade-up">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-[2rem] md:rounded-[3rem] shadow-2xl p-8 md:p-12 lg:p-16 relative">
            <div class="size-14 md:size-16 bg-accent-pink rounded-2xl flex items-center justify-center text-cta-pink absolute -top-7 md:-top-8 left-1/2 -translate-x-1/2 shadow-xl">
                <span class="material-symbols-outlined text-3xl">forum</span>
            </div>
            
            <div class="text-center mb-10 md:mb-12 mt-4">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4">Buku Tamu</h2>
                <p class="text-slate-500 text-sm md:text-base">Bagikan kesan dan pesan Anda setelah berkunjung ke TK PGRI Harapan Bangsa 1</p>
            </div>

            <form id="guestbookForm" action="{{ route('buku-tamu.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nama --}}
                    <div class="space-y-2">
                        <label class="text-[10px] md:text-xs font-bold text-slate-400 uppercase ml-4">Nama Lengkap *</label>
                        <input name="nama" value="{{ old('nama') }}" required class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-primary/20 text-slate-800 text-base shadow-sm" placeholder="Masukkan nama Anda" type="text"/>
                        <p class="error-nama error-text text-xs text-red-500 ml-4 hidden"></p>
                    </div>
                    {{-- Email --}}
                    <div class="space-y-2">
                        <label class="text-[10px] md:text-xs font-bold text-slate-400 uppercase ml-4">Email (Opsional)</label>
                        <input name="email" value="{{ old('email') }}" class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-primary/20 text-slate-800 text-base shadow-sm" placeholder="alamat@email.com" type="email"/>
                        <p class="error-email error-text text-xs text-red-500 ml-4 hidden"></p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- No HP/Kontak --}}
                    <div class="space-y-2">
                        <label class="text-[10px] md:text-xs font-bold text-slate-400 uppercase ml-4">No. HP / WhatsApp *</label>
                        <input name="telepon" value="{{ old('telepon') }}" required class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-primary/20 text-slate-800 text-base shadow-sm" placeholder="0821xxxx" type="tel"/>
                        <p class="error-telepon error-text text-xs text-red-500 ml-4 hidden"></p>
                    </div>
                    {{-- Jabatan --}}
                    <div class="space-y-2">
                        <label class="text-[10px] md:text-xs font-bold text-slate-400 uppercase ml-4">Jabatan *</label>
                        <input name="jabatan" value="{{ old('jabatan') }}" required class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-primary/20 text-slate-800 text-base shadow-sm" placeholder="Contoh: Orang Tua / Umum" type="text"/>
                        <p class="error-jabatan error-text text-xs text-red-500 ml-4 hidden"></p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Instansi --}}
                    <div class="space-y-2">
                        <label class="text-[10px] md:text-xs font-bold text-slate-400 uppercase ml-4">Instansi/Lembaga *</label>
                        <input name="instansi" value="{{ old('instansi') }}" required class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-primary/20 text-slate-800 text-base shadow-sm" placeholder="Nama asal instansi" type="text"/>
                        <p class="error-instansi error-text text-xs text-red-500 ml-4 hidden"></p>
                    </div>
                    {{-- Tanggal Datang --}}
                    <div class="space-y-2">
                        <label class="text-[10px] md:text-xs font-bold text-slate-400 uppercase ml-4">Tanggal Datang *</label>
                        <input name="tanggal_kunjungan" value="{{ old('tanggal_kunjungan', date('Y-m-d')) }}" required class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-primary/20 text-slate-800 text-base shadow-sm" type="date"/>
                        <p class="error-tanggal_kunjungan error-text text-xs text-red-500 ml-4 hidden"></p>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] md:text-xs font-bold text-slate-400 uppercase ml-4">Maksud dan Tujuan *</label>
                    <input name="tujuan_kunjungan" value="{{ old('tujuan_kunjungan') }}" required class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-primary/20 text-slate-800 text-base shadow-sm" placeholder="Contoh: Kunjungan Dinas / Urusan PPDB" type="text"/>
                    <p class="error-tujuan_kunjungan error-text text-xs text-red-500 ml-4 hidden"></p>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] md:text-xs font-bold text-slate-400 uppercase ml-4">Pesan dan Kesan *</label>
                    <textarea name="pesan_kesan" required rows="4" class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 focus:ring-2 focus:ring-primary/20 text-slate-800 text-base shadow-sm" placeholder="Tuliskan pengalaman atau masukan Anda...">{{ old('pesan_kesan') }}</textarea>
                    <p class="error-pesan_kesan error-text text-xs text-red-500 ml-4 hidden"></p>
                </div>

                <div class="flex flex-col md:flex-row items-center justify-between gap-6 pt-4">
                    <p class="text-xs text-slate-400 order-2 md:order-1">* Wajib diisi</p>
                    <button type="submit" id="btnSubmit" class="w-full md:w-auto px-12 py-5 bg-primary text-white rounded-full font-bold shadow-xl shadow-primary/20 hover:scale-105 transition-all text-base order-1 md:order-2 flex items-center justify-center gap-3 group">
                        <span class="btn-text">Kirim Sekarang</span>
                        <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">send</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('guestbookForm');
        const btnSubmit = document.getElementById('btnSubmit');
        const btnText = btnSubmit.querySelector('.btn-text');
        const btnIcon = btnSubmit.querySelector('.material-symbols-outlined');

        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            // Reset errors
            document.querySelectorAll('.error-text').forEach(el => el.classList.add('hidden'));
            
            // Loading state
            btnSubmit.disabled = true;
            btnText.textContent = 'Mengirim...';
            btnIcon.textContent = 'sync';
            btnIcon.classList.add('animate-spin');

            const formData = new FormData(form);

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    // Success
                    Swal.fire({
                        title: 'Berhasil Terkirim!',
                        text: 'Terima kasih telah berkunjung ke TK PGRI Harapan Bangsa 1',
                        icon: 'success',
                        timer: 5000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        background: '#ffffff',
                        color: '#1e293b',
                        iconColor: '#308ce8',
                        customClass: {
                            popup: 'rounded-3xl border-none shadow-2xl',
                            title: 'text-2xl font-bold pt-6',
                            timerProgressBar: 'bg-primary'
                        }
                    });
                    form.reset();
                } else if (response.status === 422) {
                    // Validation Errors
                    Object.keys(data.errors).forEach(key => {
                        const errorEl = document.querySelector(`.error-${key}`);
                        if (errorEl) {
                            errorEl.textContent = data.errors[key][0];
                            errorEl.classList.remove('hidden');
                        }
                    });
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Mohon periksa kembali formulir Anda.',
                        icon: 'error',
                        confirmButtonText: 'Oke',
                        confirmButtonColor: '#308ce8',
                        customClass: { popup: 'rounded-3xl' }
                    });
                } else {
                    throw new Error('Something went wrong');
                }
            } catch (error) {
                Swal.fire({
                    title: 'Kesalahan Sistem',
                    text: 'Gagal mengirim data. Silakan coba lagi nanti.',
                    icon: 'error',
                    confirmButtonText: 'Oke',
                    confirmButtonColor: '#308ce8',
                    customClass: { popup: 'rounded-3xl' }
                });
            } finally {
                btnSubmit.disabled = false;
                btnText.textContent = 'Kirim Sekarang';
                btnIcon.textContent = 'send';
                btnIcon.classList.remove('animate-spin');
            }
        });
    });
</script>
@endpush
@endsection
