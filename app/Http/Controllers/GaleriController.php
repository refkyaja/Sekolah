<?php
namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->get('kategori');
        
        // ✅ TAMBAHKAN with('gambar') PENTING!
        $galeri = Galeri::with('gambar')  // <-- INI YANG MISSING!
            ->published()
            ->byKategori($kategori)
            ->latest('tanggal')
            ->paginate(12);
        
        $kategoriList = Galeri::published()
            ->select('kategori')
            ->distinct()
            ->pluck('kategori');
        
        return view('Home.galeri.index', compact('galeri', 'kategoriList', 'kategori'));
    }

    public function show($slug)
    {
        // ✅ TAMBAHKAN JUGA DI SINI
        $galeri = Galeri::with('gambar')
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();
        
        $galeri->incrementViews();
        
        $related = Galeri::with('gambar')
            ->published()
            ->where('kategori', $galeri->kategori)
            ->where('id', '!=', $galeri->id)
            ->latest('tanggal')
            ->limit(4)
            ->get();
        
        return view('Home.galeri.show', compact('galeri', 'related'));
    }
}