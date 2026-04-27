<div class="relative flex-1 flex items-center gap-3 lg:mx-0 lg:mr-auto lg:ml-0">
    {{-- Tombol Kembali ke Website --}}
    <a href="{{ Route::has('home') ? route('home') : url('/') }}" 
       class="flex items-center gap-2 px-3.5 py-2.5 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded-2xl border border-slate-200 dark:border-slate-700/50 shadow-sm hover:bg-lavender/10 dark:hover:bg-slate-700/80 transition-all group shrink-0"
       title="Kembali ke Website Utama">
        <span class="material-symbols-outlined text-primary group-hover:scale-110 transition-all font-medium">home</span>
        <span class="text-xs font-bold uppercase tracking-wider hidden sm:block">Beranda</span>
    </a>

    {{-- Widget Waktu Realtime --}}
    <div class="flex items-center gap-2 px-4 py-2.5 bg-slate-100/80 dark:bg-slate-800/80 rounded-2xl border border-slate-200 dark:border-slate-700/50 shadow-sm w-fit transition-all hover:bg-slate-200/80 dark:hover:bg-slate-700/80">
        <span class="material-symbols-outlined text-primary/80 dark:text-primary/70 text-lg">calendar_month</span>
        <span id="waktu-desktop" class="hidden md:inline text-sm font-semibold tracking-wide text-slate-700 dark:text-slate-200"></span>
        <span id="waktu-mobile" class="inline md:hidden text-[11px] font-semibold tracking-wide text-slate-700 dark:text-slate-200"></span>
    </div>
</div>


@push('scripts')
<script>
    function updateWaktu() {
        const desktopElement = document.getElementById('waktu-desktop');
        const mobileElement = document.getElementById('waktu-mobile');
        if (!desktopElement && !mobileElement) return;

        const now = new Date();

        // Format Desktop: Hari, Tanggal Bulan Tahun | HH:mm:ss WIB
        const optionsTanggal = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };

        const tanggal = now.toLocaleDateString('id-ID', optionsTanggal);
        const jamLengkap = now.toLocaleTimeString('id-ID', { hour12: false });

        if (desktopElement) {
            desktopElement.innerHTML = `${tanggal} <span class="mx-1.5 text-slate-400 dark:text-slate-500">|</span> ${jamLengkap} WIB`;
        }

        // Format Mobile: HH:mm
        if (mobileElement) {
            const jamMenit = now.toLocaleTimeString('id-ID', { 
                hour: '2-digit', 
                minute: '2-digit',
                hour12: false 
            });
            mobileElement.innerHTML = jamMenit;
        }
    }

    // Hanya jalankan jika elemen ada
    if (document.getElementById('waktu-desktop') || document.getElementById('waktu-mobile')) {
        setInterval(updateWaktu, 1000);
        updateWaktu();
    }
</script>
@endpush
