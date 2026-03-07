@extends('layouts.frontend')

@section('content')
<!-- Hero Section -->
<section class="relative bg-brand-cream dark:bg-brand-dark overflow-hidden">
    <div class="container mx-auto px-4 lg:px-8 py-12 md:py-20 lg:py-24">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Left: Hero Image -->
            <div class="lg:col-span-7 rounded-3xl overflow-hidden shadow-2xl shadow-stone-200 dark:shadow-none">
                <img alt="Happy kids learning" class="w-full h-[350px] md:h-[700px] object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBV_slvI7W3TFIWXNXG-7djn61fjKlqaqo0RXhYc07noSC0qNDaaAy6Wt4X34Nfzz9YRNyaDn9U_FtQCPqsouvKiK6uhck_gPD7rAq9ggHA3mpPT0nPMhz8wdfASpYnp8h-Aomtwg-WNg33s3TsttBMrdov66IWy7ewJQujAqen0xMoJvL2fhje4oSauDLIzh_9_uWTdX5MVClK03MDYPHmD_Y54VY0HyDaQr5BdVaxU0wNcYEC2tEIaVy0_FjfzsU9WJR6gmNvtg"/>
            </div>
            <!-- Right: Hero Text -->
            <div class="lg:col-span-5 space-y-6 lg:pl-12">
                <h1 class="text-3xl md:text-5xl lg:text-6xl font-extrabold leading-tight text-brand-dark dark:text-white">
                    Selamat Datang di <span class="text-brand-primary">TK Harapan Bangsa 1</span>
                </h1>
                <p class="text-lg text-stone-600 dark:text-stone-400 font-medium leading-relaxed">
                    Tempat Anak Belajar, Bermain, dan Berkembang dengan Bahagia.
                </p>
                <div class="flex flex-wrap gap-4 pt-4">
                    @guest('siswa')
                    <button onclick="showLoginModal(event)" class="inline-block bg-brand-dark dark:bg-brand-primary text-white px-8 py-4 rounded-full font-bold uppercase tracking-widest text-xs hover:bg-brand-primary transition-all transform hover:-translate-y-1">
                        Daftar PPDB
                    </button>
                    @else
                    <a href="{{ route('spmb.pendaftaran') }}" class="inline-block bg-brand-dark dark:bg-brand-primary text-white px-8 py-4 rounded-full font-bold uppercase tracking-widest text-xs hover:bg-brand-primary transition-all transform hover:-translate-y-1">
                        Daftar PPDB
                    </a>
                    @endguest
                    <a href="#about-section" class="inline-block bg-white dark:bg-stone-800 text-brand-dark dark:text-stone-300 border-2 border-brand-dark dark:border-stone-700 px-8 py-4 rounded-full font-bold uppercase tracking-widest text-xs hover:bg-brand-dark hover:text-white transition-all transform hover:-translate-y-1">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Info Bar -->
<div class="max-w-4xl mx-auto -mt-8 relative z-20 px-6">
    <div class="bg-white dark:bg-brand-dark rounded-3xl shadow-2xl p-8 grid md:grid-cols-2 gap-8 divide-y md:divide-y-0 md:divide-x border border-stone-100 dark:border-stone-800">
        <div class="flex items-center gap-6 md:justify-center">
            <div class="w-14 h-14 bg-brand-soft dark:bg-stone-800 rounded-2xl flex items-center justify-center text-brand-primary">
                <span class="material-icons text-3xl">email</span>
            </div>
            <div>
                <h4 class="font-bold text-stone-500 text-[10px] uppercase tracking-wider">Email Us</h4>
                <p class="text-sm font-bold text-brand-dark dark:text-stone-300">trilingualkids@gmail.com</p>
            </div>
        </div>
        <div class="flex items-center gap-6 md:justify-center pt-6 md:pt-0">
            <div class="w-14 h-14 bg-brand-soft dark:bg-stone-800 rounded-2xl flex items-center justify-center text-brand-primary">
                <span class="material-icons text-3xl">phone</span>
            </div>
            <div>
                <h4 class="font-bold text-stone-500 text-[10px] uppercase tracking-wider">Call Now</h4>
                <p class="text-sm font-bold text-brand-dark dark:text-stone-300">+62-8172-0112</p>
            </div>
        </div>
    </div>
</div>

<!-- Wardrobe Essentials (Program Categories) -->
<section class="py-20 bg-white dark:bg-brand-dark">
    <div class="container mx-auto px-6">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-brand-dark dark:text-white uppercase">Learning Essentials</h2>
                <p class="text-stone-500 mt-2">Built to define their future code.</p>
            </div>
            <a class="text-xs font-bold uppercase tracking-widest border-b-2 border-brand-primary pb-1 text-brand-dark dark:text-stone-300" href="{{ route('akademik.kurikulum') }}">Explore All</a>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
            <!-- Category Item -->
            <a class="group block text-center space-y-3 md:space-y-4" href="#">
                <div class="bg-stone-100 dark:bg-stone-800 rounded-2xl md:rounded-3xl p-6 md:p-8 aspect-square flex items-center justify-center overflow-hidden transition-transform duration-500 group-hover:scale-[1.02]">
                    <img alt="Sneakers" class="w-full h-auto object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCilF439_4mFyq7vJWveUaxSU0flnoDiVBhpaQDvY773ZHQYiuWjJqHdpvquiKAkROYd6XEm-3ltnk5gM7bGxy5zBW2bjwg3qiXRRbim9unewLF-UIeaBZEvtIRsaTcyOVI1K_5s3Mip_UfhEGXNKP-sl-7Dol56TFKIIEQiGZn3FsCU4rC60i-EIa58IEm6sdaQs7Cyiwfz5HfcKIJQhZQHt4mfbjaktFfMeULGDrzenloHZESulvVvd2oVUyAF3_NovKUS48Qag"/>
                </div>
                <span class="block text-[10px] md:text-xs font-bold uppercase tracking-widest text-brand-dark dark:text-stone-300 group-hover:text-brand-primary transition-colors">Cognitive</span>
            </a>
            <!-- Category Item -->
            <a class="group block text-center space-y-3 md:space-y-4" href="#">
                <div class="bg-stone-100 dark:bg-stone-800 rounded-2xl md:rounded-3xl p-6 md:p-8 aspect-square flex items-center justify-center overflow-hidden transition-transform duration-500 group-hover:scale-[1.02]">
                    <img alt="T-Shirts" class="w-full h-auto object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDhwI2VqJFL3HG0oWNqk1LpiXE_qSs7gmxCkpJff46G1kNjYXQCtJ3fgOjC0WXhtK4wc9QzcozBv4PhpZjzfeXaES5a5B0Ry56BW8vH-74r9LpCdCqxtp0Irf0B1Ii29p50N0po0X2rZieU22arpWzHmBPjWrtSnPaT0UEXgEFn4V02ayRORcXWL1NQiSu4lwX9wLYmdw8VexANlUcYF2MQIN490M5V9dN3aWrbLtEnvVIE8TmVNiVjcmlRjOyZ5H9dlobu8DVKGA"/>
                </div>
                <span class="block text-[10px] md:text-xs font-bold uppercase tracking-widest text-brand-dark dark:text-stone-300 group-hover:text-brand-primary transition-colors">Linguistic</span>
            </a>
            <!-- Category Item -->
            <a class="group block text-center space-y-3 md:space-y-4" href="#">
                <div class="bg-stone-100 dark:bg-stone-800 rounded-2xl md:rounded-3xl p-6 md:p-8 aspect-square flex items-center justify-center overflow-hidden transition-transform duration-500 group-hover:scale-[1.02]">
                    <img alt="Loafers" class="w-full h-auto object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDVL2yIK6w-lIEAOXxPw9vCDHgSIplwVZNp3i52R0Cjb3iBK-2sUsmORWoypAcjxbU4RiSiVBu5c2F5C6fWH_n27HqQ1KfVlw1EuwYZ_81Zvt38l-8TLF2jrYH309KS8or6CAEgn8f7HA5VSOH11MzDcMbZFViXUzfH02KKnhKIFz_-O3SVMmozfRZL52mWZM-SSFkHU7BtvIbjOb5AFX2k9QSs27FOw4q4LzG9SOav_ewCj_-ObrXcHjpV2i6RPwFhNCVEtOB00A"/>
                </div>
                <span class="block text-[10px] md:text-xs font-bold uppercase tracking-widest text-brand-dark dark:text-stone-300 group-hover:text-brand-primary transition-colors">Emotional</span>
            </a>
            <!-- Category Item -->
            <a class="group block text-center space-y-3 md:space-y-4" href="#">
                <div class="bg-stone-100 dark:bg-stone-800 rounded-2xl md:rounded-3xl p-6 md:p-8 aspect-square flex items-center justify-center overflow-hidden transition-transform duration-500 group-hover:scale-[1.02]">
                    <img alt="Trousers" class="w-full h-auto object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCbDELOifEzjq9fo4snNWW-UH4TZhYm9-KEnJtOPBN3MUmTpvQitjIP0RdhfQ9Qaf_ynvhLSlmQmWy3pzmiTYLj689PHtYNPTmndjTR6AOAn1AGhZaxdAr0c3f-4vhFbTJlHwUUS-xwjL56ptBC8X7lblRqCnM21bdxdU_Zo-vrUZlCuKC2SwxGtXcMVh0YUiHyh_swIlgdG8vCYQlhrhl48ohdoGnVw0puBh9WGhqqvZH82lqRt_E6o8VQkuMrjSs9PDfWeqVTXA"/>
                </div>
                <span class="block text-[10px] md:text-xs font-bold uppercase tracking-widest text-brand-dark dark:text-stone-300 group-hover:text-brand-primary transition-colors">Creative</span>
            </a>
        </div>
    </div>
</section>

<!-- Everyday Luxury (Featured Programs Carousel) -->
<section class="py-20 overflow-hidden bg-brand-cream dark:bg-brand-dark">
    <div class="container mx-auto px-6 mb-10">
        <div class="flex justify-between items-end">
            <div>
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-brand-dark dark:text-white uppercase">Featured Programs</h2>
                <p class="text-stone-500 mt-2">Quality experiences, crafted for the energy of childhood.</p>
            </div>
            <div class="flex space-x-2">
                <button class="w-10 h-10 rounded-full border border-stone-200 flex items-center justify-center hover:bg-brand-primary hover:text-white transition-colors dark:border-stone-700 dark:text-stone-300">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                </button>
                <button class="w-10 h-10 rounded-full border border-stone-200 flex items-center justify-center hover:bg-brand-primary hover:text-white transition-colors dark:border-stone-700 dark:text-stone-300">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewbox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                </button>
            </div>
        </div>
    </div>
    <div class="container mx-auto px-6 overflow-x-auto no-scrollbar flex space-x-6 pb-8">
        @forelse($programs as $program)
        <div class="min-w-[280px] md:min-w-[340px] group">
            <div class="bg-stone-100 dark:bg-stone-800 rounded-3xl aspect-[4/5] p-8 mb-4 relative overflow-hidden">
                <span class="absolute top-4 left-4 text-[10px] font-bold uppercase bg-white dark:bg-brand-dark dark:text-stone-300 px-3 py-1 rounded-full">New Batch</span>
                @if($program->gambar)
                <img alt="{{ $program->nama }}" class="w-full h-full object-contain transition-transform duration-500 group-hover:scale-110" src="{{ asset('storage/' . $program->gambar) }}"/>
                @endif
            </div>
            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-1">Most Wanted</p>
            <h4 class="font-bold text-sm mb-1 uppercase tracking-tight text-brand-dark dark:text-white">{{ $program->nama }}</h4>
            <p class="text-xs text-stone-500 mb-2">{{ Str::limit($program->deskripsi, 50) }}</p>
            <div class="flex items-center space-x-2">
                <span class="text-sm font-extrabold text-brand-primary">Apply Now</span>
            </div>
        </div>
        @empty
        <!-- Static Fallback Items -->
        <div class="min-w-[280px] md:min-w-[340px] group">
            <div class="bg-stone-100 dark:bg-stone-800 rounded-3xl aspect-[4/5] p-8 mb-4 relative overflow-hidden">
                <span class="absolute top-4 left-4 text-[10px] font-bold uppercase bg-white dark:bg-brand-dark dark:text-stone-300 px-3 py-1 rounded-full text-brand-primary">Full Time</span>
                <div class="h-full flex items-center justify-center text-8xl font-black text-stone-200 dark:text-stone-700">BC</div>
            </div>
            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-1">English Nursery</p>
            <h4 class="font-bold text-sm mb-1 uppercase tracking-tight text-brand-dark dark:text-white">The Discovery Program</h4>
            <p class="text-xs text-stone-500 mb-2">Age 3 - 4 Years</p>
            <div class="flex items-center space-x-2">
                <span class="text-sm font-extrabold text-brand-primary">Apply now</span>
            </div>
        </div>
        @endforelse
    </div>
</section>

<!-- Brand Philosophy (About School) -->
<section id="about-section" class="py-12 md:py-24 bg-brand-soft dark:bg-stone-900">
    <div class="container mx-auto px-4 text-center mb-16">
         <h2 class="text-3xl md:text-4xl font-extrabold uppercase tracking-tight text-brand-dark dark:text-white">Tentang Sekolah</h2>
         <p class="text-stone-500 mt-2">Membentuk landasan masa depan sejak dini.</p>
    </div>
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center px-2">
            <div class="rounded-[1.5rem] md:rounded-[2.5rem] overflow-hidden shadow-xl hover-zoom">
                <img alt="Kids playing" class="w-full h-auto object-cover aspect-[4/5]" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC8U5Xu-2SD1ny_MGJ0tLYCTIa4B-dRpWEHX-inYs0jC1YGPo5fF_YxqsCiJE6ZTdXQ4cXKyfFjixWOjY8lR_NyrLWycVEDNCRzkYhXYMdxpqlyHV7XU_6tzPrZ716XJLYGMnr2o1UkN2wULnKW5TREhW6L0QbZAIePTxuiVVQzb6t0AAVqHg7SKPdxa3IdCLZus4pFwJaPSQIn2u1IvEM7pORcdvSNjbh-2GcAZX5sRGs370B9-L6O9rjU0FHVmCZ5vcHysKNurQ"/>
            </div>
            <div class="space-y-8 px-4 md:px-12">
                <div class="w-12 h-1 bg-brand-primary"></div>
                <h3 class="text-3xl md:text-4xl font-extrabold leading-tight text-brand-dark dark:text-white uppercase">TK Harapan Bangsa 1</h3>
                <p class="text-[10px] font-bold text-brand-primary uppercase tracking-[0.2em]">Berdiri Sejak Tahun 2010</p>
                <p class="text-stone-600 dark:text-stone-400 text-lg leading-relaxed">
                    TK Harapan Bangsa 1 adalah tempat di mana anak-anak dapat belajar, bermain, dan berkembang dengan bahagia. Kami fokus pada pembentukan karakter dan kreativitas anak melalui metode pembelajaran yang menyenangkan dan interaktif.
                </p>
                <p class="text-stone-600 dark:text-stone-400 text-lg leading-relaxed">
                    Dengan fasilitas yang lengkap dan tenaga pengajar profesional, kami berkomitmen untuk memberikan pendidikan terbaik bagi buah hati Anda di masa emas pertumbuhan mereka.
                </p>
                <a class="inline-block bg-white dark:bg-brand-dark text-brand-dark dark:text-stone-300 border-2 border-brand-dark dark:border-stone-700 px-10 py-3 rounded-full font-bold text-xs uppercase tracking-widest hover:bg-brand-dark hover:text-white dark:hover:bg-brand-primary transition-all" href="{{ route('profil.index') }}">
                    Lihat Visi & Misi Kami
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Multi-Story Grid -->
<section class="bg-white dark:bg-brand-dark py-20">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="relative rounded-[2rem] overflow-hidden aspect-[3/4] group">
                <img alt="Craft story" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBCke_ZUeeJa8_NgxtBkZ2ZbWLF0YnviN5RmscaUdx1hWRvC-9gFAtBwXoJWS8Xsbndndt54vEP34nwXgZeGaU1Qc_fjEn-1Vp0Z-sQTZNVnZJL9rAcQgp2UlI4uvC0w2J0wkSO3Gr0-lLmNLPSAOshbOwXWYG03xaIFliQfkBTNsihGDVJKcCg4H_CjI71Z15p5v7221CCoehxPh5VSjY_6YgP1LAmaLnrN4hEp6WfowM-rER0fan5l-d37Dz_lUNUzWiVHpnwSA"/>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex flex-col justify-end p-10 text-white">
                    <h3 class="text-2xl font-bold mb-4">Evolving through play.</h3>
                    <a class="text-xs font-bold uppercase tracking-widest border-b border-white self-start pb-1" href="{{ route('berita.index') }}">Read more</a>
                </div>
            </div>
            <div class="relative rounded-[2rem] overflow-hidden aspect-[3/4] group">
                <img alt="Process story" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCnjOajl1VEZu7ji4RPUH_JnhsyWLEyDRPy0baRpAHixRFS6tKOCgmu6_HnaBxAr_mYKAbKIMMcqjd52hG1XtmWXaacpVytx_wSr_Hdi2tMTc03xOTqNM8c90EkARpJYzZ4QlsosLZXuGVtVWmkpL-HrsW3XcQDGiEZ0y5kfsBhBa6dB-cveK--OiYdgdvmXDNE8214r5wo8mBBN2WT9BddrcjX2A7DbhR0kv318VNg-Cs4PDLq_FK9Ca7FbOr6FQmWCe9prg__gQ"/>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex flex-col justify-end p-10 text-white">
                    <h3 class="text-2xl font-bold mb-4">We do it with grace.</h3>
                    <a class="text-xs font-bold uppercase tracking-widest border-b border-white self-start pb-1" href="{{ route('berita.index') }}">Read more</a>
                </div>
            </div>
            <div class="relative rounded-[2rem] overflow-hidden aspect-[3/4] group">
                <img alt="Lifestyle story" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCm_rGCj2LPrgw0PJONI4bAFVI5JewP-DyHeN6TFbY27a_mm6bTGF8L07qbI3bJ6zKTEPuhGNAFw37oCpA_XcqBFQ9gYvxCkaK_1pfozy5Y4aeHjXQpJu4aehsqlg4oLAAR3CicrNxDBsMtFNKKB07xvla5jA4TGKzyri4fE_T5yuogHNLYtq82TKzt0zaGEdCSp8QX6Pa_j9xmuqENDZtSL2yV3P6BcYxzfL9OMdDHX7kZ4ZuFGJK42BbIvUH-KvB4c3VfyUdoKw"/>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex flex-col justify-end p-10 text-white">
                    <h3 class="text-2xl font-bold mb-4">Forever play time.</h3>
                    <a class="text-xs font-bold uppercase tracking-widest border-b border-white self-start pb-1" href="{{ route('berita.index') }}">Read more</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials (Our Favorites Style) -->
<section class="py-24 bg-brand-cream dark:bg-stone-900/50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-extrabold tracking-tight mb-12 text-brand-dark dark:text-white uppercase">Parent Favorites</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($testimonis as $testimoni)
            <!-- Favorite Item (Testimonial Card) -->
            <div class="group cursor-pointer">
                <div class="bg-white dark:bg-stone-800 rounded-3xl aspect-square flex flex-col items-center justify-center p-8 mb-4 shadow-sm group-hover:shadow-md transition-shadow relative overflow-hidden">
                    @if($testimoni->foto)
                    <img alt="{{ $testimoni->nama }}" class="w-20 h-20 rounded-full object-cover mb-4 grayscale group-hover:grayscale-0 transition-all border-2 border-stone-100 dark:border-stone-700" src="{{ asset('storage/' . $testimoni->foto) }}"/>
                    @else
                    <div class="w-20 h-20 bg-stone-100 dark:bg-stone-700 rounded-full flex items-center justify-center mb-4"><span class="material-icons text-stone-400">person</span></div>
                    @endif
                    <p class="text-[10px] italic text-stone-500 text-center leading-relaxed">"{{ Str::limit($testimoni->pesan, 100) }}"</p>
                </div>
                <p class="text-[10px] font-bold uppercase tracking-widest mb-1 text-stone-400">{{ $testimoni->peran ?? 'Parent' }}</p>
                <h5 class="text-sm font-bold tracking-tight mb-1 text-brand-dark dark:text-white uppercase">{{ $testimoni->nama }}</h5>
                <p class="text-xs font-bold text-brand-primary">Verified Feedback</p>
            </div>
            @empty
            <!-- Static Fallback Testimonial -->
            <div class="group cursor-pointer">
                <div class="bg-white dark:bg-stone-800 rounded-3xl aspect-square flex flex-col items-center justify-center p-8 mb-4 shadow-sm group-hover:shadow-md transition-shadow relative">
                     <div class="h-full flex items-center justify-center text-center italic text-xs text-stone-400">"The best decision for our child's growth."</div>
                </div>
                <p class="text-[10px] font-bold uppercase tracking-widest mb-1 text-stone-400">Parent</p>
                <h5 class="text-sm font-bold tracking-tight mb-1 text-brand-dark dark:text-white uppercase">John Doe</h5>
                <p class="text-xs font-bold text-brand-primary">Verified Feedback</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Location & Contact Section -->
<section id="location-section" class="py-24 bg-white dark:bg-brand-dark">
    <div class="container mx-auto px-6">
        <div class="flex flex-col lg:flex-row gap-12 items-start">
            <!-- Left: Contact Details -->
            <div class="lg:w-1/3 space-y-8">
                <div>
                    <h2 class="text-3xl font-extrabold text-brand-dark dark:text-white uppercase tracking-tight">Hubungi Kami</h2>
                    <p class="text-stone-500 mt-2">Kami siap menjawab pertanyaan Anda.</p>
                </div>
                
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-brand-soft dark:bg-stone-800 rounded-xl flex items-center justify-center text-brand-primary flex-shrink-0">
                            <span class="material-icons">location_on</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-brand-dark dark:text-white text-sm uppercase">Alamat Lengkap</h4>
                            <p class="text-stone-600 dark:text-stone-400 text-sm mt-1 leading-relaxed">
                                Jl. Pendidikan No. 123, Jakarta Pusat 10110
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-brand-soft dark:bg-stone-800 rounded-xl flex items-center justify-center text-brand-primary flex-shrink-0">
                            <span class="material-icons">whatsapp</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-brand-dark dark:text-white text-sm uppercase">Nomor WhatsApp</h4>
                            <p class="text-stone-600 dark:text-stone-400 text-sm mt-1">
                                +62 812-3456-7890
                            </p>
                            <a href="https://wa.me/6281234567890" target="_blank" class="inline-block mt-3 text-brand-primary font-bold text-xs uppercase tracking-widest border-b border-brand-primary pb-0.5">Chat Sekarang</a>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-brand-soft dark:bg-stone-800 rounded-xl flex items-center justify-center text-brand-primary flex-shrink-0">
                            <span class="material-icons">schedule</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-brand-dark dark:text-white text-sm uppercase">Jam Operasional</h4>
                            <p class="text-stone-600 dark:text-stone-400 text-sm mt-1">
                                Senin - Jumat: 07.30 - 15.00 WIB
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Google Maps -->
            <div class="lg:w-2/3 w-full h-[450px] rounded-[2rem] overflow-hidden shadow-2xl border border-stone-100 dark:border-stone-800">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126935.91899147285!2d106.759477!3d-6.17511!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6a1ed444310507%3A0xe54d63ea352be57!2sJakarta%20Pusat%2C%20Kota%20Jakarta%20Pusat%2C%20Daerah%20Khusus%20Ibukota%20Jakarta!5e0!3m2!1sid!2sid!4v1709850000000!5m2!1sid!2sid" 
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section (Premium Style) -->
<section class="max-w-7xl mx-auto px-6 pb-24">
    <div class="bg-brand-soft dark:bg-stone-800 rounded-[3rem] p-12 flex flex-col md:flex-row items-center gap-12 border border-stone-100 dark:border-stone-700">
        <div class="md:w-1/3">
            <img alt="Happy student" class="rounded-[2rem] shadow-2xl rotate-3" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA0Xh7xkz95Cn-ukCaAO-PdIyn5y2P4tjEuJd5yzgl9wSpJm-qH0llO7okWliqbprfAEhBEcysULGn0z4ChxduBaL77lCF6Te35cWK52jArgiUoecq1hOyQa32-Rbb9xy8WVES0ybeNnbW4BK8MDBiyokBf6mpprI0nvM1J4XDppvLh_B9OQ82IuLnKwAcLDPxfKtEE2IIWnEMG_uu2WPx2RGHdnqVr9AVLaMJii2Ugmzw-2gde9GQr_GeSzUQHpbjB38zWOdJoUAw"/>
        </div>
        <div class="md:w-2/3 space-y-6">
            <h3 class="text-4xl font-extrabold text-brand-dark dark:text-white uppercase">Come & Learn With Us</h3>
            <p class="text-lg text-stone-600 dark:text-stone-400 font-medium">Join our vibrant community where every child's curiosity is nurtured and every dream is given wings.</p>
            <div class="flex flex-wrap gap-4 pt-4">
                @guest('siswa')
                <button onclick="showLoginModal(event)" class="bg-brand-dark dark:bg-brand-primary text-white px-10 py-4 rounded-full font-bold uppercase tracking-widest text-[10px] hover:bg-brand-primary transition-all shadow-lg shadow-stone-200 dark:shadow-none">Enroll Now</button>
                @else
                <a href="{{ route('spmb.pendaftaran') }}" class="bg-brand-dark dark:bg-brand-primary text-white px-10 py-4 rounded-full font-bold uppercase tracking-widest text-[10px] hover:bg-brand-primary transition-all shadow-lg shadow-stone-200 dark:shadow-none">Enroll Now</a>
                @endguest
                <button class="bg-white dark:bg-stone-700 text-brand-dark dark:text-stone-300 border-2 border-brand-dark dark:border-stone-600 px-10 py-4 rounded-full font-bold uppercase tracking-widest text-[10px] hover:bg-brand-dark hover:text-white transition-all">Contact Us</button>
            </div>
        </div>
    </div>
</section>

<!-- Guestbook Section (Newsletter Style Form) -->
<section id="bukutamu-section" class="py-20 bg-brand-dark text-white">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-extrabold mb-4 uppercase tracking-tight">Our Guestbook</h2>
            <p class="text-stone-400 text-lg">Leave a mark on our journey. Share your thoughts or messages about TK Harapan Bangsa 1.</p>
        </div>
        
        @if(session('success'))
        <div class="mb-8 bg-green-500/20 border border-green-500 text-green-200 px-6 py-4 rounded-2xl text-center">
             {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('buku-tamu.home') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid md:grid-cols-2 gap-4">
                <input name="nama" value="{{ old('nama') }}" required class="bg-stone-800 border-none rounded-full px-8 py-4 text-white focus:ring-2 focus:ring-brand-primary placeholder:text-stone-500 text-sm" placeholder="Your Full Name" type="text"/>
                <input name="email" value="{{ old('email') }}" class="bg-stone-800 border-none rounded-full px-8 py-4 text-white focus:ring-2 focus:ring-brand-primary placeholder:text-stone-500 text-sm" placeholder="Your Email Address" type="email"/>
            </div>
            <div class="grid md:grid-cols-1 gap-4">
                <select name="status" required class="bg-stone-800 border-none rounded-full px-8 py-4 text-white focus:ring-2 focus:ring-brand-primary cursor-pointer text-sm">
                    <option value="" class="text-stone-500">Select Status</option>
                    <option value="parent">Parent</option>
                    <option value="visitor">Visitor</option>
                    <option value="alumni">Alumni</option>
                </select>
            </div>
            <textarea name="pesan_kesan" required class="w-full bg-stone-800 border-none rounded-3xl px-8 py-6 text-white focus:ring-2 focus:ring-brand-primary placeholder:text-stone-500 text-sm" placeholder="Your message or feedback..." rows="4">{{ old('pesan_kesan') }}</textarea>
            
            <div class="text-center pt-4">
                <button class="bg-brand-primary text-white font-bold px-12 py-4 rounded-full uppercase tracking-widest text-[10px] hover:bg-orange-600 transition-colors shadow-xl" type="submit">
                    Send Message
                </button>
            </div>
        </form>
    </div>
</section>
@endsection