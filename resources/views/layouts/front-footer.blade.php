<footer class="bg-brand-cream py-20 text-stone-600 dark:bg-brand-dark dark:text-stone-400">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-12 mb-20 px-4">
            <!-- Brand Info -->
            <div class="col-span-2 lg:col-span-1 space-y-6">
                <h4 class="text-brand-dark dark:text-white font-extrabold text-sm uppercase tracking-widest">Tentang TK HB 1</h4>
                <p class="text-xs leading-relaxed font-medium">
                    TK Harapan Bangsa 1 adalah tempat belajar yang ceria dan penuh kasih. Kami berdedikasi untuk memberikan fondasi pendidikan terbaik bagi pertumbuhan putra-putri Anda.
                </p>
                <a class="inline-block text-[10px] font-bold uppercase tracking-widest border-b border-brand-primary text-brand-dark dark:text-stone-300" href="{{ route('profil.index') }}">Selengkapnya</a>
            </div>
            <!-- Links Column -->
            <div class="space-y-4">
                <h4 class="text-brand-dark dark:text-white font-extrabold text-sm uppercase tracking-widest">Alamat</h4>
                <ul class="text-xs space-y-2 font-medium">
                    <li>Jl. Pendidikan No. 123</li>
                    <li>Jakarta Pusat</li>
                    <li>10110, Indonesia</li>
                </ul>
            </div>
            <!-- Links Column -->
            <div class="space-y-4">
                <h4 class="text-brand-dark dark:text-white font-extrabold text-sm uppercase tracking-widest">Kontak</h4>
                <ul class="text-xs space-y-2 font-medium">
                    <li><a class="hover:text-brand-primary transition-colors" href="mailto:harapanbangsa2@gmail.com">harapanbangsa2@gmail.com</a></li>
                    <li>(021) 1234-5678 (Senin - Jumat)</li>
                    <li>WhatsApp: +62 812-3456-7890</li>
                </ul>
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
</footer>
