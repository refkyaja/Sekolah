<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    /**
     * Menampilkan semua berita untuk public
     */
    public function index()
    {
        $beritas = Berita::where('status', 'publish')
                        ->where('tanggal_publish', '<=', now())
                        ->orderBy('tanggal_publish', 'desc')
                        ->paginate(9);
        
        return view('Home.berita.index', compact('beritas'));
    }

    /**
     * Menampilkan detail berita
     */
    public function show($slug)
    {
        $berita = Berita::where('slug', $slug)
                       ->where('status', 'publish')
                       ->where('tanggal_publish', '<=', now())
                       ->firstOrFail();
        
        // Increment views (jika ada kolom views)
        if (isset($berita->views)) {
            $berita->increment('views');
        }
        
        // Berita Terkait (berdasarkan kategori yang sama)
        $beritaTerkait = Berita::where('status', 'publish')
                              ->where('tanggal_publish', '<=', now())
                              ->where('id', '!=', $berita->id);
        
        // Jika ada kolom kategori, filter berdasarkan kategori
        if (isset($berita->kategori) && !empty($berita->kategori)) {
            $beritaTerkait = $beritaTerkait->where('kategori', $berita->kategori);
        }
        
        $beritaTerkait = $beritaTerkait->orderBy('tanggal_publish', 'desc')
                                       ->limit(5)
                                       ->get();
        
        // Berita Lainnya (semua berita selain yang sedang dibaca)
        $beritaLainnya = Berita::where('status', 'publish')
                              ->where('tanggal_publish', '<=', now())
                              ->where('id', '!=', $berita->id)
                              ->orderBy('tanggal_publish', 'desc')
                              ->limit(5)
                              ->get();
        
        // Berita Populer (jika ada kolom views)
        $beritaPopuler = Berita::where('status', 'publish')
                              ->where('tanggal_publish', '<=', now())
                              ->where('id', '!=', $berita->id);
        
        // Jika ada kolom views, urutkan berdasarkan views
        if (isset($berita->views)) {
            $beritaPopuler = $beritaPopuler->orderBy('views', 'desc');
        } else {
            $beritaPopuler = $beritaPopuler->orderBy('tanggal_publish', 'desc');
        }
        
        $beritaPopuler = $beritaPopuler->limit(5)->get();
        
        // Berita Terbaru
        $beritaTerbaru = Berita::where('status', 'publish')
                              ->where('tanggal_publish', '<=', now())
                              ->where('id', '!=', $berita->id)
                              ->orderBy('tanggal_publish', 'desc')
                              ->limit(5)
                              ->get();
        
        // Berita Rekomendasi (kombinasi dari berita terkait dan terbaru)
        $beritaRekomendasi = Berita::where('status', 'publish')
                                  ->where('tanggal_publish', '<=', now())
                                  ->where('id', '!=', $berita->id)
                                  ->orderBy('tanggal_publish', 'desc')
                                  ->limit(4)
                                  ->get();
        
        // Berita sebelumnya
        $previous_berita = Berita::where('status', 'publish')
                                ->where('tanggal_publish', '<=', now())
                                ->where('tanggal_publish', '<', $berita->tanggal_publish)
                                ->orderBy('tanggal_publish', 'desc')
                                ->first();
        
        // Berita selanjutnya
        $next_berita = Berita::where('status', 'publish')
                           ->where('tanggal_publish', '<=', now())
                           ->where('tanggal_publish', '>', $berita->tanggal_publish)
                           ->orderBy('tanggal_publish', 'asc')
                           ->first();
        
        return view('Home.berita.show', compact(
            'berita', 
            'beritaTerkait',
            'beritaLainnya',
            'beritaPopuler',
            'beritaTerbaru',
            'beritaRekomendasi',
            'previous_berita', 
            'next_berita'
        ));
    }
}