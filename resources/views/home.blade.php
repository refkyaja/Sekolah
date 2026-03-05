@extends('layouts.frontend')

@section('content')
<!-- Hero Section -->
<section class="relative bg-accent-blue dark:bg-slate-800 pt-16 pb-32 wavy-bg overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center relative z-10">
        <div class="space-y-6">
            <h1 class="text-5xl md:text-7xl font-bold text-primary dark:text-white leading-tight">
                Come & Learn <br/>With Us
            </h1>
            <p class="text-xl text-slate-600 dark:text-slate-300 leading-relaxed max-w-lg">
                The Trilingual Kids classroom provides a nurturing environment and diverse opportunities for children to find themselves and learn about themselves. Both online and offline formats, integrate fun activities for learners.
            </p>
            <div class="pt-4">
                <a href="{{ route('ppdb.index') }}" class="inline-flex bg-primary text-white items-center gap-3 px-8 py-4 rounded-xl font-bold text-lg hover:translate-y-[-2px] transition-all shadow-xl">
                    Enroll Now
                    <span class="material-icons">chevron_right</span>
                </a>
            </div>
        </div>
        <div class="relative">
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-accent-pink rounded-full blur-2xl opacity-50 bubble-float"></div>
            <div class="absolute -bottom-10 -left-10 w-24 h-24 bg-accent-yellow rounded-full blur-2xl opacity-50 bubble-float" style="animation-delay: 2s"></div>
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-4 pt-8">
                    <img alt="Kids playing" class="rounded-3xl shadow-lg border-4 border-white dark:border-slate-700" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCMFLetxjrt6ca4qUdbTxjAHCZphdvSXzKeJnak6Dbz9COgf4wt0qf7QEDZD5R5XuZtcLzrCdj43WnJY3Lr2gWpQYFztuk5xPk4Q7BLqSqbm5DwhZWuFyjK-alQI0fnW4tgmcuTOhCyYkq3hnhYNxWwdx1wV9e5E3f_ozbrkRD0cHhNyZ1RNXCyTpKFKdFjq_tCbwcxO7VSqcFyTT1xafa9ynlaIU8GnxU9dBUumkXj-cucr3JP4TogXsaLuIEyquM2ndKI8Lpef2Y"/>
                    <img alt="Learning together" class="rounded-3xl shadow-lg border-4 border-white dark:border-slate-700" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCZ74ZR5Tvzm6chcDq7yxnSbf9jV3TkB-bmwdTPbRRC5GlYPaoBHNGo7_nc8Z_FzgRB0JILfgTWWuiiYkIrlGhZOlX0PkfnicbjToK5O-GCyQ0d4atz8cnSKq_1wkLo6-Z1y1NJjHNqPng9HJKY_Ox8sh21YUSgvB-XXHb8yMRVpS65F8FInwikb0q4Suoft3uAz7W8zUIAhSFk3wJkDAGEVXKOFwTRMn6DrDnmQrc163G_LqJSXxS9ocZNcgpbUwA8E7wSfv0ODc8"/>
                </div>
                <div class="space-y-4">
                    <img alt="Art project" class="rounded-3xl shadow-lg border-4 border-white dark:border-slate-700 h-64 object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAuLJDtI4804DagegH-zhFeUuotQPNympD9gniGLsH-2soGy19STDhQLxXdOjPKPD5u5RX7eTSR4CkPKpqIuxusBNCca5Ly4x0Bfq9DCaYhEgMDrjk0l30ojJBEhFpWy-IuKktFFoio2hya6rax-WNaPclQomTpBMQxkAH30e9KRddkfxUsOlX5pqAuXHEPI04HdXMkTgtdCugJX96CQCdot_5I2PX-u9THNbLRp0JcTNHOv2WCDqPNzSTQ7a2KQnWNEm3Pxb-XkfY"/>
                    <img alt="Outdoor activity" class="rounded-3xl shadow-lg border-4 border-white dark:border-slate-700" src="https://lh3.googleusercontent.com/aida-public/AB6AXuARB-0DpIbnay5ToahMxpL9VnO4082zYezQjctrvkAxzFcyZz5l77B2v15E7MdLxPB1r_q4HSzdIclm-yCTb138Oz5NQcelVix24oQK5XYAdC1kE1LiLAbfJY2-AT3A4QAIeTLgQ35708TXruBII0wunepUvguG1MOVA19VTyFZ_vQjG8w_ouZybmApZ0-4ojuqnJGRRXHeCFn5tI9L9oTcSd9xHy5j0lQEdVV_7dQH-bVWi_Wcv4cVx9BD-O4cz0bRLPmfEJ7XKrc"/>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Info Bar -->
<div class="max-w-4xl mx-auto -mt-16 relative z-20 px-6">
    <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-2xl p-8 grid md:grid-cols-2 gap-8 divide-y md:divide-y-0 md:divide-x dark:divide-slate-800">
        <div class="flex items-center gap-6 md:justify-center">
            <div class="w-14 h-14 bg-accent-blue/40 rounded-2xl flex items-center justify-center text-primary">
                <span class="material-icons text-3xl">email</span>
            </div>
            <div>
                <h4 class="font-bold text-slate-500 text-sm uppercase tracking-wider">Email</h4>
                <p class="text-lg font-bold">trilingualkids@gmail.com</p>
            </div>
        </div>
        <div class="flex items-center gap-6 md:justify-center pt-6 md:pt-0">
            <div class="w-14 h-14 bg-accent-pink/40 rounded-2xl flex items-center justify-center text-pink-600">
                <span class="material-icons text-3xl">phone</span>
            </div>
            <div>
                <h4 class="font-bold text-slate-500 text-sm uppercase tracking-wider">Call Now</h4>
                <p class="text-lg font-bold">+62-8172-0112</p>
            </div>
        </div>
    </div>
</div>

<!-- Our Programs Section -->
<section class="py-24 px-6 max-w-7xl mx-auto">
    <div class="text-center mb-16 space-y-4">
        <h4 class="text-primary font-bold uppercase tracking-[0.2em] text-sm">Educational Excellence</h4>
        <h2 class="text-4xl md:text-5xl font-bold text-slate-900 dark:text-white">Our Programs</h2>
    </div>
    
    <div class="grid md:grid-cols-3 gap-8">
        @forelse($programs as $program)
        <div class="group {{ $program->warna_bg ?? 'bg-accent-yellow' }} dark:bg-yellow-900/20 rounded-[2.5rem] p-8 text-center transition-all hover:scale-105 shadow-xl {{ $program->warna_shadow ?? 'shadow-yellow-100' }} dark:shadow-none relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-white/20 rounded-full"></div>
            <div class="h-48 flex items-center justify-center mb-6">
                @if($program->icon_text)
                <div class="text-6xl font-display font-bold {{ $program->warna_text ?? 'text-yellow-600' }} dark:text-yellow-400">
                    {!! $program->icon_text !!}
                </div>
                @else
                <img src="{{ asset('storage/' . $program->gambar) }}" class="h-32 object-contain" alt="{{ $program->nama }}"/>
                @endif
            </div>
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur rounded-2xl p-6">
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-2">{{ $program->nama }}</h3>
                <p class="text-slate-600 dark:text-slate-400 text-sm">{{ $program->deskripsi }}</p>
            </div>
        </div>
        @empty
        <!-- Static Fallback if no programs in DB -->
        <div class="group bg-accent-yellow dark:bg-yellow-900/20 rounded-[2.5rem] p-8 text-center transition-all hover:scale-105 shadow-xl shadow-yellow-100 relative overflow-hidden">
            <div class="h-48 flex items-center justify-center mb-6 text-8xl font-display font-bold text-yellow-600">क<br/>ग</div>
            <div class="bg-white/80 dark:bg-slate-800/80 rounded-2xl p-6">
                <h3 class="text-2xl font-bold mb-2">Hindi</h3>
                <p class="text-slate-600 text-sm">Exploring rich culture and language through play.</p>
            </div>
        </div>
        <div class="group bg-accent-pink dark:bg-pink-900/20 rounded-[2.5rem] p-8 text-center transition-all hover:scale-105 shadow-xl shadow-pink-100 relative overflow-hidden">
            <div class="h-48 flex items-center justify-center mb-6 text-8xl font-display font-bold text-pink-500">B<br/>C</div>
            <div class="bg-white/80 dark:bg-slate-800/80 rounded-2xl p-6">
                <h3 class="text-2xl font-bold mb-2">French/Spanish</h3>
                <p class="text-slate-600 text-sm">Interactive language learning for global citizens.</p>
            </div>
        </div>
        <div class="group bg-accent-purple dark:bg-purple-900/20 rounded-[2.5rem] p-8 text-center transition-all hover:scale-105 shadow-xl shadow-purple-100 relative overflow-hidden">
            <div class="h-48 flex items-center justify-center mb-6 text-8xl font-display font-bold text-purple-600">1 2<br/>3 4</div>
            <div class="bg-white/80 dark:bg-slate-800/80 rounded-2xl p-6">
                <h3 class="text-2xl font-bold mb-2">Math</h3>
                <p class="text-slate-600 text-sm">Building logical thinking and problem solving.</p>
            </div>
        </div>
        @endforelse
    </div>
    
    <div class="mt-12 text-center">
        <a href="#" class="inline-block bg-primary text-white px-10 py-3 rounded-full font-bold hover:shadow-lg transition-all">View All Programs</a>
    </div>
</section>

<!-- Testimonials Section -->
<section class="bg-accent-yellow/30 dark:bg-slate-900 py-24 px-6 overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center gap-4 mb-12">
            <span class="text-7xl font-display text-accent-yellow leading-none">“</span>
            <h2 class="text-4xl md:text-5xl font-bold text-slate-900 dark:text-white uppercase tracking-tight">Testimonials</h2>
        </div>
        <div class="grid md:grid-cols-2 gap-8">
            @forelse($testimonis as $index => $testimoni)
                @if($index == 0)
                <div class="bg-white dark:bg-slate-800 p-10 rounded-3xl shadow-lg border-b-8 {{ $testimoni->warna_border ?? 'border-accent-yellow' }}">
                    <p class="text-lg italic text-slate-600 dark:text-slate-300 mb-8 leading-relaxed">
                        "{{ $testimoni->pesan }}"
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-slate-200 rounded-full overflow-hidden">
                            @if($testimoni->foto)
                            <img alt="{{ $testimoni->nama }}" src="{{ asset('storage/' . $testimoni->foto) }}" class="w-full h-full object-cover"/>
                            @else
                            <div class="w-full h-full bg-gray-300 flex items-center justify-center"><i class="material-icons text-gray-500">person</i></div>
                            @endif
                        </div>
                        <div>
                            <h5 class="font-bold text-primary dark:text-accent-yellow">{{ $testimoni->nama }}</h5>
                            <p class="text-sm text-slate-500">{{ $testimoni->peran }}</p>
                        </div>
                    </div>
                </div>
                <div class="space-y-8">
                @else
                    <div class="bg-white dark:bg-slate-800 p-8 rounded-3xl shadow-lg border-b-8 {{ $testimoni->warna_border ?? ($index == 1 ? 'border-accent-pink' : 'border-accent-purple') }}">
                        <p class="text-slate-600 dark:text-slate-300 leading-relaxed mb-4">"{{ Str::limit($testimoni->pesan, 100) }}"</p>
                        <h5 class="font-bold text-primary">{{ $testimoni->nama }}</h5>
                    </div>
                @endif
                @if($loop->last && $index > 0)
                </div>
                @endif
            @empty
                <!-- Fallback Static Testimonials -->
                <div class="bg-white dark:bg-slate-800 p-10 rounded-3xl shadow-lg border-b-8 border-accent-yellow">
                    <p class="text-lg italic text-slate-600 dark:text-slate-300 mb-8 leading-relaxed">"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tincidunt bibendum sapien, aliquam sit sed massa rhoncus, non."</p>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-slate-200 rounded-full overflow-hidden"><img src="https://lh3.googleusercontent.com/aida-public/AB6AXuBjZ1cWo6TyiSI5vlXCXwi_KJqMmgiOMuOUtFC4k9SyNHCNt3I_3AySQIhhzgeuHY4KjytLmAs11Y9mdw6jTJEF_rgacdtTEDpObM_N3BzFKrpTFHU6wq5vFWm_Y03RzsAlLMHh8jSAiODAojxjgTSCoo6g_2rs5meZmD3RGx17b-Z9hXPDU6k_Pa_KL9hQGJ4mIVpoo2CaYld7k2-4Rdnu0_vevHuNH7CZgS2EDHfbjmq-hg7pvy1KCEhaNRt-b_RcDhdtkpdFoko" alt="Person"/></div>
                        <div><h5 class="font-bold text-primary">Floyd Miles</h5><p class="text-sm text-slate-500">Parent</p></div>
                    </div>
                </div>
                <div class="space-y-8">
                    <div class="bg-white dark:bg-slate-800 p-8 rounded-3xl shadow-lg border-b-8 border-accent-pink"><p class="text-slate-600 dark:text-slate-300 mb-4">"Ultrices mi sem non urna. Curabitur aliquet quam id dui posuere blandit."</p><h5 class="font-bold text-primary">Jane Cooper</h5></div>
                    <div class="bg-white dark:bg-slate-800 p-8 rounded-3xl shadow-lg border-b-8 border-accent-purple"><p class="text-slate-600 dark:text-slate-300 mb-4">"Maecenas interdum, metus vitae tincidunt porttitor."</p><h5 class="font-bold text-primary">Kristin Watson</h5></div>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="py-24 px-6 max-w-7xl mx-auto">
    <h2 class="text-4xl font-bold text-slate-900 dark:text-white mb-12">Gallery</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @forelse($galeris as $index => $galeri)
            @if($index % 2 == 0) <div class="space-y-4 {{ $index % 4 == 2 ? 'pt-8' : '' }}"> @endif
                <img alt="{{ $galeri->judul }}" src="{{ asset('storage/' . $galeri->gambar) }}" class="rounded-2xl w-full {{ $index % 3 == 0 ? 'h-64' : 'h-48' }} object-cover"/>
            @if($index % 2 == 1 || $loop->last) </div> @endif
            @if($index >= 7) @break @endif
        @empty
            <!-- Static Fallback -->
            <div class="space-y-4">
                <img class="rounded-2xl w-full h-64 object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBq1C9x7KGfqIdz2IQwsDaAsvf7c4NlB-l9XMWN6VJ0g-weVIGurDRuuhK0k1B98p_h75ivnNVoxs5NbmEibpZ7lbxW_gnHN-jX1xHV5twWOGGQnpeynQ80h4TnfVh5ybdPsZ88zMxK2Gar8tnNeYMlLL7XFYMnkOQj1b4O9q5LKNE8vNuLRcc6an_-Ma2E2pvZe2mqnMRItJ-LD7rrd3fcwuf7xx31ZgJ88fBRnavYhQGUalaPkEqvzWP7RgqIEvBEvwKgoKfZcOQ" alt="Gallery"/>
                <img class="rounded-2xl w-full h-48 object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC90jzOab7eCKtC9WrccxT1W3EYKmQuM8CiO25JgObzigsuj-KFrt_BKlGswB29XtVtzupF5zRYIB9zWxGT8tAv4FmDeqkewVaLpuNnvZxSnQb1mI6YNENnTx5aWd6XmWahtVe_605e3Ax-RJRaHYpXlvnXBkK4a_DSYR-DIq6lhR8IDK1ZHYT0CzgC7HXPU8DFjutkZ-dQenrg5sTg52-ei2kW_Z3SPowgZaqHZe71TQS674F-LqK3H8LBbiQmzfnGnraYfPzJjY0" alt="Gallery"/>
            </div>
            <div class="space-y-4 pt-8">
                <img class="rounded-2xl w-full h-48 object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCqBsM3FHx4wTGWyYIraZIZOEvjUYsrnMYe1UNFDEa06bUBh113edmCTzoEvnu6agwAsNsRvu5vPcCfV2c6k0UjnudL9x9ygnCk42j47M8eN5LvrD6U80VvUNz2-uq9IIx277myssfyktHqvpLEEzJl5Xn7gVW4At-cQBNnVj-nKI7w3K-Dy23ce4qf660WD76tWlyqM7a5yrjy9VkZDX4iXkBjwp-F88oO4gdb73t8MjEroVldhzQEG_ICleLVGM19k8DJiPHoP0c" alt="Gallery"/>
                <img class="rounded-2xl w-full h-64 object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCJ1DHFZXDPX-Gpb801_9onl4ZA1xvG55O7xQ9zFMiLx-SbYfNSDU0PMPhwEvk0TIgeqCK-FAi_4Z15meuQcqYWsZSG23-KkQJEKvj3DgCeSePOrW2fEN4eF6T_jPjCa2KsfXamVRy6S66Cg6Ul_7TtutivpN3vT1Z3QABuj7i07iF_fZAsXZBL7l7yyrV6kAoQ5W45xegRQLTJTirJugXmlauEOtvzboM6DprgGSIU1qXZ8nyYChEay3gPWc01icCISTgLteExkno" alt="Gallery"/>
            </div>
            <div class="space-y-4">
                <img class="rounded-2xl w-full h-80 object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCFD3GLeoxS8nBl8GFQb9TqbwuEKy46AwNvHKwmlT-5BpLhaVesEdexMwppKw62idUA57Tn9aHziRvsEW0L3a6aHYt9ep7rx_iTSFvrneoxRzonkTb4BjY0JvbA4PrurYbHHwawwjHCkxgwLIxEbWD413zNHvRssvkJduVOgAL-DLFmd013iu10BvkwU9_1o-taJVWuOF2_hr4wXtiZCk0EMK4utNiORr9EGeEZRo1kxQjGZa98XYbPyL6nFqGgvdATN6XuHkCcaI4" alt="Gallery"/>
                <img class="rounded-2xl w-full h-32 object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCJB-24bwGAsTkXuhGH8CKe49regZlY6FdnPq6cFTV3qumIL3-z09-rzaxRMHr2qF7lmFQ5AS7rLW4tUuWOe0C2afMMaMlY_XDxqHkGvkThqE8GeRmjFMl4WrheZ9CO03usYlafL6RcJNSIS-EA849F8qPxRXC7Uwof1-6r9Ond3SP44Z2FcYQ4vHZIFe-KNkNvNwR3C9oVqwkgZnWVUJARCSxJbBwUyW_eJzzP4MjWeKnNE9CU13hrrtZ6_a2lYH3Gt5VD_SiGOxw" alt="Gallery"/>
            </div>
            <div class="space-y-4 pt-8">
                <img class="rounded-2xl w-full h-48 object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBjL5k9zAUv_mDpSgJHwYXCzgPaw3nHvQId8EAfXn0PtlXaEwaynhE6h8YxpW0R2d5u3VgS1tcLpb5NVKrRjDljYMHFEX3Fq6LEyNy-sCSzL7x-MVZAFD7zx4Q6oCLiBwKTIY06wqiAHQd2n_ofVoDQrTzRQki1tp-sx28CvuVT1LmteR3gsYfFjjEpqCaldXfOncjo9NRpAB3CGeIMGsEDOBOxm4OaxnboGfa7-tZBax6MUJ_g-fNZFyt5BTa9jQRzD1_9T8T_8nA" alt="Gallery"/>
                <img class="rounded-2xl w-full h-64 object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD98rzIeiWXCyULuDeS92CspAMSZPKgkXxS85UbLSUwL92M7cu5iHkIvwy1TPy8iCN81PqxFu9oT2IesOHnh4hv9gW2k52z9DfSLhTGv1VG69F4nzF6HyaWwAZkPIX-SohLjU4UMEQ0uFBcGQ99UAE-EOsz2l7MmKQ1IZ_0-lXcmn5uDlp2B18__J4AtYAsZp8c1EJuKfIP0sLjZXErllFewEnXJkRzb-hSvG5WNfD4G4aVwI5_T2X2Ar06FtpGyqQXzLYOzL8ETnA" alt="Gallery"/>
            </div>
        @endforelse
    </div>
</section>

<!-- Call to Action Section -->
<section class="max-w-7xl mx-auto px-6 pb-24">
    <div class="bg-accent-blue/20 dark:bg-slate-800 rounded-[3rem] p-12 flex flex-col md:flex-row items-center gap-12 border-4 border-dashed border-accent-blue">
        <div class="md:w-1/3">
            <img alt="Happy student" class="rounded-[2rem] shadow-2xl rotate-3" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA0Xh7xkz95Cn-ukCaAO-PdIyn5y2P4tjEuJd5yzgl9wSpJm-qH0llO7okWliqbprfAEhBEcysULGn0z4ChxduBaL77lCF6Te35cWK52jArgiUoecq1hOyQa32-Rbb9xy8WVES0ybeNnbW4BK8MDBiyokBf6mpprI0nvM1J4XDppvLh_B9OQ82IuLnKwAcLDPxfKtEE2IIWnEMG_uu2WPx2RGHdnqVr9AVLaMJii2Ugmzw-2gde9GQr_GeSzUQHpbjB38zWOdJoUAw"/>
        </div>
        <div class="md:w-2/3 space-y-6">
            <h3 class="text-4xl font-bold text-primary dark:text-white">Come & Learn With Us</h3>
            <p class="text-lg text-slate-600 dark:text-slate-400">Join our vibrant community where every child's curiosity is nurtured and every dream is given wings. Enroll your child today for a brighter tomorrow!</p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('ppdb.index') }}" class="bg-primary text-white px-8 py-4 rounded-2xl font-bold text-lg hover:shadow-xl transition-all">Enroll Now</a>
                <button class="bg-white dark:bg-slate-700 text-primary dark:text-white border-2 border-primary dark:border-slate-600 px-8 py-4 rounded-2xl font-bold text-lg hover:bg-primary hover:text-white transition-all">Contact Us</button>
            </div>
        </div>
    </div>
</section>

<!-- Guestbook Section -->
<section id="bukutamu-section" class="py-24 px-6 max-w-7xl mx-auto">
    <div class="bg-accent-pink/20 dark:bg-pink-900/10 rounded-[3rem] p-8 md:p-16 relative overflow-hidden">
        <!-- Decorative background elements -->
        <div class="absolute -top-20 -right-20 w-64 h-64 bg-accent-yellow/40 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-accent-purple/40 rounded-full blur-3xl"></div>
        <div class="relative z-10">
            <div class="text-center mb-12 space-y-4">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white dark:bg-slate-800 rounded-2xl shadow-lg transform -rotate-6 mb-4">
                    <span class="material-icons text-pink-500 text-3xl">auto_stories</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-slate-900 dark:text-white">Buku Tamu</h2>
                <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">Bagikan kesan dan pesan Anda setelah berkunjung ke KiddyLearn!</p>
            </div>
            
            @if(session('success'))
            <div class="max-w-3xl mx-auto mb-8 bg-green-100 dark:bg-green-900 border border-green-400 text-green-700 dark:text-green-300 px-4 py-3 rounded-2xl relative">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <form action="{{ route('buku-tamu.home') }}" method="POST" class="max-w-3xl mx-auto space-y-6">
                @csrf
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 ml-2">Nama Lengkap</label>
                        <input name="nama" value="{{ old('nama') }}" required class="w-full px-6 py-4 rounded-2xl border-none bg-white dark:bg-slate-800 focus:ring-4 focus:ring-accent-pink/50 shadow-sm" placeholder="Masukkan nama Anda" type="text"/>
                        @error('nama') <p class="text-red-500 text-xs mt-1 ml-2">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 ml-2">Email</label>
                        <input name="email" value="{{ old('email') }}" class="w-full px-6 py-4 rounded-2xl border-none bg-white dark:bg-slate-800 focus:ring-4 focus:ring-accent-pink/50 shadow-sm" placeholder="email@anda.com" type="email"/>
                        @error('email') <p class="text-red-500 text-xs mt-1 ml-2">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 ml-2">Status</label>
                    <select name="status" required class="w-full px-6 py-4 rounded-2xl border-none bg-white dark:bg-slate-800 focus:ring-4 focus:ring-accent-pink/50 shadow-sm">
                        <option value="">Pilih Status</option>
                        <option value="parent" {{ old('status') == 'parent' ? 'selected' : '' }}>Orang Tua</option>
                        <option value="alumni" {{ old('status') == 'alumni' ? 'selected' : '' }}>Alumni</option>
                        <option value="visitor" {{ old('status') == 'visitor' ? 'selected' : '' }}>Pengunjung</option>
                    </select>
                    @error('status') <p class="text-red-500 text-xs mt-1 ml-2">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 ml-2">Pesan/Kesan</label>
                    <textarea name="pesan_kesan" required class="w-full px-6 py-4 rounded-2xl border-none bg-white dark:bg-slate-800 focus:ring-4 focus:ring-accent-pink/50 shadow-sm" placeholder="Tuliskan pesan atau kesan Anda di sini..." rows="4">{{ old('pesan_kesan') }}</textarea>
                    @error('pesan_kesan') <p class="text-red-500 text-xs mt-1 ml-2">{{ $message }}</p> @enderror
                </div>
                <div class="text-center pt-4">
                    <button class="bg-pink-500 hover:bg-pink-600 text-white px-12 py-4 rounded-2xl font-bold text-lg shadow-xl hover:translate-y-[-2px] transition-all flex items-center gap-2 mx-auto" type="submit">
                        <span class="material-icons">send</span>
                        Kirim Pesan
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection