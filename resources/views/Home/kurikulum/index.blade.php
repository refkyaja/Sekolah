@extends('layouts.frontend')

@section('content')
<main class="flex-1">
    <style>
        .wavy-shape {
            clip-path: polygon(0% 0%, 100% 0%, 100% 85%, 95% 88%, 90% 92%, 85% 95%, 80% 97%, 75% 98%, 70% 98%, 65% 97%, 60% 95%, 55% 92%, 50% 88%, 45% 85%, 40% 82%, 35% 81%, 30% 81%, 25% 82%, 20% 85%, 15% 88%, 10% 92%, 5% 95%, 0% 98%);
        }
    </style>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-b from-orange-50 to-white pt-20 pb-32 px-6 wavy-shape">
        <div class="max-w-4xl mx-auto text-center relative z-10">
            <div class="inline-block px-4 py-1.5 bg-primary/10 text-primary rounded-full text-sm font-bold uppercase tracking-wider mb-6">
                Belajar dengan Menyenangkan
            </div>
            <h1 class="text-5xl md:text-6xl font-black font-playful text-slate-900 mb-6 leading-tight">Kurikulum & Pendekatan</h1>
            <p class="text-lg md:text-xl text-slate-600 leading-relaxed max-w-2xl mx-auto">
                Kami menerapkan pendekatan holistik yang menyeimbangkan kecerdasan akademik, perkembangan karakter, dan kreativitas anak untuk masa depan yang gemilang.
            </p>
        </div>
        <div class="absolute -bottom-10 left-1/2 -translate-x-1/2 flex gap-4 opacity-20 pointer-events-none">
            <span class="material-symbols-outlined text-8xl text-primary animate-bounce">star</span>
            <span class="material-symbols-outlined text-8xl text-secondary">palette</span>
            <span class="material-symbols-outlined text-8xl text-accent">auto_stories</span>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 py-12 lg:py-24">
        <!-- Kurikulum & Pendekatan (Two Cards) -->
        <div class="grid lg:grid-cols-2 gap-12 mb-24">
            <!-- Kurikulum Utama -->
            @if($utama)
            <div class="bg-blue-50 p-10 rounded-3xl border-4 border-blue-100 flex flex-col items-center text-center shadow-sm hover:shadow-xl transition-shadow group">
                <div class="w-24 h-24 bg-secondary rounded-full flex items-center justify-center text-white mb-8 group-hover:scale-110 transition-transform shadow-lg">
                    <span class="material-symbols-outlined text-5xl">{{ $utama->ikon ?? 'public' }}</span>
                </div>
                <h3 class="text-3xl font-black font-playful text-slate-800 mb-6">{{ $utama->judul }}</h3>
                <div class="text-slate-600 text-lg leading-relaxed space-y-4 text-justify">
                    {!! nl2br(e($utama->deskripsi)) !!}
                </div>
            </div>
            @endif

            <!-- Pendekatan Holistik -->
            @if($pendekatan)
            <div class="bg-yellow-50 p-10 rounded-3xl border-4 border-yellow-100 flex flex-col items-center text-center shadow-sm hover:shadow-xl transition-shadow group">
                <div class="w-24 h-24 bg-primary rounded-full flex items-center justify-center text-white mb-8 group-hover:scale-110 transition-transform shadow-lg">
                    <span class="material-symbols-outlined text-5xl">{{ $pendekatan->ikon ?? 'favorite' }}</span>
                </div>
                <h3 class="text-3xl font-black font-playful text-slate-800 mb-6">{{ $pendekatan->judul }}</h3>
                <div class="text-slate-600 text-lg leading-relaxed space-y-4 text-justify">
                    {!! nl2br(e($pendekatan->deskripsi)) !!}
                    @if($pendekatan->poin_penting && count($pendekatan->poin_penting) > 0)
                    <div class="flex flex-wrap justify-center gap-3 mt-6">
                        @foreach($pendekatan->poin_penting as $poin)
                        <span class="px-4 py-2 bg-white text-primary rounded-full font-bold shadow-sm border border-primary/20 text-sm">{{ $poin }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- PAUD HIBER -->
        @if($layanan)
        <div class="bg-slate-50 rounded-3xl p-12 lg:p-20 relative overflow-hidden mb-24 border border-slate-100 shadow-xl">
            <div class="absolute top-0 right-0 w-64 h-64 bg-accent/5 rounded-full -mr-32 -mt-32"></div>
            <div class="text-center mb-16 relative">
                <h2 class="text-4xl font-black font-playful text-slate-900 mb-6">{{ $layanan->judul }}</h2>
                <div class="h-1.5 w-24 bg-accent mx-auto rounded-full mb-8"></div>
                <!-- Parse the text: before the first newline -->
                <p class="text-lg text-slate-600 max-w-4xl mx-auto leading-relaxed text-justify mb-10">
                    {!! nl2br(e($layanan->deskripsi)) !!}
                </p>
                
                @if($layanan->poin_penting && count($layanan->poin_penting) > 0)
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 relative max-w-5xl mx-auto">
                    @foreach($layanan->poin_penting as $index => $poin)
                    <div class="bg-white p-6 rounded-2xl shadow-sm text-center hover:-translate-y-2 transition-transform border-b-4 border-accent group">
                        <div class="w-12 h-12 bg-accent/10 group-hover:bg-accent text-accent group-hover:text-white transition-colors rounded-xl flex items-center justify-center mx-auto mb-4">
                            <span class="material-symbols-outlined text-2xl font-bold">check_circle</span>
                        </div>
                        <h4 class="font-bold text-slate-800">{{ $poin }}</h4>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Status & Alasan -->
        <div class="grid lg:grid-cols-2 gap-12">
            @if($status)
            <div class="bg-white rounded-3xl p-10 shadow-lg border border-slate-100 relative overflow-hidden group hover:-translate-y-2 transition-transform h-full">
                <div class="absolute -right-10 -bottom-10 text-slate-50 opacity-10 group-hover:scale-110 group-hover:-rotate-12 transition-transform duration-700 pointer-events-none">
                    <span class="material-symbols-outlined !text-[12rem]">{{ $status->ikon ?? 'verified' }}</span>
                </div>
                <div class="w-16 h-16 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center mb-8 relative z-10">
                    <span class="material-symbols-outlined text-4xl">{{ $status->ikon ?? 'verified' }}</span>
                </div>
                <h3 class="text-2xl font-black font-playful text-slate-800 mb-6 relative z-10">{{ $status->judul }}</h3>
                <div class="text-slate-600 text-lg leading-relaxed space-y-4 text-justify relative z-10">
                    {!! nl2br(e($status->deskripsi)) !!}
                </div>
            </div>
            @endif

            @if($alasan)
            <div class="bg-primary text-white rounded-3xl p-10 shadow-lg relative overflow-hidden group hover:-translate-y-2 transition-transform h-full">
                <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -mr-20 -mt-20 blur-xl pointer-events-none"></div>
                <div class="absolute -right-10 -bottom-10 text-white opacity-10 group-hover:scale-110 group-hover:rotate-12 transition-transform duration-700 pointer-events-none">
                    <span class="material-symbols-outlined !text-[12rem]">{{ $alasan->ikon ?? 'school' }}</span>
                </div>
                <div class="w-16 h-16 bg-white/20 text-white rounded-2xl flex items-center justify-center mb-8 relative z-10">
                    <span class="material-symbols-outlined text-4xl">{{ $alasan->ikon ?? 'school' }}</span>
                </div>
                <h3 class="text-2xl font-black font-playful mb-6 text-white relative z-10">{{ $alasan->judul }}</h3>
                <div class="text-white/90 text-lg leading-relaxed space-y-4 text-justify relative z-10">
                    {!! nl2br(e($alasan->deskripsi)) !!}
                </div>
            </div>
            @endif
        </div>
    </section>
</main>
@endsection
