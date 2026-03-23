{{-- ============================================
     Footer: layouts/partials/home-footer.blade.php
     ============================================ --}}
<footer class="bg-slate-900 text-slate-400 pt-16 md:pt-20 pb-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-12 mb-16 items-start text-center md:grid-cols-2 lg:grid-cols-[minmax(0,1.25fr)_repeat(3,minmax(0,0.8fr))] lg:gap-10 lg:text-left">

            {{-- Branding --}}
            <div class="space-y-6 w-full">
                <div class="flex items-center justify-center lg:justify-start gap-3">
                    <div class="size-10 bg-primary rounded-lg flex items-center justify-center text-white">
                        <span class="material-symbols-outlined text-xl">school</span>
                    </div>
                    <h1 class="text-xl font-black text-white">TK PGRI HB 1</h1>
                </div>
                <p class="text-sm leading-relaxed max-w-xs mx-auto lg:mx-0">
                    Membangun fondasi masa depan cerah anak anda melalui pendidikan usia dini yang holistik dan kreatif di Kota Bandung.
                </p>
            </div>

            {{-- Tautan Langsung --}}
            <div class="w-full space-y-6">
                <h5 class="font-bold text-white">Tautan Langsung</h5>
                <ul class="space-y-4 text-sm">
                    <li><a href="{{ route('profil') }}" class="hover:text-white transition-colors">Visi &amp; Misi</a></li>
                    <li><a href="{{ route('kurikulum') }}" class="hover:text-white transition-colors">Kurikulum</a></li>
                    <li><a href="{{ route('informasi') }}" class="hover:text-white transition-colors">Galeri Foto</a></li>
                    <li><a href="{{ route('informasi') }}" class="hover:text-white transition-colors">Pusat Informasi</a></li>
                </ul>
            </div>

            {{-- Informasi PPDB --}}
            <div class="w-full space-y-6">
                <h5 class="font-bold text-white">Informasi PPDB</h5>
                <ul class="space-y-4 text-sm">
                    <li><a href="{{ route('ppdb.index') }}" class="hover:text-white transition-colors">Syarat Pendaftaran</a></li>
                    <li><a href="{{ route('ppdb.index') }}" class="hover:text-white transition-colors">Jadwal Seleksi</a></li>
                    <li><a href="{{ route('ppdb.index') }}" class="hover:text-white transition-colors">Formulir Online</a></li>
                    <li><a href="{{ route('ppdb.index') }}" class="hover:text-white transition-colors">Hasil Seleksi</a></li>
                </ul>
            </div>

            {{-- Ikuti Kami --}}
            <div class="w-full space-y-6">
                <h5 class="font-bold text-white">Ikuti Kami</h5>
                <div class="flex flex-col items-center lg:items-start gap-4">
                    
                    {{-- Facebook --}}
                    <a href="https://facebook.com/usernamekamu" target="_blank"
                    class="inline-flex items-center gap-3 transition-all hover:translate-x-1 group"
                    aria-label="Facebook">
                        <div class="size-10 rounded-full bg-slate-800 flex items-center justify-center group-hover:bg-[#1877F2] transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.99h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="text-sm hover:text-white transition-colors">Facebook</span>
                    </a>

                    {{-- Instagram --}}
                    <a href="https://instagram.com/usernamekamu" target="_blank"
                    class="inline-flex items-center gap-3 transition-all hover:translate-x-1 group"
                    aria-label="Instagram">
                        <div class="size-10 rounded-full bg-slate-800 flex items-center justify-center group-hover:bg-[#E4405F] transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="text-sm hover:text-white transition-colors">Instagram</span>
                    </a>

                    {{-- YouTube --}}
                    <a href="https://youtube.com/c/channelkamu" target="_blank"
                    class="inline-flex items-center gap-3 transition-all hover:translate-x-1 group"
                    aria-label="YouTube">
                        <div class="size-10 rounded-full bg-slate-800 flex items-center justify-center group-hover:bg-[#FF0000] transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
                            </svg>
                        </div>
                        <span class="text-sm hover:text-white transition-colors">YouTube</span>
                    </a>

                </div>
            </div>
        </div>

        {{-- Copyright --}}
        <div class="pt-10 border-t border-slate-800 text-center text-[10px] md:text-xs uppercase tracking-widest">
            <p>&copy; {{ date('Y') }} TK PGRI Harapan Bangsa 1 Bandung. Seluruh hak cipta dilindungi.</p>
        </div>
    </div>
</footer>
