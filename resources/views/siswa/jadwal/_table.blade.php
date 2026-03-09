<div class="bg-white rounded-[2rem] border border-stone-100 shadow-xl shadow-stone-200/30 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[1000px]">
            <thead>
                <tr class="border-b border-stone-50">
                    <th class="p-8 text-[9px] font-extrabold text-stone-300 uppercase tracking-[0.3em] w-32 text-center">Waktu</th>
                    @foreach($hariList as $hari)
                        <th class="p-8 text-[10px] font-extrabold text-brand-dark uppercase tracking-[0.2em] text-center">{{ $hari }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-50">
                @foreach($slots as $slot)
                    @php
                        $jamMulai = \Carbon\Carbon::parse($slot->jam_mulai)->format('H:i');
                        $jamSelesai = \Carbon\Carbon::parse($slot->jam_selesai)->format('H:i');
                        
                        $isBreakRow = false;
                        foreach($hariList as $hari) {
                            $item = $jadwal->get($hari)?->firstWhere('jam_mulai', $slot->jam_mulai);
                            if ($item && $item->kategori === 'break') {
                                $isBreakRow = true;
                                break;
                            }
                        }
                    @endphp

                    @if($isBreakRow)
                        <tr class="bg-stone-50/50">
                            <td class="p-8">
                                <div class="flex flex-col items-center">
                                    <span class="text-[10px] font-extrabold text-brand-dark">{{ $jamMulai }}</span>
                                    <span class="text-[8px] font-bold text-stone-300 uppercase mt-1">{{ $jamSelesai }}</span>
                                </div>
                            </td>
                            <td class="p-8 text-center" colspan="5">
                                <div class="flex items-center justify-center gap-4 text-stone-300">
                                    <div class="h-[1px] w-24 bg-stone-100"></div>
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-lg">restaurant</span>
                                        <span class="text-[9px] font-extrabold uppercase tracking-[0.3em]">Istirahat & Snack Time</span>
                                        <span class="material-symbols-outlined text-lg">local_cafe</span>
                                    </div>
                                    <div class="h-[1px] w-24 bg-stone-100"></div>
                                </div>
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="p-8 align-top">
                                <div class="flex flex-col items-center">
                                    <span class="text-[10px] font-extrabold text-brand-dark">{{ $jamMulai }}</span>
                                    <span class="text-[8px] font-bold text-stone-300 uppercase mt-1">{{ $jamSelesai }}</span>
                                </div>
                            </td>
                            @foreach($hariList as $hari)
                                <td class="p-6 align-top">
                                    @php
                                        $item = $jadwal->get($hari)?->firstWhere('jam_mulai', $slot->jam_mulai);
                                        $bgClass = '';
                                        $borderClass = '';
                                        $textClass = '';
                                        $icon = 'event';

                                        if ($item) {
                                            switch($item->kategori) {
                                                case 'akademik': $bgClass = 'bg-brand-soft border-brand-primary/20'; $textClass = 'text-brand-primary'; $icon = 'menu_book'; break;
                                                case 'art': $bgClass = 'bg-amber-50 border-amber-200'; $textClass = 'text-amber-500'; $icon = 'palette'; break;
                                                case 'physical': $bgClass = 'bg-emerald-50 border-emerald-200'; $textClass = 'text-emerald-500'; $icon = 'fitness_center'; break;
                                                case 'special': $bgClass = 'bg-fuchsia-50 border-fuchsia-200'; $textClass = 'text-fuchsia-500'; $icon = 'auto_awesome'; break;
                                                default: $bgClass = 'bg-stone-50 border-stone-200'; $textClass = 'text-stone-400';
                                            }
                                        }
                                    @endphp

                                    @if($item)
                                        <div class="{{ $bgClass }} p-6 rounded-2xl border flex flex-col gap-3 transition-all hover:scale-[1.05] hover:shadow-lg hover:shadow-stone-200/40 cursor-default">
                                            <div class="flex flex-col gap-1">
                                                <span class="text-[8px] font-extrabold uppercase tracking-[0.3em] opacity-40">{{ $item->kategori }}</span>
                                                <h4 class="text-[10px] font-extrabold text-brand-dark uppercase tracking-tight leading-tight">{{ $item->mata_pelajaran }}</h4>
                                            </div>
                                            <div class="flex items-center gap-2 opacity-40">
                                                <span class="material-symbols-outlined text-xs">location_on</span>
                                                <span class="text-[8px] font-bold uppercase tracking-widest">{{ $item->lokasi }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endif
                @endforeach

                <!-- Exit Row -->
                <tr class="bg-brand-dark/5">
                    <td class="p-8">
                        <div class="flex flex-col items-center">
                            <span class="text-[10px] font-extrabold text-brand-dark">11:30</span>
                            <span class="text-[8px] font-bold text-stone-300 uppercase mt-1">12:00</span>
                        </div>
                    </td>
                    <td class="p-8" colspan="5">
                        <div class="flex items-center justify-center py-4 px-8 border-2 border-dashed border-stone-200 rounded-[2rem]">
                            <div class="flex items-center gap-4 text-stone-400">
                                <span class="material-symbols-outlined">logout</span>
                                <span class="text-[10px] font-extrabold uppercase tracking-[0.4em]">Persiapan Pulang & Penjemputan</span>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
