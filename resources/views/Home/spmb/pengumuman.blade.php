@extends('layouts.ppdb')

@section('title', 'Pengumuman PPDB - Harapan Bangsa 1')

@section('content')
<div class="min-h-screen bg-brand-soft py-20 px-6">
    <div class="max-w-4xl mx-auto">
        @php
            $isPengumumanOpen = $setting && $now->between($setting->pengumuman_mulai, $setting->pengumuman_selesai);
            $isPublished = $setting && $setting->is_published;
        @endphp

        @if(!$isPengumumanOpen || !$isPublished)
            <!-- Waiting for Announcement -->
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-white text-stone-300 rounded-[2rem] flex items-center justify-center mx-auto mb-12 shadow-sm">
                    <span class="material-symbols-outlined text-5xl">hourglass_empty</span>
                </div>
                
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-stone-400 mb-4 block">Hasil Seleksi</span>
                <h1 class="text-5xl font-extrabold tracking-tight text-brand-dark mb-8 uppercase">PENGUMUMAN<br>BELUM DIBUKA.</h1>
                
                @if($setting && $now->lt($setting->pengumuman_mulai))
                    <p class="text-stone-500 font-medium leading-relaxed mb-12 max-w-lg mx-auto">
                        Hasil seleksi pendaftaran akan diumumkan secara resmi pada:
                    </p>
                    <div class="bg-white rounded-[3rem] p-12 inline-block shadow-xl border border-stone-100 mb-12">
                        <div class="text-3xl font-extrabold text-brand-dark mb-2">
                            {{ $setting->pengumuman_mulai->translatedFormat('d F Y') }}
                        </div>
                        <div class="text-[10px] font-bold text-brand-primary uppercase tracking-widest">
                            Pukul {{ $setting->pengumuman_mulai->translatedFormat('H:i') }} WIB
                        </div>
                    </div>
                @else
                    <p class="text-stone-500 font-medium leading-relaxed mb-12 max-w-lg mx-auto">
                        Periode pengumuman telah berakhir atau sedang dalam persiapan oleh tim administrasi.
                    </p>
                @endif
                
                <div class="flex justify-center">
                    <a href="{{ route('spmb.index') }}" 
                       class="bg-brand-dark text-white font-extrabold py-5 px-10 rounded-full text-[10px] uppercase tracking-[0.2em] transition-all hover:bg-brand-primary shadow-xl">
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        @else
            <!-- Announcement Form -->
            <div class="bg-white rounded-[3rem] shadow-2xl shadow-stone-200 overflow-hidden border border-stone-50">
                <div class="bg-brand-dark p-12 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-brand-primary/10 -mr-32 -mt-32 rounded-full"></div>
                    <div class="relative z-10">
                        <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-primary mb-4 block">Portal Hasil Seleksi</span>
                        <h2 class="text-4xl font-extrabold tracking-tight uppercase">CEK HASIL<br>SELEKSI PPDB</h2>
                        <p class="text-stone-400 text-[10px] font-bold uppercase tracking-widest mt-4">Tahun Ajaran {{ $tahunAjaranAktif->tahun_ajaran ?? '2026/2027' }}</p>
                    </div>
                </div>
                
                <div class="p-12">
                    <form action="{{ route('spmb.cek-pengumuman') }}" method="POST" class="space-y-12" id="formPengumuman">
                        @csrf
                        
                        <div class="grid md:grid-cols-2 gap-10">
                            <div>
                                <label class="block text-[10px] font-extrabold uppercase tracking-widest text-brand-dark mb-4">
                                    Nomor Pendaftaran <span class="text-brand-primary">*</span>
                                </label>
                                <input type="text" name="no_pendaftaran" required 
                                       class="w-full px-6 py-5 bg-stone-50 border border-stone-100 rounded-2xl focus:ring-1 focus:ring-brand-primary focus:border-brand-primary text-sm font-medium outline-none transition-all"
                                       placeholder="PPDB-2026XX-XXXX">
                            </div>
                            
                            <div>
                                <label class="block text-[10px] font-extrabold uppercase tracking-widest text-brand-dark mb-4">
                                    NIK Calon Siswa <span class="text-brand-primary">*</span>
                                </label>
                                <input type="text" name="nik_anak" required 
                                       pattern="[0-9]{16}"
                                       maxlength="16"
                                       class="w-full px-6 py-5 bg-stone-50 border border-stone-100 rounded-2xl focus:ring-1 focus:ring-brand-primary focus:border-brand-primary text-sm font-medium outline-none transition-all"
                                       placeholder="16 Digit NIK">
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <input type="checkbox" id="agreePrivacy" required 
                                   class="mt-1 h-5 w-5 text-brand-primary border-stone-200 rounded focus:ring-brand-primary">
                            <label for="agreePrivacy" class="text-[10px] font-bold text-stone-500 uppercase tracking-tight leading-relaxed">
                                Saya menyatakan bahwa data yang saya masukkan adalah benar untuk mengakses hasil seleksi pribadi saya.
                            </label>
                        </div>
                        
                        <div class="pt-4">
                            <button type="submit" 
                                    class="w-full bg-brand-primary text-white font-extrabold py-6 px-10 rounded-full text-[10px] uppercase tracking-[0.2em] transition-all hover:bg-brand-dark shadow-2xl shadow-brand-primary/20">
                                Lihat Hasil Seleksi
                            </button>
                        </div>
                    </form>
                    
                    <div class="mt-16 pt-12 border-t border-stone-100">
                        <div class="grid md:grid-cols-2 gap-8">
                            <div class="flex items-start gap-4">
                                <span class="material-symbols-outlined text-stone-300">security</span>
                                <div>
                                    <h5 class="text-[10px] font-extrabold uppercase tracking-widest text-brand-dark mb-2">Keamanan Data</h5>
                                    <p class="text-[10px] font-bold text-stone-400 uppercase tracking-tight">Data hasil seleksi bersifat rahasia dan hanya dapat diakses dengan verifikasi data yang valid.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <span class="material-symbols-outlined text-stone-300">help_outline</span>
                                <div>
                                    <h5 class="text-[10px] font-extrabold uppercase tracking-widest text-brand-dark mb-2">Butuh Bantuan?</h5>
                                    <p class="text-[10px] font-bold text-stone-400 uppercase tracking-tight">Hubungi panitia via WhatsApp jika nomor pendaftaran Anda tidak ditemukan.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-12 text-center">
                <a href="{{ route('spmb.index') }}" 
                   class="inline-flex items-center text-[10px] font-bold uppercase tracking-widest text-stone-400 hover:text-brand-primary transition-colors">
                    <span class="material-symbols-outlined text-sm mr-2">arrow_back</span>
                    Halaman Utama PPDB
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formPengumuman');
    if (form) {
        form.addEventListener('submit', function(e) {
            const agreePrivacy = document.getElementById('agreePrivacy');
            if (!agreePrivacy.checked) {
                e.preventDefault();
                alert('Anda harus menyetujui pernyataan privasi terlebih dahulu');
                return false;
            }
            
            // Show loading
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = 'Memproses...';
            submitBtn.disabled = true;
        });
    }
    
    // NIK Input formatting
    const nikInput = document.querySelector('input[name="nik_anak"]');
    if (nikInput) {
        nikInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '');
        });
    }
});
</script>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formPengumuman');
    if (form) {
        form.addEventListener('submit', function(e) {
            const agreePrivacy = document.getElementById('agreePrivacy');
            if (!agreePrivacy.checked) {
                e.preventDefault();
                alert('Anda harus menyetujui pernyataan privasi terlebih dahulu');
                return false;
            }
            
            // Show loading
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-3"></i> Memproses...';
            submitBtn.disabled = true;
        });
    }
});
</script>
@endpush