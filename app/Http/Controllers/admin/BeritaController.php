<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// app/Http/Controllers/Admin/BeritaController.php
class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::latest()->get();
        return view('admin.berita.index', compact('berita'));
    }
    
    public function create()
    {
        return view('admin.berita.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $berita = new Berita();
        $berita->judul = $request->judul;
        $berita->isi = $request->isi;
        
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('berita', 'public');
            $berita->gambar = $path;
        }
        
        $berita->save();
        
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan');
    }
    
    // ... methods untuk edit, update, destroy
}

