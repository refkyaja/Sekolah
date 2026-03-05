<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kegiatan;
use App\Models\Galeri;
use App\Models\Program;
use App\Models\Testimoni;
use App\Models\BukuTamu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil berita terbaru untuk ditampilkan di homepage (max 3)
        $beritas = Berita::where('status', 'publish')
                        ->where('tanggal_publish', '<=', now())
                        ->orderBy('tanggal_publish', 'desc')
                        ->take(3)
                        ->get();
        
        // Ambil data galeri
        $galeris = Galeri::where('is_published', 1)
                        ->orderBy('tanggal', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->take(6)
                        ->get();

        $programs = Program::all();
        $testimonis = Testimoni::latest()->take(4)->get();

        // Data guru (tetap array)
        $guru = [
            [
                'nama' => 'Siti Nurhaliza, S.Pd',
                'jabatan' => 'Kepala Sekolah',
                'deskripsi' => 'S1 Pendidikan Anak Usia Dini, 15 tahun pengalaman',
                'foto' => 'images/kepala-sekolah.jpg'
            ],
            // ... data guru lainnya
        ];

        return view('home', compact('beritas', 'galeris', 'guru', 'programs', 'testimonis'));
    }

    public function storeBukuTamu(Request $request)
    {
        $rules = [
            'nama' => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'status' => 'required|string|in:parent,alumni,visitor',
            'pesan_kesan' => 'required|string|max:1000',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->withFragment('bukutamu-section');
        }

        BukuTamu::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'instansi' => $request->status, // Map status to instansi temporarily as requested by db
            'jabatan' => $request->status,
            'tanggal_kunjungan' => now()->toDateString(),
            'jam_kunjungan' => now()->toTimeString(),
            'tujuan_kunjungan' => 'Homepage Guestbook',
            'pesan_kesan' => $request->pesan_kesan,
            'status' => 'pending',
            'is_verified' => false,
        ]);

        return redirect()->back()
            ->with('success', 'Terima kasih atas pesan dan kesan Anda!')
            ->withFragment('bukutamu-section');
    }
}