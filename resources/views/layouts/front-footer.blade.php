<footer class="bg-slate-900 text-slate-400 py-12 px-6">
    <div class="max-w-7xl mx-auto grid md:grid-cols-4 gap-12">
        <div class="space-y-4">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-yellow-400 rounded flex items-center justify-center">
                    <span class="material-icons text-white text-sm">school</span>
                </div>
                <span class="text-xl font-bold text-white font-display">TK HARAPAN BANGSA 2</span>
            </div>
            <!-- Links Column -->
            <div class="space-y-4">
                <h4 class="text-brand-dark dark:text-white font-extrabold text-sm uppercase tracking-widest">Informasi</h4>
                <ul class="text-xs space-y-2 font-medium">
                    <li><a class="hover:text-brand-primary transition-colors" href="{{ route('akademik.kurikulum') }}">Kurikulum</a></li>
                    <li><a class="hover:text-brand-primary transition-colors" href="{{ route('informasi.index') }}">Berita & Acara</a></li>
                    <li><a class="hover:text-brand-primary transition-colors" href="#">Syarat & Ketentuan</a></li>
                </ul>
            </div>
            <!-- Social Column -->
            <div class="space-y-4">
                <h4 class="text-brand-dark dark:text-white font-extrabold text-sm uppercase tracking-widest">Ikuti Kami</h4>
                <ul class="text-xs space-y-2 font-medium">
                    <li><a class="hover:text-brand-primary transition-colors" href="#">Instagram</a></li>
                    <li><a class="hover:text-brand-primary transition-colors" href="#">Facebook</a></li>
                    <li><a class="hover:text-brand-primary transition-colors" href="#">Youtube</a></li>
                </ul>
            </div>
        </div>
        <!-- Footer Bottom -->
        <div class="pt-10 border-t border-stone-200 dark:border-stone-800 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="text-[10px] font-bold uppercase tracking-widest flex space-x-8">
                <a class="hover:text-brand-primary transition-colors" href="#">Syarat & Ketentuan</a>
                <a class="hover:text-brand-primary transition-colors" href="#">Kebijakan Privasi</a>
            </div>
            <div class="text-[10px] font-bold uppercase tracking-widest">
                © {{ date('Y') }} TK HARAPAN BANGSA 1. Seluruh Hak Cipta Dilindungi.
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto border-t border-slate-800 mt-12 pt-8 text-center text-xs">
        © {{ date('Y') }} TK HARAPAN BANGSA 2. All rights reserved.    </div>
</footer>
