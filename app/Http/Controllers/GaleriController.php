<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->get('search'));
        $sort = $request->get('sort', 'terbaru');

        $galeri = Galeri::with('gambar')
            ->published()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('judul', 'like', '%' . $search . '%')
                        ->orWhere('kategori', 'like', '%' . $search . '%')
                        ->orWhere('lokasi', 'like', '%' . $search . '%')
                        ->orWhere('deskripsi', 'like', '%' . $search . '%');
                });
            });

        $galeri = match ($sort) {
            'terlama' => $galeri->orderBy('tanggal', 'asc')->orderBy('judul', 'asc'),
            'az' => $galeri->orderBy('judul', 'asc'),
            'za' => $galeri->orderBy('judul', 'desc'),
            default => $galeri->latest('tanggal')->latest('created_at'),
        };

        return view('Home.galeri.index', [
            'galeri' => $galeri->paginate(12)->withQueryString(),
            'search' => $search,
            'sort' => $sort,
        ]);
    }

    public function show($slug)
    {
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
