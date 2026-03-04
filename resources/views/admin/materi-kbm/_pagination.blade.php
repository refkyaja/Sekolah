<div class="p-4 sm:p-6 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
    <p class="text-xs font-medium text-slate-400 uppercase tracking-wider text-center sm:text-left">
        Menampilkan {{ $materiKbm->firstItem() ?? 0 }}&ndash;{{ $materiKbm->lastItem() ?? 0 }}
        dari {{ $materiKbm->total() }} Materi
    </p>
    <div class="flex items-center justify-center gap-1.5 flex-wrap">
        {{-- Previous --}}
        @if($materiKbm->onFirstPage())
            <span class="w-9 h-9 flex items-center justify-center rounded-xl border border-slate-200 text-slate-300 cursor-not-allowed">
                <span class="material-symbols-outlined text-lg">chevron_left</span>
            </span>
        @else
            <a href="{{ $materiKbm->previousPageUrl() }}"
                class="w-9 h-9 flex items-center justify-center rounded-xl border border-slate-200 text-slate-400 hover:bg-slate-50">
                <span class="material-symbols-outlined text-lg">chevron_left</span>
            </a>
        @endif

        {{-- Pages (show limited on mobile) --}}
        @foreach($materiKbm->getUrlRange(1, $materiKbm->lastPage()) as $page => $url)
            @if($page == $materiKbm->currentPage())
                <span class="w-9 h-9 flex items-center justify-center rounded-xl bg-primary text-white font-bold text-sm shadow-sm shadow-primary/20">
                    {{ $page }}
                </span>
            @elseif($page == 1 || $page == $materiKbm->lastPage() || abs($page - $materiKbm->currentPage()) <= 1)
                <a href="{{ $url }}"
                    class="w-9 h-9 flex items-center justify-center rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 font-bold text-sm">
                    {{ $page }}
                </a>
            @elseif(abs($page - $materiKbm->currentPage()) == 2)
                <span class="w-9 h-9 flex items-center justify-center text-slate-400 text-sm">…</span>
            @endif
        @endforeach

        {{-- Next --}}
        @if($materiKbm->hasMorePages())
            <a href="{{ $materiKbm->nextPageUrl() }}"
                class="w-9 h-9 flex items-center justify-center rounded-xl border border-slate-200 text-slate-400 hover:bg-slate-50">
                <span class="material-symbols-outlined text-lg">chevron_right</span>
            </a>
        @else
            <span class="w-9 h-9 flex items-center justify-center rounded-xl border border-slate-200 text-slate-300 cursor-not-allowed">
                <span class="material-symbols-outlined text-lg">chevron_right</span>
            </span>
        @endif
    </div>
</div>
