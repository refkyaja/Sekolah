@extends('layouts.home')

@section('title', 'Profil Sekolah - TK PGRI Harapan Bangsa 1')

@section('content')
<div class="px-4 md:px-10 py-6 space-y-12">
    <!-- Hero Section -->
    <section data-home-animate="zoom-in" class="relative h-[300px] md:h-[400px] w-full overflow-hidden rounded-xl md:rounded-3xl shadow-lg mt-4 md:mt-8">
        <div class="absolute inset-0 bg-cover bg-center" data-alt="Children playing happily in a colorful classroom" style="background-image: url('{{ asset('images/profile.jpeg') }}');"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex flex-col justify-end p-8 md:p-12">
            <nav data-home-animate="fade-up" class="flex gap-2 text-white/80 text-sm mb-4">
                <span><a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a></span> <span>/</span> <span class="text-white font-medium">Profil Sekolah</span>
            </nav>
            <h1 data-home-animate="fade-up" class="text-white text-4xl md:text-5xl font-bold tracking-tight">Profil Sekolah</h1>
            <p data-home-animate="fade-up" class="mt-4 text-white/85 text-base md:text-lg leading-relaxed max-w-2xl">
                Mengenal lebih dekat visi, misi, tujuan, dan profil lengkap TK PGRI Harapan Bangsa 1 sebagai ruang tumbuh yang hangat bagi anak usia dini.
            </p>
        </div>
    </section>

    <!-- 1. Sambutan Kepala Sekolah -->
    <section data-home-animate="fade-up" class="grid md:grid-cols-12 gap-8 lg:gap-12 bg-white p-6 md:p-10 rounded-2xl border border-slate-100 shadow-sm relative">
        <div data-home-animate="fade-right" class="md:col-span-4 flex justify-center md:sticky md:top-24 self-start">
            <div class="relative group mt-0 md:mt-4">
                <div class="absolute -inset-4 bg-primary/10 rounded-full blur-2xl group-hover:bg-primary/20 transition-all"></div>
                <div class="size-64 md:size-72 lg:size-80 rounded-full overflow-hidden border-8 border-white shadow-xl relative">
                    <img alt="Ibu Tina Wati, S.Pd." class="w-full h-full object-cover" data-alt="Portrait of a smiling female principal in formal attire" src="{{ asset('images/kepala-sekolah.jpeg') }}"/>
                </div>
            </div>
        </div>
        <div data-home-animate="fade-left" class="md:col-span-8 space-y-6">
            <div data-home-animate="fade-left" class="inline-flex items-center gap-2 text-primary font-bold px-3 py-1 bg-primary/10 rounded-full text-xs uppercase tracking-wider">
                <span class="material-symbols-outlined text-sm">record_voice_over</span> Sambutan
            </div>
            <h2 data-home-animate="fade-left" class="text-3xl md:text-4xl font-bold text-slate-900 leading-tight">Kata Sambutan</h2>
            <div data-home-animate="fade-left" class="space-y-4 text-slate-600 leading-relaxed text-sm md:text-base text-justify">
                <p><strong>Assalamu'alaikum warahmatullahi wabarakatuh,</strong></p>
                <p>Salam sejahtera bagi kita semua,</p>
                <p>Puji syukur kita panjatkan ke hadirat Tuhan Yang Maha Esa, karena atas rahmat dan karunia-Nya, website resmi sekolah ini dapat hadir sebagai sarana informasi, komunikasi, dan transparansi bagi seluruh warga sekolah serta masyarakat luas.</p>
                <p>Di era digital saat ini, keterbukaan informasi dan kemudahan akses menjadi kebutuhan yang sangat penting. Melalui website ini, kami berkomitmen untuk memberikan informasi yang akurat dan terpercaya mengenai profil sekolah, program akademik, kegiatan siswa, hingga layanan Penerimaan Peserta Didik Baru (PPDB). Kami berharap platform ini dapat menjadi jembatan yang mempererat hubungan antara sekolah, orang tua, siswa, dan masyarakat.</p>
                <p>Sekolah bukan hanya tempat untuk menimba ilmu, tetapi juga tempat membangun karakter, menanamkan nilai-nilai integritas, kedisiplinan, serta semangat berprestasi. Kami terus berupaya meningkatkan mutu pendidikan, baik dari sisi akademik maupun pengembangan potensi siswa melalui berbagai kegiatan ekstrakurikuler dan pembinaan karakter.</p>
                <p>Kami menyadari bahwa keberhasilan pendidikan tidak dapat dicapai tanpa dukungan dan kerja sama dari seluruh pihak. Oleh karena itu, kami mengajak orang tua dan masyarakat untuk bersama-sama mendukung program sekolah demi terciptanya generasi yang cerdas, berakhlak mulia, serta siap menghadapi tantangan masa depan.</p>
                <p>Akhir kata, kami mengucapkan terima kasih atas kepercayaan dan dukungan yang telah diberikan kepada sekolah ini. Semoga website ini dapat memberikan manfaat yang sebesar-besarnya bagi kita semua.</p>
                <p><strong>Wassalamu'alaikum warahmatullahi wabarakatuh.</strong></p>
            </div>
            <div data-home-animate="fade-left" class="pt-4 border-t border-slate-100">
                <p class="text-slate-500 text-sm mb-1">Hormat kami,</p>
                <p class="font-bold text-slate-900 text-lg">Tina Wati, S.Pd</p>
                <p class="text-slate-500 text-xs uppercase tracking-widest font-bold">Kepala Sekolah TK PGRI Harapan Bangsa 1</p>
            </div>
        </div>
    </section>

    <!-- 2. Visi dan Misi -->
    <section data-home-animate="fade-up" class="space-y-8 mt-16 md:mt-24">
        <div data-home-animate="fade-up" class="text-center space-y-2 mb-10">
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900">Visi &amp; Misi</h2>
            <div class="h-1.5 w-20 bg-primary mx-auto rounded-full"></div>
        </div>
        <div class="grid md:grid-cols-2 gap-8">
            <div data-home-animate="slide-rotate" class="bg-primary text-white p-8 md:p-10 rounded-3xl shadow-xl relative overflow-hidden group flex flex-col justify-center">
                <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-[150px] opacity-10 rotate-12 group-hover:rotate-0 transition-transform duration-500">lightbulb</span>
                <div class="relative z-10">
                    <h3 class="text-3xl font-bold mb-6 flex items-center gap-3">
                        <span class="material-symbols-outlined text-4xl">visibility</span> Visi
                    </h3>
                    <p class="text-lg md:text-xl leading-relaxed opacity-95 text-justify">
                        "Terwujudnya anak yang cerdas, mandiri, dan berakhlak mulia dan siap menghadapi global dalam lingkungan belajar ramah, inklusif serta berbasis budaya lokal Bandung."
                    </p>
                </div>
            </div>
            <div data-home-animate="blur-in" class="bg-white p-8 md:p-10 rounded-3xl border border-slate-200 shadow-sm h-full rounded-tr-3xl">
                <h3 class="text-2xl font-bold mb-6 text-primary flex items-center gap-3">
                    <span class="material-symbols-outlined text-3xl">flag</span> Misi
                </h3>
                <ul class="space-y-6 text-sm md:text-base">
                    <li class="flex gap-4 items-start">
                        <div class="size-8 rounded-full bg-primary/20 text-primary flex items-center justify-center shrink-0 font-bold text-sm mt-0.5">1</div>
                        <p class="text-slate-600 leading-relaxed text-justify">Menyelenggarakan pembelajaran berbasis bermain yang berpusat pada anak, mendukung perkembangan identitas diri, berpikir aktif, dan kemampuan fondasi sesuai fase fondasi Kurikulum Merdeka.</p>
                    </li>
                    <li class="flex gap-4 items-start">
                        <div class="size-8 rounded-full bg-primary/20 text-primary flex items-center justify-center shrink-0 font-bold text-sm mt-0.5">2</div>
                        <p class="text-slate-600 leading-relaxed text-justify">Meningkatkan kompetensi pendidikan melalui pelatihan berkelanjutan, kolaborasi, dan pemanfaatan assessment untuk memberikan pendampingan teridentifikasi serta umpan balik konstruktif.</p>
                    </li>
                    <li class="flex gap-4 items-start">
                        <div class="size-8 rounded-full bg-primary/20 text-primary flex items-center justify-center shrink-0 font-bold text-sm mt-0.5">3</div>
                        <p class="text-slate-600 leading-relaxed text-justify">Membangun kemitraan aktif dengan orang tua, masyarakat, dan stakeholder lokal untuk mendukung perkembangan holistik anak, termasuk integrasi budaya Sunda dan nilai-nilai Pancasila dalam kegiatan sehari-hari.</p>
                    </li>
                    <li class="flex gap-4 items-start">
                        <div class="size-8 rounded-full bg-primary/20 text-primary flex items-center justify-center shrink-0 font-bold text-sm mt-0.5">4</div>
                        <p class="text-slate-600 leading-relaxed text-justify">Menciptakan ekosistem belajar yang aman, kreatif, dan menyediakan kebijakan, sesuai Standar Nasional Pendidikan serta rekomendasi Rapor Pendidikan untuk mengatasi tantangan seperti dukungan pendidikan dan kemitraan orang tua.</p>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- 3. Tujuan -->
    <section data-home-animate="fade-up" class="space-y-8 mt-16 md:mt-24">
        <div data-home-animate="fade-up" class="text-center space-y-2 mb-10">
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900">Tujuan</h2>
            <div class="h-1.5 w-20 bg-primary mx-auto rounded-full"></div>
        </div>
        <div data-home-stagger class="bg-white p-8 md:p-10 rounded-3xl border border-slate-200 shadow-sm">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="space-y-4 p-6 bg-slate-50 rounded-2xl hover:bg-primary hover:text-white group transition-colors">
                    <div class="size-14 rounded-2xl bg-white text-primary flex items-center justify-center mb-6 shadow-sm group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-4xl">psychology</span>
                    </div>
                    <h4 class="font-bold text-lg group-hover:text-white">Kualitas Pembelajaran</h4>
                    <p class="text-sm text-slate-600 group-hover:text-white/80 leading-relaxed">Meningkatkan kualitas pembelajaran untuk mendukung identitas diri dan berpikir aktif dan kemampuan pondasi.</p>
                </div>
                <div class="space-y-4 p-6 bg-slate-50 rounded-2xl hover:bg-primary hover:text-white group transition-colors">
                    <div class="size-14 rounded-2xl bg-white text-primary flex items-center justify-center mb-6 shadow-sm group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-4xl">school</span>
                    </div>
                    <h4 class="font-bold text-lg group-hover:text-white">Profesionalisme</h4>
                    <p class="text-sm text-slate-600 group-hover:text-white/80 leading-relaxed">Meningkatkan kualitas pelajaran, pedagogik dan profesionalisme guru didik.</p>
                </div>
                <div class="space-y-4 p-6 bg-slate-50 rounded-2xl hover:bg-primary hover:text-white group transition-colors">
                    <div class="size-14 rounded-2xl bg-white text-primary flex items-center justify-center mb-6 shadow-sm group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-4xl">diversity_3</span>
                    </div>
                    <h4 class="font-bold text-lg group-hover:text-white">Partisipasi Ortu</h4>
                    <p class="text-sm text-slate-600 group-hover:text-white/80 leading-relaxed">Meningkatkan partisipasi orang tua secara aktif dalam berbagai kegiatan kemitraan bersama sekolah.</p>
                </div>
                <div class="space-y-4 p-6 bg-slate-50 rounded-2xl hover:bg-primary hover:text-white group transition-colors">
                    <div class="size-14 rounded-2xl bg-white text-primary flex items-center justify-center mb-6 shadow-sm group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-4xl">account_balance</span>
                    </div>
                    <h4 class="font-bold text-lg group-hover:text-white">Keselarasan Standar</h4>
                    <p class="text-sm text-slate-600 group-hover:text-white/80 leading-relaxed">Memastikan keselarasan dengan 8 Standar Nasional Pendidikan melalui pengelolaan sumber daya yang efektif.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Profil Sekolah (Identity, Staff, KBM) -->
    <section data-home-animate="fade-up" class="space-y-8 mt-16 md:mt-24">
        <div data-home-animate="fade-up" class="text-center space-y-2 mb-10">
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900">Profil Sekolah</h2>
            <div class="h-1.5 w-20 bg-primary mx-auto rounded-full"></div>
        </div>
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Identitas Sekolah -->
            <div data-home-animate="slide-rotate" class="lg:col-span-1 space-y-6">
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm h-full transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">info</span> Identitas Sekolah
                    </h3>
                    <div class="space-y-4">
                        <div data-home-stagger class="space-y-4">
                            <div class="pb-3 border-b border-slate-100 stagger-item">
                                <p class="text-xs text-slate-400 font-medium uppercase">Nama Sekolah</p>
                                <p class="font-semibold text-slate-900">TK PGRI HARAPAN BANGSA 1</p>
                            </div>
                            <div class="pb-3 border-b border-slate-100 stagger-item">
                                <p class="text-xs text-slate-400 font-medium uppercase">NPSN</p>
                                <p class="font-semibold text-slate-900">20255202</p>
                            </div>
                            <div class="pb-3 border-b border-slate-100 stagger-item">
                                <p class="text-xs text-slate-400 font-medium uppercase">Jenjang Pendidikan</p>
                                <p class="font-semibold text-slate-900">Taman Kanak-Kanak (TK)</p>
                            </div>
                            <div class="pb-3 border-b border-slate-100 stagger-item">
                                <p class="text-xs text-slate-400 font-medium uppercase">Status Sekolah</p>
                                <p class="font-semibold text-slate-900">Swasta</p>
                            </div>
                            <div class="pb-3 border-b border-slate-100 stagger-item">
                                <p class="text-xs text-slate-400 font-medium uppercase">Akreditasi</p>
                                <p class="font-semibold text-slate-900">B</p>
                            </div>
                            <div class="pb-3 stagger-item">
                                <p class="text-xs text-slate-400 font-medium uppercase">Alamat Sekolah</p>
                                <p class="font-semibold text-sm text-slate-900">JL. Terusan PSM No. 1A, Kel. Sukapura, Kec. Kiaracondong, Kota Bandung, Jawa Barat</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pendidik & KBM -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Pendidik & Tenaga Kependidikan -->
                <div data-home-animate="fade-up" class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm transition-all duration-300 hover:shadow-xl">
                    <h3 class="text-xl font-bold mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">groups</span> Pendidik &amp; Tenaga Kependidikan
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-6 mb-8">
                        <div data-home-animate="zoom-in" class="bg-slate-50 p-4 rounded-xl border border-slate-100 transition-all duration-300 hover:scale-105 hover:shadow-md">
                            <p class="text-[10px] text-slate-400 font-bold tracking-widest uppercase mb-3">Staf Utama</p>
                            <ul class="text-sm space-y-2 font-medium text-slate-700">
                                <li class="flex justify-between items-center"><span>Kepala Sekolah</span> <span class="text-primary font-bold">1 Orang</span></li>
                                <li class="flex justify-between items-center"><span>Guru Kelompok</span> <span class="text-primary font-bold">2 Orang</span></li>
                                <li class="flex justify-between items-center"><span>Guru Pendamping</span> <span class="text-primary font-bold">1 Orang</span></li>
                            </ul>
                        </div>
                        <div data-home-animate="zoom-in" class="bg-slate-50 p-4 rounded-xl border border-slate-100 transition-all duration-300 hover:scale-105 hover:shadow-md" style="transition-delay: 100ms">
                            <p class="text-[10px] text-slate-400 font-bold tracking-widest uppercase mb-3">Kualifikasi</p>
                            <div class="flex items-start gap-3 text-slate-700">
                                <span class="material-symbols-outlined text-primary text-lg mt-0.5">workspace_premium</span>
                                <p class="text-sm font-semibold leading-tight">Memiliki Sertifikat<br/>Pendidik: Ya</p>
                            </div>
                        </div>
                        <div data-home-animate="zoom-in" class="bg-slate-50 p-4 rounded-xl border border-slate-100 transition-all duration-300 hover:scale-105 hover:shadow-md" style="transition-delay: 200ms">
                            <p class="text-[10px] text-slate-400 font-bold tracking-widest uppercase mb-3">Kualitas</p>
                            <ul class="text-sm space-y-2 font-medium text-slate-700">
                                <li class="flex items-start gap-2">
                                    <span class="material-symbols-outlined text-primary text-base mt-0.5">check_circle</span> 
                                    <span class="leading-tight">Pembinaan &amp; Evaluasi:<br/>Rutin</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="material-symbols-outlined text-primary text-base mt-0.5">check_circle</span> 
                                    <span class="leading-tight">Pengembangan Kompetensi:<br/>Rutin</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div data-home-animate="flip-in" class="text-center group transition-all duration-300 hover:-translate-y-2">
                            <div class="size-20 bg-slate-100 rounded-full mx-auto mb-2 overflow-hidden border-2 border-transparent group-hover:border-primary transition-all duration-300 relative group-hover:shadow-xl">
                                <!-- UBAH SRC DI BAWAH UNTUK FOTO KEPALA SEKOLAH -->
                                <img alt="Kepala Sekolah" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110" data-alt="Portrait of a female teacher" src="{{ asset('images/kepala-sekolah.jpeg') }}"/>
                            </div>
                            <p class="font-bold text-sm text-slate-900">Tina Wati, S.Pd</p>
                            <p class="text-[10px] text-slate-400">Kepala Sekolah</p>
                        </div>
                        <div data-home-animate="flip-in" class="text-center group transition-all duration-300 hover:-translate-y-2" style="transition-delay: 100ms">
                            <div class="size-20 bg-slate-100 rounded-full mx-auto mb-2 overflow-hidden border-2 border-transparent group-hover:border-primary transition-all duration-300 relative group-hover:shadow-xl">
                                <!-- UBAH SRC DI BAWAH UNTUK FOTO GURU KELOMPOK A -->
                                <img alt="Guru Kelompok A" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110" data-alt="Portrait of a female teacher" src="{{ asset('images/guru-a.jpeg') }}"/>
                            </div>
                            <p class="font-bold text-sm text-slate-900">Vera Irawaty, S.Pd</p>
                            <p class="text-[10px] text-slate-400">Guru Kelompok A</p>
                        </div>
                        <div data-home-animate="flip-in" class="text-center group transition-all duration-300 hover:-translate-y-2" style="transition-delay: 200ms">
                            <div class="size-20 bg-slate-100 rounded-full mx-auto mb-2 overflow-hidden border-2 border-transparent group-hover:border-primary transition-all duration-300 relative group-hover:shadow-xl">
                                <!-- UBAH SRC DI BAWAH UNTUK FOTO GURU KELOMPOK B -->
                                <img alt="Guru Kelompok B" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110" data-alt="Portrait of a female teacher" src="{{ asset('images/guru-b.jpeg') }}"/>
                            </div>
                            <p class="font-bold text-sm text-slate-900">Nena, S.Pd</p>
                            <p class="text-[10px] text-slate-400">Guru Kelompok B</p>
                        </div>
                        <div data-home-animate="flip-in" class="text-center group transition-all duration-300 hover:-translate-y-2" style="transition-delay: 300ms">
                            <div class="size-20 bg-slate-100 rounded-full mx-auto mb-2 overflow-hidden border-2 border-transparent group-hover:border-primary transition-all duration-300 relative group-hover:shadow-xl">
                                <!-- UBAH SRC DI BAWAH UNTUK FOTO GURU PENDAMPING -->
                                <img alt="Guru Pendamping" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110" data-alt="Portrait of a female teacher" src="{{ asset('images/guru-p.jpeg') }}"/>
                            </div>
                            <p class="font-bold text-sm text-slate-900">Serly Marliyana, SE</p>
                            <p class="text-[10px] text-slate-400">Guru Pendamping</p>
                        </div>
                    </div>
                </div>

                <!-- Kegiatan Belajar Mengajar (KBM) -->
                <div data-home-animate="blur-in" class="bg-primary/5 p-6 rounded-2xl border border-primary/20 transition-all duration-500 hover:shadow-xl hover:-translate-y-1">
                    <h3 class="text-xl font-bold mb-4 flex items-center gap-2 text-primary">
                        <span class="material-symbols-outlined animate-pulse">auto_stories</span> Kegiatan Belajar Mengajar (KBM)
                    </h3>
                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        <div class="space-y-4">
                            <div data-home-animate="fade-right">
                                <p class="text-xs text-slate-400 font-bold uppercase mb-1">Kurikulum &amp; Metode</p>
                                <ul class="text-sm space-y-2 text-slate-800">
                                    <li class="flex items-start gap-2 transition-all duration-300 hover:translate-x-2">
                                        <span class="material-symbols-outlined text-primary text-sm mt-0.5">verified</span>
                                        <div>
                                            <p class="font-bold">Kurikulum Merdeka Belajar</p>
                                            <p class="text-slate-500 text-xs">Acuan: Kemendikdaskan</p>
                                        </div>
                                    </li>
                                    <li class="flex items-start gap-2 transition-all duration-300 hover:translate-x-2">
                                        <span class="material-symbols-outlined text-primary text-sm mt-0.5">child_care</span>
                                        <div>
                                            <span class="font-medium">Kelompok A</span>
                                            <p class="text-slate-500 text-xs">Penguatan: Pend. Holistik Berbasis Karakter</p>
                                        </div>
                                    </li>
                                    <li class="flex items-start gap-2 transition-all duration-300 hover:translate-x-2">
                                        <span class="material-symbols-outlined text-primary text-sm mt-0.5">stars</span>
                                        <div>
                                            <p class="font-bold">Piloting PAUD Percontohan Rujukan</p>
                                            <p class="text-slate-500 text-xs">Dinas Pendidikan (Penerapan Layanan PAUD HIBER)</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div data-home-animate="fade-left">
                                <p class="text-xs text-slate-400 font-bold uppercase mb-1">Informasi Siswa</p>
                                <div class="bg-white p-3 rounded-lg border border-slate-100 transition-all duration-300 hover:shadow-md">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm text-slate-600">Jumlah Siswa / Thn</span>
                                        <span class="font-bold text-primary">± 50 Siswa</span>
                                    </div>
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm text-slate-600">Rombongan Belajar</span>
                                        <span class="font-bold text-primary">2 Rombel</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-slate-600">Awal Tahun Ajaran</span>
                                        <span class="font-bold text-primary">Juli</span>
                                    </div>
                                </div>
                            </div>
                            <div data-home-animate="fade-left">
                                <p class="text-xs text-slate-400 font-bold uppercase mb-1">Program Rutin</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="px-2 py-1 bg-white border border-slate-200 text-[10px] font-bold text-slate-700 rounded-full flex items-center gap-1 transition-all duration-300 hover:scale-110 hover:bg-primary hover:text-white hover:border-primary">
                                        <span class="material-symbols-outlined text-xs text-primary group-hover:text-white">family_restroom</span> Program Parenting
                                    </span>
                                    <span class="px-2 py-1 bg-white border border-slate-200 text-[10px] font-bold text-slate-700 rounded-full flex items-center gap-1 transition-all duration-300 hover:scale-110 hover:bg-primary hover:text-white hover:border-primary">
                                        <span class="material-symbols-outlined text-xs text-primary group-hover:text-white">description</span> Laporan Rutin
                                    </span>
                                    <span class="px-2 py-1 bg-white border border-slate-200 text-[10px] font-bold text-slate-700 rounded-full flex items-center gap-1 transition-all duration-300 hover:scale-110 hover:bg-primary hover:text-white hover:border-primary">
                                        <span class="material-symbols-outlined text-xs text-primary group-hover:text-white">palette</span> Ekstrakurikuler Ada
                                    </span>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-bold uppercase mb-1">Program Rutin</p>
                                <div class="flex flex-wrap gap-2">
                                    <span class="px-2 py-1 bg-white border border-slate-200 text-[10px] font-bold text-slate-700 rounded-full flex items-center gap-1">
                                        <span class="material-symbols-outlined text-xs text-primary">family_restroom</span> Program Parenting
                                    </span>
                                    <span class="px-2 py-1 bg-white border border-slate-200 text-[10px] font-bold text-slate-700 rounded-full flex items-center gap-1">
                                        <span class="material-symbols-outlined text-xs text-primary">description</span> Laporan Rutin
                                    </span>
                                    <span class="px-2 py-1 bg-white border border-slate-200 text-[10px] font-bold text-slate-700 rounded-full flex items-center gap-1">
                                        <span class="material-symbols-outlined text-xs text-primary">palette</span> Ekstrakurikuler Ada
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        <div class="flex items-center gap-2 p-2 bg-white rounded-lg shadow-sm">
                            <span class="material-symbols-outlined text-primary text-sm">calendar_month</span>
                            <span class="text-xs font-medium text-slate-700">5 Hari / Minggu</span>
                        </div>
                        <div class="flex items-center gap-2 p-2 bg-white rounded-lg shadow-sm">
                            <span class="material-symbols-outlined text-primary text-sm">event_repeat</span>
                            <span class="text-xs font-medium text-slate-700">Tahun Ajaran: Juli</span>
                        </div>
                        <div class="flex items-center gap-2 p-2 bg-white rounded-lg shadow-sm">
                            <span class="material-symbols-outlined text-primary text-sm">check_circle</span>
                            <span class="text-xs font-medium text-slate-700">Terverifikasi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. Struktur Organisasi Sekolah -->
    <section data-home-animate="fade-up" class="space-y-8 mt-16 md:mt-24">
        <div data-home-animate="fade-up" class="text-center space-y-2 mb-10">
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900">Struktur Organisasi</h2>
            <p class="text-slate-600 font-medium">TK PGRI Harapan Bangsa 1 Tahun Ajaran 2025/2026</p>
            <div class="h-1.5 w-20 bg-primary mx-auto rounded-full mt-4"></div>
        </div>

        <div data-home-animate="zoom-in" class="bg-white rounded-[2rem] md:rounded-[2.5rem] border border-slate-200 shadow-sm p-4 md:p-8 overflow-hidden">
            <div class="relative rounded-[1.5rem] bg-gradient-to-br from-white via-slate-50 to-orange-50/40 p-3 md:p-6 border border-slate-100 shadow-inner">
                <div class="absolute inset-x-10 top-0 h-24 bg-primary/5 blur-3xl"></div>
                <figure class="relative overflow-x-auto">
                    <svg viewBox="0 0 1000 560" class="min-w-[820px] w-full h-auto drop-shadow-[0_20px_40px_rgba(15,23,42,0.08)]" role="img" aria-labelledby="strukturTitle strukturDesc">
                        <title id="strukturTitle">Struktur Organisasi TK PGRI Harapan Bangsa 1</title>
                        <desc id="strukturDesc">Diagram struktur organisasi sekolah berisi Dinas Pendidikan, Ketua YPLP PGRI, Kepala Sekolah, Komite, Sekretaris, Bendahara, Guru Kelompok A, Guru Pendamping, dan Guru Kelompok B.</desc>

                        <defs>
                            <style>
                                .org-line { stroke: #1f2937; stroke-width: 4; stroke-linecap: square; fill: none; }
                                .org-box { fill: #ffffff; stroke: #f97316; stroke-width: 4; rx: 18; }
                                .org-title { font-family: Lexend, sans-serif; font-size: 13px; font-weight: 800; fill: #0f172a; text-transform: uppercase; letter-spacing: 0.8px; }
                                .org-name { font-family: Lexend, sans-serif; font-size: 11px; font-weight: 500; fill: #111827; }
                            </style>
                        </defs>

                        <path class="org-line" d="M500 76 L500 132" />
                        <path class="org-line" d="M250 132 L750 132" />
                        <path class="org-line" d="M500 132 L500 194" />
                        <path class="org-line" d="M748 258 L748 280" />
                        <path class="org-line" d="M675 280 L835 280" />
                        <path class="org-line" d="M500 248 L500 360" />
                        <path class="org-line" d="M180 360 L820 360" />
                        <path class="org-line" d="M180 360 L180 410" />
                        <path class="org-line" d="M500 360 L500 410" />
                        <path class="org-line" d="M820 360 L820 410" />
                        <path class="org-line" d="M748 132 L748 194" />

                        <g>
                            <rect class="org-box" x="345" y="12" width="310" height="64"></rect>
                            <text class="org-title" x="500" y="31" text-anchor="middle">DINAS PENDIDIKAN</text>
                            <text class="org-name" x="500" y="54" text-anchor="middle">Drs. Asep Saeful Gufron, M.Si</text>
                        </g>

                        <g>
                            <rect class="org-box" x="58" y="94" width="250" height="68"></rect>
                            <text class="org-title" x="183" y="113" text-anchor="middle">KETUA YPLP - PGRI</text>
                            <text class="org-name" x="183" y="139" text-anchor="middle">Iis Aisyah, S.Pd, M.M.Pd</text>
                        </g>

                        <g>
                            <rect class="org-box" x="388" y="192" width="224" height="68"></rect>
                            <text class="org-title" x="500" y="211" text-anchor="middle">KEPALA SEKOLAH</text>
                            <text class="org-name" x="500" y="237" text-anchor="middle">Tina Wati, S.Pd</text>
                        </g>

                        <g>
                            <rect class="org-box" x="668" y="190" width="176" height="68"></rect>
                            <text class="org-title" x="756" y="212" text-anchor="middle">KOMITE</text>
                            <text class="org-name" x="756" y="238" text-anchor="middle">Rista Triyana</text>
                        </g>

                        <g>
                            <rect class="org-box" x="600" y="280" width="150" height="68"></rect>
                            <text class="org-title" x="675" y="303" text-anchor="middle">SEKRETARIS</text>
                            <text class="org-name" x="675" y="329" text-anchor="middle">Marlina</text>
                        </g>

                        <g>
                            <rect class="org-box" x="760" y="280" width="150" height="68"></rect>
                            <text class="org-title" x="835" y="303" text-anchor="middle">BENDAHARA</text>
                            <text class="org-name" x="835" y="329" text-anchor="middle">Melani</text>
                        </g>

                        <g>
                            <rect class="org-box" x="90" y="410" width="220" height="72"></rect>
                            <text class="org-title" x="200" y="435" text-anchor="middle">GURU KELOMPOK A</text>
                            <text class="org-name" x="200" y="462" text-anchor="middle">Vera Irawaty, S.Pd</text>
                        </g>

                        <g>
                            <rect class="org-box" x="390" y="410" width="220" height="72"></rect>
                            <text class="org-title" x="500" y="435" text-anchor="middle">GURU PENDAMPING</text>
                            <text class="org-name" x="500" y="462" text-anchor="middle">Serly Marliyana, SE</text>
                        </g>

                        <g>
                            <rect class="org-box" x="690" y="410" width="220" height="72"></rect>
                            <text class="org-title" x="800" y="435" text-anchor="middle">GURU KELOMPOK B</text>
                            <text class="org-name" x="800" y="462" text-anchor="middle">Nena, S.Pd</text>
                        </g>
                    </svg>
                </figure>
            </div>
        </div>
    </section>
</div>
@endsection
