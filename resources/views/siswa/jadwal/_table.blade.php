<div class="bg-white dark:bg-slate-900 rounded-xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-200 dark:border-slate-800 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[1000px]">
            <thead>
                <tr class="border-b border-slate-200 dark:border-slate-800">
                    <th class="p-6 text-sm font-bold text-slate-400 uppercase tracking-wider w-32">Waktu</th>
                    @foreach($hariList as $hari)
                        <th class="p-6 text-sm font-bold text-slate-900 dark:text-slate-100">{{ $hari }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @foreach($slots as $slot)
                    @php
                        $jamMulai = \Carbon\Carbon::parse($slot->jam_mulai)->format('H:i');
                        $jamSelesai = \Carbon\Carbon::parse($slot->jam_selesai)->format('H:i');
                        
                        // Check if any day has a 'break' at this time to render a full-width break row
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
                        <tr class="bg-slate-50 dark:bg-slate-800/50">
                            <td class="p-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold">{{ $jamMulai }}</span>
                                    <span class="text-xs text-slate-400">{{ $jamSelesai }}</span>
                                </div>
                            </td>
                            <td class="p-4 text-center" colspan="5">
                                <div class="flex items-center justify-center gap-3 text-slate-400 font-medium italic">
                                    <span class="material-symbols-outlined">restaurant</span>
                                    <span class="text-sm uppercase tracking-[0.2em]">Istirahat & Makan Ringan</span>
                                    <span class="material-symbols-outlined">local_cafe</span>
                                </div>
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="p-6 align-top">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold">{{ $jamMulai }}</span>
                                    <span class="text-xs text-slate-400">{{ $jamSelesai }}</span>
                                </div>
                            </td>
                            @foreach($hariList as $hari)
                                <td class="p-4">
                                    @php
                                        $item = $jadwal->get($hari)?->firstWhere('jam_mulai', $slot->jam_mulai);
                                        $bgClass = '';
                                        $borderClass = '';
                                        $textClass = '';
                                        $icon = 'event';

                                        if ($item) {
                                            switch($item->kategori) {
                                                case 'akademik': $bgClass = 'bg-academic/50 dark:bg-academic/10'; $borderClass = 'border-blue-400'; $textClass = 'text-blue-900 dark:text-blue-300'; $icon = 'menu_book'; break;
                                                case 'art': $bgClass = 'bg-art/50 dark:bg-art/10'; $borderClass = 'border-amber-400'; $textClass = 'text-amber-900 dark:text-amber-300'; $icon = 'palette'; break;
                                                case 'physical': $bgClass = 'bg-physical/50 dark:bg-physical/10'; $borderClass = 'border-emerald-400'; $textClass = 'text-emerald-900 dark:text-emerald-300'; $icon = 'fitness_center'; break;
                                                case 'special': $bgClass = 'bg-special/50 dark:bg-special/10'; $borderClass = 'border-fuchsia-400'; $textClass = 'text-fuchsia-900 dark:text-fuchsia-300'; $icon = 'auto_awesome'; break;
                                                default: $bgClass = 'bg-slate-50 dark:bg-slate-800'; $borderClass = 'border-slate-300'; $textClass = 'text-slate-700 dark:text-slate-300';
                                            }
                                        }
                                    @endphp

                                    @if($item)
                                        <div class="{{ $bgClass }} p-4 rounded-xl border-l-4 {{ $borderClass }} flex flex-col gap-2 transition-transform hover:scale-[1.02]">
                                            <div class="flex items-center gap-2">
                                                <span class="material-symbols-outlined text-[18px]">{{ $icon }}</span>
                                                <span class="text-sm font-bold {{ $textClass }}">{{ $item->mata_pelajaran }}</span>
                                            </div>
                                            <p class="text-[11px] opacity-70">{{ $item->lokasi }}</p>
                                        </div>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endif
                @endforeach

                <!-- Exit Row (Static mockup as it's consistent) -->
                <tr>
                    <td class="p-6">
                        <div class="flex flex-col">
                            <span class="text-sm font-bold">11:30</span>
                            <span class="text-xs text-slate-400">12:00</span>
                        </div>
                    </td>
                    <td class="p-4" colspan="5">
                        <div class="flex items-center justify-center p-3 border-2 border-dashed border-slate-200 dark:border-slate-800 rounded-xl">
                            <div class="flex items-center gap-3 text-slate-500">
                                <span class="material-symbols-outlined">logout</span>
                                <span class="text-sm font-bold uppercase tracking-widest">Persiapan Pulang & Penjemputan</span>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
