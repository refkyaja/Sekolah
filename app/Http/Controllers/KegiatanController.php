<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->get('search'));
        $sort = $request->get('sort', 'terbaru');

        $kegiatan = Kegiatan::query()
            ->where('is_published', true)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('nama_kegiatan', 'like', '%' . $search . '%')
                        ->orWhere('kategori', 'like', '%' . $search . '%')
                        ->orWhere('lokasi', 'like', '%' . $search . '%')
                        ->orWhere('deskripsi', 'like', '%' . $search . '%');
                });
            });

        $kegiatan = match ($sort) {
            'terlama' => $kegiatan->orderBy('tanggal_mulai', 'asc')->orderBy('nama_kegiatan', 'asc'),
            'az' => $kegiatan->orderBy('nama_kegiatan', 'asc'),
            'za' => $kegiatan->orderBy('nama_kegiatan', 'desc'),
            default => $kegiatan->orderBy('tanggal_mulai', 'desc')->orderBy('nama_kegiatan', 'asc'),
        };

        return view('Home.kegiatan.index', [
            'kegiatan' => $kegiatan->paginate(9)->withQueryString(),
            'search' => $search,
            'sort' => $sort,
        ]);
    }

    public function show($slug)
    {
        $kegiatan = Kegiatan::query()
            ->where('is_published', true)
            ->where('slug', $slug)
            ->firstOrFail();

        $related = Kegiatan::query()
            ->where('is_published', true)
            ->where('id', '!=', $kegiatan->id)
            ->when($kegiatan->kategori, function ($query) use ($kegiatan) {
                $query->where('kategori', $kegiatan->kategori);
            })
            ->orderBy('tanggal_mulai', 'desc')
            ->limit(4)
            ->get();

        return view('Home.kegiatan.show', compact('kegiatan', 'related'));
    }
}
