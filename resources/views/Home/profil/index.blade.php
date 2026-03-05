@extends('layouts.frontend')

@section('content')
<main class="flex-1 flex flex-col items-center">
    <div class="w-full max-w-7xl px-6 lg:px-10 py-10">
        <!-- Hero/Sambutan Section -->
        <section class="flex flex-col gap-10 lg:flex-row items-center mb-24">
            <div class="w-full lg:w-1/2 aspect-[4/5] bg-slate-200 rounded-3xl overflow-hidden shadow-2xl relative" 
                 style='background-image: url("{{ $profil->kepsek_foto ?? "https://lh3.googleusercontent.com/aida-public/AB6AXuBSBipBW54agH2W1tFAX2pGBd8dSQrxA4OT9Fgh873K0o22CM-oqNSMmMyWi9Du5hP1Uqcdxc-11mAKJ_BSYUrD9rWPOztET91YJ1xjUlTYlqOjoboUMRZ1SOPPwibQtyi6sXI9aCZ03UkYqUeJMdMv0ivNunytwEX0r1mjSH8GgcS2wWW4YtOJHb7M8Yqt54-wUxzofubUFOuCpR7CeS_uo2vlY0S9QYItwHOguYpwOf261N9sHRfLxednlFI1-8XG5fg_y09zB_I" }}"); background-size: cover; background-position: center;'>
                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
            </div>
            <div class="flex flex-col gap-6 w-full lg:w-1/2">
                <div class="inline-flex items-center gap-2 text-primary font-bold tracking-wider text-sm uppercase">
                    <span class="h-px w-8 bg-primary"></span>
                    Kata Sambutan
                </div>
                <h1 class="text-slate-900 dark:text-slate-100 text-4xl font-black leading-tight tracking-[-0.033em] lg:text-5xl font-playful">
                    Sambutan Kepala Sekolah
                </h1>
                <div class="text-slate-600 dark:text-slate-400 text-base leading-relaxed space-y-4">
                    <p><strong>Assalamu’alaikum warahmatullahi wabarakatuh,</strong></p>
                    <p><strong>Salam sejahtera bagi kita semua,</strong></p>
                    <p>Puji syukur kita panjatkan ke hadirat Tuhan Yang Maha Esa, karena atas rahmat dan karunia-Nya, website resmi sekolah ini dapat hadir sebagai sarana informasi, komunikasi, dan transparansi bagi seluruh warga sekolah serta masyarakat luas.</p>
                    <p>Di era digital saat ini, keterbukaan informasi dan kemudahan akses menjadi kebutuhan yang sangat penting. Melalui website ini, kami berkomitmen untuk memberikan informasi yang akurat dan terpercaya mengenai profil sekolah, program akademik, kegiatan siswa, hingga layanan Penerimaan Peserta Didik Baru (PPDB). Kami berharap platform ini dapat menjadi jembatan yang mempererat hubungan antara sekolah, orang tua, siswa, dan masyarakat.</p>
                    <p>Sekolah bukan hanya tempat untuk menimba ilmu, tetapi juga tempat membangun karakter, menanamkan nilai-nilai integritas, kedisiplinan, serta semangat berprestasi. Kami terus berupaya meningkatkan mutu pendidikan, baik dari sisi akademik maupun pengembangan potensi siswa melalui berbagai kegiatan ekstrakurikuler dan pembinaan karakter.</p>
                    <p>Kami menyadari bahwa keberhasilan pendidikan tidak dapat dicapai tanpa dukungan dan kerja sama dari seluruh pihak. Oleh karena itu, kami mengajak orang tua dan masyarakat untuk bersama-sama mendukung program sekolah demi terciptanya generasi yang cerdas, berakhlak mulia, serta siap menghadapi tantangan masa depan.</p>
                    <p>Akhir kata, kami mengucapkan terima kasih atas kepercayaan dan dukungan yang telah diberikan kepada sekolah ini. Semoga website ini dapat memberikan manfaat yang sebesar-besarnya bagi kita semua.</p>
                    <p><strong>Wassalamu’alaikum warahmatullahi wabarakatuh.</strong></p>
                </div>
                <div class="flex flex-col gap-1 mt-4">
                    <p class="text-slate-900 dark:text-slate-100 font-bold text-xl">Tina Wati, S.Pd</p>
                    <p class="text-primary font-medium">Kepala Sekolah TK PGRI HARAPAN BANGSA 1</p>
                </div>
            </div>
        </section>

        <!-- Visi & Misi Section -->
        <section class="bg-primary/5 dark:bg-primary/10 rounded-3xl p-8 lg:p-16 mb-24 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-primary/10 rounded-full blur-3xl"></div>
            <div class="flex flex-col items-center text-center gap-4 mb-12">
                <h2 class="text-slate-900 dark:text-slate-100 text-4xl font-black tracking-tight font-playful">Visi & Misi</h2>
                <div class="h-1.5 w-24 bg-primary rounded-full"></div>
            </div>
            <div class="grid md:grid-cols-2 gap-10 relative z-10">
                <div class="bg-white dark:bg-slate-800 p-10 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-700">
                    <div class="w-14 h-14 bg-primary/20 text-primary rounded-2xl flex items-center justify-center mb-8">
                        <span class="material-symbols-outlined text-3xl">visibility</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 font-playful text-primary">Visi</h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed text-lg">
                        Terwujudnya anak yang cerdas, mandiri, dan berakhlak mulia dan siap menghadapi global dalam lingkungan belajar ramah, inklusif serta berbasis budaya lokal Bandung.
                    </p>
                </div>
                <div class="bg-white dark:bg-slate-800 p-10 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-700">
                    <div class="w-14 h-14 bg-secondary/20 text-secondary rounded-2xl flex items-center justify-center mb-8">
                        <span class="material-symbols-outlined text-3xl">track_changes</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 font-playful text-secondary">Misi</h3>
                    <ul class="space-y-4">
                        <li class="flex gap-4">
                            <span class="material-symbols-outlined text-secondary font-bold shrink-0">check_circle</span>
                            <span class="text-slate-600 dark:text-slate-400">Menyelenggarakan pembelajaran berbasis bermain yang berpusat pada anak, mendukung perkembangan identitas diri, berpikir aktif, dan kemampuan fondasi sesuai fase fondasi Kurikulum Merdeka.</span>
                        </li>
                        <li class="flex gap-4">
                            <span class="material-symbols-outlined text-secondary font-bold shrink-0">check_circle</span>
                            <span class="text-slate-600 dark:text-slate-400">Meningkatkan kompetensi pendidik melalui pelatihan berkelanjutan, kolaborasi, dan pemanfaatan assessment untuk memberikan pendampingan terdiferensiasi serta umpan balik konstruktif.</span>
                        </li>
                        <li class="flex gap-4">
                            <span class="material-symbols-outlined text-secondary font-bold shrink-0">check_circle</span>
                            <span class="text-slate-600 dark:text-slate-400">Membangun kemitraan aktif dengan orang tua, masyarakat, dan stakeholder lokal untuk mendukung perkembangan holistik anak, termasuk integrasi budaya Sunda dan nilai-nilai Pancasila dalam kegiatan sehari-hari.</span>
                        </li>
                        <li class="flex gap-4">
                            <span class="material-symbols-outlined text-secondary font-bold shrink-0">check_circle</span>
                            <span class="text-slate-600 dark:text-slate-400">Menciptakan ekosistem belajar yang aman, kreatif, dan merayakan kebinekaan, sesuai Standar Nasional Pendidikan serta rekomendasi Rapor Pendidikan untuk mengatasi tantangan seperti dukungan pendidik dan kemitraan orang tua.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Tujuan Sekolah Section -->
        <section class="mb-24">
            <div class="flex flex-col items-center text-center gap-4 mb-16">
                <h2 class="text-slate-900 dark:text-slate-100 text-4xl font-black tracking-tight font-playful">Tujuan Sekolah</h2>
                <div class="h-1.5 w-24 bg-accent rounded-full"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-8">
                <div class="group p-8 bg-white dark:bg-slate-800 rounded-3xl border-2 border-slate-50 dark:border-slate-700 hover:border-primary/30 transition-all hover:shadow-2xl hover:-translate-y-2">
                    <div class="w-16 h-16 bg-accent/10 text-accent rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-3xl">psychology</span>
                    </div>
                    <h4 class="text-xl font-bold mb-4 font-playful">Kualitas Pembelajaran</h4>
                    <p class="text-slate-600 dark:text-slate-400">Meningkatkan kualitas pembelajaran untuk mendukung identitas diri dan berpikir aktif dan kemampuan pondasi.</p>
                </div>
                <div class="group p-8 bg-white dark:bg-slate-800 rounded-3xl border-2 border-slate-50 dark:border-slate-700 hover:border-primary/30 transition-all hover:shadow-2xl hover:-translate-y-2">
                    <div class="w-16 h-16 bg-primary/10 text-primary rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-3xl">local_library</span>
                    </div>
                    <h4 class="text-xl font-bold mb-4 font-playful">Profesionalisme</h4>
                    <p class="text-slate-600 dark:text-slate-400">Meningkatkan kualitas pelajaran, pedagogik dan profesionalisme pendidik.</p>
                </div>
                <div class="group p-8 bg-white dark:bg-slate-800 rounded-3xl border-2 border-slate-50 dark:border-slate-700 hover:border-primary/30 transition-all hover:shadow-2xl hover:-translate-y-2">
                    <div class="w-16 h-16 bg-secondary/10 text-secondary rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-3xl">family_restroom</span>
                    </div>
                    <h4 class="text-xl font-bold mb-4 font-playful">Kemitraan Orang Tua</h4>
                    <p class="text-slate-600 dark:text-slate-400">Meningkatkan partisipasi orang tua dalam kegiatan kemitraan.</p>
                </div>
                <div class="group p-8 bg-white dark:bg-slate-800 rounded-3xl border-2 border-slate-50 dark:border-slate-700 hover:border-primary/30 transition-all hover:shadow-2xl hover:-translate-y-2">
                    <div class="w-16 h-16 bg-green-500/10 text-green-500 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-3xl">verified</span>
                    </div>
                    <h4 class="text-xl font-bold mb-4 font-playful">Standar Nasional</h4>
                    <p class="text-slate-600 dark:text-slate-400">Memastikan keselarasan dengan 8 Standar Nasional Pendidikan melalui pengelolaan sumber daya yang efektif.</p>
                </div>
            </div>
        </section>

        <!-- Profil Sekolah (Identitas, PTK, KBM) -->
        <section class="mb-24">
            <div class="flex flex-col items-center text-center gap-4 mb-16">
                <h2 class="text-slate-900 dark:text-slate-100 text-4xl font-black tracking-tight font-playful">Profil Sekolah</h2>
                <div class="h-1.5 w-24 bg-primary rounded-full"></div>
            </div>

            <div class="grid lg:grid-cols-2 gap-10">
                <!-- Identitas Sekolah -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl overflow-hidden border border-slate-100 dark:border-slate-700 h-full">
                    <div class="bg-primary px-8 py-6">
                        <h3 class="text-white text-xl font-bold font-playful flex items-center gap-2">
                            <span class="material-symbols-outlined">badge</span>
                            Identitas Sekolah
                        </h3>
                    </div>
                    <div class="p-6 sm:p-8 space-y-4">
                        <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-100 dark:border-slate-700 pb-3 gap-2">
                            <span class="text-slate-500 dark:text-slate-400">Nama Sekolah</span>
                            <span class="font-bold sm:text-right">TK PGRI HARAPAN BANGSA 1</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-100 dark:border-slate-700 pb-3 gap-2">
                            <span class="text-slate-500 dark:text-slate-400">NPSN</span>
                            <span class="font-bold sm:text-right">20255202</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-100 dark:border-slate-700 pb-3 gap-2">
                            <span class="text-slate-500 dark:text-slate-400">Jenjang Pendidikan</span>
                            <span class="font-bold sm:text-right">Taman Kanak-Kanak (TK)</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-100 dark:border-slate-700 pb-3 gap-2">
                            <span class="text-slate-500 dark:text-slate-400">Status Sekolah</span>
                            <span class="font-bold sm:text-right">Swasta</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-100 dark:border-slate-700 pb-3 gap-2">
                            <span class="text-slate-500 dark:text-slate-400">Status Akreditasi</span>
                            <span class="font-bold sm:text-right">B</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between pt-1 gap-2">
                            <span class="text-slate-500 dark:text-slate-400 whitespace-nowrap mr-4">Alamat Sekolah</span>
                            <span class="font-bold sm:text-right">JL. Terusan PSM No. 1A, Kel. Sukapura, Kec. Kiaracondong, Kota Bandung, Jawa Barat</span>
                        </div>
                    </div>
                </div>

                <!-- Pendidik dan Tenaga Kependidikan -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl overflow-hidden border border-slate-100 dark:border-slate-700 h-full">
                    <div class="bg-secondary px-8 py-6">
                        <h3 class="text-white text-xl font-bold font-playful flex items-center gap-2">
                            <span class="material-symbols-outlined">groups</span>
                            Pendidik & Tenaga Kependidikan
                        </h3>
                    </div>
                    <div class="p-6 sm:p-8 space-y-4">
                        <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-100 dark:border-slate-700 pb-3 gap-2">
                            <span class="text-slate-500 dark:text-slate-400">Kepala Sekolah</span>
                            <span class="font-bold sm:text-right">1 Orang</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-100 dark:border-slate-700 pb-3 gap-2">
                            <span class="text-slate-500 dark:text-slate-400">Guru Kelas</span>
                            <span class="font-bold sm:text-right">2 Orang</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-100 dark:border-slate-700 pb-3 gap-2">
                            <span class="text-slate-500 dark:text-slate-400">Guru Pendamping</span>
                            <span class="font-bold sm:text-right">1 Orang</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-100 dark:border-slate-700 pb-3 gap-2 items-start sm:items-center">
                            <span class="text-slate-500 dark:text-slate-400">Memiliki Sertifikat Pendidik</span>
                            <span class="font-bold sm:text-right bg-green-100 text-green-700 px-2 py-0.5 rounded text-sm">Ya</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-100 dark:border-slate-700 pb-3 gap-2">
                            <span class="text-slate-500 dark:text-slate-400">Pembinaan dan Evaluasi</span>
                            <span class="font-bold sm:text-right">Rutin</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between pt-1 gap-2">
                            <span class="text-slate-500 dark:text-slate-400">Pengembangan Kompetensi</span>
                            <span class="font-bold sm:text-right">Rutin</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kegiatan Belajar Mengajar -->
            <div class="mt-10">
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl overflow-hidden border border-slate-100 dark:border-slate-700">
                    <div class="bg-accent px-8 py-6">
                        <h3 class="text-white text-xl font-bold font-playful flex items-center gap-2">
                            <span class="material-symbols-outlined">event_note</span>
                            Kegiatan Belajar Mengajar (KBM)
                        </h3>
                    </div>
                    <div class="p-6 sm:p-8">
                        <div class="grid md:grid-cols-2 gap-x-12 gap-y-4">
                            <div class="flex flex-col xl:flex-row xl:justify-between border-b border-slate-100 dark:border-slate-700 pb-3 gap-1">
                                <span class="text-slate-500 dark:text-slate-400">Waktu Penyelenggaraan</span>
                                <span class="font-bold xl:text-right">5 Hari dalam seminggu</span>
                            </div>
                            <div class="flex flex-col xl:flex-row xl:justify-between border-b border-slate-100 dark:border-slate-700 pb-3 gap-1">
                                <span class="text-slate-500 dark:text-slate-400">Awal Tahun Ajaran</span>
                                <span class="font-bold xl:text-right">Juli</span>
                            </div>
                            <div class="flex flex-col xl:flex-row xl:justify-between border-b border-slate-100 dark:border-slate-700 pb-3 gap-1">
                                <span class="text-slate-500 dark:text-slate-400">Jumlah Siswa per Tahun</span>
                                <span class="font-bold xl:text-right">± 50 Siswa</span>
                            </div>
                            <div class="flex flex-col xl:flex-row xl:justify-between border-b border-slate-100 dark:border-slate-700 pb-3 gap-1">
                                <span class="text-slate-500 dark:text-slate-400">Jumlah Rombongan Belajar</span>
                                <span class="font-bold xl:text-right">2</span>
                            </div>
                            <div class="flex flex-col xl:flex-row xl:justify-between border-b border-slate-100 dark:border-slate-700 pb-3 gap-1">
                                <span class="text-slate-500 dark:text-slate-400">Jenis Kurikulum</span>
                                <span class="font-bold xl:text-right">Merdeka Belajar</span>
                            </div>
                            <div class="flex flex-col xl:flex-row xl:justify-between border-b border-slate-100 dark:border-slate-700 pb-3 gap-1">
                                <span class="text-slate-500 dark:text-slate-400">Acuan</span>
                                <span class="font-bold xl:text-right">Kemendikdasmen</span>
                            </div>
                            <div class="flex flex-col xl:flex-row xl:justify-between border-b border-slate-100 dark:border-slate-700 pb-3 gap-1">
                                <span class="text-slate-500 dark:text-slate-400 shrink-0">Penguatan</span>
                                <span class="font-bold xl:text-right xl:truncate xl:ml-4" title="Pendidikan Holistik Berbasis Karakter, Penerapan Layanan PAUD HIBER">Pendidikan Holistik Berbasis Karakter, Penerapan Layanan PAUD HIBER</span>
                            </div>
                            <div class="flex flex-col xl:flex-row xl:justify-between border-b border-slate-100 dark:border-slate-700 pb-3 gap-1">
                                <span class="text-slate-500 dark:text-slate-400 shrink-0">Status Sekolah</span>
                                <span class="font-bold xl:text-right xl:truncate xl:ml-4" title="Piloting PAUD Percontohan Rujukan Dinas Pendidikan">Piloting PAUD Percontohan Rujukan Dinas Pendidikan</span>
                            </div>
                            <div class="flex flex-col xl:flex-row xl:justify-between border-b border-slate-100 dark:border-slate-700 pb-3 gap-1">
                                <span class="text-slate-500 dark:text-slate-400">Proses Pembelajaran</span>
                                <span class="font-bold xl:text-right">Pembelajaran Berbasis Bermain</span>
                            </div>
                            <div class="flex flex-col xl:flex-row xl:justify-between border-b border-slate-100 dark:border-slate-700 pb-3 gap-1 items-start xl:items-center">
                                <span class="text-slate-500 dark:text-slate-400">Program Parenting</span>
                                <span class="font-bold xl:text-right bg-green-100 text-green-700 px-2 py-0.5 rounded text-sm">Ya</span>
                            </div>
                            <div class="flex flex-col xl:flex-row xl:justify-between border-b border-slate-100 dark:border-slate-700 pb-3 md:pb-0 md:border-transparent gap-1 items-start xl:items-center">
                                <span class="text-slate-500 dark:text-slate-400">Laporan Perkembangan Rutin</span>
                                <span class="font-bold xl:text-right bg-green-100 text-green-700 px-2 py-0.5 rounded text-sm">Ya</span>
                            </div>
                            <div class="flex flex-col xl:flex-row xl:justify-between pb-3 md:pb-0 gap-1">
                                <span class="text-slate-500 dark:text-slate-400">Kegiatan Ekstrakurikuler</span>
                                <span class="font-bold xl:text-right">Ada</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Pendidik Section (Guru List) -->
        @if(isset($gurus) && count($gurus) > 0)
        <section class="mb-24">
            <div class="flex flex-col items-center text-center gap-4 mb-12">
                <h2 class="text-slate-900 dark:text-slate-100 text-4xl font-black tracking-tight font-playful">Galeri Tenaga Pendidik</h2>
                <div class="h-1.5 w-24 bg-secondary rounded-full"></div>
            </div>
            <div class="flex flex-col gap-10">
                <div class="flex gap-6 overflow-x-auto pb-8 pt-4 custom-scrollbar">
                    @foreach($gurus as $guru)
                    <div class="flex-none w-48 group text-center">
                        <div class="w-40 h-40 mx-auto bg-slate-200 rounded-3xl mb-4 overflow-hidden border-4 border-white dark:border-slate-800 shadow-lg group-hover:scale-105 transition-transform" 
                             style='background-image: url("{{ $guru->foto ? asset('storage/' . $guru->foto) : "https://lh3.googleusercontent.com/aida-public/AB6AXuD9c2aGhkF8awtKaYgGpUmnKIGLohPn5QIm7-STxW1-okvvd_6l0X2cIXYQ2xX-vZVBoFYtGsjr3_TtFVn8QjP9OZHqeNQ4dnzZTFkM8qLjN-pV8YBl5fUbo4oghny-21vbp6RN-VTPPqI8w-HhekCPHJ3V6sqyHoW9lX8bqjXo_-5shYQY1NT1bEEL3avsaMz1qpMsGE46Aw3xl7fNvHVR9q-Mby4lMB5aSIfrJnDl7AtCu7Ry9AAIT6j3YzSsVSAKdq-y1n-MuQI" }}"); background-size: cover; background-position: center;'></div>
                        <h5 class="font-bold text-slate-800 dark:text-white">{{ $guru->nama }}</h5>
                        <p class="text-xs text-primary font-bold">{{ $guru->jabatan ?? 'Guru' }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
    </div>
</main>
@endsection
