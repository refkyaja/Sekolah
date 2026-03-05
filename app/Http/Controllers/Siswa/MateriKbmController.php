<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MateriKbm;
use Illuminate\Support\Facades\Storage;

class MateriKbmController extends Controller
{
    /**
     * Display a listing of materi KBM for the logged in student.
     */
    public function index(Request $request)
    {
        $siswa = auth('siswa')->user();
        
        // Default to student's group if not specified
        $selectedKelompok = $request->get('kelompok', $siswa->kelompok);
        $kelompokFull = $selectedKelompok ? "Kelompok " . $selectedKelompok : null;
        
        $query = MateriKbm::query();

        if ($kelompokFull) {
            $query->where(function($q) use ($kelompokFull) {
                $q->where('kelas', $kelompokFull)
                  ->orWhere('kelas', 'Semua Kelas');
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul_materi', 'like', "%{$search}%")
                  ->orWhere('mata_pelajaran', 'like', "%{$search}%");
            });
        }

        if ($request->filled('mata_pelajaran')) {
            $query->where('mata_pelajaran', $request->mata_pelajaran);
        }

        $materiKbm = $query->latest('tanggal_publish')->paginate(12)->withQueryString();
        $daftarMapel = MateriKbm::daftarMataPelajaran();
        $daftarKelompok = ['A', 'B']; // Values matching student's 'kelompok' field

        return view('siswa.materi.index', compact('materiKbm', 'daftarMapel', 'siswa', 'daftarKelompok', 'selectedKelompok'));
    }

    /**
     * Download the file of a materi KBM.
     */
    public function download(MateriKbm $materiKbm)
    {
        if (!$materiKbm->file_path || !Storage::disk('public')->exists($materiKbm->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download(
            $materiKbm->file_path,
            $materiKbm->file_name ?? 'materi-kbm'
        );
    }
}
