@extends('layouts.ppdb')

@section('title', 'Menunggu Pengumuman - Harapan Bangsa 1')

@section('content')
<div class="min-h-screen bg-brand-soft py-20 px-6 flex items-center justify-center">
    <div class="max-w-4xl w-full text-center">
        @php
            $isPengumumanOpen = $setting && $now->between($setting->pengumuman_mulai, $setting->pengumuman_selesai);
            $isPublished = $setting && $setting->is_published;
        @endphp

        @if(!$isPengumumanOpen)
            <div class="text-center">
                <div class="w-24 h-24 bg-white text-stone-300 rounded-[2rem] flex items-center justify-center mx-auto mb-12 shadow-sm">
                    <span class="material-symbols-outlined text-5xl">error_outline</span>
                </div>
                <h2 class="text-4xl font-extrabold text-brand-dark mb-8 uppercase">Akses Terbatas</h2>
                <p class="text-stone-500 font-medium leading-relaxed mb-12 max-w-lg mx-auto">
                    Halaman ini hanya dapat diakses ketika waktu pengumuman sudah tiba.
                </p>
                <a href="{{ route('spmb.index') }}" 
                   class="bg-brand-dark text-white font-extrabold py-5 px-10 rounded-full text-[10px] uppercase tracking-[0.2em] transition-all hover:bg-brand-primary shadow-xl">
                    Kembali ke Beranda
                </a>
            </div>
        @elseif($isPublished)
            <div class="text-center">
                <div class="w-24 h-24 bg-brand-primary text-white rounded-[2rem] flex items-center justify-center mx-auto mb-12 shadow-sm">
                    <span class="material-symbols-outlined text-5xl">campaign</span>
                </div>
                <h2 class="text-4xl font-extrabold text-brand-dark mb-8 uppercase">Pengumuman Dibuka</h2>
                <p class="text-stone-500 font-medium leading-relaxed mb-12 max-w-lg mx-auto">
                    Hasil seleksi sudah dapat Anda akses sekarang.
                </p>
                <a href="{{ route('spmb.pengumuman') }}" 
                   class="bg-brand-primary text-white font-extrabold py-5 px-10 rounded-full text-[10px] uppercase tracking-[0.2em] transition-all hover:bg-brand-dark shadow-xl">
                    Lihat Hasil Sekarang
                </a>
            </div>
        @else
            <!-- Countdown Content -->
            <div class="space-y-12">
                <div class="w-24 h-24 bg-white text-brand-primary rounded-[2rem] flex items-center justify-center mx-auto mb-12 shadow-sm animate-pulse">
                    <span class="material-symbols-outlined text-5xl">hourglass_bottom</span>
                </div>
                
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-stone-400 mb-4 block">Hampir Tiba</span>
                <h1 class="text-6xl font-extrabold tracking-tighter text-brand-dark mb-8 uppercase">SIAPKAN<br>DIRI ANDA.</h1>
                
                <p class="text-stone-500 font-medium leading-relaxed mb-12 max-w-lg mx-auto">
                    Hasil seleksi PPDB Harapan Bangsa 1 akan segera ditampilkan secara otomatis dalam:
                </p>

                <!-- Countdown Timer -->
                <div id="countdown" class="grid grid-cols-2 sm:grid-cols-4 gap-6 max-w-2xl mx-auto">
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-stone-100">
                        <div class="text-5xl font-extrabold tracking-tighter text-brand-dark mb-2" id="days">00</div>
                        <div class="text-[9px] font-bold text-stone-400 uppercase tracking-widest">Hari</div>
                    </div>
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-stone-100">
                        <div class="text-5xl font-extrabold tracking-tighter text-brand-dark mb-2" id="hours">00</div>
                        <div class="text-[9px] font-bold text-stone-400 uppercase tracking-widest">Jam</div>
                    </div>
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-stone-100">
                        <div class="text-5xl font-extrabold tracking-tighter text-brand-dark mb-2" id="minutes">00</div>
                        <div class="text-[9px] font-bold text-stone-400 uppercase tracking-widest">Menit</div>
                    </div>
                    <div class="bg-brand-primary p-8 rounded-[2.5rem] shadow-2xl shadow-brand-primary/20 text-white">
                        <div class="text-5xl font-extrabold tracking-tighter mb-2" id="seconds">00</div>
                        <div class="text-[9px] font-bold uppercase tracking-widest opacity-80">Detik</div>
                    </div>
                </div>

                <div class="pt-20">
                    <p class="text-[10px] font-bold text-stone-300 uppercase tracking-[0.25em]">Harapan Bangsa 1 — Timeless Education</p>
                </div>
            </div>

            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const setting = @json($setting);
                if (!setting || !setting.pengumuman_mulai) return;

                // Fix for UTC vs Local time
                const targetTime = new Date(setting.pengumuman_mulai).getTime();
                
                function updateCountdown() {
                    const now = new Date().getTime();
                    const distance = targetTime - now;

                    if (distance <= 0) {
                        const countdownEl = document.getElementById('countdown');
                        if (countdownEl) {
                            countdownEl.innerHTML = `
                                <div class="col-span-full py-12">
                                    <span class="text-[10px] font-bold text-brand-primary uppercase tracking-[0.3em] block mb-4">Waktunya Telah Tiba</span>
                                    <h3 class="text-3xl font-extrabold text-brand-dark uppercase">Membuka Pengumuman...</h3>
                                </div>
                            `;
                        }
                        setTimeout(() => {
                            window.location.href = "{{ route('spmb.pengumuman') }}?refresh=" + Date.now();
                        }, 2000);
                        return;
                    }

                    const d = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const h = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const s = Math.floor((distance % (1000 * 60)) / 1000);

                    const daysEl = document.getElementById('days');
                    const hoursEl = document.getElementById('hours');
                    const minutesEl = document.getElementById('minutes');
                    const secondsEl = document.getElementById('seconds');

                    if (daysEl) daysEl.textContent = String(d).padStart(2, '0');
                    if (hoursEl) hoursEl.textContent = String(h).padStart(2, '0');
                    if (minutesEl) minutesEl.textContent = String(m).padStart(2, '0');
                    if (secondsEl) secondsEl.textContent = String(s).padStart(2, '0');
                }

                updateCountdown();
                setInterval(updateCountdown, 1000);
            });
            </script>
        @endif
    </div>
</div>
@endsection