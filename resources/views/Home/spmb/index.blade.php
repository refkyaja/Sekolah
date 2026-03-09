@extends('layouts.nav-spmb')

@section('title', 'PPDB Harapan Bangsa 1')

@section('content')
@php
    $isPendaftaranOpen = $setting && 
                        $setting->pendaftaran_mulai && 
                        $setting->pendaftaran_selesai && 
                        $now->between($setting->pendaftaran_mulai, $setting->pendaftaran_selesai);

    $isPengumumanOpen = $setting && 
                        $setting->pengumuman_mulai && 
                        $setting->pengumuman_selesai && 
                        $now->between($setting->pengumuman_mulai, $setting->pengumuman_selesai);

    $isPublished = $setting && $setting->is_published;
@endphp
<div class="bg-brand-soft min-h-screen">
    <!-- Hero Section -->
    <section class="relative h-[80vh] flex items-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80" 
                 class="w-full h-full object-cover" alt="Happy Children">
            <div class="absolute inset-0 bg-stone-900/40"></div>
        </div>
        
        <div class="container mx-auto px-6 relative z-10 text-white">
            <div class="max-w-2xl text-left">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] mb-4 block">Penerimaan Siswa Baru</span>
                <h1 class="text-6xl font-extrabold tracking-tight leading-none mb-8">
                    LANGKAH PERTAMA<br>UNTUK MASA DEPAN.
                </h1>
                <p class="text-lg font-medium mb-12 opacity-90 leading-relaxed">
                    Bergabunglah dengan komunitas belajar kami yang penuh kasih, di mana setiap anak didorong untuk mengeksplorasi, tumbuh, dan bersinar.
                </p>
                <div class="flex items-center gap-6">
                    @if($isPendaftaranOpen)
                        @guest('siswa')
                        <button onclick="showLoginModal(event)" class="bg-brand-primary text-white px-10 py-5 rounded-full text-[10px] font-bold uppercase tracking-widest hover:bg-white hover:text-brand-dark transition-all shadow-xl">Daftar Sekarang</button>
                        @else
                        <a href="{{ route('spmb.pendaftaran') }}" class="bg-brand-primary text-white px-10 py-5 rounded-full text-[10px] font-bold uppercase tracking-widest hover:bg-white hover:text-brand-dark transition-all shadow-xl">Daftar Sekarang</a>
                        @endguest
                    @else
                        <button class="bg-stone-400 text-white px-10 py-5 rounded-full text-[10px] font-bold uppercase tracking-widest cursor-not-allowed shadow-xl">Pendaftaran Tutup</button>
                    @endif
                    <a href="#info" class="text-[10px] font-bold uppercase tracking-widest hover:underline">Pelajari Lebih Lanjut</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Dates & Info -->
    <section id="info" class="py-32 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="bg-white p-12 rounded-[2rem] shadow-sm hover:shadow-xl transition-all border border-stone-100">
                    <div class="w-14 h-14 bg-brand-soft text-brand-primary rounded-2xl flex items-center justify-center mb-8">
                        <span class="material-symbols-outlined text-3xl">calendar_today</span>
                    </div>
                    <h3 class="text-sm font-extrabold uppercase tracking-widest text-brand-dark mb-4">Periode Pendaftaran</h3>
                    <p class="text-stone-500 text-xs font-medium leading-loose">
                        @if($setting && $setting->pendaftaran_mulai)
                            Gelombang: {{ $setting->pendaftaran_mulai->translatedFormat('d M') }} — {{ $setting->pendaftaran_selesai ? $setting->pendaftaran_selesai->translatedFormat('d M Y') : 'Selesai' }}
                        @else
                            Akan segera hadir. Pantau terus website kami untuk informasi terbaru.
                        @endif
                    </p>
                </div>

                <div class="bg-brand-dark p-12 rounded-[2rem] shadow-xl text-white">
                    <div class="w-14 h-14 bg-white/10 text-brand-primary rounded-2xl flex items-center justify-center mb-8">
                        <span class="material-symbols-outlined text-3xl">verified</span>
                    </div>
                    <h3 class="text-sm font-extrabold uppercase tracking-widest mb-4">Kriteria Utama</h3>
                    <ul class="space-y-4 text-[10px] font-bold uppercase tracking-wider">
                        <li class="flex items-center gap-3">
                            <span class="w-1.5 h-1.5 bg-brand-primary rounded-full"></span> Usia 4-6 Tahun
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-1.5 h-1.5 bg-brand-primary rounded-full"></span> Domisili Terdekat
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-1.5 h-1.5 bg-brand-primary rounded-full"></span> Kesiapan Belajar
                        </li>
                    </ul>
                </div>

                <div class="bg-white p-12 rounded-[2rem] shadow-sm hover:shadow-xl transition-all border border-stone-100">
                    <div class="w-14 h-14 bg-brand-soft text-brand-primary rounded-2xl flex items-center justify-center mb-8">
                        <span class="material-symbols-outlined text-3xl">description</span>
                    </div>
                    <h3 class="text-sm font-extrabold uppercase tracking-widest text-brand-dark mb-4">Dokumen Wajib</h3>
                    <p class="text-stone-500 text-[10px] font-bold uppercase tracking-wider leading-loose">
                        Akta Kelahiran (Asli)<br>
                        Kartu Keluarga (KK)<br>
                        KTP Orang Tua<br>
                        Pas Foto 3x4 (4 Lembar)
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Us (Story Grid Style) -->
    <section class="py-32 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-20 items-center">
                <div class="relative group overflow-hidden rounded-[3rem] aspect-square">
                    <img src="https://images.unsplash.com/photo-1544365558-35aa4afcf11f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" 
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="Learning">
                    <div class="absolute inset-0 bg-brand-dark/20"></div>
                </div>
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-stone-400 mb-6 block">Filosofi Kami</span>
                    <h2 class="text-5xl font-extrabold tracking-tight mb-8 text-brand-dark uppercase">LINGKUNGAN YANG<br>MENINSPIRASI.</h2>
                    <p class="text-stone-500 font-medium leading-relaxed mb-10">
                        Kami percaya bahwa lingkungan belajar haruslah seindah rumah. Dengan fasilitas modern yang dipadukan dengan pendekatan humanistis, kami memastikan setiap detik waktu anak Anda di sekolah adalah pengalaman yang berharga.
                    </p>
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="p-2 bg-brand-soft rounded-lg text-brand-primary">
                                <span class="material-symbols-outlined text-sm">auto_awesome</span>
                            </div>
                            <div>
                                <h4 class="text-xs font-extrabold uppercase tracking-widest text-brand-dark mb-1">Kurikulum Inovatif</h4>
                                <p class="text-[10px] text-stone-400 font-medium uppercase tracking-wider">Metode belajar sambil bermain yang terintegrasi.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-32 px-6">
        <div class="max-w-5xl mx-auto bg-brand-primary rounded-[3rem] p-20 text-center text-white relative overflow-hidden shadow-2xl">
            <div class="absolute inset-0 opacity-10 pointer-events-none">
                <div class="absolute -top-24 -left-24 w-96 h-96 border-[40px] border-white rounded-full"></div>
            </div>
            <h2 class="text-4xl font-extrabold tracking-tight mb-8 uppercase">SIAP UNTUK BERGABUNG?</h2>
            <p class="text-lg font-medium opacity-90 mb-12 max-w-xl mx-auto leading-relaxed">
                Kuota terbatas untuk setiap jenjang. Pastikan anak Anda mendapatkan tempat terbaik untuk memulai perjalanannya.
            </p>
            @if($isPendaftaranOpen)
                @guest('siswa')
                <button onclick="showLoginModal(event)" class="bg-brand-dark text-white px-12 py-5 rounded-full text-[10px] font-bold uppercase tracking-widest hover:bg-white hover:text-brand-dark transition-all shadow-xl">Ajukan Pendaftaran</button>
                @else
                <a href="{{ route('spmb.pendaftaran') }}" class="bg-brand-dark text-white px-12 py-5 rounded-full text-[10px] font-bold uppercase tracking-widest hover:bg-white hover:text-brand-dark transition-all shadow-xl">Ajukan Pendaftaran</a>
                @endguest
            @else
                <button class="bg-stone-600 text-white px-12 py-5 rounded-full text-[10px] font-bold uppercase tracking-widest cursor-not-allowed shadow-xl">Pendaftaran Tutup</button>
            @endif
        </div>
    </section>
</div>
@endsection