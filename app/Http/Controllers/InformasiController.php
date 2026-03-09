<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kegiatan;
use App\Models\Galeri;
use Illuminate\Http\Request;

class InformasiController extends Controller
{
    public function index()
    {
        // Ambil 3 kegiatan terbaru yang sudah dipublish
        $kegiatan = Kegiatan::where('is_published', true)
            ->orderBy('tanggal_mulai', 'desc')
            ->limit(3)
            ->get();

        // Ambil galeri terbaru (dengan gambar)
        $galeri = Galeri::where('is_published', true)
            ->with(['gambar' => function($query) {
                $query->orderBy('urutan', 'asc')->limit(1);
            }])
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        return view('Home.informasi.index', compact('kegiatan', 'galeri'));
    }
}
