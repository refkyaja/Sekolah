<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\JadwalPelajaran;
use Barryvdh\DomPDF\Facade\Pdf;

class JadwalPelajaranController extends Controller
{
    /**
     * Display the student schedule.
     */
    public function index()
    {
        $ta = \App\Models\TahunAjaran::where('is_aktif', true)->first() ?? \App\Models\TahunAjaran::first();
        
        if (!$ta) {
            return view('siswa.jadwal.index', [
                'jadwalA' => collect(),
                'jadwalB' => collect(),
                'slots' => collect(),
                'hariList' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'],
                'ta' => null
            ]);
        }

        $jadwalA = JadwalPelajaran::where('kelompok', 'A')
            ->where('tahun_ajaran_id', $ta->id)
            ->where('semester', $ta->semester)
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        $jadwalB = JadwalPelajaran::where('kelompok', 'B')
            ->where('tahun_ajaran_id', $ta->id)
            ->where('semester', $ta->semester)
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        $slots = JadwalPelajaran::where('tahun_ajaran_id', $ta->id)
            ->where('semester', $ta->semester)
            ->select('jam_mulai', 'jam_selesai')
            ->distinct()
            ->orderBy('jam_mulai')
            ->get();

        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $studentKelompok = auth()->guard('siswa')->user()->kelompok ?? 'A';

        return view('siswa.jadwal.index', compact('jadwalA', 'jadwalB', 'slots', 'hariList', 'ta', 'studentKelompok'));
    }

    /**
     * Download the schedule as PDF.
     */
    public function downloadPdf()
    {
        $ta = \App\Models\TahunAjaran::where('is_aktif', true)->first() ?? \App\Models\TahunAjaran::first();
        
        if (!$ta) {
            return back()->with('error', 'Tahun ajaran tidak aktif ditemukan.');
        }

        $jadwalA = JadwalPelajaran::where('kelompok', 'A')
            ->where('tahun_ajaran_id', $ta->id)
            ->where('semester', $ta->semester)
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        $jadwalB = JadwalPelajaran::where('kelompok', 'B')
            ->where('tahun_ajaran_id', $ta->id)
            ->where('semester', $ta->semester)
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        $slots = JadwalPelajaran::where('tahun_ajaran_id', $ta->id)
            ->where('semester', $ta->semester)
            ->select('jam_mulai', 'jam_selesai')
            ->distinct()
            ->orderBy('jam_mulai')
            ->get();

        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $siswa = auth()->guard('siswa')->user();
        $studentKelompok = $siswa->kelompok ?? 'A';

        $pdf = Pdf::loadView('siswa.jadwal.pdf', compact(
            'jadwalA', 
            'jadwalB', 
            'slots', 
            'hariList', 
            'ta', 
            'studentKelompok',
            'siswa'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('Jadwal-Pelajaran-' . $studentKelompok . '.pdf');
    }
}
