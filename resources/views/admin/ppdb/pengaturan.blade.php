@php
    $role = auth()->user()->role;
    $layout = match ($role) {
        'admin' => 'layouts.admin',
        'operator' => 'layouts.operator',
        'kepala_sekolah' => 'layouts.kepala-sekolah',
        'guru' => 'layouts.guru',
        default => 'layouts.app',
    };
    $routePrefix = match ($role) {
        'admin' => 'admin',
        'operator' => 'operator',
        'kepala_sekolah' => 'kepala-sekolah',
        'guru' => 'guru',
        default => 'admin',
    };
    $isReadOnlyRole = $role !== 'admin';
@endphp

@extends($layout)

@push('styles')
<style>
    .sidebar-scroll::-webkit-scrollbar { width: 4px; }
    .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
    .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.2); border-radius: 10px; }
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    #sidebar-toggle:checked ~ aside { width: 80px; }
    #sidebar-toggle:checked ~ aside .logo-text, #sidebar-toggle:checked ~ aside .nav-text, #sidebar-toggle:checked ~ aside .nav-section-title, #sidebar-toggle:checked ~ aside .system-status { display: none; }
    #sidebar-toggle:checked ~ aside .nav-item { justify-content: center; padding-left: 0; padding-right: 0; }
    #sidebar-toggle:checked ~ aside .nav-section-divider { display: block; border-top: 1px solid rgba(255, 255, 255, 0.1); margin: 1rem 0.5rem; }
    .nav-section-divider { display: none; }
    aside { transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    input[type="datetime-local"]::-webkit-calendar-picker-indicator {
        filter: invert(33%) sepia(35%) saturate(1786%) hue-rotate(228deg) brightness(93%) contrast(92%);
        cursor: pointer;
    }
</style>
@endpush

@section('content')
<nav aria-label="Breadcrumb" class="flex mb-4 text-xs font-medium text-slate-400 uppercase tracking-widest">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li><a class="hover:text-primary" href="{{ route($routePrefix . '.ppdb.index') }}">PPDB</a></li>
        <li><span class="mx-2">/</span></li>
        <li class="text-slate-600">Pengaturan Jadwal & Statistik</li>
    </ol>
</nav>

<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Pengaturan Jadwal & Statistik</h1>
    <p class="text-sm text-slate-500 mt-1">Kelola periode pendaftaran, jadwal pengumuman, dan pantau statistik aplikasi masuk.</p>
</div>

@php
$countdownDate = $setting->pengumuman_mulai ?? now()->addDays(12);
$now = now();
$diff = $now->diff($countdownDate);
@endphp

<div class="bg-primary rounded-3xl p-8 mb-8 shadow-2xl shadow-primary/20 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-20 -mt-20 blur-3xl"></div>
    <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
        <div>
            <span class="inline-block px-4 py-1.5 bg-white/20 rounded-full text-xs font-bold text-white uppercase tracking-widest mb-4 backdrop-blur-md">Status Berjalan</span>
            <h2 class="text-2xl font-bold text-white">Hitung Mundur Menuju Pengumuman</h2>
            <p class="text-white/70 mt-1">Sisa waktu sebelum sistem secara otomatis dirilis hasil seleksi.</p>
        </div>
        <div class="flex gap-4">
            <div class="flex flex-col items-center">
                <div id="countdown-days" class="w-16 h-16 sm:w-20 sm:h-20 bg-white/10 backdrop-blur-lg border border-white/20 rounded-2xl flex items-center justify-center text-2xl sm:text-3xl font-bold text-white">{{ $diff->d }}</div>
                <span class="text-[10px] font-bold text-white/60 uppercase mt-2 tracking-widest">Hari</span>
            </div>
            <div class="flex flex-col items-center">
                <div id="countdown-hours" class="w-16 h-16 sm:w-20 sm:h-20 bg-white/10 backdrop-blur-lg border border-white/20 rounded-2xl flex items-center justify-center text-2xl sm:text-3xl font-bold text-white">{{ str_pad($diff->h, 2, '0', STR_PAD_LEFT) }}</div>
                <span class="text-[10px] font-bold text-white/60 uppercase mt-2 tracking-widest">Jam</span>
            </div>
            <div class="flex flex-col items-center">
                <div id="countdown-minutes" class="w-16 h-16 sm:w-20 sm:h-20 bg-white/10 backdrop-blur-lg border border-white/20 rounded-2xl flex items-center justify-center text-2xl sm:text-3xl font-bold text-white">{{ str_pad($diff->i, 2, '0', STR_PAD_LEFT) }}</div>
                <span class="text-[10px] font-bold text-white/60 uppercase mt-2 tracking-widest">Menit</span>
            </div>
            <div class="flex flex-col items-center">
                <div id="countdown-seconds" class="w-16 h-16 sm:w-20 sm:h-20 bg-white/10 backdrop-blur-lg border border-white/20 rounded-2xl flex items-center justify-center text-2xl sm:text-3xl font-bold text-white">{{ str_pad($diff->s, 2, '0', STR_PAD_LEFT) }}</div>
                <span class="text-[10px] font-bold text-white/60 uppercase mt-2 tracking-widest">Detik</span>
            </div>
        </div>
    </div>
</div>

<form action="{{ $isReadOnlyRole ? '#' : route('admin.ppdb.updatePengaturan') }}" method="POST">
    @csrf
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <div class="xl:col-span-2 space-y-8">
            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary">calendar_month</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">Jadwal Pendaftaran</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Mulai Pendaftaran</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">event</span>
                            <input type="datetime-local" name="pendaftaran_mulai" value="{{ $setting->pendaftaran_mulai ? $setting->pendaftaran_mulai->format('Y-m-d\TH:i') : '' }}" class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-sm transition-all">
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1 px-1 italic">Waktu dimana formulir pendaftaran mulai dapat diakses publik.</p>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Selesai Pendaftaran</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">event_available</span>
                            <input type="datetime-local" name="pendaftaran_selesai" value="{{ $setting->pendaftaran_selesai ? $setting->pendaftaran_selesai->format('Y-m-d\TH:i') : '' }}" class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-sm transition-all">
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1 px-1 italic">Sistem akan otomatis menutup pendaftaran pada waktu ini.</p>
                    </div>
                </div>
                <div class="mt-10 pt-8 border-t border-slate-100">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-orange-600">notifications_active</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">Waktu Pengumuman</h3>
                    </div>
                    <div class="max-w-md space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Tanggal & Waktu Pengumuman</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">campaign</span>
                            <input type="datetime-local" name="pengumuman_mulai" value="{{ $setting->pengumuman_mulai ? $setting->pengumuman_mulai->format('Y-m-d\TH:i') : '' }}" class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-primary/20 text-sm transition-all">
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1 px-1 italic">Status kelulusan pendaftar akan dipublikasikan secara serentak.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-8">
            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm h-full">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-indigo-600">analytics</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">Statistik Pendaftaran</h3>
                </div>
                <div class="space-y-6">
                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 flex items-center gap-5 transition-all hover:shadow-md hover:bg-white">
                        <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-primary text-3xl">groups</span>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Jumlah Pendaftar</p>
                            <div class="flex items-baseline gap-2">
                                <span class="text-3xl font-extrabold text-slate-800">{{ $totalPendaftaran }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 flex items-center gap-5 transition-all hover:shadow-md hover:bg-white">
                        <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-green-600 text-3xl">verified</span>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Jumlah Siswa Lulus</p>
                            <div class="flex items-baseline gap-2">
                                <span class="text-3xl font-extrabold text-slate-800">{{ $totalLulus }}</span>
                                <span class="text-[10px] font-bold text-slate-400">dari {{ $kuota }} kuota</span>
                            </div>
                        </div>
                    </div>
                </div>
                @php
                $persentase = $totalPendaftaran > 0 ? round(($totalLulus / $totalPendaftaran) * 100) : 0;
                @endphp
                <div class="mt-4 p-5 rounded-2xl bg-indigo-50 border border-indigo-100/50">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="material-symbols-outlined text-indigo-500 text-sm">insights</span>
                        <span class="text-[11px] font-bold text-indigo-900 uppercase tracking-wider">Persentase Kelulusan</span>
                    </div>
                    <div class="h-2 bg-indigo-200/50 rounded-full overflow-hidden">
                        <div class="h-full bg-indigo-500 rounded-full" style="width: {{ $persentase }}%"></div>
                    </div>
                    <p class="text-[10px] text-indigo-600 mt-2 italic">Sekitar {{ $persentase }}% dari total pendaftar dinyatakan lulus seleksi dokumen.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-12 flex flex-col sm:flex-row items-center justify-between gap-4 p-6 bg-white rounded-3xl border border-slate-100 shadow-sm">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-slate-400">update</span>
            <p class="text-xs text-slate-500">Terakhir diperbarui: {{ $setting->updated_at ? $setting->updated_at->format('d M Y, H:i') : '-' }}</p>
        </div>
        <div class="flex items-center gap-3 w-full sm:w-auto">
            <a href="{{ route($routePrefix . '.ppdb.pengaturan') }}" class="flex-1 sm:flex-none px-8 py-3.5 bg-slate-100 text-slate-600 rounded-2xl font-bold text-sm hover:bg-slate-200 transition-all">
                Reset Jadwal
            </a>
            @if(!$isReadOnlyRole)
                <button type="submit" class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-10 py-3.5 bg-primary text-white rounded-2xl font-bold text-sm hover:bg-primary/90 transition-all shadow-lg shadow-primary/25">
                    <span class="material-symbols-outlined text-lg">save</span>
                    Simpan Perubahan
                </button>
            @else
                <div class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-6 py-3.5 bg-slate-100 text-slate-500 rounded-2xl font-bold text-sm">
                    <span class="material-symbols-outlined text-lg">visibility</span>
                    Mode Lihat Saja
                </div>
            @endif
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const countdownDate = new Date('{{ $setting->pengumuman_mulai ? $setting->pengumuman_mulai->toIso8601String() : now()->addDays(12)->toIso8601String() }}').getTime();
    
    function updateCountdown() {
        const now = new Date().getTime();
        const distance = countdownDate - now;
        
        if (distance < 0) {
            document.getElementById('countdown-days').textContent = '00';
            document.getElementById('countdown-hours').textContent = '00';
            document.getElementById('countdown-minutes').textContent = '00';
            document.getElementById('countdown-seconds').textContent = '00';
            return;
        }
        
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        document.getElementById('countdown-days').textContent = String(days).padStart(2, '0');
        document.getElementById('countdown-hours').textContent = String(hours).padStart(2, '0');
        document.getElementById('countdown-minutes').textContent = String(minutes).padStart(2, '0');
        document.getElementById('countdown-seconds').textContent = String(seconds).padStart(2, '0');
    }
    
    updateCountdown();
    setInterval(updateCountdown, 1000);
});
</script>
@endpush
