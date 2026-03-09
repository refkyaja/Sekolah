<footer class="bg-slate-900 text-slate-400 py-12 px-6">
    <div class="max-w-7xl mx-auto grid md:grid-cols-4 gap-12">
        <div class="space-y-4">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-yellow-400 rounded flex items-center justify-center">
                    <span class="material-icons text-white text-sm">school</span>
                </div>
                <span class="text-xl font-bold text-white font-display">TK HARAPAN BANGSA 1</span>
            </div>
            <p class="text-sm">Providing excellence in early childhood education since 2010. Nurturing the leaders of tomorrow.</p>
        </div>
        
        <div>
            <h5 class="text-white font-bold mb-6">Quick Links</h5>
            <ul class="space-y-3 text-sm">
                <li><a class="hover:text-yellow-400 transition-colors" href="{{ route('spmb.index') }}">Admissions</a></li>
                <li><a class="hover:text-yellow-400 transition-colors" href="#">Curriculum</a></li>
                <li><a class="hover:text-yellow-400 transition-colors" href="{{ route('berita.index') }}">Events</a></li>
                <li><a class="hover:text-yellow-400 transition-colors" href="#">Careers</a></li>
            </ul>
        </div>
        
        <div>
            <h5 class="text-white font-bold mb-6">Connect</h5>
            <ul class="space-y-3 text-sm">
                <li><a class="hover:text-yellow-400 transition-colors" href="#">Instagram</a></li>
                <li><a class="hover:text-yellow-400 transition-colors" href="#">Facebook</a></li>
                <li><a class="hover:text-yellow-400 transition-colors" href="#">YouTube</a></li>
                <li><a class="hover:text-yellow-400 transition-colors" href="#">LinkedIn</a></li>
            </ul>
        </div>
        
        <div>
            <h5 class="text-white font-bold mb-6">Newsletter</h5>
            <div class="flex">
                <input class="bg-slate-800 border-none rounded-l-xl px-4 py-2 w-full focus:ring-1 focus:ring-yellow-400" placeholder="Your email" type="email"/>
                <button class="bg-yellow-400 text-slate-900 font-bold px-4 py-2 rounded-r-xl hover:bg-yellow-500 transition-colors">Join</button>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto border-t border-slate-800 mt-12 pt-8 text-center text-xs">
        © {{ date('Y') }} TK HARAPAN BANGSA 1. All rights reserved.    </div>
</footer>
