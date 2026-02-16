<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index()
    {
        $guru = Auth::user();
        $kelompok = $guru->kelompok;
        
        // Jika guru mengelola kelompok tertentu
        if ($kelompok && $kelompok !== 'Semua') {
            $siswas = Siswa::where('kelompok', $kelompok)
                ->where('status_siswa', 'aktif')
                ->orderBy('nama')
                ->get();
        } else {
            $siswas = Siswa::where('status_siswa', 'aktif')
                ->orderBy('kelompok')
                ->orderBy('nama')
                ->get();
        }
        
        $tanggal = now()->format('Y-m-d');
        
        return view('guru.absensi.index', compact('siswas', 'tanggal'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'absensi' => 'required|array',
            'absensi.*.siswa_id' => 'required|exists:siswas,id',
            'absensi.*.status' => 'required|in:hadir,izin,sakit,alpa',
            'absensi.*.keterangan' => 'nullable|string|max:255',
        ]);
        
        $guru_id = Auth::id();
        $tanggal = $request->tanggal;
        
        foreach ($request->absensi as $item) {
            Absensi::updateOrCreate(
                [
                    'siswa_id' => $item['siswa_id'],
                    'tanggal' => $tanggal,
                ],
                [
                    'guru_id' => $guru_id,
                    'status' => $item['status'],
                    'keterangan' => $item['keterangan'] ?? null,
                ]
            );
        }
        
        return redirect()->route('guru.absensi.index')
            ->with('success', 'Absensi berhasil disimpan.');
    }
}