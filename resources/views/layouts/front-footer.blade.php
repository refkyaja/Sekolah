<footer class="bg-slate-900 text-slate-400 py-12 px-6">
    <div class="max-w-7xl mx-auto grid md:grid-cols-4 gap-12">
        <div class="space-y-4">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-yellow-400 rounded flex items-center justify-center">
                    <span class="material-icons text-white text-sm">school</span>
                </div>
                <span class="text-xl font-bold text-white font-display">TK HARAPAN BANGSA 1</span>
            </div>
            <!-- Links Column -->
            <div class="space-y-4">
                <h4 class="text-brand-dark dark:text-white font-extrabold text-sm uppercase tracking-widest">Informasi</h4>
                <ul class="text-xs space-y-2 font-medium">
                    <li><a class="hover:text-brand-primary transition-colors" href="{{ route('kurikulum') }}">Kurikulum</a></li>
                    <li><a class="hover:text-brand-primary transition-colors" href="{{ route('informasi') }}">Pusat Informasi</a></li>
                    <li><a class="hover:text-brand-primary transition-colors" href="javascript:void(0)" onclick="Swal.fire({
                        title: 'Syarat & Ketentuan',
                        html: '<div class=\'text-left text-sm space-y-2 font-display\'>1. Calon siswa wajib mengisi data pendaftaran dengan benar dan jujur.<br>2. Dokumen yang diunggah harus asli, jelas terbaca, dan dalam format yang ditentukan.<br>3. Keputusan hasil seleksi panitia bersifat mutlak dan tidak dapat diganggu gugat.<br>4. Segala bentuk kecurangan akan mengakibatkan pembatalan pendaftaran.</div>',
                        confirmButtonText: 'Saya Mengerti',
                        confirmButtonColor: '#7f19e6',
                        customClass: { popup: 'rounded-3xl' }
                    })">Syarat & Ketentuan</a></li>
                </ul>
            </div>
            <!-- Social Column -->
            <div class="space-y-4">
                <h4 class="text-brand-dark dark:text-white font-extrabold text-sm uppercase tracking-widest">Ikuti Kami</h4>
                <ul class="text-xs space-y-2 font-medium">
                    <li><a class="hover:text-brand-primary transition-colors" href="https://instagram.com/tkhb1_official" target="_blank">Instagram</a></li>
                    <li><a class="hover:text-brand-primary transition-colors" href="https://facebook.com/tkhb1" target="_blank">Facebook</a></li>
                    <li><a class="hover:text-brand-primary transition-colors" href="https://youtube.com/@tkhb1" target="_blank">Youtube</a></li>
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
        © {{ date('Y') }} TK HARAPAN BANGSA 1. All rights reserved.    </div>
</footer>
